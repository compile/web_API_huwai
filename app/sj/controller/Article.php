<?php
declare (strict_types = 1);

namespace app\sj\controller;

use app\sj\model\common;
use app\BaseController;

use think\App;
use think\exception\ValidateException;
use think\facade\Config;
use think\facade\Cache;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Article extends \app\sj\BaseController
{

    protected $deleteTime = 'delete_time';
    public $table;
    function __construct(App $app)
    {
        parent::__construct($app);
        $this->table= 'article';
    }

    function articleList(){//文章列表
        $this->ifLogin();
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

    function deleteOne(){
        if($this->request->isPost()) {
            $id = Request::param('id');
            $common = new \app\sj\controller\Common();
            $common->deleteOne($this->table, $id);
        }
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

}
