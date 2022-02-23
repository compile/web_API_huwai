<?php
declare (strict_types = 1);

namespace app\api\controller;

use think\facade\Cache;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class link extends Common
{
    public function list(){
        echo '{"code":200,"msg":"请求成功","result":{"total":2,"per_page":10,"current_page":1,"last_page":1,"data":[{"id":48,"title":"晚安","url":"\/pages\/topic-detail\/topic-detail?id=271","img":"https:\/\/oss.ymeoo.cn\/20210713162618174474218.png","type":3,"create_time":1626181750},{"id":47,"title":"早安","url":"\/pages\/topic-detail\/topic-detail?id=272","img":"https:\/\/oss.ymeoo.cn\/20210713162618170385654.png","type":3,"create_time":1626181705}]}}';
        exit();
    }

}
