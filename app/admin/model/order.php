<?php
namespace app\admin\model;
use think\Model;
use think\facade\Db;
use think\facade\Request;
class order extends Model
{

    public function check($code){
        return captcha_check($code);
    }

    public function getOne($id){
        $user = User::find($id);
        return $user->toArray();
    }

    public function change($id,$post){
        if($id){
            $order = Order::find($id);
        }else{
            $order = new Order;
        }
        $order->save($post);
    }

    public function changeOneAttribute($id,$attribute){
        if($id){
            $res = static::find($id);
        }else{
            echo '不存在';
            exit();
        }
        $post['id']= $res['id'];
        $res[$attribute]==0?$post[$attribute]=1:$post[$attribute]=0;//取反
        echo $res->save($post);
    }
}
