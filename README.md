# QcloudApi-VOD
- php sdk for www.qcloud.com vod service
- 针对腾讯云点播服务(后期可能支持其他腾讯云产品接口服务，有需要可以 [收藏](https://github.com/ShaoZeMing/QcloudApi-VOD/stargazers) || [关注](https://github.com/ShaoZeMing/QcloudApi-VOD/subscription))，基于多个官方SDK进行封装，目前支持：

>    1. 点播服务：
>        - 分类添加，修改，查找，删除。
>        - 视频API上传
>        - 视频信息获取
>        - ·····（待更新）

* 使用本包前，建议阅读官方文档<https://www.qcloud.com/document/product/266/1965>。*
知其然而知其所以然才是修仙成佛之根本。当然了，你真不想看，也阔以！我对很多方法也做了简化的修改，使其看着一目了然。如果这样你还是一脸懵逼？也没关系，后期我也会添加简单使用说明手册，保证智商受限的童鞋也能快速使用。什么？这还不行！（惊讶）那个.....，这。这位看官，别激动，放下你手里的板砖，我们有话好好说，我再给你一个demo....(哭着跑。。。)

如有不当之处，请各位看官批评指正。可以在我的GitHub上<https://github.com/ShaoZeMing/QcloudApi-VOD/issues>讨论

# 文件结构描述

在此简要介绍以下几个文件：

```
    - src/QcloudApi/Common             核心公共类文件目录
    - src/QcloudApi/Module             核心各个云服务模块类目录
    - src/QcloudApi.php                核心加载中心类文件。
    - src/Wrapper/                     使用操作类目录
    - src/Wrapper/CommonVod.php        点播api公共类
    - src/Wrapper/ClassApi.php         点播分类api操作类
    - src/Wrapper/VideoUpload.php      点播视频上传类
    - src/Wrapper/VideoUpload.php      点播视频api操作类
    - src/.......(更新中。。。。)
```

# 安装

## 方法 1：(推荐)
执行命令

   `composer require shaozeming/qcloudapi-vod "dev-master"`

直接运行composer自动安装代码。

## 方法 2：
在项目根目录的下composer.json文件中添加代码 `shaozeming/qcloudapi-vod": "dev-master`
```
     "require": {
            "php": ">=5.6.4",
            "laravel/framework": "5.3.*",
            "predis/predis": "^1.1",
            "zizaco/entrust": "5.2.x-dev",
            "shaozeming/qcloudapi-vod": "dev-master"  //添加这一行
        },
```
添加在 require 中。然后执行命令：`composer update`。

## 方法 3：
直接在github<https://github.com/ShaoZeMing/QcloudApi-VOD>,下载源代码。减压到你需要的项目中。

在需要使用的API的代码文件中添加：

`require_once $xx_path.'/vendor/autoload.php'`

注：`$xx_path`指的是基于api文件减压目录路径
该核心类会自动基于composer.json 加载相应的类文件。

# 使用

## 上传视频demo

```
<?php

require_once __DIR__ . '/vendor/autoload.php';


error_reporting(E_ALL ^ E_NOTICE);
require_once  './src/QcloudApi/QcloudApi.php';

$form = <<<ETC
<form  method='post' enctype='multipart/form-data'>
<input name=id>
<input type="file" name = "file">
<input type=submit>
</form>
ETC;
echo $form;

if (isset($_FILES['file'])) {
    var_dump('<pre>', $_FILES['file'], '</pre>');
    $filename = $_FILES['file']['tmp_name'];
    $config = array(
        'SecretId' => '**************',        //你的腾讯云SecretId
        'SecretKey' => '***************',      //你的腾讯云SecretKey
        'RequestMethod' => 'POST',             //上传接口只支持POST方法
        'DefaultRegion' => 'bj',               //区域标记，保持默认不需要更改
        'ServerPort' => ''                     //端口默认是80，不需要设置
    );
    $vod = new \shaozeming\api_vod\VideoUpload($config);
//要输入的参数
    $package = array(
        'fileName' => $_FILES['file']['tmp_name'],                                              //文件的绝对路径，包含文件名
        'dataSize' => 1024 * 1024 * 5,                                       //分片大小，建议使用默认值5MB
        'isTranscode' => 0,                                                  //是否转码
        'isScreenshot' => 0,                                                 //是否截图
        'isWatermark' => 0,                                                  //是否添加水印
        'isTranscode' => 1,                                                  //是否转码
        'notifyUrl' => ""                                                     //转码完成后的回调地址，不转码此项无效
       //.......
    );
    $vod->videoUpload($package);
}
```

更新中。。。






