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
 * Date: 2018/7/1
 * Time: 15:43
 */

namespace app\admin\controller;

use think\Cache;

class Setting extends Common {
    /*
     * 设置显示
     *
     */
    public function index(){
        $data=model('setting')->getSetting();


        //获取模板选择
        $temp=scandir('./template');
        unset($temp[0]);
        unset($temp[1]);

        $models=model('models')->adminGetModelSelect();
        $this->assign('setting',$data);
        $this->assign('models',$models);
        $this->assign('temp',$temp);


        return $this->fetch();
    }
    /*
     * 设置提交修改
     */
    public function indexPost(){
        if($this->request->isAjax()){
            $data=$this->request->post();
            $data['stationmaster_info']=json_encode($data['stationmaster_info']);
            //upload_type 1 本地  2 七牛  3 oss

            $data['qiniu_config']=json_encode($data['qiniu_config']);
            $search_model=[];

            if(!empty($data['search_model'])){
                $models=model('models')->adminGetModelSelect();
                foreach ($data['search_model'] as $v){
                    $name='';
                    foreach ($models as $m_v){
                        if($v == $m_v['id']){
                            $name=$m_v['name'];
                        }
                    }

                    $search_model[$v]=['id'=>$v,'name'=>$name];
                }
            };
            $data['search_model']=json_encode($search_model);


            foreach ($data as $k=>$v){
                $up=model('setting')->where('key',$k)->update(['value'=>$v]);
            }
            Cache::tag('setting_data')->clear();
            return ['code'=>200,'msg'=>'保存成功'];
        }
    }
    /*
     * siteMap 显示
     */
    public function sitemap(){

        $data=model('setting')->getSetting();
        $data['sitemap_model']=explode(',',$data['sitemap_model']);

        $models=model('models')->adminGetModelSelect();

        $changefreq_select = array(
            'always'  => '一直更新',
            'hourly'  => '小时',
            'daily'   => '天',
            'weekly'  => '周',
            'monthly' => '月',
            'yearly'  => '年',
            'never'   => '从不更新',
        );

        $this->assign('setting',$data);
        $this->assign('models',$models);
        $this->assign('changefreq_select',$changefreq_select);
        return $this->fetch();
    }
    /*
     * siteMap 生成
     */
    public function sitemapPost(){
        if($this->request->isAjax()){
            $param=$this->request->post();
            $param['sitemap_model']=implode(',',$param['sitemap_model']);

            foreach ($param as $k=>$v){
                $up=model('setting')->where('key',$k)->update(['value'=>$v]);
            }

            model('setting')->set_sitemap($param['changefreq'],$param['sitemap_model']);
            return ['code'=>200,'msg'=>'生成成功'];

        }
    }


    /*
     * 友情链接显示
     */
    public function links(){
        $data=model('setting')->getSetting();
        $links=(empty($data['links'])) ? [] : json_decode($data['links'],true);
        $add_id = 1 + end($links)['id'];
        $this->assign('links',$links);
        $this->assign('add_id',$add_id);
        return $this->fetch();
    }
    /*
     * 友情链接添加或修改
     */
    public function editLink(){
        if($this->request->isAjax()){
            $data=$this->request->post();
            $setting=model('setting')->getSetting();
            $links=(empty($setting['links'])) ? [] : json_decode($setting['links'],true);

            $links[$data['id']]=$data;
            $links=json_encode($links);
            $up=model('setting')->where('key','links')->update(['value'=>$links]);
            Cache::tag('setting_data')->clear();
            return ['code'=>200,'msg'=>'添加成功'];
        }
    }
    /*
     * 友情链接删除
     */
    public function delLink(){
        if($this->request->isAjax()){
            $id=$this->request->post('id/d', 0 ,'intval');
            $setting=model('setting')->getSetting();
            $links=(empty($setting['links'])) ? [] : json_decode($setting['links'],true);

            unset($links[$id]);
            $links=json_encode($links);
            model('setting')->where('key','links')->update(['value'=>$links]);
            Cache::tag('setting_data')->clear();
            return ['code'=>200,'msg'=>'删除成功'];
        }
    }
    /*
     * 友情链接排序
     */
    public function sortLink(){
        if($this->request->isAjax()){
            $data=$this->request->post();
            $setting=model('setting')->getSetting();
            $links=(empty($setting['links'])) ? [] : json_decode($setting['links'],true);

            foreach ($data['sorts'] as $k => $v) {
                $links[$k]['sort'] = $v;
            }
            $links = array_sort($links,'sort','desc');
            $links=json_encode($links);
            model('setting')->where('key','links')->update(['value'=>$links]);
            Cache::tag('setting_data')->clear();
            return ['code'=>200,'msg'=>'排序成功'];
        }
    }
}