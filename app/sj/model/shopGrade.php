<?php
namespace app\sj\model;
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
        $res = static::find($id);
        return $res->toArray();
    }

    public function change($id,$post){
        if($id){
            $res = static::find($id);
        }else{
            $res = new UserGrade();
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
