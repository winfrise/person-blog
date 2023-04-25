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
 * Time: 15:57
 */
namespace app\index\controller;

class Page extends Common{
    /*
     * 单页显示
     */
    public function index(){
        $category_id=$this->request->param('category/d', 0 ,'intval');

        $data=model('page')->getPageDataToCategoryId($category_id);
        if(count($data) == 0){
            //没有数据则跳转到404
            $this->redirect('/404.html');
        }

        $this->assign('data',$data);

        //访问量增加
        Lemon_hits_add($data['id'],$this->model_data['tablename']);
        //获取面包屑导航
        $category_breadcrumb=model('category')->indexGetCategoryBreadcrumbToModelId($data['category_id'],$this->model_data['id']);
        $this->assign('category_breadcrumb',$category_breadcrumb);
        //栏目导航
        $second_categorys=model('category')->indexGetSecondCategoryToModelId($this->model_data['id'],$category_id);
        $this->assign('second_categorys',$second_categorys);
        //栏目数据
        $category_data=model('category')->indexFindCategoryDataToId($category_id);
        $temp=(!empty($category_data['index_template']) ? $category_data['index_template'] : '');
        return $this->fetch($temp);
    }
}