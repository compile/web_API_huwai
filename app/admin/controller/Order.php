<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\model\Test;
use app\BaseController;

use think\App;
use think\exception\ValidateException;
use think\facade\Config;
use think\facade\Cache;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Order extends \app\admin\BaseController
{
        public $table;
        function __construct(App $app)
        {
            parent::__construct($app);
            $this->table= 'user';
        }

    function orderList(){//用户列表
            $this->ifLogin();
            if (Request::isAjax()) {
                $table = str_replace("List",'',__FUNCTION__);
            $common = new \app\admin\controller\Common();
            $common->getList($table.'_master');
            exit();
            }
            return view();
        }


}
