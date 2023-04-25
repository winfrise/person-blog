<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
//判断PHP版本
if(version_compare(phpversion(), '5.6') == -1){
    echo '请使用 PHP5.6 及以上版本！';exit;
}

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

//不显示警告错误
error_reporting(E_ALL^E_NOTICE^E_WARNING);


define('CMS_NAME','Lemon');
//定义版本
define('CMS_VERSION', 'v1.0.0');

define('POST_MAX',rtrim(ini_get('upload_max_filesize'),'M'));

// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
