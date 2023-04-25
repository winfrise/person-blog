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
 * Date: 2018/6/28
 * Time: 17:00
 */
namespace app\admin\model;

use think\Model;

class Comment extends Model{
    /*
     * 获取所有的评论
     *
     */
    public function adminGetAllCommentData($param){
        $page_size=10;
        $model_id=2;
        $model_name='article';
        if(!empty($param['models']) && !empty($param['model_name'])){
            $model_id=$param['models'];
            $model_name=$param['model_name'];
        }
        $where=['com.delete_time'=>0,'cat.model_id'=>$model_id];
        if(!empty($param['search'])){
            $where['p.title']=['like','%'. $param['search'] . '%'];
        }

        $field='com.id,com.a_id,com.c_id,com.parent_id,com.content,com.send,com.receive,com.ip,com.reply,com.create_time,com.is_status,cat.id as category_id,cat.name as category_name,p.title as title';
        $data=$this->alias('com')
            ->join('category cat','com.c_id=cat.id')
            ->join("$model_name p",'com.a_id=p.id')
            ->where($where)
            ->order('com.create_time desc')
            ->field($field)
            ->paginate($page_size);

        return $data;
    }
}