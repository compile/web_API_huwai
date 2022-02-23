<?php
namespace app\admin\validate;
use think\Validate;
class User extends Validate
{
    protected $rule = [
        'name' => 'require|max:25',
        'value' => 'require|max:5',
    ];


    protected $message = [
        'name.require' => '名称必须',
        'name.max'     => '名称最多不得超过25个字符',
    ];
}
