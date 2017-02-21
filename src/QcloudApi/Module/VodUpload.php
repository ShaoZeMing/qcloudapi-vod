<?php
require_once QCLOUDAPI_ROOT_PATH . '/Module/Base.php';
/**
 * QcloudApi_Module_Vod
 * 视频云模块类
 */
class QcloudApi_Module_VodUpload extends QcloudApi_Module_Base
{
    /**
     * $_serverHost
     * 接口域名
     * @var string
     */
    protected $_serverHost = 'vod.qcloud.com';
    
//    public function __construct()
//    {
//        //目前只支持POST方法
//        if($this->_requestMethod != 'POST')
//            $this->_requestMethod = 'POST';
//    }
    
    /**
     * MultipartUploadVodFile
     * 上传视频文件
     * @param  array $params API请求参数
     * @return
     */
    public function MultipartUploadVodFile($params)
    {
        $name = 'MultipartUploadVodFile';
        
        //设置API请求参数
        if(!isset($params['fileName']))
        {
            echo "API fileName参数为空，为必填选项\n";
            return false;
        }
        if(empty($params['fileName']))
        {
            echo "fileName为空，请检测参数";
            return false;
        }
        if(!is_file($params['fileName']))
        {
            echo $params['fileName']."  不存在，请检测\n";
            return false;
        }
        
        $fileSha = sha1_file($params['fileName']);
        $fileSize = filesize($params['fileName']);
        
        //不包含路径的全文件名
        //$fileName = basename($params['fileName']);
        //防止中文文件名中有空格
        $len_dir = strlen(dirname($params['fileName']));
        if(dirname($params['fileName']) == '.')
            $fileName = $params['fileName'];
        else
            $fileName = substr($params['fileName'],$len_dir+1);
        
        //不包含路径且无后缀的文件名
        $pos_dot = (int)strrpos($fileName,'.');

        $fileType = substr($fileName,$pos_dot+1);
        $fileName_NoSurfix = substr($fileName,0,$pos_dot);
        
        //分片大小 未设置选择512KB
        if(!isset($params['dataSize']))
        {
            $sliceSize = 1024*512;
        }
        else
        {
            $sliceSize = $params['dataSize'];
        }
        
        $nextOffset = 0;
        static $retry_times = 0;
        
        while(true)
        {
            //随机整数，每次发送分片时都要变化
            $Nonce = rand(0,1000000);
            
            $timestamp = time();
            
            //如果是网络问题出错重传 
            if($retry_times != 0)
            {
                $nextOffset = 0;
                $sliceSize = 1024*512;
            }
            
            //最后一个分片大小选择实际剩余的还为发送的大小
            if($fileSize - $nextOffset < $sliceSize)
            {
                $sliceSize = $fileSize - $nextOffset;
            }
            
            //封装API参数
            $arguments = array(
                'Action' => $name,
                'Nonce' => $Nonce,
                'Region' => $this->_defaultRegion,
                'SecretId' => $this->_secretId,
                'Timestamp' => $timestamp,
                'dataSize' => $sliceSize,
                'fileName' => $fileName_NoSurfix,
                'fileSha' => $fileSha,
                'fileSize' => $fileSize,
                'fileType' => $fileType,
                'isTranscode' => isset($params['isTranscode'])? $params['isTranscode']:0,
                'isScreenshot' => isset($params['isScreenshot'])? $params['isScreenshot']:0,
                'isWatermark' => isset($params['isWatermark'])? $params['isWatermark']:0,
                'name' => $fileName,
                'offset' => $nextOffset,
                'notifyUrl' => isset($params['notifyUrl'])?$params['notifyUrl']:""
            );
            
            //读取要发送的文件内容
            $fp = fopen($params['fileName'],"rb");
            
            if(!$fp)
            {
                echo $params['fileName']." 文件打开错误";
                return false;
            }
            
            fseek($fp,$nextOffset);
            $data = fread($fp,$sliceSize);
            fclose($fp);
            
            $response = $this->dispatchRequest($name, array($arguments),$data);
            
            if(!$response)
            {
                $this->setError("", 'request falied!');
                $retry_times++;
                
                if($retry_times > 3)
                    return false;
                else
                {
                    echo "retry ".$retry_times." times";
                    continue;
                }
            }
            
            //执行成功
            if($response['code'] == 0)
            {
                $retry_times = 0;
                //是最后一个分片
                if($response['flag'] == 1)
                {
                    echo "upload success!\n";
                    echo "fileId:".$response['fileId'];
                    return true;
                }
                //读取服务器返回的正确的下一次要发送的偏移量
                else
                {
                    $nextOffset = $response['offset'];
                }
            }
            else
            {
                echo $response['msg'];
                return false;
            }
        }       
    }
    
    /**
     * dispatchRequest
     * 发起接口请求
     * @param  string $name      接口名
     * @param  array $arguments 接口参数
     * @param  string $data     发送的数据
     * @return
     */
    protected function dispatchRequest($name, $arguments,$data)
    {
        
        $action = ucfirst($name);
    
        $params = array();
        if (is_array($arguments) && !empty($arguments)) {
            $params = (array) $arguments[0];
        }
        $params['Action'] = $action;
    
        if (!isset($params['Region']))
            $params['Region'] = $this->_defaultRegion;
    
        require_once QCLOUDAPI_ROOT_PATH . '/Common/Request_Upload.php';
        
        $request['method'] = $this->_requestMethod;
        $request['uri'] = $this->_serverUri;
        $request['host'] = $this->_serverHost;
        $request['port'] = $this->_serverPort;
        $request['query'] = http_build_query($params);
        
        $response = QcloudApi_Common_Request_Upload::send($params, $this->_secretId, $this->_secretKey, $request,$data);
    
        return $response;
    }
}