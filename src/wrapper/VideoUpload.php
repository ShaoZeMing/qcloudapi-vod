<?php
/**
 * Created by PhpStorm.
 * User: ShaoZeMing
 * homepage: http://blog.4d4k.com
 * email: szm19920426@gmail.com
 * Date: 2016/2/21
 * Time: 10:14
 */
namespace shaozeming\api_vod;
require_once dirname(__DIR__) . "/QcloudApi/QcloudApi.php";


class VideoUpload
{
    protected $_config = [
        'SecretId' => 'AKIDG6a*****************',          //腾讯云SecretId
        'SecretKey' => '7O9y2tznqmx****************',      //腾讯云SecretKey
        'RequestMethod' => 'POST',                                           //上传接口只支持POST方法
        'DefaultRegion' => 'bj',                                             //区域标记，保持默认不需要更改
        'ServerPort' => ''                                                 //端口默认是80，不需要设置

    ];  //必要的配置

    protected $cvn;   //接口对象


    /**
     * 构造方法
     *
     * $config array 配置属性同上面属性
     *
     * @author szm19920426@gmail.com
     *
     * @return mixed
     */
    public function __construct(array $config = [])
    {
        if (!is_array($config) || empty($config)) {
            return false;
        }
        $this->_config = array_merge($this->_config, $config);
        $this->cvn = $this->loadVod();

    }

    /**
     * 设置配置属性方法
     *
     * $config array 配置属性同上面属性
     *
     * @author szm19920426@gmail.com
     *
     * @return mixed
     */
    public function setConfig(array $config)
    {
        if (!is_array($config)) {
            return false;
        }
        $this->_config = array_merge($this->_config, $config);
    }


    /**
     * vod点播视频上传接口方法
     *
     * @author szm19920426@gmail.com
     *
     * @return mixed
     */
    public function loadVod()
    {
        try {
            $cvm = \QcloudApi::load(\QcloudApi::MODULE_VOD_UPLOAD, $this->_config);
        } catch (\Exception $e) {
            throw new \Exception("c=VideoUpload,a=loadVod,msg=" . $e->getMessage());
        }
        return $cvm;
    }


    /**
     * 快捷上传视频
     *
     * @author szm19920426@gmail.com
     *
     * @param $fileName string 视频文件
     * @param $notifyUrl string 上传成功后转码完成后的回调地址
     * @param $isScreenshot int 是否截图
     * @param $isWatermark int  是否添加水印
     * @param $dataSize int   视频分片大小
     *
     * @return mixed
     */
    public function videoUpload($fileName, $notifyUrl = '', $isScreenshot = 0, $isWatermark = 0, $dataSize = 1024 * 1024 * 5)
    {
        $package = array(
            'fileName' => $fileName,                         //文件的绝对路径，包含文件名
            'dataSize' => $dataSize,                         //分片大小，建议使用默认值5MB
            'isScreenshot' => $isScreenshot,                 //是否截图
            'isWatermark' => $isWatermark,                   //是否添加水印
            'isTranscode' => 1,                               //是否转码
            'notifyUrl' => $notifyUrl,                       //转码完成后的回调地址，不转码此项无效
        );
        return $this->cvn->MultipartUploadVodFile($package);
    }


    /**
     * 快捷上传视频
     *
     * @author szm19920426@gmail.com
     *
     * @param $fileName string 视频名称
     * @param $notifyUrl string 上传成功后转码完成后的回调地址
     * @param $pullUrl   string    拉去地址url
     * @param $classId int  分类ID
     *
     * @return mixed
     */
    public function videoUrlUpload($pullUrl, $fileName, $classId = -1, $notifyUrl = '')
    {
        //是否输入分类
        if ($classId == -1) {
            $package = array(
                'pullset.1.url' => $pullUrl,                     //文件的url
                'pullset.1.fileName	' => $fileName,              //文件名称
                'isTranscode' => 1,                               //是否转码
                'pullset.1.notifyUrl' => $notifyUrl,             //转码完成后的回调地址，不转码此项无效
            );
        } else {
            $package = array(
                'pullset.1.url' => $pullUrl,                     //文件的绝对路径，包含文件名
                'pullset.1.fileName	' => $fileName,              //分片大小，建议使用默认值5MB
                'isTranscode' => 1,                               //是否转码
                'pullset.1.notifyUrl' => $notifyUrl,             //转码完成后的回调地址，不转码此项无效
                'pullset.n.classId' => $classId                  //所属分类
            );
        }
        return $this->cvn->MultiPullVodFile($package);
    }


    /**
     * 上传视频自定义方法，
     *
     * @author szm19920426@gmail.com
     *
     * @param $package array  上传视频键值对参数,可访问"https://www.qcloud.com/document/product/266/1316#2.-.E8.BE.93.E5.85.A5.E5.8F.82.E6.95.B0"查看
     *
     * @return mixed
     */
    public function videoUploadInfo(array $package)
    {

        return $this->cvn->MultipartUploadVodFile($package);
    }


}