<?php
declare (strict_types = 1);

namespace app\api\controller;

use think\facade\Cache;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Cart
{

    public function cartList()
    {
        $redis = Cache::store('redis')->handler();
        $restemp = $redis->KEYS("cartlist*");
        foreach($restemp as $item){
            $temp[] = $redis->HGETALL($item);
        }
        $result['data']['status'] = 0;

        foreach($temp as $item => $value){
            $temp[$item]['stock']= (int)$temp[$item]['stock']; //强制数字
            $temp[$item]['price']= (float)$temp[$item]['price'];//强制数字
            $temp[$item]['number']= (int)$temp[$item]['number'];//强制数字
        }
        $result['data']['res'] = $temp;
        echo json_encode($result);
    }


    function addCart(){// 入购物车
        $res = new \app\admin\model\goods();
        $temppost = Request::param();// 有 goodsOne 和用户信息 。 用于验证。 如果 redis 没有存在信息。则说明过期？？？？需要重新登陆。
        $id =  $temppost['goodsOne']['id'];
        $uid = $temppost['userInfo']['id'];
        $buyinfo = $temppost['buyinfo'];
        $data = $res->getOne($id);
            $common = new Common();
            if(!$common->is_not_json(@$data['image'])){//去否判断是json
                $image = json_decode($data['image'],true);
                $zimage = $image['0']['src'];
                $list['data']['image'] = $zimage;
            }
        $redis = Cache::store('redis')->handler();
        $keys = "uid_".$uid."cartlist_";
        $if_in  = $redis->KEYS($keys.$id);// uid cartlist id
        if($if_in){//存在 则 +1
            $redis->HINCRBY($keys.$id,'number',1);//加库存
        }else{//不存在则 新增
            $cart = array();
            $cart['id'] = $data['id'];
            $cart['title'] =  $data['title'];
            $cart['price'] = (float)$data['price'];
            $cart['image'] = $data['thumb'];
            $cart['attr_val'] = $buyinfo['attr'];
            $cart['number'] = (float)1;
            $cart['stock'] = (int)$data['stock'];
            $redis->HMSET($keys.$id ,$cart);
        }
        //返回购物车。 每次都新的返回。 应该先存入数据库。？
        $restemp = $redis->KEYS($keys."*");
        foreach($restemp as $item){
            $temp[] = $redis->HGETALL($item);
        }
        $result['data']['status'] = 0;
        $result['data']['res'] = $temp;
        $result['data']['userInfo'] = $temppost;
        echo json_encode($result);
        exit();
    }


    function changeCart(){//这里 添加修改 重新生成购物车的redis 然后返回。
        $res = new \app\admin\model\goods();
        $temppost = Request::param();// 有 goodsOne 和用户信息 。 用于验证。 如果 redis 没有存在信息。则说明过期？？？？需要重新登陆。
        $id =  $temppost['goodsOne']['id'];
        $uid = $temppost['userInfo']['id'];
        $buyinfo = $temppost['buyinfo'];

    }


    function clearCart(){ //清理所有
        $res = new \app\admin\model\goods();
        $temppost = Request::param();// 有 goodsOne 和用户信息 。 用于验证。 如果 redis 没有存在信息。则说明过期？？？？需要重新登陆。
        $uid = $temppost['userInfo']['id'];
//        $buyinfo = $temppost['buyinfo'];
        $keys = "uid_".$uid."cartlist_";

        $redis = Cache::store('redis')->handler();
        $restemp = $redis->KEYS($keys."*");
        foreach($restemp as $item){
            echo $redis->delete($item);
        }
    }


    function modifyState(){
        $comon = new \app\admin\controller\Common();
        $this->ifLogin();
        $tempdata = Request::param();
        $type = $tempdata['type'];
        $id = $tempdata['id'];
        $comon->changeOneAttribute($this->table,$type,$id);//表 ，属性， id
    }

    public function goodsOne(){
        $res = new \app\admin\model\goods();
        $id =  Request::param('id');
         $goodsRes = $res->getOne($id) ;

        $result['data']['status'] = 0;
        $result['data']['res'] = $goodsRes;
        echo json_encode($result);

    }

    public function index(){
        echo __FUNCTION__;
    }
}
