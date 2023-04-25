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
 * Time: 18:55
 */
namespace app\admin\model;

use think\Model;
use think\Url;

class Models extends Model  {




    //获取所有的模型数组
    public function adminGetModelSelect(){
        $data=$this->order('sort')->select()->toArray();
        return $data;
    }
    //根据模型id获取数据表名称
    public function adminGetTableNameToModelId($id){
        $data=$this->where(['id'=>$id])->field('id,name,tablename')->find();
        if(empty($data)){
            return false;
        }else{
            $data=$data->toArray();
        }
        return $data;
    }
    //根据数据表名称获取model数据
    public function adminGetModelDataToTableName($tablename){
        $data=$this->where(['tablename'=>$tablename])->field('id,name,tablename')->find();
        if(empty($data)){
            return false;
        }
        return $data->toArray();
    }
    //获取到所有的模型数组   一维结构
    /*
     *  [
     *      'id'=>'tablename',
     *      'id'=>'tablename',
     * ]
     *
     */
    public function adminGetModelArray(){
        $arr=[];
        $data=$this->adminGetModelSelect();
        foreach ($data as $val){
            $arr[$val['id']]=$val['tablename'];
        }
        return $arr;
    }
    //获取带不同url的model跳转链接(后台url)
    /*
     * $id 根据id获取  如果为0则获取全部 不为0则获取一个
     * $func  控制器下的方法  如：admin/Article/index  or admin/Article/edit
     */
    public function adminGetModelSelectAndUrl($id=0,$func='index'){
        if($id==0){
            $arr=[];
            $all_data=$this->adminGetModelSelect();
            foreach ($all_data as $val){
                $val['url']=url("".$val['tablename']."/".$func."");
                $arr[]=$val;
            }
            return $arr;
        }else{
            $one_data=$this->adminGetTableNameToModelId($id);
            $one_data['url']=url("".$one_data['tablename'] ."/".$func."");
            return $one_data;
        }
    }
    //生成url跳转链接
    /*
     * $model_id 模型id
     * $param ['param1'=>'id or category','param2'=>'$id']
     * $func  控制器下的方法  如：index/Article/index  or index/Article/edit
     */
    public function getUrlToModelId($model_id,$param=[],$func='index'){
        $model_data=$this->adminGetTableNameToModelId($model_id);
        Url::root('/');
        $url=url('index/'.$model_data['tablename'].'/'.$func,[$param['param1']=>$param['param2']]);
        return $url;
    }
}