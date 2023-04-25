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
 * Time: 15:06
 */
namespace app\index\model;


use think\Db;
use think\Model;

class Article extends Model{

    /*
     *  获取推荐文章(首页使用)
     */
    public function indexGetArticleToIsRecommend(){
        $cacheName=CMS_NAME . 'article_recommend_data_where_recommend';

        $where=['a.delete_time'=>0,'a.is_show'=>1,'a.is_recommend'=>1,'c.delete_time'=>0];
        $data=cache($cacheName);
        if($data == false || is_null($data)){
            $field='a.id,a.category_id,a.title,a.description,a.image_url,a.author,a.hits,a.is_recommend,a.comment_num,a.is_top,c.name as category_name,a.url,a.create_time,c.url as category_url';

            $data=$this->alias('a')
                ->join('category c','a.category_id=c.id')
                ->where($where)
                ->field($field)
                ->order('is_top DESC,create_time DESC')
                ->limit(10)
                ->select()
                ->toArray();

            cache($cacheName,$data,'','article_data');
        }

        return $data;
    }
    /*
     * 根据条件获取文章 (首页、右侧栏使用)
     */
    public function indexGetArticleToOrder($where=[],$order=[],$limit=5){
        $w=['delete_time'=>0,'is_show'=>1];
        if(!empty($where)){
            $w = array_merge($w,$where);
        }
        $str='';
        foreach ($w as $k=>$v){
            $str .= $k .'_'. $v . '_';
        }

        $cacheName=CMS_NAME . 'article_data_where_'.$str . implode('_',$order);

        $data=cache($cacheName);
        if($data == false || is_null($data)){
            $field='id,title,hits,url,image_url,comment_num';
            $data=$this->where($w)->field($field)->order("$order[0] $order[1]")->limit($limit)->select()->toArray();
            cache($cacheName,$data,'','article_data');
        }

        return $data;
    }
    /*
     * 获取所有文章列表(文章列表页)
     */
    public function indexGetArticleDataToCategoryId($category_id=0){
        $where=['a.delete_time'=>0,'a.is_show'=>1,'c.delete_time'=>0];
        if($category_id != 0){
            $ids=Db::name('category')->cache(true,'','category_data')->where(['delete_time'=>0,'is_menu'=>1,'parent_id'=>$category_id])->column('id');
            $ids=(empty($ids)) ? $category_id : $category_id . ',' . implode(',',$ids);
            $where['a.category_id']=['in',$ids];


        }
        $field='a.id,a.category_id,a.title,a.keywords,a.description,a.image_url,a.content,a.author,a.comment_num,a.source,a.hits,a.is_recommend,a.is_top,a.url,a.create_time,c.name as category_name,c.id as category_id,c.url as category_url';
        $data=$this->alias('a')
            ->join('category c','a.category_id=c.id')
            ->where($where)
            ->field($field)
            ->cache(true,'','article_data')
            ->order('is_top DESC,create_time DESC')
            ->paginate(10);

        return $data;
    }
    /*
     * 获取单个文章详情
     */
    public function indexFindArticleDataToId($id){
        $cacheName=CMS_NAME . 'article_data_to_id_' . $id;
        $returnArr=cache($cacheName);

        if($returnArr == false || is_null($returnArr)){
            $where=['delete_time'=>0,'is_show'=>1,'id'=>$id];
            $field='id,category_id,title,keywords,description,image_url,content,author,source,hits,url,create_time,comment_num';
            $data=$this->where($where)->field($field)->find();
            $returnArr=[];
            if(!is_null($data)){
                $returnArr=$data->toArray();
                $next = $this->where('id','<',$id)->where('category_id',$data['category_id'])->order('id desc')->find();
                $prev = $this->where('id','>',$id)->where('category_id',$data['category_id'])->order('id asc')->find();
                $next = (!is_null($next)) ? $next->toArray() : ['title'=>'返回列表','url'=>url('index/article/lists',['category'=>$data['category_id']])];
                $prev = (!is_null($prev)) ? $prev->toArray() : ['title'=>'返回列表','url'=>url('index/article/lists',['category'=>$data['category_id']])];
                $returnArr['prev']=$prev;
                $returnArr['next']=$next;
                return $returnArr;
            }
            cache($cacheName,$returnArr,'','article_data');
        }

        return $returnArr;
    }


}