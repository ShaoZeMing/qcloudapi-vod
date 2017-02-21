# QcloudApi-VOD
- php sdk for www.qcloud.com vod service
- 针对腾讯云点播服务，基于官方SDK进行封装，使用本包前，建议阅读官方文档<https://www.qcloud.com/document/product/266/1965>。
- 如有不当之处，请各位看官批评指正。

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
** 注：`$xx_path`基于api文件减压目录路径 **
该核心类会自动基于composer.json 加载相应的类文件。




