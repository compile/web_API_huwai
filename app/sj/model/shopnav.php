<?php
namespace app\sj\model;
use think\Model;
use think\facade\Db;
use think\facade\Request;
class shopnav extends Model
{



    public function getOne($id){
        $shop = static::find($id);
        return $shop->toArray();
    }

    public function change($id,$post){
        if($id){
            $res = static::find($id);
        }else{
            $res = new ShopNav();
        }
        $res->save($post);
    }


    public function deleteOne($id){
        if($id){
            $res = static::find($id);
            $res->delete();
        }
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
