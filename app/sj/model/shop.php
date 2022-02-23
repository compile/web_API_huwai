<?php
namespace app\sj\model;
use think\Model;
use think\facade\Db;
use think\facade\Request;
class shop extends Model
{



    public function getOne($id){
        $shop = static::find($id);
        return $shop->toArray();
    }

    public function change($id,$post){
        if($id){
            $shop = static::find($id);
        }else{
            $shop = new Shop();
        }
        $shop->save($post);
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
