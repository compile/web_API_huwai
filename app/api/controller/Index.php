<?php
declare (strict_types = 1);

namespace app\api\controller;

class Index extends \app\api\BaseController
{
    public function index()
    {
        $temp['test'] = 'test';
        $temp['code'] = 0;
        $temp['msg'] = 'hehehe';
        echo json_encode($temp);
    }

    public function login(){
        echo 'login';
    }
}
