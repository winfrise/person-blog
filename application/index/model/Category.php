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
 * Date: 2018/6/13
 * Time: 14:20
 */
namespace app\index\model;


use think\Model;


class Category extends Model{
    public $returnArr=[];

    /*
     * 获取头部导航
     */
    public function homeGetCategoryTreeArray(){
        $cacheName=CMS_NAME . 'category_header_data';
        $returnArray=cache($cacheName);


        if($returnArray == false || is_null($returnArray)){
            $returnArray=[];
            $field='id,parent_id,model_id,name,description,url,create_time,image_url,is_cover,sort';
            $arr=$this->where(['delete_time'=>0,'is_menu'=>1])->order('sort asc')->field($field)->select()->toArray();

            //模型数据
            //$models=model('admin/models')->adminGetModelArray();


            foreach ($arr as $k =>$v){
                if($v['parent_id'] == 0){
                    //父级
                    $returnArray[$v['id']]=$v;
                    //子级
                    foreach ($arr as $c_k=>$c_v){
                        if($c_v['parent_id'] == $v['id']){
                            $returnArray[$v['id']]['child'][]=$c_v;
                        }
                    }
                }
            }
            cache($cacheName,$returnArray,'','category_data');
        }

        return $returnArray;
    }
    /*
     * 获取栏目导航
     */
    public function indexGetSecondCategoryToModelId($model_id,$category_id){
        $one_data=$this->indexFindCategoryDataToId($category_id);
        $parent_id=0;
        if(!empty($one_data)){
            $parent_id=($one_data['parent_id'] != 0) ? $one_data['parent_id'] : $one_data['id'];
        }
        $cacheName=CMS_NAME . 'category_second_data_to_model_id_'.$model_id . '_' . $category_id . '_' . $parent_id;
        $data=cache($cacheName);

        if($data == false || is_null($data)){
            $where=['delete_time'=>0,'is_menu'=>1,'model_id'=>$model_id,'parent_id'=>$parent_id];
            $data=$this->where($where)->whereOr('id',$category_id)->field('id,name,url')->order('sort,id')->select()->toArray();

            cache($cacheName,$data,'','category_data');
        }
        return $data;
    }
    /*
     * 获取面包屑导航
     */
    public function indexGetCategoryBreadcrumbToModelId($id,$model_id){
        //$data=$this->where(['delete_time'=>0,'is_menu'=>1,'id'=>$id,'model_id'=>$model_id])->field('id,name,url,parent_id')->find();
        $data=$this->indexFindCategoryDataToId($id,['model_id'=>$model_id]);

        if(count($data) > 0){
            if($data['parent_id'] == 0){
                array_unshift($this->returnArr,$data);
                return $this->returnArr;
            }else{
                $this->returnArr[]=$data;
                $this->indexGetCategoryBreadcrumbToModelId($data['parent_id'],$model_id);

            }
        }
        return $this->returnArr;
    }
    /*
     *  根据category_id获取一条数据
     */
    public function indexFindCategoryDataToId($category_id,$where=[]){
        $w=['delete_time'=>0,'is_menu'=>1];
        if(!empty($where)){
            $w=array_merge($where,$w);
        }
        $str='';
        foreach ($w as $k=>$v){
            $str .= $k . '_' . $v . '_';
        }

        $cacheName=CMS_NAME . 'category_data_to_id_' . $str . '_' . $category_id;
        $data=cache($cacheName);

        if($data == false || is_null($data)){
            $data=$this->field('id,parent_id,name,url,index_template,list_template,show_template')->where($w)->find($category_id);
            if(is_null($data)){
                return [];
            }
            $data=$data->toArray();
            cache($cacheName,$data,'','category_data');
        }

        return $data;

    }

}