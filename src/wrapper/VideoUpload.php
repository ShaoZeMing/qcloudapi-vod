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
require_once dirname(__DIR__)."/QcloudApi/QcloudApi.php";


class VideoUpload
{
    protected $_config = [
        'SecretId' => 'AKIDG6a*****************',          //腾讯云SecretId
        'SecretKey' => '7O9y2tznqmx****************',      //腾讯云SecretKey
        'RequestMethod' => 'POST',                                           //上传接口只支持POST方法
        'DefaultRegion' => 'bj',                                             //区域标记，保持默认不需要更改
        'ServerPort' => ''                                                 //端口默认是80，不需要设置

    ];  //必要的配置

    public  $cvn;   //接口对象


    /**
     * 构造方法
     *
     * $config array 配置属性同上面属性
     *
     * @author szm19920426@gmail.com
     *
     * @return mixed
     */
    public function __construct(array $config)
    {
        if(!is_array($config)){
            return false;
        }
        $this->_config = array_merge($this->_config, $config);
        $this->cvn= $this->loadVod();

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
            throw new \Exception("c=VideoUpload,a=loadVod,msg=".$e->getMessage());
        }
        return $cvm;
    }



    /**
     * 上传视频
     *
     * @author szm19920426@gmail.com
     *
     * @param $package array  上传视频键值对参数,可访问"https://www.qcloud.com/document/product/266/1316#2.-.E8.BE.93.E5.85.A5.E5.8F.82.E6.95.B0"查看
     *
     * @return mixed
     */
    public function videoUpload(array $package)
    {
        return $this->cvn->MultipartUploadVodFile($package);
    }


}