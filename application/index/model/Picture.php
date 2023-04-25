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
 * Date: 2018/6/23
 * Time: 21:45
 */
namespace app\index\model;

use think\Db;
use think\Model;

class Picture extends Model{
    /*
     * 获取所有图集列表
     */
    public function indexGetPictureDataToCategoryId($category_id=0){
        $where=['p.delete_time'=>0,'p.is_show'=>1,'c.delete_time'=>0];
        if($category_id != 0){
            $ids=Db::name('category')->cache(true,'','category_data')->where(['delete_time'=>0,'is_menu'=>1,'parent_id'=>$category_id])->column('id');
            $ids=(empty($ids)) ? $category_id : $category_id . ',' . implode(',',$ids);
            $where['p.category_id']=['in',$ids];
        }
        $field='p.id,p.category_id,p.title,p.keywords,p.description,p.is_pwd,p.image_url,p.images,p.content,p.hits,p.comment_num,p.is_recommend,p.is_top,p.url,p.create_time,c.name as category_name,c.id as category_id,c.url as category_url';
        $data=$this->alias('p')
            ->join('category c','p.category_id=c.id')
            ->where($where)
            ->field($field)
            ->cache(true,'','picture_data')
            ->order('is_top DESC,create_time DESC')
            ->paginate(8);
        return $data;
    }
    /*
     * 获取图集详情
     */
    public function indexFindPictureDataToId($id){
        $cacheName=CMS_NAME . 'picture_data_to_id_' . $id;
        $returnArr=cache($cacheName);
        if ($returnArr == false || is_null($returnArr)){
            $where=['delete_time'=>0,'is_show'=>1,'id'=>$id];
            $field='id,category_id,title,keywords,description,image_url,images,content,is_pwd,hits,url,create_time,comment_num';
            $data=$this->where($where)->field($field)->find();
            $returnArr=[];
            if(!is_null($data)){
                $returnArr=$data->toArray();

                cache($cacheName,$returnArr,'','picture_data');
            }
        }

        return $returnArr;
    }


}