<?php
declare (strict_types = 1);

namespace app\sj\controller;

use app\sj\model\Test;
use app\BaseController;

use think\App;
use think\exception\ValidateException;
use think\facade\Config;
use think\facade\Cache;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class User extends \app\sj\BaseController
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
                $common = new \app\sj\controller\Common();
                $common->getList($table);
                exit();
            }
            return view();
        }

        function userGrade(){//用户等级
            $this->ifLogin();
            if (Request::isAjax()) {
                $table = str_replace("List",'',__FUNCTION__);
                $common = new \app\sj\controller\Common();
                $common->getList($table);
                exit();
            }
            return view();
        }

        function addUser(){
            $user = new \app\sj\model\user();
            $this->ifLogin();
            $id =  Request::param('id');
            Request::param('id') ? $data = $user->getOne($id) : $data = \app\sj\model\common::key_value_array_flip(config::get('wushi.user_table'));//php7新三目 获得新数据 或者空数据
            View::assign('data',$data);
            if($this->request->isPost()) {
                $common = new \app\sj\controller\Common();
                $data = Request::post();
                $id = Request::param('id') ?? '';
                $common->updateOne($this->table,$data,$id);//更新或者新增单个
            }
            return view();
        }
        function deleteUser(){
            if($this->request->isPost()) {
                $id = Request::param('id');
                $common = new Common();
                $common->deleteOne($this->table, $id);
            }
        }
        function modifyState(){
            $comon = new \app\sj\controller\Common();
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
            $usergrade = new \app\sj\model\userGrade();
            $this->ifLogin();
            $id =  Request::param('id');
            Request::param('id') ? $data = $usergrade->getOne($id) : $data = array('name'=>'','gradeValue'=>'');//php7新三目 获得新数据 或者空数据
            View::assign('data',$data);
            if($this->request->isPost()) {
                $common = new \app\sj\controller\Common();
                $data = Request::post();
                $id = Request::param('id') ?? '';
                $common->updateOne($this->table.'grade',$data,$id);//更新或者新增单个
            }
        return view();
        }
}
