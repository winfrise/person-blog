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
 * Date: 2018/5/10
 * Time: 11:34
 */
namespace app\admin\controller;

use think\Controller;
use think\Url;

class Category extends Common {


    //内容管理首页
    public function index(){
        $data=model('category')->adminCategoryTableTree();
        $this->assign('data',$data);
        return $this->fetch();
    }
    //添加栏目
    public function add(){
        $category_select = model('category')->adminCategorySelectTree();
        $model_select = model('models')->adminGetModelSelect();



        $this->assign('category_select',$category_select);
        $this->assign('model_select',$model_select);

        return $this->fetch();
    }
    //添加栏目提交
    public function addPost(){
        if(request()->isPost()){
            $params = $this->request->param();

            $return=['code'=>0,'msg'=>'添加失败'];
            //模型id必须大于0
            if($params['model_id'] < 1){
                $return['msg']='请选择模型';
                return $return;
            }
            //链接模型url不能为空
            if($params['model_id'] == 4){
                if(empty($params['url'])){
                    $return['msg']='外部链接不能为空';
                    return $return;
                }

            }
            //验证码验证
            $result =$this->validate($params,'Category');
            if($result !== true){
                $return['msg']=$result;
                return $return;
            }
            //添加数据
            $in=model('Category')->add($params);
            if ($in !== false){
                $return=['code'=>200,'msg'=>'添加成功'];
                return $return;
            }
            return $return;
        }
    }


    //编辑栏目
    public function edit(){
        $id=$this->request->param('parent');
        $category_data=model('category')->find($id);
        if(empty($category_data)){
            //id不存在
            $this->error('id错误');
        }

        $category_select = model('category')->adminCategorySelectTree($category_data['parent_id'],$id);
        $model_select = model('models')->adminGetModelSelect();


        $this->assign('category',$category_data->toArray());
        $this->assign('category_select',$category_select);
        $this->assign('model_select',$model_select);
        return $this->fetch();
    }
    //编辑栏目提交
    public function editPost(){
        if($this->request->isPost()){
            $param=$this->request->param();
            $return=['code'=>0,'msg'=>'添加失败'];
            //模型id必须大于0
            if($param['model_id'] < 1){
                $return['msg']='请选择模型';
                return $return;
            }
            //链接模型url不能为空
            if($param['model_id'] == 4){
                if(empty($param['url'])){
                    $return['msg']='外部链接不能为空';
                    return $return;
                }

            }
            //验证码验证
            $result =$this->validate($param,'Category');
            if($result !== true){
                $return['msg']=$result;
                return $return;
            }
            //添加数据
            $in=model('Category')->edit($param);
            if ($in !== false){
                $return=['code'=>200,'msg'=>'添加成功'];
                return $return;
            }
            return $return;

        }
    }
    //栏目删除
    public function del(){
        $id = $this->request->param('id/d' , 0 , 'intval');
        $json=['code'=>0,'msg'=>'删除失败'];
        if($id == 0){
            return $json;
        }
        //检查是否有子级
        $child_ids=model('category')->checkCategoryChild($id);
        if($child_ids === true){
            //有子级
            $json['msg']='请先删除该栏目的下级栏目';
            return $json;
        }
        //删除栏目 及栏目下内容数据
        //将栏目对应模型下的内容数据一并删除
        $category_data=model('category')->getCategoryData($id);
        if($category_data['model_id'] != 4){
            $ids=model($category_data['tablename'])->where('category_id',$id)->column('id');
            if(count($ids) > 0){
                $del=model($category_data['tablename'])->del($ids);
            }
        }

        $up=model('category')->del($id);
        if($up !== false){

            $json['code']=200;
            $json['msg']='删除成功';
            return $json;
        }
        return $json;
    }

    //是否导航显示
    public function menuSwitch(){
        $id = $this->request->param('id/d' , 0 , 'intval');
        $json=['code'=>0,'msg'=>'修改失败'];
        if($id == 0){
            return $json;
        }

        //修改导航显示
        $up=model('category')->adminIsMenuToCategory($id);
        if($up !== false){
            $json['code']=200;
            $json['msg']='修改成功';
            return $json;
        }
        return $json;
    }


    //排序
    public function sort(){
        if($this->request->isAjax()){
            $param=$this->request->post();

            $arr=[];
            foreach ($param['sort'] as $k=>$v){
                $arr[]=['id'=>$k,'sort'=>$v];
            }
            model('category')->allowField(true)->saveAll($arr);
            return ['code'=>200,'msg'=>'排序成功'];
        }
    }
    //栏目选择  主要是移动内容移动时需要
    public function select(){
        if($this->request->isPost()){
            $param=$this->request->param();

            //获得栏目下拉框
            $categorySelect=model('category')->adminCategorySelectTreeToModelId(0,0,$param['model_id']);
            $this->assign('category_select',$categorySelect);
            //移动的id
            $this->assign('ids',implode(',',$param['ids']));
            return $this->fetch();
        }

    }

    public function updateUrl(){
        //更新category的url
        $category_data=model('category')->field('id,parent_id,model_id,url')->select()->toArray();
        //获取到models
        $models=model('models')->adminGetModelArray();

        //更新栏目url
        $up_category_arr=[];
        Url::root('/');
        foreach ($category_data as $k=>$v){
            //不更新链接模型
            if($v['model_id'] != 4){
                $func='lists';
                if($v['parent_id'] == 0 || $v['model_id'] == 1){
                    $func='index';
                }
                $url=url('index/' . $models[$v['model_id']] . '/' .$func, ['category'=>$v['id']]);
                $up_category_arr[]=['id'=>$v['id'],'url'=>$url];
            }
        }
        model('category')->saveAll($up_category_arr);

        //更新模型url
        foreach ($models as $key=>$val){
            //不更新链接模型
            if($key != 4){
                $func='show';
                if($key == 1){
                    $func='index';
                }
                $data=model($val)->field('id,url')->select()->toArray();
                $up_data_arr=[];
                foreach ($data as $kk=>$vv){
                    $url=url('index/' . $val . '/' . $func , ['id'=>$vv['id']]);
                    $up_data_arr[]=['id'=>$vv['id'],'url'=>$url];
                }

                //更新
                model($val)->saveAll($up_data_arr);
            }

        }


        return ['code'=>200,'msg'=>'更新成功'];

    }
}