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
 * Time: 15:54
 */
namespace app\index\controller;

class Video extends Common{
    public $is_auto=true;

    public $category_id;
    public $category_data;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub

        if($this->is_auto){
            $this->category_id=$this->request->param('category/d', 0 ,'intval');
        }

        $category_breadcrumb=model('category')->indexGetCategoryBreadcrumbToModelId($this->category_id,$this->model_data['id']);
        $this->assign('category_breadcrumb',$category_breadcrumb);

        $id=$this->request->param('id/d', 0 ,'intval');
        if($id != 0){
            //栏目导航
            $second_category=model('category')->indexGetSecondCategoryToModelId($this->model_data['id'],$this->category_id);
            $this->assign('second_category',$second_category);
        }

        //栏目数据
        $this->category_data=model('category')->indexFindCategoryDataToId($this->category_id);

    }


    /*
     *  显示所有视频栏目的所有列表
     */
    public function index(){
        $data=model('video')->indexGetVideoDataToCategoryId($this->category_id);
        // 获取分页显示
        $page = $data->render();
        $this->assign('data',$data);
        $this->assign('page',$page);

        $temp=(!empty($this->category_data['index_template']) ? $this->category_data['index_template'] : '');
        return $this->fetch($temp);
    }

    /*
     *  显示某个视频栏目的所有列表
     */
    public function lists(){

        $data=model('video')->indexGetVideoDataToCategoryId($this->category_id);

        // 获取分页显示
        $page = $data->render();
        $this->assign('data',$data);
        $this->assign('page',$page);
        $temp=(!empty($this->category_data['list_template']) ? $this->category_data['list_template'] : '');
        return $this->fetch($temp);
    }

    /*
    * 显示视频详情
    */
    public function show(){
        $id=$this->request->param('id/d', 0 ,'intval');
        $data=model('video')->indexFindVideoDataToId($id);
        //没有数据则跳转到404
        if(count($data) == 0){
            $this->redirect('/404.html');
        }

        $this->assign('data',$data);

        $this->is_auto=false;
        $this->category_id=$data['category_id'];
        $this->_initialize();

        //访问量增加
        Lemon_hits_add($id,$this->model_data['tablename']);

        $temp=(!empty($this->category_data['show_template']) ? $this->category_data['show_template'] : '');
        return $this->fetch($temp);
    }
}