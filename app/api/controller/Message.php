<?php
declare (strict_types = 1);

namespace app\api\controller;

use think\facade\Cache;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class message extends Common
{

    public function __construct(Request $request)

    {



    }

    public function num(){
        echo '{ "code": 200, "msg": "请求成功", "result": { "thumb_collect": 0, "follow": 0, "comment": 0, "all_count": 0, "article_msg_list": [], "chat_msg_list": [] } }';
        exit();
    }

}
