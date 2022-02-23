<?php
namespace app\api\model;
use think\Model;
use think\facade\Db;
use think\facade\Request;
class user extends Model
{

    public function getInfo($data){
        $where['phone']=trim($data['mobile']);
        $where['passwd']= trim($data['password']);
        $info = Db::name('user')->where($where)->find();
        return $info;
    }

    public function ifExists($iphone){
        $where['phone']=$iphone;
        $info = Db::name('user')->where($where)->find();
        return $info;
    }

    public function check($code){
        return captcha_check($code);
    }


    public function getOne($id){
        $res = static::find($id);
        return $res->toArray();
    }

    public function change($id,$post){
        if($id){
            $res = static::find($id);
        }else{
            $res = new User;
        }
        $res->save($post);
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
