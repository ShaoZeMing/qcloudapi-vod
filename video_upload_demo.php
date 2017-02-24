<?php

require_once __DIR__ . '/vendor/autoload.php';
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
        'SecretId' => 'AKIDG*****************',   //腾讯云SecretId
        'SecretKey' => '7O9y2tz***************',      //腾讯云SecretKey
        'RequestMethod' => 'POST',                                           //上传接口只支持POST方法
        'DefaultRegion' => 'bj',                                             //区域标记，保持默认不需要更改
        'ServerPort' => ''                                                 //端口默认是80，不需要设置
    );
    $vod = new \shaozeming\api_vod\VideoUpload($config);
//要输入的参数
    $package = array(
        'fileName' => $_FILES['file']['tmp_name'],                         //文件的绝对路径，包含文件名
        'dataSize' => 1024 * 1024 * 5,                                      //分片大小，建议使用默认值5MB
        'isScreenshot' => 0,                                                 //是否截图
        'isWatermark' => 0,                                                  //是否添加水印
        'isTranscode' => 1,                                                  //是否转码
        'notifyUrl' => "",                                                   //转码完成后的回调地址，不转码此项无效
    );
    $vod->videoUpload($package);
}


