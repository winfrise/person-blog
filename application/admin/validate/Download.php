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
 * Time: 18:31
 */
namespace app\admin\validate;

use think\Validate;

class Download extends Validate {
    protected $rule = [
        'category_id' =>  'checkId',
        'title'  =>  'require|max:100|token',
        'keywords' =>  'max:100',
        'description' =>  'max:200',
        'pwd'          => 'max:4',
        //url url验证

    ];

    protected $message = [
        'title.require'  =>  '标题为必填',
        'title.max'  =>  '标题最多100个字符',
        'keywords.max'  =>  '关键词最多100个字符',
        'description.max' =>  '栏目描述最多200个字符',
        'pwd.max' =>  '密码最多四位',

    ];

    protected function checkId($value,$rule,$data){
        if($value < 1){
            return '栏目ID错误';
        }
        return true;
    }
}