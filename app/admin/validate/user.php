<?php
namespace app\admin\validate;
use think\Validate;
class User extends Validate
{
    protected $rule = [
        'name' => 'require|max:25',
        'email' => 'email',
    ];


    protected $message = [
        'name.require' => '名称必须',
        'name.max'     => '名称最多不得超过25个字符',
        'email' => '邮箱格式错误'
    ];
}
