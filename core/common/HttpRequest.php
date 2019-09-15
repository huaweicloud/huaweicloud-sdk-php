<?php

namespace core\common;

/**
 * 数据操作类
 */


use Exception;

class HttpRequest
{
    /**
     * 将请求头key转为小写
     * @param $headers
     * @return array
     */
    public static function curlHeaders($headers)
    {
        $header = array();
        foreach ($headers as $key => $value) {
            array_push($header, strtolower($key) . ':' . trim($value));
        }
        return $header;
    }

    /**
     * 公共HTTP请求
     * @param $url
     * @param $params
     * @param string $method
     * @param array $header
     * @param array $query
     * @param array $config
     * @return HttpResponse
     * @throws Exception
     * @internal param int $timeout
     */
    public static function http($url, $params, $method = 'GET', $header = array(), $query = array(), $config =  array())
    {
        // POST 提交方式的传入 $set_params 必须是字符串形式
        $opts = array(
            CURLOPT_TIMEOUT => 5,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => self::curlHeaders($header)

        );

        if(isset($config['request_options']['connect_timeout'])){
            $opts[CURLOPT_CONNECTTIMEOUT] =  $config['request_options']['connect_timeout'];
        }

        if(isset($config['request_options']['timeout'])){
            $opts[CURLOPT_TIMEOUT] =  $config['request_options']['timeout'];
        }

        // 是否开启代理
        if(isset($config['request_options']['proxy']) && $config['request_options']['proxy']){
            $opts[CURLOPT_PROXYAUTH] = CURLAUTH_BASIC;
            $opts[CURLOPT_PROXY] = $config['request_options']['proxy']["ip"];
            $opts[CURLOPT_PROXYPORT] = $config['request_options']['proxy']["port"];
            $opts[CURLOPT_PROXYTYPE] = CURLPROXY_HTTP;
        }

        // 关闭https认证
        if (isset($config['request_options']['verify']) && !$config['request_options']['verify']) {
            $opts[CURLOPT_SSL_VERIFYPEER] = false;
            $opts[CURLOPT_SSL_VERIFYHOST] = false;
        }

        /* 根据请求类型设置特定参数 */
        switch (strtoupper($method)) {
            case 'GET':
                if(!empty($query)){
                    $opts[CURLOPT_URL] = $url . '?' . http_build_query($query);
                }else{
                    $opts[CURLOPT_URL] = $url;
                }
                $opts[CURLOPT_CUSTOMREQUEST] = 'GET';
                break;
            case 'POST':
                if(!empty($query)){
                    $opts[CURLOPT_URL] = $url . '?' . http_build_query($query);
                }else{
                    $opts[CURLOPT_URL] = $url;
                }
                $opts[CURLOPT_CUSTOMREQUEST] = 'POST';
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            case 'DELETE':
                if(!empty($query)){
                    $opts[CURLOPT_URL] = $url . '?' . http_build_query($query);
                }else{
                    $opts[CURLOPT_URL] = $url;
                }
                $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
                break;
            case 'PUT':
                if(!empty($query)){
                    $opts[CURLOPT_URL] = $url . '?' . http_build_query($query);
                }else{
                    $opts[CURLOPT_URL] = $url;
                }
                $opts[CURLOPT_POST] = 0;
                $opts[CURLOPT_CUSTOMREQUEST] = 'PUT';
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                throw new Exception('不支持的请求方式！');
        }
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        //设置为true的时候可以在返回的时候使用curl_getinfo获取到header
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        $data = curl_exec($ch);
        if ($data === false) {
            $errorNo = curl_errno($ch);
            $errorMessage = curl_error($ch);
            if (!$errorMessage && function_exists("curl_strerror")) {
                $errorMessage = curl_strerror($errorNo);
            }
            throw new Exception( "CURL Exception. ErrorNo:". $errorNo. ", ErrorMessage:". $errorMessage);
        }
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        //是否打印日志
        if (isset($config['request_options']['debug']) && $config['request_options']['debug']){
            $request_header = curl_getinfo($ch, CURLINFO_HEADER_OUT);
            echo $request_header;
            if($params){
                print_r($params);
                echo "\n";
                echo "\n";
            }
        }

        /**
         * 对响应结果进行封装，包含响应状态码、响应头和响应体
         */
        $httpResponse = new HttpResponse();
        $httpResponse->setStatus(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        $httpResponse->setHeader(substr($data, 0, $headerSize));
        $httpResponse->setBody(json_encode(json_decode(substr($data, $headerSize)),
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        curl_close($ch);
        return $httpResponse;
    }

    static function escape($string)
    {
        $entities = array('+', "%7E");
        $replacements = array('%20', "~");
        return str_replace($entities, $replacements, urlencode($string));
    }
}