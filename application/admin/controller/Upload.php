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
 * Date: 2018/5/10
 * Time: 15:32
 */

namespace app\admin\controller;
header('Content-Type:text/html; charset=utf-8');
use think\Controller;

class Upload extends Common {
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('upload');
    }

    //附件首页
    public function index(){
        $data=model('upload')->field('id,file_size,create_time,status,filename,file_path,suffix')->select()->toArray();
        $this->assign('data',$data);
        $this->assign('page','');
        return $this->fetch();
    }



    public function upimage(){
        return $this->model->upfile('images');
    }
    public function upimages(){
        return $this->model->upfiles('images');
    }
    public function upfile(){
        return $this->model->upfile('files');
    }

    //layui 上传
    public function layedit_upimage(){
        $result =  $this->model->upfile('layedit','file',false);
        if($result['code'] == 200){
            $data = array('code'=>0,'msg'=>'上传成功','data'=>array('src'=>$result['path'],'title'=>$result['info']['name']));
        }else{
            $data = array('code'=>1,'msg'=>$result['msg']);
        }
        return $data;
    }
    //wangEditor 上传
    public function wangEditor_upimage(){
        $result =  $this->model->upfile('wangEditor','file',false);

        if($result['code'] == 200){
            $data = array('errno'=>0,'msg'=>'上传成功','data'=>array($result['path']));
        }else{
            $data = array('errno'=>1,'msg'=>$result['msg']);
        }

        return json_encode($data);
    }

    public function umeditor_upimage(){
        $result =  $this->model->upfile('umeditor','upfile');

        if($result['code'] == 200){
            $data = array(
                "originalName" => $result['info']['name'] ,
                'title'=> $result['info']['name'],
                "original"=>$result['info']['name'] ,
                "name" => $result['info']['name'] ,
                "url" => $result['path'] ,
                "size" => $result['info']['size'] ,
                "type" => $result['info']['type'] ,
                "state" => "SUCCESS"
            );
        }else{
            $data = array(
                "originalName" => $result['info']['name'] ,
                "name" => $result['info']['name'] ,
                "url" => $result['path'] ,
                "size" => $result['info']['size'] ,
                "type" => $result['info']['type'] ,
                "state" => $result['msg']
            );
        }
        return json_encode($data);
    }
}