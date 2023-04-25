<?php
/**
 * Created by PhpStorm.
 * User: hengge
 * Date: 2018/7/2
 * Time: 10:37
 */
namespace app\admin\model;

use think\Model;
use think\Url;

class Setting extends Model{



    public function getSetting(){
        $data=$this->column('key,value');

        $data['stationmaster_info']=json_decode($data['stationmaster_info'],true);
        $data['qiniu_config']=json_decode($data['qiniu_config'],true);
        $data['search_model']=json_decode($data['search_model'],true);
        return $data;
    }

    /**
     * 生成sitemap
     * @param  string 	$changefreq 更新频率
     * @return [result]
     */
    public function set_sitemap($changefreq,$model_ids = '2'){
        $site_url = request()->domain();

        $site_url = trim($site_url,'/').'/';
        $model_ids_arr = explode(',', $model_ids);
        $models = model('models')->adminGetModelArray();

        $sitemap_str  = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap_str .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $sitemap_str .= '<url>';
        $sitemap_str .= '<loc>'.$site_url.'</loc>';
        $sitemap_str .= '<lastmod>'.date('Y-m-d',time()).'</lastmod>';
        $sitemap_str .= '<changefreq>daily</changefreq>';
        $sitemap_str .= '<priority>1.0</priority>';
        $sitemap_str .= '</url>';
        Url::root('/');
        foreach ($model_ids_arr as $model_id) {
            $data = model($models[$model_id])->order('id desc')->where(['delete_time'=>0,'is_show'=>1])->select()->toArray();
            foreach ($data as $k => $v) {
                if(strpos($v['url'],'http') === false){
                    $v['url'] = trim($site_url,'/').$v['url'];
                }
                $sitemap_str .= '<url>';
                $sitemap_str .= '<loc>'.$v['url'].'</loc>';
                $sitemap_str .= '<lastmod>'.date('Y-m-d',time()).'</lastmod>';
                $sitemap_str .= '<changefreq>'.$changefreq.'</changefreq>';
                $sitemap_str .= '<priority>0.8</priority>';
                $sitemap_str .= '</url>';
            }
        }

        $categorys = model('category')->order('id desc')->where(['delete_time'=>0,'is_menu'=>1])->select()->toArray();
        foreach ($categorys as $k => $v) {
            if(strpos($v['url'],'http') === false){
                $v['url'] = trim($site_url,'/').$v['url'];
            }
            $sitemap_str .= '<url>';
            $sitemap_str .= '<loc>'.$v['url'].'</loc>';
            $sitemap_str .= '<lastmod>'.date('Y-m-d',time()).'</lastmod>';
            $sitemap_str .= '<changefreq>weekly</changefreq>';
            $sitemap_str .= '<priority>0.6</priority>';
            $sitemap_str .= '</url>';
        }
        $sitemap_str .= '</urlset>';
        return file_put_contents('Sitemap.xml', $sitemap_str);
    }
}