<?php
namespace app\sj\model;
use think\facade\Config;
use think\Model;
use think\facade\Db;
use think\facade\Request;
use think\model\concern\SoftDelete;
class goodsGroup extends Model
{
    protected $deleteTime = 'delete_time';
    protected $name = 'goodsgroup';

    public function index(){
        $find = static::find(74);
        return $find->toArray();
    }
    public function getOne($id){
        $res = static::find($id);
        $inc['clicks'] = $res['clicks']+1;
        $inc['id'] = $res['id'];
        if($res){
            static::find($id)->save($inc);
        }
        //这里需要加判断是否存在
        return $res->toArray();
    }



    public function searchScreen($arrayid){
        $res = static::select($arrayid);
        return $res;
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
        echo '<pre>';
        print_r($post);



        if($id){
            $res = static::find($id);
        }else{
            $res = new goodsGroup();
        }
        empty($post['status']) ? $post['status']=0 : $post['status'] = 1;

        if(@$post['attr_status'] == 'on'){
            $post['attr_status'] = 1;
        }
        if(@$post['attr_status'] == 'off'){
            $post['attr_status'] = 0;
        }




            $attrgid   = $post['gid'];
            $attr      = $post['attr'];
            $attrid    = $post['attrid'];
            $attrnum   = $post['num'];
            $attrstock= $post['attrstock'];
            $attrprice = $post['attrprice'];
            $attrthumb = $post['thumblist'];


            @$id = $post['id'];
            $newarr = array();
            $num = count($attrprice);
            for($k=0;$k<$num;$k++){//组成属性组 方便提交数据库
                if(!empty($param['gid'])){
                    $newarr[$k]['id'] = @$id[$k];
                }

                $newarr[$k]['attr']      = $attr[$k];
                $newarr[$k]['thumblist'] =  $attrthumb[$k] ;
                $newarr[$k]['gid'] =   $attrgid[$k] ;
                $newarr[$k]['attrprice'] = $attrprice[$k];
                $newarr[$k]['attrstock'] = $attrstock[$k];
                $newarr[$k]['num'] = $attrnum[$k];
                $newarr[$k]['attrid'] = $attrid[$k];
            }

            $goodsGroup['title'] =  $post['title'];
            $goodsGroup['thumb'] = $post['thumb'];
            $goodsGroup['type_id'] = $post['type_id'];
            $goodsGroup['status'] = $post['status'];
            $goodsGroup['content'] = $post['content'];

            if(@$post['id']){
                $goodsGroup['id'] = @$post['id'];
            }

            $goodsGroup['goodslist'] = json_encode($newarr);

            echo '<pre>';

            print_r($goodsGroup);

            echo '<pre>';
                $res->save($goodsGroup);

            echo 'hehe';
            exit();
    }

    public function deleteOne($id){
        if($id){
            $res = static::find($id);
            $res->delete();
        }
    }


}
