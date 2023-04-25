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
 * Time: 16:58
 */
namespace app\admin\controller;


use think\Db;

class Comment extends Common{
    //留言显示
    public function index(){
        $param=$this->request->param();

        (!empty($param['models'])) ? $param['model_name']=model('models')->adminGetTableNameToModelId($param['models'])['tablename'] : true;

        //留言数据
        $data=model('comment')->adminGetAllCommentData($param);

        $data->appends($param);
        $this->assign('data',$data->toArray());
        $this->assign('page',$data->render());
        //搜索数据
        $this->assign('models_id',(empty($param['models']) ? 2 : $param['models']));
        $this->assign('search',(empty($param['search']) ? '' : $param['search']));


        //所有模型数据
        $models=model('models')->adminGetModelSelect();
        $this->assign('models',$models);

        return $this->fetch();
    }
    //留言通过审核
    public function commentExamine(){
        if($this->request->isAjax()){
            $id=$this->request->param('id/d', 0 ,'intval');
            $data=model('comment')->field('id,a_id,c_id,parent_id,reply')->find($id);
            // 通过审核
            $up = model('comment')->where('id',$id)->update(['is_status'=>1]);
            if($up){
                $category_data=model('admin/category')->getCategoryData($data['c_id']);
                $models_data=model('admin/models')->adminGetTableNameToModelId($category_data['model_id']);
                // 文章留言数量增加
                Lemon_comment_add($data['a_id'],$models_data['tablename']);
            }
            return ['code'=>200,'msg'=>'审核成功'];

        }
    }
    //留言删除
    public function isDel(){
        if($this->request->isAjax()){
            $id=$this->request->param('id/d', 0 ,'intval');

            $data=model('comment')->field('id,a_id,c_id,parent_id,reply')->find($id);
            $dels=0;
            if($data['parent_id'] == 0 && $data['reply'] != 0){
                //删除评论下的回复
                $dels=model('comment')->where('parent_id',$id)->delete();
            }
            $del=model('comment')->where('id',$id)->delete();
            $del_num=$dels+$del;   //删除总数
            if($data['parent_id'] != 0){
                //减少评论下的回复数量
                model('comment')->where('id',$data['parent_id'])->setDec('reply');
            }
            //减少对应内容的评论数

            $category_data=model('category')->getCategoryData($data['c_id']);
            $model_data=model('models')->adminGetTableNameToModelId($category_data['model_id']);
            model($model_data['tablename'])->where('id',$data['a_id'])->setDec('comment_num',$del_num);

            return ['code'=>200,'msg'=>'删除成功'];

        }
    }

    //留言数据修复
    public function upComment(){
        //先更新每个模型内的内容 是否准确
        $models=model('models')->adminGetModelSelect();
        foreach ($models as $v){
            if($v['id'] != 4){
                $data=Db::name($v['tablename'])->field('id,category_id,comment_num')->select();
                //查找评论并更新
                $up_data=[];
                foreach ($data as $key=>$val){
                    $num=Db::name('comment')->where(['a_id'=>$val['id'],'c_id'=>$val['category_id']])->count('id');
                    $up_data[]=['id'=>$val['id'],'comment_num'=>$num];
                }
                $up=model($v['tablename'])->isUpdate(true)->allowField(true)->saveAll($up_data);
            }
        }

        //更新每个评论的回复数量是否准确
        $comment_data=model('comment')->where('parent_id',0)->field('id,parent_id,reply')->select();
        $up_comment_arr=[];
        foreach ($comment_data as $c_k=>$c_v){
            $comment_num=model('comment')->where('parent_id',$c_v['id'])->count('id');
            $up_comment_arr[]=['id'=>$c_v['id'],'reply'=>$comment_num];
        }
        $up_comment=model('comment')->isUpdate(true)->allowField(true)->saveAll($up_comment_arr);
        
        return ['code'=>200,'msg'=>'更新成功'];

    }
}