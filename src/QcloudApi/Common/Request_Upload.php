<?php
require_once QCLOUDAPI_ROOT_PATH . '/Common/Request.php';

/**
 * 
 * 视频云模块文件上传请求
 */
class QcloudApi_Common_Request_Upload extends QcloudApi_Common_Request
{
    /**
     * send
     * 发起请求
     * @param  array  $paramArray    API参数
     * @param  string $secretId      secretId
     * @param  string $secretKey     secretKey
     * @param  array  $request       http请求参数
     * @param  string $data          发送的数据
     * @param  bool   $https         是否使用https协议
     * @return
     */
    public static function send($paramArray, $secretId, $secretKey, $request,$data,$https=false)
    {
    
        if(!isset($paramArray['SecretId']))
            $paramArray['SecretId'] = $secretId;
    
        if (!isset($paramArray['Nonce']))
            $paramArray['Nonce'] = rand(1, 65535);
    
        if (!isset($paramArray['Timestamp']))
            $paramArray['Timestamp'] = time();
    
        $paramArray['RequestClient'] = self::$_version;
        
        $plainText = QcloudApi_Common_Sign::makeSignPlainText($paramArray,
            $request['method'], $request['host'], $request['uri']);
    
        $paramArray['Signature'] = QcloudApi_Common_Sign::sign($plainText, $secretKey);
        
        /*
        ksort($paramArray);
        $plainText = '';
        $paramText = http_build_query($paramArray);
        $plainText = $request['method'].$request['host'].$request['uri'].'?'.$paramText;
        $sig = base64_encode(hash_hmac('sha1',$plainText,$secretKey,true));
        $paramArray['Signature'] = $sig;*/
        
        //重新设置request 选择rawurlencode
        $request['query'] = http_build_query($paramArray);
        $request['query'] = str_replace('+','%20',$request['query']);
    
        $url = $request['host'].$request['uri'];
    
        if($request['port'] != '' && $request['port'] != 80)
        {
            $url = $request['host'].":".$request['port'].$request['uri'];
        }
        $url = $url.'?'.$request['query'];
    
        
        if($https)
        {
            $url = 'https://'.$url;
        }
        else
        {
            $url = 'http://'.$url;
        }
    
        $request['url'] = $url;
        
        $ret = self::_sendPostRequest($request, $paramArray,$data);
    
        return $ret;
    }
    
    /**
     * _sendPostRequest
     * @param  array  $request    http请求参数
     * @param  array  $paramArray API参数
     * @param  string $data       发送的数据
     * @return
     */
    protected static function _sendPostRequest($request, $paramArray, $data)
    {  
        $url = $request['url'];
        self::$_requestUrl = $url;
        
        //$ch = curl_init($url);
        
        $header = array(
            "POST {$request['uri']}?{$request['query']} HTTP/1/1",
            "HOST:{$request['host']}",
            "Content-Length:".$paramArray['dataSize'],
            "Content-type:application/octet-stream",
            "Accept:*/*",
            "User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36",
            	
        );
        
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_FRESH_CONNECT,1);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_FORBID_REUSE,1);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
            
        if (false !== strpos($url, "https")) {
            // 证书
            // curl_setopt($ch,CURLOPT_CAINFO,"ca.crt");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  false);
        }
        
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        
        
        $response = curl_exec($ch);
    
        curl_close($ch);
        
        self::$_rawResponse = $response;
    
        $result = json_decode($response, true);
        if (!$result)
        {
            echo "请求发送失败，请检查URL:\n";
            echo $url;
            return $response;
        }
        return $result;
    }
}

?>