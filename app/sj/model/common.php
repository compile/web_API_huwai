<?php
namespace app\sj\model;
use think\Model;
use think\facade\Db;
use think\facade\Request;
class common extends Model
{



    public function getOne($id){
        $shop = Shop::find($id);
        return $shop->toArray();
    }

    public function change($id,$post){
        if($id){
            $shop = Shop::find($id);
        }else{
            $shop = new Shop();
        }
        $shop->allowField(['name'])->save($post);
    }




    static function key_value_array_flip($arr,$str=false){
        $res = array_flip($arr);
        if($str==false){
            $result = array();
            foreach($res as $key=>$val){
                $key === 'status'?$result[$key]=1:$result[$key]='';
            }
        }else{
            $result = '';
            foreach($res as $key=>$val){
                $result .= "'".$key."',";
            }
            $result = trim($result,',');
        }
        return $result;
    }


    static function changeOneAttribute($table,$attribute,$id){
        switch($table){
            case 'article':

                break;
            case 'usergrade':  //等级

                break;
            case 'goodsgrade':

                break;
            case 'shop':

                break;
            case 'article':

                break;
            case 'order':
                echo 'order';
                break;

        }
    }






}
