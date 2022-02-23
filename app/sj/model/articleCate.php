<?php
namespace app\sj\model;
use think\Model;
class articleCate extends Model
{
    protected $schema = [
        'id'          => 'int',
        'name'        => 'string',
        'status'      => 'int',
        'pId'       => 'int',
        'create_time' => 'datetime',
        'update_time' => 'datetime',
    ];

    public function getOne($id){
        $res = static::find($id);
        return $res->toArray();
    }


    public function getList(){
        $res = static::where('id','>',0)->order('id')->select();
        return $res->toArray();
    }

    public function change($id,$post){
        if($id){
            $res = static::find($id);
            if(!$res){
                $res = new ArticleCate();
            }
        }else{

            $res = new ArticleCate();
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
