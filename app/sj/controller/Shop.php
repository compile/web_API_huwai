<?php
declare (strict_types = 1);

namespace app\sj\controller;

use app\BaseController;

use app\sj\model\ShopAd;
use app\sj\model\ShopNav;
use think\App;
use think\exception\ValidateException;
use think\facade\Config;
use think\facade\Cache;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Shop extends \app\sj\BaseController
{
    public $table;
    function __construct(App $app)
    {
        parent::__construct($app);
        $this->table= 'shop';
    }

    function shopList(){//店铺列表
        $this->ifLogin();
        if (Request::isAjax()) {
            $table = str_replace("List",'',__FUNCTION__);
            $common = new \app\admin\controller\Common();
            $common->getList($table);
            exit();
        }
        return view();
    }


    function shopnavList(){//店铺导航列表
        $this->ifLogin();

        if (Request::isAjax()) {
            $table = str_replace("List",'',__FUNCTION__);
            $common = new Common();
            $common->getList($table);
            exit();
        }
        return view();
    }


    function shopadList(){//店铺导航列表
        $this->ifLogin();

        if (Request::isAjax()) {
            $table = str_replace("List",'',__FUNCTION__);
            $common = new Common();
            $common->getList($table);
            exit();
        }
        return view();
    }

    function addShop(){
        $shop = new \app\admin\model\Shop();
        $this->ifLogin();
        $id =  Request::param('id');
        Request::param('id') ? $data = $shop->getOne($id) :  $data = \app\sj\model\common::key_value_array_flip(config::get('wushi.shop'));//php7新三目 获得新数据 或者空数据
        View::assign('data',$data);
        echo $this->table;
        if($this->request->isPost()) {
            $common = new \app\admin\controller\Common();
            $data = Request::post();
            $id = Request::param('id') ?? '';
            $common->updateOne($this->table,$data,$id);//更新或者新增单个
        }
        return view();
    }

    function addShopNav(){
        $res = new \app\sj\model\shopnav();
        $this->ifLogin();
        $id =  Request::param('id');
        Request::param('id') ? $data = $res->getOne($id) :  $data = \app\sj\model\common::key_value_array_flip(config::get('wushi.shopnav'));//php7新三目 获得新数据 或者空数据
        View::assign('data',$data);

        if($this->request->isPost()) {
            $common = new Common();
            $data = Request::post();
            $id = Request::param('id') ?? '';
            $common->updateOne('shopnav',$data,$id);//更新或者新增单个
        }
        return view();
    }

    function addShopAd(){
        $res = new \app\sj\model\shopad();
        $this->ifLogin();
        $id =  Request::param('id');
        Request::param('id') ? $data = $res->getOne($id) :  $data = \app\sj\model\common::key_value_array_flip(config::get('wushi.shopad'));//php7新三目 获得新数据 或者空数据
        View::assign('data',$data);

        if($this->request->isPost()) {
            $common = new Common();
            $data = Request::post();
            $id = Request::param('id') ?? '';
            $common->updateOne('shopad',$data,$id);//更新或者新增单个
        }
        return view();
    }

    function deleteOne(){
        if($this->request->isPost()) {
            $id = Request::param('id');
            $common = new \app\sj\controller\common();
            $common->deleteOne($this->table, $id);
        }
    }

    function modifyState(){
        $comon = new  Common();
        $this->ifLogin();
        $tempdata = Request::param();
        $type = $tempdata['type'];
        $id = $tempdata['id'];
        $tempdata['att'] ?$tempdata['att']:'';
        $att = $tempdata['att'];
        $this->table = $this->table.$att;
        echo $this->table;
        echo $type;
        echo $id;
        $comon->changeOneAttribute($this->table,$type,$id);//表 ，属性， id
    }
    function modifyStateWithatt(){
        $tempdata = Request::param();
        $att= $tempdata['att'];
        $this->table = $this->table.$att;
        $this->modifyState();
    }
    function modifyStateTwo(){
        echo $this->table = $this->table.'grade';
        $this->modifyState();
    }
    function addGrade(){
        $usergrade = new \app\admin\model\userGrade();
        $this->ifLogin();
        $id =  Request::param('id');
        Request::param('id') ? $data = $usergrade->getOne($id) : $data = array('name'=>'','gradeValue'=>'');//php7新三目 获得新数据 或者空数据
        View::assign('data',$data);
        if($this->request->isPost()) {
            $common = new \app\admin\controller\Common();
            $data = Request::post();
            $id = Request::param('id') ?? '';
            $common->updateOne($this->table.'grade',$data,$id);//更新或者新增单个
        }
        return view();
    }
    function upload(){
        $common = new Common();
        echo $common->upload('image');
    }
}
