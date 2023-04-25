<?php
/**
 * Created by PhpStorm.
 * User: hengge
 * Date: 2018/6/23
 * Time: 18:38
 */
namespace app\index\model;

use think\Model;

class Page extends Model{
    public function getPageDataToCategoryId($category_id){
        $cacheName=CMS_NAME . '_page_data_to_id_' . $category_id;
        $data=cache($cacheName);
        if($data == false || is_null($data)){
            $where=['category_id'=>$category_id,'delete_time'=>0];
            $data=$this->where($where)->field('id,category_id,title,keywords,description,content,image_url,hits,url,create_time,comment_num')->find();
            if(is_null($data)){
                $data=[];
            }else{
                $data=$data->toArray();
            }

            cache($cacheName,$data,'','page_data');
        }

        return $data;

    }
}