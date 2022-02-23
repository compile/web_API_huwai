<?php
namespace app\admin\model;
use think\facade\Config;
use think\Model;
use think\facade\Db;
use think\facade\Request;
use think\model\concern\SoftDelete;
class article extends Model
{
    protected $deleteTime = 'delete_time';


    public function index(){
        $find = static::find(74);
        return $find->toArray();
    }
    public function getOne($id){
        $res = static::find($id);
        //这里需要加判断是否存在
            return $res->toArray();
    }
//    public function getStatusAttr($v){ //获取器
//        $status = [
//            1=>'开启',
//            2=>'关闭'
//        ];
//        return $status[$v];
//    }
    public function setStatusAttr($v,$all){//修改器
        // $all 全部参数
        return (int)$v;
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
        $res->save($post);
    }

    public function change($id,$post){
        if($id){
            $res = static::find($id);
        }else{
            $res = new Article();
        }
        empty($post['status']) ? $post['status']=0 : $post['status'] = 1;
        $res->save($post);
    }

    public function deleteOne($id){
        if($id){
            $res = static::find($id);
            $res->delete();
        }
    }


}
