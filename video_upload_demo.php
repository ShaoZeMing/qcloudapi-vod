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

    $config = array(
        'SecretId' => 'AKIDG*****************',   //你的腾讯云SecretId
        'SecretKey' => '7O9y2tz***************',      //你的腾讯云SecretKey
        'RequestMethod' => 'POST',                                           //上传接口只支持POST方法
        'DefaultRegion' => 'bj',                                             //区域标记，保持默认不需要更改
        'ServerPort' => ''                                                 //端口默认是80，不需要设置
    );
    $vod = new \shaozeming\api_vod\VideoUpload($config);  //要输入的参数

    $filename = $_FILES['file']['tmp_name'];
    $filePath = "./upload/vidoe/";
    $filePath = is_dir($filePath) ? $filePath : mkdir($filePath, 777, true);
    $file = $filePath . date("YmdHis") . $_FILES['file']['name'];
    $mv = move_uploaded_file($filename, $file);
    if ($mv) {
        $re = $vod->videoUpload($file,1);
       @unlink($file);
    }


}


