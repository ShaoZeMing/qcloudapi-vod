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
     * 创建视频分类
     *
     * @author szm19920426@gmail.com
     *
     * @param $className string  分类名称，
     * @param $parentId int  父类ID，默认-1顶级，
     *
     * @return mixed
     */
    public function createClass($className,$parentId = -1)
    {
        if($parentId== -1){
            $package=[
                'className'=>$className,
            ];
        }else{
            $package=[
                'className'=>$className,
                'parentId'=>$parentId,
            ];
        }

        return $this->cvn->CreateClass($package);
    }

    /**
     * 获取所有分类层级结构数据
     *
     * @author szm19920426@gmail.com
     *
     * @return mixed
     */
    public function getLevelAllClass()
    {
        return $this->cvn->DescribeAllClass();
    }

    /**
     * 获取所有视频分类分层级结构
     *
     * @author szm19920426@gmail.com
     *
     * @return mixed
     */
    public function getAllClass()
    {
        return $this->cvn->DescribeClass();
    }


    /**
     * 修改分类名称
     *
     * @author szm19920426@gmail.com
     *
     * @param $package array  所需键值对参数，请参考对应文档参数<https://www.qcloud.com/document/product/266/1965>，
     *
     * @return mixed
     */
    public function saveClassName( $classId,$className )
    {
        $package = [
            "classId" => $classId,
            "className" => $className,
        ];
        return $this->cvn->ModifyClass($package);
    }



    /**
     * 删除视频分类
     *
     * @author szm19920426@gmail.com
     *
     * @param $classId int  分类id
     *
     * @return mixed
     */
    public function deleteClass($classId)
    {
        $package = [
            "classId" => $classId,
        ];
        return $this->cvn->DeleteClass($package);
    }


    /**
     * 获取视频播放信息，可以根据视频文件名前缀获得多个视频信息列表。
     *
     * @author szm19920426@gmail.com
     *
     * @param $package array  所需键值对参数，请参考对应文档参数<https://www.qcloud.com/document/product/266/1965>，
     *
     * @return mixed
     */
    public function getVideoPlayInfo($package)
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
    public function getVideoPlayUrls($fileId)
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
    public function getVideosInfo($package=[])
    {
        if(empty($package)){
            return $this->cvn->DescribeVodInfo();
        }else{
            return $this->cvn->DescribeVodInfo($package);
        }

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
    public function saveVideoInfo($package)
    {
        return $this->cvn->ModifyVodInfo($package);
    }

//
//    /**
//     * 设置视频封面图片
//     *
//     * @author szm19920426@gmail.com
//     *
//     * @param $fileId int  视频ID，
//     * @param $imageFile string  封面图片文件，
//     *
//     * @return mixed
//     */
//    public function setVideoImage($fileId,$imageFile)
//    {
//        if(!file_exists($imageFile)){
//            echo $imageFile."文件不存在！";
//            return false;
//        }
//        $package = [
//            'fileId' => $fileId,
//            'type' => 2,
//            'para' => $imageFile,
//            'imageData'=> base64_encode($imageFile)
//
//        ];
//        return $this->cvn->DescribeVodCover($package);
//    }


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
    public function saveVideoClass($fileId, $classId)
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
    public function convertVideoFile($fileId)
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