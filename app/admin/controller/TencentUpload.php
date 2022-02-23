<?php
declare (strict_types = 1);

namespace app\admin\controller;


use Qcloud\Cos\Client;
use Qcloud\Cos\Exception\ServiceResponseException;
use think\Exception;
require '../extend/coss/vendor/autoload.php';

class TencentUpload
{
    // $srcPath 本地文件绝对路径
    // $type 文件mime类型
    // $dir 远程目录
    public static function upload($srcPath,$type,$dir,$filename)
    {

        // 腾讯云账户中的SecretId
        $SecretId = 'AKID3uUptgDTTBcmgKgnfGaeRyESSCiz0mJb';
        // 腾讯云账户中的SecretKey
        $SecretKey = '4sRjjSwA7oGRM0NUKJ6fxyiCQN4VgaDZ';
        $region = "ap-guangzhou"; //设置一个默认的存储桶地域
        $array =array(
            'region' => $region,
            'schema' => 'http', //协议头部，默认为http
            'credentials'=> array(
                'secretId'  => $SecretId,
                'secretKey' => $SecretKey,
            )
        );
        $cosClient=  new Client($array);
        $keyv = $dir.'/'.$filename; //随机文件名
        try {
            $bucket = "yy-1255875008"; //存储桶名称 格式：BucketName-APPID
            $key = $keyv; //此处的 key 为对象键，对象键是对象在存储桶中的唯一标识
            $file = fopen($srcPath, "rb");
            if($file){
                try {
                    $result = $cosClient->putObject(
                        array(
                            'Bucket' => $bucket,
                            'Key' => $key,
                            'Body' => $file,//文件路径
                            'ContentType' => $type//文件类型
                        )
                    );
                    return json_encode(["code"=>0,"msg"=>'成功','url'=>'https://'.$result['Location']]);
                }catch (ServiceResponseException $e){
                    return json_encode(["code"=>-1,"msg"=>$e->getMessage()]);
                }

            }else{
                return json_encode(["code"=>-1,"msg"=>'非法文件']);
            }
        }catch (\Exception $e){
            return json_encode(["code"=>-1,"msg"=>$e->getMessage()]);
        }
    }

    public function test(){

        $secretId = "AKID3uUptgDTTBcmgKgnfGaeRyESSCiz0mJb"; //"云 API 密钥 SecretId";
        $secretKey = "4sRjjSwA7oGRM0NUKJ6fxyiCQN4VgaDZ"; //"云 API 密钥 SecretKey";
        $region = "ap-guangzhou"; //设置一个默认的存储桶地域
        $cosClient = new Client(
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
            echo '<pre>';
            print_r($result);
        } catch (\Exception $e) {
            // 请求失败
            echo 'false';
            echo($e);
        }

    }

}