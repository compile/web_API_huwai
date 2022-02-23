<?php
declare (strict_types = 1);

namespace app\index\controller;

class Index
{
    public function index()
    {
        echo 'eee';
        exit();
        return '您好！这是一个[guanli]示例应用';
    }
    public function login(){
        echo 'login';
    }

    public function test(){
        echo 'aff';
    }
}
