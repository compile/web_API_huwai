<?php
namespace app\admin\validate;
use app\admin\validate\BaseValidate;

class LoginValidate extends  BaseValidate
{
    protected $rule =[
        "phone_number"=>"require|isMobile",
        "password" => "require|",
    ];


    protected $message =[
        "phone_number"=>'请输入手机号码',
        "password" =>'请传入密码',
    ];
}
