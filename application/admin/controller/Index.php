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
 * Date: 2018/5/9
 * Time: 17:54
 */
namespace app\admin\controller;

use think\Cache;
use think\Db;

class Index extends Common {

    //后台首页
    public function index(){
        return $this->fetch();
    }
    //后台面板
    public function home(){
        return $this->fetch();
    }
    //后台管理员编辑
    public function edit(){
        $data=Db::name('admin')->find();
        $this->assign('data',$data);

        return $this->fetch();
    }
    //后台管理员编辑提交
    public function editPost(){
        if($this->request->isAjax()){
            $data=$this->request->post();
            $data['password']=Lemon_get_pwd($data['password']);
            $up=Db::name('admin')->update($data);
            if($up !== false){
                session('admin',null);
                return ['code'=>200,'msg'=>'修改成功'];
            }
            return ['code'=>0,'msg'=>'修改失败'];
        }
    }
    //缓存
    public function upCache(){
        Cache::tag('article_data')->clear();
        Cache::tag('category_data')->clear();
        Cache::tag('download_data')->clear();
        Cache::tag('page_data')->clear();
        Cache::tag('picture_data')->clear();
        Cache::tag('video_data')->clear();
        Cache::tag('setting_data')->clear();



        return ['code'=>200,'msg'=>'更新成功'];
    }
}