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
    public function saveClassName( $package )
    {
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

}