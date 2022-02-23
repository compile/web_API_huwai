<?php
namespace app\admin\validate;
use think\Validate;
class Goods extends Validate
{
    protected $rule = [
        'name' => 'require|max:25',
        'chj' => 'require',
        'yj' => 'require',
        'sj' => 'require',
    ];


    protected $message = [
        'name.require' => '名称必须',
        'name.max'     => '名称最多不得超过25个字符',
        'email' => '邮箱格式错误',
        'chj.require' => '名称必须',
        'yj.require' => '名称必须',
        'sj.require' => '名称必须',
    ];
}
