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
 * Date: 2018/5/29
 * Time: 18:30
 */
namespace app\admin\model;


use think\Cache;
use think\Model;
use think\Url;

class Video extends Model {
    protected static function init()
    {

        //编辑后可用
        Video::event('after_update', function () {
            Cache::tag('video_data')->clear();
        });
        //新增后可用
        Video::event('after_insert', function () {
            Cache::tag('video_data')->clear();
        });
        //写入后  貌似没用到
        Video::event('after_write', function () {
            Cache::tag('video_data')->clear();
        });
        //删除后
        Video::event('after_delete', function () {
            Cache::tag('video_data')->clear();
        });
    }


    /*
     * 获取文章数据库所有文章并分页
     */
    public function adminGetVideoAllDataToPage($param){
        $where['v.delete_time']=0;
        $where['c.delete_time']=0;
        $page_size=10;
        if(!empty($param)){
            //添加条件

            //栏目id
            if(isset($param['category_id']) && $param['category_id'] != 0){
                $where['v.category_id']=['eq',$param['category_id']];
            }
            //搜索条件
            if(!empty($param['search'])){
                $where['v.title']=['like',"%".$param['search']."%"];
            }
            isset($param['page_size']) && $param['page_size'] != 0 ? $page_size=(int)$param['page_size'] : '';

        }
        $field=('v.*,c.name as category_name');

        $data=$this
            ->alias('v')
            ->join('category c','v.category_id=c.id')
            ->where($where)
            ->order('id desc')
            ->field($field)
            ->paginate($page_size);
        return $data;
    }
    /*
     * 添加
     */
    public function add($params){
        $res=$this->isUpdate(false)->allowField(true)->save($params);
        $id=$this->id;
        Url::root('/');
        $url=url('index/video/show',['id'=>$id]);
        $this->edit(['url'=>$url,'id'=>$id]);
        return $res;
    }
    /*
     * 修改
     */
    public function edit($params){
        //Url::root('/');
        //$params['url']=url('index/video/show',['id'=>$params['id']]);
        return $this->isUpdate(true)->allowField(true)->save($params);
    }
    /*
     *  删除单个或多个
     *
     */
    public function del($id){
        if(is_array($id)){
            $ids=implode(',',$id);
        }else{
            $ids=$id;
        }
        $del=$this->destroy(['id'=>['in',$ids]]);
        return $del;

    }
    /*
     * 批量移动
     */
    public function remove_category($ids,$to_category_id){
        if(is_array($ids)){
            $up_arr=[];
            foreach ($ids as $k=>$v){
                $up_arr[$k]['id']=$v;
                $up_arr[$k]['category_id']=$to_category_id;
            }
            return $this->isUpdate(true)->allowField(true)->saveAll($up_arr);
        }
        return false;
    }
    /*
     *  通过id获取一条信息
     */
    public function adminFindDataToId($id){
        $data=$this->where(['delete_time'=>0])->find($id);
        if(empty($data)){
            return false;
        }
        return $data->toArray();
    }
}