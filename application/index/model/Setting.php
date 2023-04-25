<?php
/**
 * Created by PhpStorm.
 * User: hengge
 * Date: 2018/7/2
 * Time: 12:09
 */
namespace app\index\model;


use think\Model;

class Setting extends Model{

    public function getSetting(){
        $cacheName=CMS_NAME . '_setting_data';
        $setting=cache($cacheName);
        if($setting == false || is_null($setting)){
            $setting=model('setting')->column('key,value');
            $setting['stationmaster_info']=json_decode($setting['stationmaster_info'],true);
            $setting['links']=json_decode($setting['links'],true);
            $setting['search_model']=json_decode($setting['search_model'],true);

            cache($cacheName,$setting,'','setting_data');
        }
        return $setting;
    }
}