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

class Html extends \app\admin\BaseController
{

    protected $deleteTime = 'delete_time';
    public $table;
    function __construct(App $app)
    {
        parent::__construct($app);
        $this->table= 'article';
    }

    function htmlList(){//文章列表
//        $this->ifLogin();
        if (Request::isAjax()) {
            $table = str_replace("List",'',__FUNCTION__);
            $common = new \app\admin\controller\Common();
            $common->getList($table);
            exit();
        }
        return view();
    }


    function addHtml(){
        $res = new \app\admin\model\html();
        $this->ifLogin();
        $id =  Request::param();
        Request::param('id') ? $data = $res->getOne($id) : $data = \app\admin\model\common::key_value_array_flip(config::get('wushi.html_table'));
//        $res->index();
//        echo Common::key_value_array_flip(config::get('wushi.article_table'),1);
        View::assign('data',$data);
        if($this->request->isAjax()) {

//

//            print_r($data);
//            exit();
//            $common = new \app\admin\controller\Common();
            $data = Request::post();

            $filename = $data['filename'] ;
            $title    = $data['title'];


           $see =  Db::name('html')->where('filename','=',$filename)->find();//如果存在 就修改。

            $file['filename'] = $filename;
            $file['create_time'] =  date('Y-m-d h:i:s');
            if($see){//存在则
                 $do =   Db::name('html')->where('id','=',$see['id'])->save($file);
                 if($do) {
                     $msg = '修改成功';

                     $this->htmlcreate($filename,$title);
                 }else{
                     $msg = '修改失败，联系管理员';
                 }
            }else{
                 $do =   Db::name('html')->save($file);
                 if($do){
                     $msg = '添加了';
                     $this->htmlcreate($filename,$title);
                 }else{
                     $msg = '操作失败联系管理员';
                 }
            }

            return json_encode(["code"=>0,"msg"=>$msg]);

            exit();
        }
        return view();
    }

    function htmlcreate($filename,$title){//这里会创建内容。

        $path = '/www/wwwroot/test.abc.com/public/'.$filename;
        if (!is_dir($path)) {
            mkdir($path,0777,true);
        }
        $filename2 = $path.'/index.html';
//        unlink($filename2);
//        rmdir($path);
        $html = 'html/';
        $path  = 'http://103.24.94.55:9121/'.$html.$filename;
        $src = $path;
        //$html2 = '<!DOCTYPE html PUBLIC"-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><title></title><style type="text/css">*{margin:0;padding:0;list-style-type:none}</style><script type="text/javascript"src="https://cdn.bootcss.com/jquery/1.8.3/jquery.min.js"></script></head><body><script type="text/javascript">$(document).ready(function(){var iframeHeight=function(){var _height=$(window).height();$(\'#content\').height(_height)}window.onresize=iframeHeight;$(function(){iframeHeight()})});</script><div id="container"style="overflow:hidden;"><iframe border="0" id="content" src="'.$src.'" frameborder="0" height="100%" width="100% "></iframe></div></body></html>';

        $do = file_put_contents($filename2,$this->read($src,$title));
        if($do){
            echo 'ok';
        }else{
            echo 'false';
        }


    }


    function read($url,$title){
        $html =   <<<scr

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
<head>
    <title>{$title}</title>
    <style type="text/css">
        *
        {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }
    </style>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/1.8.3/jquery.min.js"></script>
</head>
<body>
<script type="text/javascript">
    $(document).ready(function () {

        var iframeHeight = function () {
            var _height = $(window).height();
            $('#content').height(_height);
        }
        window.onresize = iframeHeight;
        $(function () {
            iframeHeight();
        });

    });

</script>

<div id="container" style="overflow:hidden;">
    <iframe border="0" id="content" src="{$url}" frameborder="0" height="100%" width="100%"></iframe>
</div>
</body>
</html>
scr;
        return $html;

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
        $file = request()->file('ziphtml');
        $name = $file->getOriginalName();
       $tempname = explode('.',$name);
       $filename = $tempname[0];
        try {
            // 验证文件格式
            validate(['file' => ['fileExt' => 'zip', 'fileMime' => 'application/zip']])->check(['file' => $file]);
            // 移动到框架应用根目录/public/uploads/ztzlzip 目录下
           $info = \think\facade\Filesystem::disk('public')->putFile('zip', $file);
            // 拼接上传后的文件绝对路径

//            $uploadPath = str_replace('\\', '/', './uploads/' . $info);
            $uploadPath = './storage/'.$info;
//             定义解压路径
            $unzipPath = './html/'.$filename;
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
                $msg['test'] = $uploadPath;
                $msg['path'] = $filename;

                unlink($uploadPath);//删除
            }


//            $zip=new \ZipArchive();
//            $uploadPath = '/Volumes/50/idiQu/util.js.zip';
//            $unzipPath = './uploads/html';
//            if ($zip->open($uploadPath, \ZipArchive::CREATE) !== TRUE) {
//                die ("Could not open archive");
//            } else {
//                //将压缩文件解压到指定的目录下
//                $zip->extractTo($unzipPath);
//                //关闭zip文档
//                $zip->close();
//                $msg['code'] = 0;
//                $msg['path'] = 'http://' . $_SERVER['SERVER_NAME'] . $unzipPath;
//            }








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
            $file->getPathname();
            $file->getMime();
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
