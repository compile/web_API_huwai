<?php
declare (strict_types = 1);

namespace app\api\controller;

use think\facade\Cache;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class system extends Common
{

    public function __construct(Request $request)

    {

        echo __FUNCTION__;
        echo '<br>';

    }

    public function miniConfig(){
        echo '{ "code": 200, "msg": "请求成功", "result": { "config": "miniapp", "value": "wx3e120210c76e1c21", "extend": "cc9fc39f175f793e63a043be291d825f", "intro": "https://oss.ymeoo.cn/20210530162236700645876.png" } }';
        exit();
    }

}
