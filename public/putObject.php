<?php

require '/Volumes/50/idiQu/app/admin/controller/coss/vendor/autoload.php';

$secretId = "AKID3uUptgDTTBcmgKgnfGaeRyESSCiz0mJb"; //"云 API 密钥 SecretId";
$secretKey = "4sRjjSwA7oGRM0NUKJ6fxyiCQN4VgaDZ"; //"云 API 密钥 SecretKey";
$region = "ap-guangzhou"; //设置一个默认的存储桶地域
$cosClient = new Qcloud\Cos\Client(
    array(
        'region' => $region,
        'schema' => 'http', //协议头部，默认为http
        'credentials'=> array(
            'secretId'  => $secretId ,
            'secretKey' => $secretKey)));
$local_path = "/Users/a50/o.txt";
try {
    $result = $cosClient->putObject(array(
        'Bucket' => 'yy-1255875008', //格式：BucketName-APPID
        'Key' => 'exampleobject',
        'Body' => fopen($local_path, 'rb'),
        /*
        'CacheControl' => 'string',
        'ContentDisposition' => 'string',
        'ContentEncoding' => 'string',
        'ContentLanguage' => 'string',
        'ContentLength' => integer,
        'ContentType' => 'string',
        'Expires' => 'string',
        'Metadata' => array(
            'string' => 'string',
        ),
        'StorageClass' => 'string'
        */
    ));
    // 请求成功
    print_r($result);
} catch (\Exception $e) {
    // 请求失败
    echo 'false';
    echo($e);
}

