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
 * Date: 2018/6/27
 * Time: 18:14
 */
namespace app\index\model;

use think\Db;
use think\Model;

class Video extends Model{
    /*
     * 获取所有视频列表
     */
    public function indexGetVideoDataToCategoryId($category_id=0){
        $where=['v.delete_time'=>0,'v.is_show'=>1,'c.delete_time'=>0];
        if($category_id != 0){
            $ids=Db::name('category')->cache(true,'','category_data')->where(['delete_time'=>0,'is_menu'=>1,'parent_id'=>$category_id])->column('id');
            $ids=(empty($ids)) ? $category_id : $category_id . ',' . implode(',',$ids);
            $where['v.category_id']=['in',$ids];
        }
        $field='v.id,v.category_id,v.title,v.keywords,v.description,v.image_url,v.video_url,v.content,v.hits,v.comment_num,v.is_recommend,v.is_top,v.url,v.create_time,c.name as category_name,c.id as category_id,c.url as category_url';
        $data=$this->alias('v')
            ->join('category c','v.category_id=c.id')
            ->where($where)
            ->field($field)
            ->cache(true,'','video_data')
            ->order('is_top DESC,create_time DESC')
            ->paginate(8);
        return $data;
    }


    /*
     * 获取视频详情
     */
    public function indexFindVideoDataToId($id){
        $cacheName=CMS_NAME . '_video_data_to_id_' . $id;
        $returnArr=cache($cacheName);


        if($returnArr == false || is_null($returnArr)){
            $where=['delete_time'=>0,'is_show'=>1,'id'=>$id];
            $field='id,category_id,title,keywords,description,image_url,video_url,content,hits,url,create_time,comment_num';
            $data=$this->where($where)->field($field)->find();
            $returnArr=[];
            if(!is_null($data)){
                $returnArr=$data->toArray();

                cache($cacheName,$returnArr,'','video_data');
            }
        }
        return $returnArr;
    }
}