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


class ClassApi extends CommonVod
{

    /**
     * 创建视频分类
     *
     * @author szm19920426@gmail.com
     *
     * @parameter $className string  分类名称
     *
     * @parameter $parentId int  父类id,默认为0
     *
     * @return mixed
     */
    public function createClass( $className, $parentId=0)
    {
        return $this->cvn->CreateClass($className,$parentId);
    }

    /**
     * 获取所有分类层级
     *
     * @author szm19920426@gmail.com
     *
     * @return mixed
     */
    public function getAllClass()
    {
        return $this->cvn->DescribeAllClass();
    }

    /**
     * 获取所有视频分类
     *
     * @author szm19920426@gmail.com
     *
     * @return mixed
     */
    public function getClass()
    {
        return $this->cvn->DescribeClass();
    }


    /**
     * 修改分类名称
     *
     * @author szm19920426@gmail.com
     *
     * @parameter $classId int  分类id
     *
     * @parameter $className string  分类新名称
     *
     * @return mixed
     */
    public function saveClassName( $classId, $className )
    {
        return $this->cvn->ModifyClass($classId,$className);
    }


    /**
     * 修改视频分类
     *
     * @author szm19920426@gmail.com
     *
     * @parameter $fileId int  视频id
     *
     * @parameter $classId int  分类id
     *
     * @return mixed
     */
    public function saveVideoClass( $fileId, $classId )
    {
        return $this->cvn->ModifyVodClass($fileId,$classId);
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
    public function deleteClass( $classId)
    {
        return $this->cvn->DeleteClass($classId);
    }

}