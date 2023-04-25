<?php
/*
                           _
                           \"-._ _.--"~~"--._
                            \   "            ^.    ___
                            /                  \.-~_.-~
                     .-----'     /\/"\ /~-._      /
                    /  __      _/\-.__\L_.-/\     "-.
                   /.-"  \    ( ` \_o>"<o_/  \  .--._\
                  /'      \    \:     "     :/_/     "`
                          /  /\ "\    ~    /~"
                          \ I  \/]"-._ _.-"[
                       ___ \|___/ ./    l   \___   ___
                  .--v~   "v` ( `-.__   __.-' ) ~v"   ~v--.
               .-{   |     :   \_    "~"    _/   :     |   }-.
              /   \  |           ~-.,___,.-~           |  /   \
             ]     \ |                                 | /     [
             /\     \|     :                     :     |/     /\
            /  ^._  _K.___,^                     ^.___,K_  _.^  \
           /   /  "~/  "\                           /"  \~"  \   \
          /   /    /     \ _          :          _ /     \    \   \
        .^--./    /       Y___________l___________Y       \    \.--^.
        [    \   /        |        [/    ]        |        \   /    ]
        |     "v"         l________[____/]________j         }r"     /
        }------t          /                       \       /`-.     /
        |      |         Y                         Y     /    "-._/
        }-----v'         |         :               |     7-.     /
        |   |_|          |         l               |    / . "-._/
        l  .[_]          :          \              :  r[]/_.  /
         \_____]                     "--.             "-.____/

                                            
                                                      
         
        */
/**
 * Created by PhpStorm.
 * User: hengge
 * Date: 2018/5/27
 * Time: 16:16
 */
namespace app\admin\model;


use think\Cache;
use think\Model;
use think\Url;
use tree\Tree;

class Category extends Model {
    protected $autoWriteTimestamp = true;
    protected $IsMenuIds = [];


    protected static function init()
    {

        //编辑后可用
        Category::event('after_update', function () {
            Cache::tag('category_data')->clear();
        });
        //新增后可用
        Category::event('after_insert', function () {
            Cache::tag('category_data')->clear();
        });
        //写入后  貌似没用到
        Category::event('after_write', function () {
            Cache::tag('category_data')->clear();
        });
        //删除后
        Category::event('after_delete', function () {
            Cache::tag('category_data')->clear();
        });
    }



    /*
     *  生成栏目列表 表格结构
     */
    public function adminCategoryTableTree($currentIds = 0, $tpl = '')
    {
        $where = ['c.delete_time' => 0];
        $field=('c.*,m.name as model_name');
        $categories = $this->alias('c')->join("models m","c.model_id = m.id")->order("c.sort ASC")->field($field)->where($where)->select()->toArray();

        $tree       = new Tree();
        $tree->icon = ['&nbsp;&nbsp;│', '&nbsp;&nbsp;├─', '&nbsp;&nbsp;└─'];
        $tree->nbsp = '&nbsp;&nbsp;';

        if (!is_array($currentIds)) {
            $currentIds = [$currentIds];
        }
        //获取模型的一维数组 以便提取控制器名称
        $models=model('models')->adminGetModelArray();
        $newCategories = [];
        foreach ($categories as $item) {
            //生成模型控制器
            $controller_name=$models[$item['model_id']];


            $item['checked'] = in_array($item['id'], $currentIds) ? "checked" : "";

            $item['str_action'] = '<a href="' . url("admin/Category/edit", ["parent" => $item['id']]) . '" class="layui-btn layui-btn-sm" title="编辑" style="float:left"><i class="layui-icon layui-icon-edit"></i></a>  
                        <a href="javascript:void(0)" class="layui-btn layui-btn-sm layui-btn-danger del_btn" category-id="'.$item['id']. '" category-name="'.$item['name'].'" title="删除"><i class="layui-icon layui-icon-delete"></i></a>';
            if ($item['is_menu'] == 1){
                $item['status']='<a href="javascript:void(0)" class="list-switch list-switch-on" category-id="'.$item['id'] .'" title="点击关闭"><i class="layui-icon layui-icon-ok"></i></a>';
            }else{
                $item['status']='<a href="javascript:void(0)" class="list-switch list-switch-off" category-id="'.$item['id'].'" title="点击开启"><i class="layui-icon layui-icon-close"></i></a>';
            }

            //如果没有下级或者是顶级则显示可以插入文章的操作

            foreach ($categories as $id){
                $is_last_level=false;
                //只有有等于的就不是最后一级
                if($item['id'] == $id['parent_id'] || $item['model_id'] == 4){
                    break;
                }else{
                    $is_last_level=true;
                }
            }
            if($is_last_level===true){
                $item['str_action'] = $item['str_action']. '<a href="' . url("admin/$controller_name/add", ["category" => $item['id']]) . '" class="layui-btn layui-btn-normal layui-btn-sm" title="添加内容"><i class="layui-icon layui-icon-add-1"></i></a>';
            }


            array_push($newCategories, $item);
        }

        $tree->init($newCategories);
        if (empty($tpl)) {
            $tpl = "<tr>
                        <td><input name='sort[\$id]' type='text' size='3' value='\$sort' lay-verify='number' class='layui-input'></td>
                        <td>\$id</td>
                        <td><span class='link' data-href='\$url' data-model='\$model_id'>\$spacer \$name</span></td>
                        <td>\$model_name</td>
                        <td align='center'>\$status</td>
                        <td>\$str_action</td>
                    </tr>";
        }
        $treeStr = $tree->getTree(0, $tpl);

        return $treeStr;
    }
    /**
     *  生成栏目 select树形结构
     * @param int $selectId 需要选中的分类 id
     * @param int $currentCid 需要隐藏的分类 id
     * @return string
     */
    public function adminCategorySelectTree($selectId = 0, $currentCid = 0)
    {
        $where = ['delete_time' => 0];
        if (!empty($currentCid)) {
            $where['id'] = ['neq', $currentCid];
        }
        $categories = $this->order("sort ASC")->where($where)->select()->toArray();

        $tree       = new Tree();
        $tree->icon = ['&nbsp;&nbsp;│', '&nbsp;&nbsp;├─', '&nbsp;&nbsp;└─'];
        $tree->nbsp = '&nbsp;&nbsp;';

        $newCategories = [];
        foreach ($categories as $item) {
            $item['selected'] = $selectId == $item['id'] ? "selected" : "";

            array_push($newCategories, $item);
        }

        $tree->init($newCategories);
        $str     = '<option value=\"{$id}\" {$selected}>{$spacer}{$name}</option>';
        $treeStr = $tree->getTree(0, $str);

        return $treeStr;
    }


    /*
     * 根据不同model生成select树状结构
     * @param int $selectId 需要选中的分类 id
     * @param int $currentCid 需要隐藏的分类 id
     * @return string
     */
    public function adminCategorySelectTreeToModelId($selectId = 0, $currentCid = 0 , $banId = 0){
        $where = ['delete_time' => 0];
        if (!empty($currentCid)) {
            $where['id'] = ['neq', $currentCid];
        }

        $categories = $this->order("sort ASC")->where($where)->select()->toArray();

        $tree       = new Tree();
        $tree->icon = ['&nbsp;&nbsp;│', '&nbsp;&nbsp;├─', '&nbsp;&nbsp;└─'];
        $tree->nbsp = '&nbsp;&nbsp;';

        //禁止选择的下拉框
        $banIdArr=[];
        $newCategories = [];
        foreach ($categories as $item) {
            $item['selected'] = $selectId == $item['id'] ? "selected" : "";

            //根据banId model_id != banId  记录下来排除掉  && 如果是父级也记录下来排除掉
            //这样不同模型就可以直接选择对应的栏目添加内容了  并且限制父级不允许选择
            foreach ($categories as $val){
               if( $val['model_id'] != $banId){
                   $banIdArr[]=$val['id'];
               }
                //只要有等于的就不是最后一级
                if($item['id'] == $val['parent_id']){
                    $banIdArr[]=$item['id'];
                    break;
                }
            }

            array_push($newCategories, $item);
        }

        $tree->init($newCategories);
        $str     = '<option value=\"{$id}\" {$selected}>{$spacer}{$name}</option>';
        $str2     = '<option value=\"{$id}\" {$selected} disabled>{$spacer}{$name}</option>';
        $treeStr = $tree->getTreeCategoryTwo(0, $str , $str2 ,$banIdArr);

        return $treeStr;
    }

    /*
     * 获取category_id的子级
     */
    public function checkCategoryChild($id){
        $this->geAllChildIdsToCategoryId($id);
        if(count($this->IsMenuIds) == 1){
            return false;
        }else{
            return true;
        }
    }
    /*
     * 是否显示  如果有子级同时修改子级
     */
    public function adminIsMenuToCategory($id){
        $data=$this->getCategoryData($id);

        $this->geAllChildIdsToCategoryId($id);
        foreach ($this->IsMenuIds as $k=>$v){
            $update[$k]['id']=$v;
            $update[$k]['is_menu']=$data['is_menu'] == 1 ? 0 : 1;
        }

        $up=$this->isUpdate(true)->saveAll($update);

        return $up;

    }

    //获取一个id下包含自己id的所有子级id
    public function geAllChildIdsToCategoryId($id){
        $this->IsMenuIds[]=$id;
        $data=$this->where(['parent_id'=>$id,'delete_time'=>0])->field('id,name,parent_id')->select();
        if(count($data) == 0){
            return;
        }else{
            $data=$data->toArray();

            foreach ($data as $val){
                $this->geAllChildIdsToCategoryId($val['id']);
            }
        }
    }
    //获取一条数据
    public function getCategoryData($id){
       $field='c.id,c.parent_id,c.model_id,c.name,c.is_menu,m.name as model_name,m.tablename';
       $data=$this->alias('c')->join('__MODELS__ m','c.model_id=m.id')->field($field)->find($id);
       if(is_null($data)){
           return false;
       }
        return $data->toArray();
    }
    //添加
    public function add($param){
        $res=$this->isUpdate(false)->allowField(true)->save($param);
        if($param['model_id'] != 4){
            $fun='lists';
            if ((int)$param['model_id'] == 1 || (int)$param['parent_id'] == 0){
                $fun='index';
            }

            $id=$this->id;
            $this->edit(['id'=>$id,'url'=>$this->getUrlToModelId($id,$param['model_id'],$fun)]);
        }

        return $res;
    }
    //编辑
    public function edit($param){
        /*if($param['model_id'] != 4){
            $fun='lists';
            if ((int)$param['model_id'] == 1 || (int)$param['parent_id'] == 0){
                $fun='index';
            }
            $param['url']=$this->getUrlToModelId($param['id'],$param['model_id'],$fun);
        }*/
        return $this->isUpdate(true)->allowField(true)->save($param);
    }
    //删除
    public function del($id){
        return $this->destroy($id);
    }


    //根据模型id查找内容(目前主要是链接模型使用了)
    public function adminGetDataToModelId($model_id){
        return $this->where(['delete_time'=>0,'model_id'=>$model_id])->order('id desc')->select()->toArray();
    }
    //生成前台可访问url
    public function getUrlToModelId($id,$model_id,$fun='index'){
        $model_data=model('models')->adminGetTableNameToModelId($model_id);
        Url::root('/');
        $url=url('index/'.$model_data['tablename'].'/'.$fun,['category'=>$id]);
        return $url;
    }

}