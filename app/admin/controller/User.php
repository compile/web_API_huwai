<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\model\Test;
use app\BaseController;

use think\App;
use think\exception\ValidateException;
use think\facade\Config;
use think\facade\Cache;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class User extends \app\admin\BaseController
{
        public $table;
        function __construct(App $app)
        {
            parent::__construct($app);
            $this->table= 'user';
        }

    function userList(){//用户列表
            $this->ifLogin();
            if (Request::isAjax()) {
                $table = str_replace("List",'',__FUNCTION__);
                $common = new \app\admin\controller\Common();
                $common->getList($table);
                exit();
            }
            return view();
        }

        function userGrade(){//用户等级
            $this->ifLogin();
            if (Request::isAjax()) {
                $table = str_replace("List",'',__FUNCTION__);
                $common = new \app\admin\controller\Common();
                $common->getList($table);
                exit();
            }
            return view();
        }

        function addUser(){
            $user = new \app\admin\model\user();
            $this->ifLogin();
            $id =  Request::param('id');
            Request::param('id') ? $data = $user->getOne($id) : $data = \app\admin\model\common::key_value_array_flip(config::get('wushi.user_table'));//php7新三目 获得新数据 或者空数据
            View::assign('data',$data);
            if($this->request->isPost()) {
                $common = new \app\admin\controller\Common();
                $data = Request::post();
                $id = Request::param('id') ?? '';
                $common->updateOne($this->table,$data,$id);//更新或者新增单个
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
}
