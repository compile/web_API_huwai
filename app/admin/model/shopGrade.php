<?php
namespace app\admin\model;
use think\Model;
class shopGrade extends Model
{
    protected $schema = [
        'id'          => 'int',
        'name'        => 'string',
        'status'      => 'int',
        'gradeValue'       => 'int',
        'create_time' => 'datetime',
        'update_time' => 'datetime',
    ];

    public function getOne($id){
        $usergrade = UserGrade::find($id);
        return $usergrade->toArray();
    }

    public function change($id,$post){
        if($id){
            $usergrade = UserGrade::find($id);
        }else{
            $usergrade = new UserGrade();
        }
        $usergrade->save($post);
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
