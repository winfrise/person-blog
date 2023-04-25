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
 * Date: 2018/5/11
 * Time: 17:38
 */
namespace app\admin\controller;

use think\Controller;



/*
 * 数据优化都在model层
 * 常用的是models
 *
 */


class Article extends Common  {

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    //显示文章类下所有内容
    public function index(){
        
        $category_id=$this->request->param('category/d', 0 ,'intval');
        $param=$this->request->param();


        if($category_id != 0){
            $param['category_id']=$category_id;
        }

        $models=model('models')->adminGetModelSelectAndUrl();
        $this->assign('models',$models);

        $data=model('article')->adminGetArticleAllDataToPage($param);

        $data->appends($param);
        $this->assign('data',$data->toArray());
        $this->assign('page',$data->render());
        //搜索赋值
        $this->assign('search',empty($param['search']) ? '' : $param['search']);
        //模型id
        $this->assign('model_id',$this->model_data['id']);
        return $this->fetch();
    }
    //文章添加
    public function add(){
        $category_id=$this->request->param('category/d', 0 ,'intval');

        $categorySelect=model('category')->adminCategorySelectTreeToModelId($category_id,0,$this->model_data['id']);

        $this->assign('category_select',$categorySelect);

        return $this->fetch();
    }
    //文章添加提交
    public function addPost(){
        if($this->request->isPost()){
            $params=$this->request->param();
            $return=['code'=>0,'msg'=>'添加失败'];
            $result =$this->validate($params,'Article');
            if($result !== true){
                $return['msg']=$result;
                return $return;
            }
            //将编辑部内容转义存储
            $params['content']=htmlspecialchars($params['content']);
            //创建时间转义
            $params['create_time']=strtotime($params['create_time']);

            $in=model('article')->add($params);
            if($in !== false){
                //成功
                $return['code']=200;
                $return['msg']='添加成功';
                return $return;
            }

            return $return;
        }
    }
    //文章编辑
    public function edit(){
        $id=$this->request->param('id/d', 0 ,'intval');

        $data=model('article')->adminFindDataToId($id);
        if($id == 0 || $data == false){
            $this->error('ID错误');
        }

        //获取栏目选中栏
        $categorySelect=model('category')->adminCategorySelectTreeToModelId($data['category_id'],0,$this->model_data['id']);
        $this->assign('category_select',$categorySelect);


        //循环models
        $models=model('models')->adminGetModelSelectAndUrl();
        $this->assign('models',$models);


        $this->assign('data',$data);
        return $this->fetch();

    }
    //文章编辑提交
    public function editPost(){
        if($this->request->isPost()){
            $data=$this->request->post();
            $return=['code'=>0,'msg'=>'修改失败'];
            $result =$this->validate($data,'Article');
            if($result !== true){
                $return['msg']=$result;
                return $return;
            }

            //将编辑部内容转义存储
            $data['content']=htmlspecialchars($data['content']);
            //创建时间转义
            $data['create_time']=strtotime($data['create_time']);

            $up=model('article')->edit($data);
            if($up !== false){
                //成功
                $return['code']=200;
                $return['msg']='修改成功';
                return $return;
            }

            return $return;
        }
    }
    //删除单个内容
    public function isDel(){
        if($this->request->isPost()){
            $id=$this->request->param('id/d',0,'intval');
            $arr=['code'=>0,'msg'=>'删除失败'];
            $del=model('article')->del($id);
            if($del !== false){
                $arr['code']=200;
                $arr['msg']='删除成功';
                return $arr;
            }
            return $arr;
        }

    }
    //批量删除
    public function delete(){
        if($this->request->isPost()){
            $ids=$this->request->param('ids/a');

            $arr=['code'=>0,'msg'=>'删除失败'];
            $del=model('article')->del($ids);
            if($del !== false){
                $arr['code']=200;
                $arr['msg']='删除成功';
                return $arr;
            }
            return $arr;

        }
    }
    //批量移动栏目
    public function removeCategory(){
        if($this->request->isPost()){
            $param=$this->request->param();
            $arr=['code'=>0,'msg'=>'移动失败'];

            $rm=model('article')->remove_category($param['ids'],$param['to_category_id']);
            if($rm !== false){
                $arr['code']=200;
                $arr['msg']='移动成功';
                return $arr;
            }
            return $arr;
        }
    }


    //推荐
    public function toRecommend(){
        if($this->request->isPost()){
            $param=$this->request->param();
            $return=['code'=>0,'msg'=>'修改失败'];
            $arr=['id'=>$param['id'],'is_recommend'=>$param['is_recommend']==0 ? 1 : 0];

            $up=model('article')->edit($arr);
            if($up !== false){
                //成功
                $return['code']=200;
                $return['msg']='修改成功';
                return $return;
            }
            return $return;
        }
    }
    //置顶
    public function toTop(){
        if($this->request->isPost()){
            $param=$this->request->param();
            $return=['code'=>0,'msg'=>'修改失败'];
            $arr=['id'=>$param['id'],'is_top'=>$param['is_top']==0 ? 1 : 0];
            $up=model('article')->edit($arr);
            if($up !== false){
                //成功
                $return['code']=200;
                $return['msg']='修改成功';
                return $return;
            }
            return $return;
        }
    }



}