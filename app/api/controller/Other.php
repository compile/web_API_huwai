<?php
declare (strict_types = 1);

namespace app\api\controller;

use think\facade\Db;

class Other
{
    public function menu_nav()//app 导航
    {
        $list = Db::name('nav')
            ->order('create_time desc')
            ->select()
            ->toArray();
        $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list, 'count' => '1', 'rel' => 1];
        echo json_encode($result);
    }


    public function goods_cate(){//商品菜单
        $list = Db::name('goods_cate')
            ->field('id,name,pid,picture')
            ->order('create_time desc')
            ->select()
            ->toArray();

        foreach($list as $key=>$value) {
            if (!$value['pid']) {
                unset($list[$key]['pid']);
                unset($list[$key]['picture']);
            }
        }


        $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list, 'count' => '1', 'rel' => 1];
        echo json_encode($result);
    }
}
