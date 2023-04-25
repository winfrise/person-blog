<?php
/**
 * Created by PhpStorm.
 * User: hengge
 * Date: 2018/6/21
 * Time: 19:16
 */

namespace app\index\model;

use think\Model;
use think\Db;
class Download extends Model{

    /*
     * 获取所有下载列表(下载列表页)
     */
    public function indexGetDownloadDataToCategoryId($category_id=0){
        $where=['d.delete_time'=>0,'d.is_show'=>1,'c.delete_time'=>0];
        if($category_id != 0){
            $ids=Db::name('category')->cache(true,'','category_data')->where(['delete_time'=>0,'is_menu'=>1,'parent_id'=>$category_id])->column('id');
            $ids=(empty($ids)) ? $category_id : $category_id . ',' . implode(',',$ids);
            $where['d.category_id']=['in',$ids];
        }
        $field='d.id,d.category_id,d.title,d.keywords,d.description,d.is_pwd,d.image_url,d.file_url,d.demo_url,d.hits,d.comment_num,d.is_recommend,d.is_top,d.url,d.create_time,c.name as category_name,c.id as category_id,c.url as category_url';
        $data=$this->alias('d')
            ->join('category c','d.category_id=c.id')
            ->where($where)
            ->field($field)
            ->cache(true,'','download_data')
            ->order('is_top DESC,create_time DESC')
            ->paginate(10);
        return $data;
    }
    /*
     * 获取下载详情
     */
    public function indexFindDownloadDataToId($id){
        $cacheName=CMS_NAME . '_download_data_to_id_' . $id;
        $returnArr=cache($cacheName);

        if($returnArr == false || is_null($returnArr)){
            $where=['delete_time'=>0,'is_show'=>1,'id'=>$id];
            $field='id,category_id,title,keywords,description,image_url,file_url,is_pwd,hits,url,create_time,comment_num';
            $data=$this->where($where)->field($field)->find();
            $returnArr=[];
            if(!is_null($data)){
                $returnArr=$data->toArray();
            }

            cache($cacheName,$returnArr,'','download_data');

        }

        return $returnArr;
    }


}