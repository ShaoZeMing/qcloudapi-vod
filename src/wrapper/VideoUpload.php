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


class VideoUpload
{
    protected $_config = [
        'SecretId' => 'AKIDG6achVIpu1YC0GOzzFamLyaFrtZSQBWV',   //腾讯云SecretId
        'SecretKey' => '7O9y2tznqmxwxARpbcNqQz4fh9yOlFjA',      //腾讯云SecretKey
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
     * vod点播接口方法
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
     * 删除视频分类
     *
     * @author szm19920426@gmail.com
     *
     * @parameter $classId int  分类id
     *
     * @return mixed
     */
    public function videoUpload(array $package)
    {
        return $this->cvn->MultipartUploadVodFile($package);
    }

}