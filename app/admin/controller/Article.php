<?php
declare (strict_types = 1);

namespace app\admin\controller;
use app\admin\model\common;
use app\BaseController;

use think\App;
use think\exception\ValidateException;
use think\facade\Config;
use think\facade\Cache;
use think\facade\Db;
use think\facade\Filesystem;
use think\facade\Request;
use think\facade\View;

class Article extends \app\admin\BaseController
{

    protected $deleteTime = 'delete_time';
    public $table;
    function __construct(App $app)
    {
        parent::__construct($app);
        $this->table= 'article';
    }

    function articleList(){//文章列表
//        $this->ifLogin();
        if (Request::isAjax()) {
            $table = str_replace("List",'',__FUNCTION__);
            $common = new \app\admin\controller\Common();
            $common->getList($table);
            exit();
        }
        return view();
    }


    function addArticle(){
        $res = new \app\admin\model\article();
        $this->ifLogin();
        $id =  Request::param('id');
        Request::param('id') ? $data = $res->getOne($id) : $data = \app\admin\model\common::key_value_array_flip(config::get('wushi.article_table'));
//        $res->index();
//        echo Common::key_value_array_flip(config::get('wushi.article_table'),1);
        if($data['id']){
            $data['content'] = preg_replace("/]*href=[^>]*>|<\/[^a]*a[^>]*>/i","",$data['content']);
            $data['content'] = addslashes($data['content']);
        }
        View::assign('data',$data);
        if($this->request->isPost()) {
            $common = new \app\admin\controller\Common();
            $data = Request::post();
            $id = Request::param('id') ?? '';
            $common->updateOne($this->table,$data,$id);//更新或者新增单个
            exit();
        }
        return view();
    }

    function modifyState(){
        $comon = new \app\admin\controller\Common();
        $this->ifLogin();
        $tempdata = Request::param();
        $type = $tempdata['type'];
        $id = $tempdata['id'];
        $comon->changeOneAttribute($this->table,$type,$id);//表 ，属性， id
    }

    function delArticle(){





    }


    function articleCate(){//文章分类列表
        $this->ifLogin();
        if (Request::isAjax()) {
            $table = 'article_cate';
            $common = new \app\admin\controller\Common();
            $common->getList($table);
            exit();
        }
        return view();
    }


    function getArticleCate(){//文章分类列表
        $this->ifLogin();
//        if (Request::isAjax()) {
            $table = 'article_cate';
            $common = new \app\admin\controller\Common();
            $common->getList($table);
            exit();
//        }
    }

    function htmlupload(){
        $file = request()->file('file');
        try {
            // 验证文件格式
            validate(['file' => ['fileExt' => 'zip', 'fileMime' => 'application/zip']])->check(['file' => $file]);
            // 移动到框架应用根目录/public/uploads/ztzlzip 目录下
            $info = \think\facade\Filesystem::disk('public')->putFile('zip', $file);
            // 拼接上传后的文件绝对路径
            $uploadPath = str_replace('\\', '/', './uploads/' . $info);
            // 定义解压路径
            $unzipPath = './uploads/ztzl/';
            // 实例化对象
            $zip = new \ZipArchive();
            //打开zip文档，如果打开失败返回提示信息
            if ($zip->open($uploadPath, \ZipArchive::CREATE) !== TRUE) {
                die ("Could not open archive");
            } else {
                //将压缩文件解压到指定的目录下
                $zip->extractTo($unzipPath);
                //关闭zip文档
                $zip->close();
                $msg['code'] = 0;
                $msg['path'] = 'http://' . $_SERVER['SERVER_NAME'] . $unzipPath;
            }

        } catch (ValidateException $e) {
            $this->error($e->getError());
            $msg['code'] = 1;
            $msg['info'] = $e->getError();
        }
        return json($msg);
    }


    function upload()
    {
            $file = request()->file('image');
//            $file->getPathname();
//            $file->getMime();
            try {
                validate(['image'=>'filesize:10240|fileExt:jpg,png,jpeg'])
                    ->check([$file]);

//                if($file){
                $md5 = $file->md5();
                $temp = Db::table("bb_resources")->where("md5",'=',$md5)->find();
                if($temp){//存在
                    $fileName = $temp['fileName'];
                    $oss = $temp['path'];
                    $msg = "1111111111111";
                    return json_encode(["code"=>0,"msg"=>$msg,'url'=>$oss,'filename'=>$fileName]);
                }else {

                    $fileName = $file->getOriginalName();
                    $res = \app\admin\controller\TencentUpload::upload($file->getPathname(), $file->getMime(), "pic1",$fileName);//如果不为空则正确


                    $res = json_decode($res,true);

                    $url = $res['url'];
                    $data['path'] = $url;
                    $data['fileName'] =$fileName;
                    $data['md5'] = $file->md5();
                    $data['create_time'] = time();
                    $data['update_time'] = time();
                    Db::table('bb_resources')->save($data);
                    $msg = "新的，记录数据库";
                    $res = array('code' => 0, 'msg' =>$msg,'url' =>$url, 'md5' => $md5);
                    $res = json_encode($res);
                    echo $res;
                    exit();
                }

            } catch (\think\exception\ValidateException $e) {
                //return Resultsfail([-1,$e->getMessage()]);
                return $e->getMessage();
            }
//            $res = array('status' => 0, 'msg' =>$result,'url' => $result, 'info' => $result,'md5' => '');
//
//            $res = json_encode($res);
//
//
//            return $res;
            exit();





    }


    function ceshi($url){
        //$url = input('url',1);

        //$url = "https://pan.baidu.com/s/1E15FuBHat2krnRfdPWazqQ";
        //$url = 'http://pan.baidu.com/wap/link?uk=2788992893&shareid=4095420072';
        //$url = 'http://pan.baidu.com/wap/link?uk=338064437&shareid=1449823372';
        //$url = 'https://pan.baidu.com/share/link?shareid=2607511645&uk=570509921';
        //$url = 'http://pan.baidu.com/s/1gdl6sWr';
        //$url = 'https://pan.baidu.com/share/link?shareid=2607511645&uk=570509921';
        //echo  $this->getRedirectLocation($url);
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, FALSE);

        $data = curl_exec($c);
        curl_close($c);
        $pos = strpos($data,'utf-8');
        if($pos===false){$data = iconv("gbk","utf-8",$data);}
        preg_match("/<title>(.*)<\/title>/i",$data, $title);
        return $title[1];
//
//
//$data = iconv("gbk","utf-8",$data);
//         return $data;
    }

    function check(){
        $res = new \app\admin\model\article();
        $this->ifLogin();
        $id =  Request::param('id');
        Request::param('id') ? $data = $res->getOne($id) : $data = \app\admin\model\common::key_value_array_flip(config::get('wushi.article_table'));
//        $res->index();
//        echo Common::key_value_array_flip(config::get('wushi.article_table'),1);
        if($data['id']){
            $data['content'] = preg_replace("/]*href=[^>]*>|<\/[^a]*a[^>]*>/i","",$data['content']);
            $data['content'] = addslashes($data['content']);
        }
        View::assign('data',$data);
        if($this->request->isPost()) {
            $common = new \app\admin\controller\Common();
            $data = Request::post();
            $id = Request::param('id') ?? '';
            $common->updateOne($this->table,$data,$id);//更新或者新增单个
            exit();
        }
        return view();
    }

    function uploadtxt(){

        $file = Request::file('txt');
        //验证文件规则
        $result=validate(['file' => ['fileSize:102400000,fileExt:gif,jpg,png,mp4,MP4,mp3,txt']])->check(['file' => $file]);
        if($result){


            //上传到服务器,
            $path = Filesystem::disk('public')->putFile('upload',$file);
            $picCover = Filesystem::getDiskConfig('public','url').'/'.str_replace('\\','/',$path);

            $fileName = $file->getOriginalName();




            $url = '.';
            //$savepath = str_replace('/storage','',$picCover);
            //$oss =  $this->shipinapi($url.$picCover,$savepath);


            //在这里处理txt文档。
            $path = $url.$picCover;


            $fopen = fopen($path,"rb");

            while (!feof($fopen)){
                $temp =  fgets($fopen);
                $checkarray[] = $temp;
            }

            //fclose($fopen);


            $c  = array_filter($checkarray);
            if(file_exists('./path.txt')){
                unlink('./path.txt');
            }


            $failinfo = $okinfo = array();
            foreach($c as $k=>$v){
                if($v !== '' ){
                    $temp2 = explode('https://pan.baidu.com',(string)$v);
                    if(count($temp2)>=2){
                       $urlok = 'https://pan.baidu.com'.trim($temp2[1]);
                       $download = trim($temp2[0]);
                        $fanhui = $this->fhttps2($urlok);
                        if(strstr($fanhui, '不存在') || strstr($fanhui, '过期') ){//放到放到异常的
                            $failinfo[$k]['cai'] = $download;
                            $failinfo[$k]['pan'] = $urlok;
                            $failinfo[$k]['result'] = $fanhui;

                        }else{//放到正常的页面

                            $okinfo[$k]['cai'] = $download;
                            $okinfo[$k]['pan'] = $urlok;
                            $okinfo[$k]['result'] = $fanhui;
                            $do = file_put_contents('./path.txt','<a href="'.$download.'">'.$download.'</a>'.PHP_EOL,FILE_APPEND);
                        }
                    }
                }
            }
            $msg = 'ok';
            $downloadpath = $_SERVER['HTTP_HOST'].'/path.txt';
            $res = array('status' => 0, 'msg' =>$msg,'url' => $downloadpath, 'okinfo'=>$okinfo , 'failinfo'=>$failinfo);
            $res = json_encode($res);


            return $res;
        }
    }
    function fhttps2($url){
         $do = $this->file_get_contents_by_curl('http://27.124.41.16:7326/pan.php?url='.$url);
         return $do;
    }
    function fhttps($url){

//        $url = 'https://pan.baidu.com/s/11WZ4?fid=315699900888696';
        $url = trim($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//禁止调用时就输出获取到的数据
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
        $fanhui = curl_exec($ch);
        curl_close($ch);
//        echo '<pre>';
//        echo htmlspecialchars(strip_tags($fanhui));
//
//

        if(!strstr($fanhui,'不存在')  || !strstr($fanhui,'页面不存在')){//没有找到不存在 或者 失效 或者页面不存在就正常。


            $result =  '存在';
        }else{

            $result = '不存在';

        }

        return $result;
    }

    function file_get_contents_by_curl($url){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_HEADER,0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//禁止调用时就输出获取到的数据
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
    }
    function testpython($url){
        return file_get_contents("http://212.64.42.156:3819/check.php?url=".$url);
    }

    function uploadedit()
    {

        $file = Request::file('file');
        //验证文件规则
        //$result=validate(['file' => ['fileSize:102400000,fileExt:gif,jpg,png,mp4,MP4,mp3']])->check(['file' => $file]);
        //if($result){
        $md5 = $file->md5();
        $temp = Db::table("bb_resources")->where("md5",'=',$md5)->find();
        if($temp){
            $fileName = $temp['fileName'];
            $oss = $temp['path'];
            $msg = "1111111111111";
        }else{
            //上传到服务器,
            $path = Filesystem::disk('public')->putFile('upload',$file);
            $picCover = Filesystem::getDiskConfig('public','url').'/'.str_replace('\\','/',$path);
            $fileName = $file->getOriginalName();
            $url = 'http://localhost';
            $savepath = str_replace('/storage','',$picCover);
            $oss =  $this->shipinapi($url.$picCover,$savepath);
            $data['path'] = $oss;
            $data['fileName'] =$fileName;
            $data['md5'] = $file->md5();
            $data['create_time'] = time();
            $data['update_time'] = time();
            Db::table('bb_resources')->save($data);
            $msg = "新的，记录数据库";

            //$fileName == 原名
            //$savepath 随机名称
        }
        $domain = strstr($oss, 'https://');
        if(!$domain){//如果没有https就加入
            $oss = 'https://'.$oss;
        }
        $filetemp['src'] = $oss;
        $filetemp['title'] = $fileName;
        $res = array('code' => 0, 'msg' =>$msg,'data' =>$filetemp, 'md5' => $md5);
        $res = json_encode($res);
        echo $res;
        // }else{
        //    $res = array('code' => 1, 'msg' => 'error','url' => '222', 'info' => '222','md5' => '222');
        //     $res = json_encode($res);
        //     echo $res;
        // }
    }


    function shipinapi($local_path,$local_name){//视频
//        exit();
        include dirname(__FILE__) . '/coss/vendor/autoload.php';

        $secretId = "AKID3uUptgDTTBcmgKgnfGaeRyESSCiz0mJb"; //"云 API 密钥 SecretId";
        $secretKey = "4sRjjSwA7oGRM0NUKJ6fxyiCQN4VgaDZ"; //"云 API 密钥 SecretKey";
        $region = "ap-guangzhou"; //设置一个默认的存储桶地域
        $cosClient = new \Qcloud\Cos\Client(
            array(
                'region' => $region,
                'schema' => 'https', //协议头部，默认为http
                'credentials'=> array(
                    'secretId'  => $secretId ,
                    'secretKey' => $secretKey)));
        // $local_path = "/Users/a50/Downloads/word2.txt";//改为文件列表

        $printbar = function($totolSize, $uploadedSize) {
            printf("uploaded [%d/%d]\n", $uploadedSize, $totolSize);
        };

        try {
            $result = $cosClient->upload(
                $bucket = 'yy-1255875008', //格式：BucketName-APPID
                $key = $local_name,#资源id # 就这样子。 判断文件夹内有多少的文件。 然后传到oss。再传数据库里
                $body = fopen($local_path, 'rb')
            /*
            $options = array(
                'ACL' => 'string',
                'CacheControl' => 'string',
                'ContentDisposition' => 'string',
                'ContentEncoding' => 'string',
                'ContentLanguage' => 'string',
                'ContentLength' => integer,
                'ContentType' => 'string',
                'Expires' => 'string',
                'GrantFullControl' => 'string',
                'GrantRead' => 'string',
                'GrantWrite' => 'string',
                'Metadata' => array(
                    'string' => 'string',
                ),
                'ContentMD5' => 'string',
                'ServerSideEncryption' => 'string',
                'StorageClass' => 'string', //存储类型
                'Progress'=>$printbar, //指定进度条
                'PartSize' => 10 * 1024 * 1024, //分块大小
                'Concurrency' => 5 //并发数
            )
            */
            );
            // 请求成功

            return $result['Location'];


        } catch (\Exception $e) {
            // 请求失败
            echo($e);
        }





    }

    function addArticleCate(){
        $res = new \app\admin\model\articleCate();
        $this->ifLogin();
        $id =  Request::param('id');
        Request::param('id') ? $data = $res->getOne($id) : $data = \app\admin\model\common::key_value_array_flip(config::get('wushi.article_cate_table'));//php7新三目 获得新数据 或者空数据
        View::assign('data',$data);
        if($this->request->isPost()) {
            $common = new \app\admin\controller\Common();
            $data = Request::post();
            $id = Request::param('id') ?? '';
            $common->updateOne($this->table.'cate',$data,$id);//更新或者新增单个
        }
        return view();
    }

}
