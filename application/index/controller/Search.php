<?php
/**
 * Created by PhpStorm.
 * User: hengge
 * Date: 2018/7/2
 * Time: 12:34
 */
namespace app\index\controller;

class Search extends Common{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $category_breadcrumb[]=['name'=>'搜索'];
        $this->assign('category_breadcrumb',$category_breadcrumb);
    }

    //搜索首页
    public function search(){
        $param=$this->request->get();
        array_shift($param);
        $model_id=$this->request->get('model_id/d',0,'intval');
        $keywords=$this->request->get('keywords/s','');



        $model_data=model('admin/models')->adminGetTableNameToModelId($model_id);
        $tablename='article';
        if($model_data !== false){
            $tablename=$model_data['tablename'];
        }
        $where=['delete_time'=>0,'is_show'=>1,'title'=>['like','%' . $keywords . '%']];
        $data=model($tablename)->where($where)->field('id,title,keywords,description,image_url,url')->paginate(10);
        $data->appends($param);
        $page = $data->render();

        $this->assign('lists',$data);
        $this->assign('page',$page);
        $this->assign('keywords',$keywords);

        //推荐文章
        $recommend_list=model('article')->indexGetArticleToIsRecommend();
        $this->assign('recommend_list',$recommend_list);


        //热门文章
        $hot_list=model('article')->indexGetArticleToOrder([],['hits','desc']);
        $this->assign('hot_list',$hot_list);
        return $this->fetch();
    }
}