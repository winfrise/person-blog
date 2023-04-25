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
 * Date: 2018/5/28
 * Time: 10:10
 */
namespace app\admin\validate;


use think\Validate;

class Category extends Validate {
    protected $rule = [
        'name'  =>  'require|max:100',
        'description' =>  'max:200',
        'meta_keywords' =>  'max:200',
        'meta_description' =>  'max:200',
    ];

    protected $message = [
        'name.require'  =>  '栏目名称为必填',
        'name.max'  =>  '栏目名称最多100个字符',
        'description.max' =>  '栏目描述最多200个字符',
        'meta_keywords.max' =>  '关键字最多200个字符',
        'meta_description.max' =>  '描述最多200个字符',
    ];

    /*protected $scene = [
        'add'   =>  ['name','email'],
        'edit'  =>  ['email'],
    ];*/


}