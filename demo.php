<?php

require_once __DIR__ . '/vendor/autoload.php';
error_reporting(E_ALL ^ E_NOTICE);

/*********************添加分类**********************/
$form = <<<ETC
<form>
 父类id:<input name='pid'><br>
 分类名称<input name='name'><br>
<input type=submit value="添加">
</form>
ETC;
echo $form;
if (isset($_GET['name'])) {
    $config = array(
        'SecretId' => 'AKIDG*****************',   //腾讯云SecretId
        'SecretKey' => '7O9y2tz***************',      //腾讯云SecretKey
        'RequestMethod' => 'GET',                                           //上传接口只支持POST方法
        'DefaultRegion' => 'bj',                                             //区域标记，保持默认不需要更改
    );
    $sd = new \shaozeming\api_vod\ClassApi($config);

    $data = $sd->getAllClass();
//    $data = $sd->getAllClass();


//    $arr=[
//        'parentId'=>$_GET['pid'],
//        'className'=>$_GET['name']
//    ];
//    $data = $sd->createClass($_GET['name']);
//
    var_dump($data);
}

