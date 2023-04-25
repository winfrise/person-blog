<?php
/**
 * Created by PhpStorm.
 * User: hengge
 * Date: 2018/6/19
 * Time: 19:54
 */
namespace app\index\model;

use think\Model;

class Comment extends Model{
    public function getCommentPageData($param){
        $limit=10;
        //$start=($param['page']-1)*$limit;
        $where=[
            'a_id'=>(int)$param['id'],
            'c_id'=>$param['c_id'],
            'parent_id'=>(int)$param['comment_id'],
            'is_status'=> 1,
        ];
        //$data=$this->where(['a_id'=>$param['id'],'c_id'=>$param['c_id']])->limit($start,$limit)->order('create_time desc,id')->select()->toArray();
        $data=$this->where($where)->order('create_time desc,id')->paginate($limit)->toArray();

        return $data;
    }
}