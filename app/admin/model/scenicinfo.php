<?php
namespace app\admin\model;
use think\facade\Config;
use think\Model;
use think\facade\Db;
use think\facade\Request;
use think\model\concern\SoftDelete;
class scenicinfo extends Model
{
    protected $deleteTime = 'delete_time';
    protected $name = 'scenic_info';

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
            $res = new scenicinfo();
        }
        empty($post['status']) ? $posttemp['status']=0 : $posttemp['status'] = 1;
        empty($post['is_type']) ? $posttemp['type']=0 : $posttemp['type'] = 1;
//        $param = array();
//        echo '<pre>';
        $param = $post;
//        print_r($param);
//        echo $param['is_type'];
        if($param['is_type'] == 1){//视频
            echo '这里哦';
             $temp= array();
             $temp[0]= @$param['video'];
            $posttemp['media'] = json_encode($temp);
        }else{//图文

//            print_r($param);
            $imagelist = @$param['imglist'];

//            print_r($imagelist);
            if(is_array($imagelist)){
                foreach($imagelist as $key=>$value){
                    $image[$key] = $value;
                }
                unset($post['image']);
                $posttemp['media'] = json_encode($image);//还需要判断 是视频 还是图文哦。
            }
        }
        if($posttemp['type'] == 1){//视频
            $posttemp['videoinfo'] = '';
        }
        $posttemp['title'] = $post['title'];
        $posttemp['content'] = $post['content'];
        $posttemp['topic_id'] = $post['topic_id'];

            echo '<pre>';
            echo '修改的';
            print_r($posttemp);
            echo '</pre>';


         $do = $res->save($posttemp);
         if($do){
             echo 'ok';
         }else{
             echo 'false';
         }

    }

    public function deleteOne($id){
        if($id){
            $res = static::find($id);
            $res->delete();
        }
    }


}
