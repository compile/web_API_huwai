<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\BaseController;

use think\App;
use think\exception\ValidateException;
use think\facade\Config;
use think\facade\Cache;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Shop extends \app\admin\BaseController
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
    function shopGradeList(){//用户等级
        $this->ifLogin();
        if (Request::isAjax()) {
            $table = str_replace("List",'',__FUNCTION__);
            $common = new \app\admin\controller\Common();
            $common->getList($table);
            exit();
        }
        return view();
    }


    function addShop(){
        $shop = new \app\admin\model\Shop();
        $this->ifLogin();
        $id =  Request::param('id');
        Request::param('id') ? $data = $shop->getOne($id) : $data = array('name'=>'');//php7新三目 获得新数据 或者空数据
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
}
