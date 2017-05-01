<?php

namespace app\modules\warning\models;

class AliApiModel{
    private function initialize()
    {
        $this->setMethod("GET");
        $this->setAcceptFormat("JSON");
    }

    public static function getDb() {
      return Yii::$app->db2;
    }
    
    protected  static $version = "2015-10-20";
    protected  static $product;
    protected  static $actionName;
    protected  static $regionId;
    protected  static $acceptFormat;
    protected  static $method = "GET";
    protected  static $protocolType = "http";
    protected  static $accessKeyId = "LTAIbTQCrYhv3TFd";
    protected  static $accessSecret = "QyBDHxCecUpVKRgu1z6doiZLkgKSCS";
    protected  static $dateTimeFormat = 'Y-m-d\TH:i:s\Z';
    protected  static $SignatureMethod = "HMAC-SHA1";
    protected  static $SignatureVersion = "1.0";
    protected static $RegionId = "cn-hangzhou";
    protected static $domain = 'metrics.aliyuncs.com';
    protected static $domainParameters = array();

    /*
        获取签名的算法
    */
    public static function getSignature( $aid, $StartTime ){
        date_default_timezone_set("GMT");
        //$apiParams = parent::getQueryParameters();
        $apiParams['Action'] = 'QueryMetricList';
        $apiParams['Project'] = 'acs_ecs';
        //流量
        //$apiParams['Metric'] = 'InternetOutNew';
        //速率
        $apiParams['Metric'] = 'InternetOutRateNew';
        
        $apiParams['StartTime'] = $StartTime;
        $Dimensions['instanceId'] = $aid;
        $apiParams['Dimensions'] = json_encode($Dimensions);
        unset($apiParams['InstanceId']);
        //公共参数
        $apiParams["AccessKeyId"] = self::$accessKeyId;
        $apiParams["Format"] = self::getAcceptFormat();
        $apiParams["Version"] = self::$version;
        $apiParams["Timestamp"] = date(self::$dateTimeFormat);
        $apiParams["SignatureMethod"] = self::$SignatureMethod;
        $apiParams["SignatureVersion"] = self::$SignatureVersion;
        $apiParams["Timestamp"] = date(self::$dateTimeFormat);
        $apiParams["SignatureNonce"] = uniqid();
        $apiParams["RegionId"] = self::$RegionId;
    
        $apiParams["Signature"] = self::computeSignature($apiParams, self::$accessSecret);
        return $apiParams;
    }

    //获取签名
    private static function computeSignature($parameters, $accessKeySecret)
    {
        ksort($parameters);
        $canonicalizedQueryString = '';
        foreach($parameters as $key => $value)
        {
            $canonicalizedQueryString .= '&' . self::percentEncode($key). '=' . self::percentEncode($value);
        }
        $stringToSign = self::getMethod().'&%2F&' . self::percentEncode(substr($canonicalizedQueryString, 1));
        $signature = self::signString($stringToSign, $accessKeySecret."&");

        return $signature;
    }

    public static function getAcceptFormat()
    {
        return self::$acceptFormat;
    }

    public static function getMethod()
    {
        return self::$method;
    }

    protected static function percentEncode($str)
    {
        $res = urlencode($str);
        $res = preg_replace('/\+/', '%20', $res);
        $res = preg_replace('/\*/', '%2A', $res);
        $res = preg_replace('/%7E/', '~', $res);
        return $res;
    }

    protected static function signString($source, $accessSecret)
    {
        return  base64_encode(hash_hmac('sha1', $source, $accessSecret, true));
    }
}