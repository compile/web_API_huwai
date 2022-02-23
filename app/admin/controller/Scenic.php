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
use think\facade\Request;
use think\facade\View;

class Scenic extends \app\admin\BaseController
{

    protected $deleteTime = 'delete_time';
    public $table;
    function __construct(App $app)
    {
        parent::__construct($app);
        $this->table= 'scenic';
    }

    function scenicList(){//文章列表
        $this->ifLogin();
        if (Request::isAjax()) {
            $table = str_replace("List",'',__FUNCTION__);
            $common = new \app\admin\controller\Common();
            $common->getList($table);
            exit();
        }
        return view();
    }

    public function getscenic(){//商品单位
//        if (Request::isAjax()) {
        $list = Db::name('scenic')
            ->order('create_time desc')
            ->select()
            ->toArray();
        $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list, 'count' => count($list), 'rel' => 1];
        echo json_encode($result);
        exit();
//        }
    }

    function scenicArticleList(){//文章列表
        $this->ifLogin();
        if (Request::isAjax()) {
            $table = 'scenic_info';
            $common = new \app\admin\controller\Common();
            $common->getList($table);
            exit();
        }
        return view();
    }


    function addScenic(){
        $res = new \app\admin\model\scenic();
        $this->ifLogin();
        $id =  Request::param('id');
        Request::param('id') ? $data = $res->getOne($id) : $data = \app\admin\model\common::key_value_array_flip(config::get('wushi.scenic_table'));
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

    function addScenicArticle(){
        $res = new \app\admin\model\scenicinfo();
        $this->ifLogin();
        $id =  Request::param('id');
        Request::param('id') ? $data = $res->getOne($id) : $data = \app\admin\model\common::key_value_array_flip(config::get('wushi.scenic_info_table'));
        if(!@$data['media'] || $data['media'] ==''){
            $data['produce_image'] = array();
        }else {
            $produce_imageArr = json_decode($data['media'], true);
            foreach ($produce_imageArr as $key => $item) {
                $data['produce_image'][$key] = $item;
            }
        }
        $pro_imgnum = count($data['produce_image']);

        if($pro_imgnum<=0){
            $data['media'] =  array();
        }
        View::assign('data',$data);
        if($this->request->isPost()) {
            $common = new \app\admin\controller\Common();
            $data = Request::post();
            $id = Request::param('id') ?? '';
            $tablename = 'scenic_info';
            $common->updateOne($tablename,$data,$id);//更新或者新增单个
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


    public function uploadMore(){
        $common = new \app\sj\controller\Common();

//        echo $common->uploadAction();

        $file = request()->file('file');

//        print_r($file);
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

       exit();
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


}
