<?php
namespace app\sj\model;
use think\Model;
class goodsattr extends Model
{
    protected $schema = [
        'id'          => 'int',
        'sid'         => 'int',
        'uid'         => 'int',
        'attr'        => 'string',
        'stock'       => 'int',
        'sku'         => 'string',
        'price'       => 'float',
        'status'      => 'int',
        'create_time' => 'datetime',
        'update_time' => 'datetime',
    ];

    public function getOne($id){
        $usergrade = GoodsGrade::find($id);
        return $usergrade->toArray();
    }


    public function getList(){
        $usergrade = GoodsGrade::where('id','>',0)->order('id')->select();
        return $usergrade->toArray();
    }

    public function change($id,$post){
        if($id){
            echo '111';
            $goodsgrade = GoodsGrade::find($id);
            if(!$goodsgrade){
                $goodsgrade = new GoodsGrade();
            }
        }else{
            echo '222';
            $goodsgrade = new GoodsGrade();
        }
        echo 'zheli';
         $goodsgrade->save($post);
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
