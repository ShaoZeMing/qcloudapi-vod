<?php
/**
 * Created by PhpStorm.
 * User: 4d4k
 * Date: 2017/2/22
 * Time: 11:53
 */

namespace shaozeming\api_vod;


class VideoApi extends CommonVod
{


    /**
     * 获取视频播放信息，可以根据视频文件名前缀获得多个视频信息列表。
     *
     * @author szm19920426@gmail.com
     *
     * @param $package array  所需键值对参数，请参考对应文档参数<https://www.qcloud.com/document/product/266/1965>，
     *
     * @return mixed
     */
    public function getVodPlayInfo($package)
    {
        return $this->cvn->DescribeVodPlayInfo($package);

    }


    /**
     * 获取单个视频所有播放地址、格式、码率、高度、宽度信息。
     *
     * @author szm19920426@gmail.com
     *
     * @param $fileId int  视频ID
     *
     * @return mixed
     */
    public function getVodPlayUrls($fileId)
    {
        $package = [
            "fileId"  => $fileId
        ];
        return $this->cvn->DescribeVodPlayUrls($package);

    }


    /**
     * 获取视频信息列表（根据不同搜索方式，获取多个）
     *
     * @author szm19920426@gmail.com
     *
     * @param $package array  所需键值对参数，请参考对应文档参数<https://www.qcloud.com/document/product/266/1965>，
     *
     * @return mixed
     */
    public function getVodInfo($package)
    {
        return $this->cvn->DescribeVodInfo($package);

    }



    /**
     * 修改视频信息
     *
     * @author szm19920426@gmail.com
     *
     * @param $package array  所需键值对参数，请参考对应文档参数<https://www.qcloud.com/document/product/266/1965>，
     *
     * @return mixed
     */
    public function saveVodInfo($package)
    {
        return $this->cvn->ModifyVodInfo($package);
    }


    /**
     * 设置视频封面图片
     *
     * @author szm19920426@gmail.com
     *
     * @param $fileId int  视频ID，
     * @param $imageFile string  封面图片文件，
     *
     * @return mixed
     */
    public function setVodImage($fileId,$imageFile)
    {
        if(!file_exists($imageFile)){
            echo $imageFile."文件不存在！";
            return false;
        }
        $package = [
          'fileId' => $fileId,
          'type' => 2,
          'para' => $imageFile,
        ];
        return $this->cvn->DescribeVodCover($package);
    }


    /**
     * 修改视频分类
     *
     * @author szm19920426@gmail.com
     *
     * @param $fileId int  视频id
     *
     * @param $classId int  分类id
     *
     * @return mixed
     */
    public function saveVodClass($fileId, $classId)
    {
        $package = [
            "fileId" => $fileId,
            "classId" => $classId,
        ];
        return $this->cvn->ModifyVodClass($package);
    }

    /**
     * 视频转码
     *
     * @author szm19920426@gmail.com
     *
     * @param $fileId int  视频id
     *
     * @return mixed
     */
    public function convertVodFile($fileId)
    {
        $package = [
            "fileId" => $fileId,
        ];
        return $this->cvn->ConvertVodFile($package);
    }

    /**
     * 删除视频
     *
     * @author szm19920426@gmail.com
     *
     * @param $fileId int  视频id
     *
     * @return mixed
     */
    public function deleteVideo($fileId)
    {
        $package = [
            "fileId" => $fileId,
            "priority" => 0,
        ];
        return $this->cvn->DeleteVodFile($package);
    }


}