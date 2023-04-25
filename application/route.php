<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------



return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    //首页
    //'/' => 'index/index/index',
    //文章模型
    '[article-index]'    => [
        '[:category]'   => ['index/article/index', ['method' => 'get'], ['category' => '\d+']],
    ],
    '[article-lists]'    => [
        '[:category]'   => ['index/article/lists', ['method' => 'get'], ['category' => '\d+']],
    ],
    '[article]'          => [
        '[:id]'            => ['index/article/show', ['method' => 'get'], ['id' => '\d+']],
    ],
    //下载模型
    '[download-index]'    => [
        '[:category]'   => ['index/download/index', ['method' => 'get'], ['category' => '\d+']],
    ],
    '[download-lists]'    => [
        '[:category]'   => ['index/download/lists', ['method' => 'get'], ['category' => '\d+']],
    ],
    '[download]'          => [
        '[:id]/[:pwd]'    => ['index/download/show', [], ['id' => '\d+','pwd' => '\w+']],
    ],

    //单页模型
    '[page]'     => [
        '[:category]'   => ['index/page/index', ['method' => 'get'], ['category' => '\d+']],
    ],
    //图片模型
    '[picture-index]'    => [
        '[:category]'   => ['index/picture/index', ['method' => 'get'], ['category' => '\d+']],
    ],
    '[picture-lists]'    => [
        '[:category]'   => ['index/picture/lists', ['method' => 'get'], ['category' => '\d+']],
    ],
    '[picture]'          => [
        '[:id]/[:pwd]'            => ['index/picture/show', [], ['id' => '\d+','pwd' => '\w+']],
    ],


    //视频模型
    '[video-index]'    => [
        '[:category]'   => ['index/video/index', ['method' => 'get'], ['category' => '\d+']],
    ],
    '[video-lists]'    => [
        '[:category]'   => ['index/video/lists', ['method' => 'get'], ['category' => '\d+']],
    ],
    '[video]'          => [
        '[:id]/[:pwd]'            => ['index/video/show', [], ['id' => '\d+','pwd' => '\w+']],
    ],



    //搜索
    '[search]'          => [
        '[:model_id]/[:keywords]'  => ['index/search/search', [], ['model_id' => '\d+','keywords' => '\w+']],
    ],



];