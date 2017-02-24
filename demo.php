<?php

require_once __DIR__ . '/vendor/autoload.php';
error_reporting(E_ALL ^ E_NOTICE);
$config = array(
    'SecretId' => 'AKIDG*****************',   //你的腾讯云SecretId
    'SecretKey' => '7O9y2tz***************',      //你的腾讯云SecretKey
);
$vd = new \shaozeming\api_vod\VideoApi($config);    //实例化操作

$class = $vd->getAllClass();                        //获取全部分类，没有层级
//$levelClass = $vd->getLevelAllClass();                   //获取全部分类，带层级
$video = $vd->getVideosInfo(['orderby' => 1]);       //获取倒序10条视频列表

//var_dump($class);
//var_dump($levelClass);
//var_dump($video);
?>

<html>
<head>
    <title>demo演示</title>
</head>
<body>
<h1 style="color: red; align-content: center">请先在demo.php和video_upload_demo.php代码中配置你的SecretId，SecretKey</h1>

<h2> 添加分类</h2>

<form>
    父类id:<input name='pid'>
    分类名称<input name='className'>
    <input type=submit value="添加">
</form>
<hr>
<h2> 删除分类</h2>

<form>
    选择分类:<select name="dleCid">
        <?php foreach ($class['data'] as $v) { ?>
            <option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>  <?php } ?>
    </select>
    <input type=submit value="删除">
</form>

<hr>
<h2>上传视频</h2>

服务端上传点击<a href="video_upload_demo.php">web服务端上传demo</a>
体验h5_js上传点击<a href="web_js_upload.html">js页面上传demo</a>
<hr>

<h2>修改视频分类</h2>

<form method='post'
'>
视频id:<input type="text" name='vid'>
分类 :
<select name="pid">
    <?php foreach ($class['data'] as $v) { ?>
        <option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>  <?php } ?>
</select>
<input type=submit value="修改">
</form>
<hr>
<h2>删除视频</h2>
<?php foreach($video['fileSet'] as $v){?>
 <div <span>名称：<?=$v['fileName'] ?></span><br>
<img width="50px" src="<?=$v['imageUrl'] ?>">
    <form class="dleVideo" onsubmit="if(confirm('你确定要删除吗，删除了就再也找不回了')){return true;}else{return false}" n  method='post''>
    视频id:<input type="text" name='dleVideo' value="<?=$v['fileId'] ?>">
    <input  type=submit value="删除">
     </form>
</div>
<?php } ?>

<hr>
<pre>
<?php

if (isset($_GET['className'])) {
    $data = $vd->createClass($_GET['className']);    //添加分类
    var_dump($data);
}
if (isset($_GET['dleCid'])) {
    $data = $vd->deleteClass($_GET['dleCid']);       //删除分类
    var_dump($data);
}
if (isset($_POST['pid'])) {
    $data = $vd->saveVideoClass($_POST['vid'], $_POST['pid']);    //添加分类
    var_dump($data);
}
if (isset($_POST['dleVideo'])) {
    $data = $vd->deleteVideo($_POST['dleVideo']);    //添加分类
    var_dump($data);
}


?>
</pre>
</body>
</html>





