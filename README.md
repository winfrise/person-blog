LeCMS 1.0.1 开源博客系统
====================

### 基本功能
> 小白也可以快速搭建出一个博客系统

> 后台支持多模板切换，对于喜新厌旧者可以经常切换模板改变风格

> 支持一键七牛云存储，后期还会更新OSS存储功能。解决空间存储问题

> 支持单页模型、文章模型、链接模型、图集模型、下载模型、视频模型的发布

> 内容评论支持自动输入QQ获取昵称，后台可设置评论间隔防止恶意刷评论

> SiteMap一键生成，有利于搜索引擎的收录

### 开发环境

> 基于ThinkPHP5.0+Layui2.3

> ThinkPHP5的运行环境要求PHP5.4以上。

详细开发文档参考 [ThinkPHP5完全开发手册](http://www.kancloud.cn/manual/thinkphp5)

> LeCMS的运行环境要求PHP5.6以上。


### 安装说明

> 指定运行目录到 /public

> 开启伪静态  参考 [URl重写](https://www.kancloud.cn/manual/thinkphp5/177576)

> 拷贝程序到项目根目录

> 访问域名即可进入自动安装引导 

注意: Linux环境下，请注意相关权限问题。尤其是runtime目录，最低应为755权限

### 虚拟主机

> 针对虚拟主机无法指定运行目录到 /public 问题,特别制作了虚拟主机专用版,加群即可获取！


## 目录结构

初始的目录结构如下：

~~~
www  WEB部署目录（或者子目录）
├─application           应用目录
│  ├─common             公共模块目录（可以更改）
│  ├─module_name        模块目录
│  │  ├─config.php      模块配置文件
│  │  ├─common.php      模块函数文件
│  │  ├─controller      控制器目录
│  │  ├─model           模型目录
│  │  └─ ...            更多类库目录
│  │  
│  │
│  ├─command.php        命令行工具配置文件
│  ├─common.php         公共函数文件
│  ├─config.php         公共配置文件
│  ├─route.php          路由配置文件
│  ├─tags.php           应用行为扩展定义文件
│  └─database.php       数据库配置文件
│
├─public                WEB目录（对外访问目录）
│  ├─index.php          入口文件
│  ├─router.php         快速测试文件
│  └─.htaccess          用于apache的重写
│
├─thinkphp              框架系统目录
│  ├─lang               语言文件目录
│  ├─library            框架类库目录
│  │  ├─think           Think类库包目录
│  │  └─traits          系统Trait目录
│  │
│  ├─tpl                系统模板目录
│  ├─base.php           基础定义文件
│  ├─console.php        控制台入口文件
│  ├─convention.php     框架惯例配置文件
│  ├─helper.php         助手函数文件
│  ├─phpunit.xml        phpunit配置文件
│  └─start.php          框架入口文件
│
├─extend                扩展类库目录
├─runtime               应用的运行时目录（可写，可定制）
├─vendor                第三方类库目录（Composer依赖库）
├─build.php             自动生成定义文件（参考）
├─composer.json         composer 定义文件
├─LICENSE.txt           授权说明文件
├─README.md             README 文件
├─think                 命令行入口文件
~~~

### 演示demo

[恒哥博客](https://www.qq123.xin/)

[悠悠吧](https://www.usuuu.com/) (个人编写的模板)

### 历史版本

> 2019-5-24   1.0.1版本更新
  
  <p>更新说明：新增评论审核功能，需要更新数据库文件。将application/install/sql/update_2019_05_24.sql导入数据库即可。</p>

> 2018-7-27   1.0.0版本上线


### 联系方式

<p>QQ用户交流群：593739481&nbsp;&nbsp;
    <a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=f79768a1be482c1e32132b71dacaf15b0806c85f848ec719cfb4a4d3581e0027"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="LemonCMS" title="LemonCMS"></a>
</p>
<hr>
<p>QQ高级付费群：838652492&nbsp;&nbsp;&nbsp;
    <a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=b32cbc8133893701665619389d7d5b6072e3a8916e1597b4c79fd5a7451e6b46"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="LeCMS高级交流群" title="LeCMS高级交流群"></a>
</p>
<p>QQ联系我：304587661&nbsp;&nbsp;
   <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=304587661&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:304587661:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>
</p> 

## 特别感谢

空白的记忆 (小姐姐呦)


