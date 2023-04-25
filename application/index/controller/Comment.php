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
 * Time: 14:38
 */
namespace app\index\controller;


use think\Controller;
use think\Db;

class Comment extends Common {
    public $tablename=false;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        //获取来源控制器
        //$referer=$this->request->header('referer');
        //获取category_id
        $category_id=$this->request->param('category/d',0,'intval');
        $category_data=model('admin/category')->getCategoryData($category_id);
        $models_data=model('admin/models')->adminGetTableNameToModelId($category_data['model_id']);
        if($models_data != false){
            $this->tablename=$models_data['tablename'];
        }else{
            $this->tablename=false;
        }

    }

    /*
     * 获取评论
     */
    public function index(){
        if($this->request->isAjax()){
            $param=$this->request->param();
            $category_data=Db::name($this->tablename)->field('category_id')->find($param['id']);
            $param['c_id']=$category_data['category_id'];
            $data=model('comment')->getCommentPageData($param);

            return $data;
        }
    }

    /*
     * 进行评论
     */
    public function add(){
        if($this->request->isAjax()){

            $data=$this->request->post();
            $cache_comment_ip=CMS_NAME . '_comment_ip_';
            $returnArr=['code'=>0,'msg'=>'吐槽失败'];
            $comment=[];
            //检测评论是否开启
            if($this->setting['comment_status'] == 0){
                $returnArr['msg']='评论未开启';
                return $returnArr;
            }

            //检测来源ip是否被封
            $ip=$this->request->ip();
            $ips=[];
            if(in_array($ip,$ips)){
                $returnArr['msg']='讲文明，树新风';
                return $returnArr;
            }
            //检测是否 可以评论  (每个ip 限制5分钟评论1次)
            $comment_ip=cache($cache_comment_ip . $ip);
            $comment_ip=false;
            if($comment_ip !== false){
                //还可以扩展

                //有记录则不可以评论
                $returnArr['msg']='请过会再来评论';
                return $returnArr;
            }

            if($this->tablename == false){
                $returnArr['msg']='来源错误';
                return $returnArr;
            }

            //获取内容id
            $content_data=Db::name($this->tablename)->where(['delete_time'=>0,'is_show'=>1])->field('id,category_id')->find($data['id']);
            if(is_null($content_data)){
                $returnArr['msg']='吐你一脸';
                return $returnArr;
            }
            $comment['a_id']=$content_data['id'];//内容id
            $comment['c_id']=$content_data['category_id'];//分类id
            $comment['content']=htmlspecialchars($data['content']);//内容
            $comment['create_time']=time();
            $comment['update_time']=time();

            //根据qq获取昵称
            $qq_nickname=action('api/api/getQQNickName',['qq'=>intval($data['qq'])]);
            if($qq_nickname['code'] != 200){
                $returnArr['msg']='获取错误';
                return $returnArr;
            }
            $comment['send']=json_encode(['qq'=>$data['qq'],'name'=>$qq_nickname['name'],'image'=>$qq_nickname['image']]);


            //检测是评论文章还是回复评论
            if($data['lemon_comment_reply_id'] != 0){
                $receive=Db::name('comment')->field('id,parent_id,send')->find($data['lemon_comment_reply_id']);
                if(is_null($receive)){
                    $returnArr['msg']='吐槽鬼呢？';
                    return $returnArr;
                }
                $parent_id=($receive['parent_id'] == 0) ? $receive['id'] : $receive['parent_id'];
                $comment['parent_id']=$parent_id;
                Db::name('comment')->where('id',$parent_id)->setInc('reply');
                $comment['receive']=$receive['send'];
            }else{
                $comment['receive']=0;
                $comment['parent_id']=0;
            }

            //记录ip
            $comment['ip']=$ip;
            //检测是否开启评论审核 不开启（！=1） 则直接通过
            $comment_examine = $this->setting['comment_examine'];
            if($comment_examine != 1){
                $comment['is_status'] = 1;
            }
            //提交评论
            $insert_id=Db::name('comment')->insertGetId($comment);
            if($insert_id){
                //设置一个可编辑的缓存时间 限制评论  默认5分钟
                $comment_ban_time=(empty($this->setting['comment_ban_time']) ? 300 : intval($this->setting['comment_ban_time'])*60);

                $ip_arr=['ip'=>$ip,'time'=>time(),'num'=>1];
                cache($cache_comment_ip . $ip , $ip_arr , $comment_ban_time);

                //不审核才直接增加留言数量
                if($comment_examine != 1){
                    //留言增加
                    Lemon_comment_add($content_data['id'],$this->tablename);
                }

                //拼凑前台使用的数据
                $comment['id']=$insert_id;
                $comment['reply']=0;
                $comment['create_time']=date('Y-m-d H:i:s',$comment['create_time']);

                $returnArr['code']=200;
                $returnArr['msg']=$comment_examine == 1 ? '吐槽成功,等待审核！' : '吐槽成功';
                $returnArr['data']=[$comment];
            }
            return $returnArr;

        }
    }



}