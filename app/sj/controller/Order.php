<?php
declare (strict_types = 1);

namespace app\sj\controller;

use app\admin\model\Test;
use app\BaseController;

use think\App;
use think\exception\ValidateException;
use think\facade\Config;
use think\facade\Cache;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Order extends \app\sj\BaseController
{
        public $table;
        function __construct(App $app)
        {
            parent::__construct($app);
            $this->table= 'user';
        }

    function orderList(){//用户列表
            $this->ifLogin();
            if (Request::isPost()) {
                $table = str_replace("List",'',__FUNCTION__);
            $common = new \app\admin\controller\Common();
            $common->getList($table);
            exit();
            }
            return view();
    }


    function checkarrive(){//订单确认到货。改变状态
        $temp =  Request::param();
        $id = $temp['id'];
        $arrivenum = $temp['arrivenum'];

        $where['id'] = $temp['id'];
        $where['arrivenum'] = $temp['arrivenum'];

        $res = Db::name('order')->where($where)->find();
        if($res){
            echo '找到了。改变状态';


            $change['id'] = $id;
            $change['status'] = 1;//改变状态 开始计时
            $change['receive_time'] = date('Y-m-d h:i:s');


            print_r($change);
           $do =  Db::name('order')->save($change);

           echo $do ;

        }else{
            echo '不对,无法改变';
        }


    }


}
