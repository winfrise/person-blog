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
 * Date: 2018/6/19
 * Time: 14:58
 */
namespace app\api\controller;

use think\Controller;

class Api extends Controller {

    /*
     * 根据qq获取昵称和头像
     */
    function getQQNickName(){
        $qq = input('param.qq/d');
        $returnArr=['code'=>0,'msg'=>'获取失败'];

        if(!$qq || !preg_match('|^[1-9]\d{4,10}$|i',$qq)){
            $returnArr['msg']='QQ格式错误';
            return json($returnArr);
        }

        $cache_key=CMS_NAME . 'qq_nickname' . $qq;
        $cache_nickname=cache($cache_key);

        if($cache_nickname != false){

            return $cache_nickname;
        }

        $nickname = file_get_contents('https://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?get_nick=1&uins='.$qq);

        $image = 'http://q.qlogo.cn/headimg_dl?dst_uin='.$qq.'&spec=100';

        if(strstr($nickname,'portraitCallBack')){
            $name=trim(mb_convert_encoding($nickname, "UTF-8", "GBK"),'portraitCallBack()');
            $name=json_decode($name,true);
            if(isset($name[$qq][6]) && !empty($name[$qq][6])){
                $name=$name[$qq][6];
            }else{
                $name='游客';
            }

            $returnArr= array('code'=>200, 'msg'=>'成功', 'image'=>$image, 'name'=> $name);

            cache($cache_key , $returnArr , 3600);

        }else if(strstr($nickname,'_Callback')){
            $returnArr['msg']='获取昵称失败';
        }
        return json($returnArr);
    }


}