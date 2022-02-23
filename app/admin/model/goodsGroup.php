<?php
namespace app\admin\model;
use app\sj\model\GoodsAttr;
use think\facade\Config;
use think\Model;
use think\facade\Db;
use think\facade\Request;
use think\model\concern\SoftDelete;
class goodsGroup extends Model
{
    protected $deleteTime = 'delete_time';

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
        if($id){
            $res = static::find($id);
        }else{
            $res = new Goods();
        }
        empty($post['status']) ? $post['status']=0 : $post['status'] = 1;
//        $param = array();
//        echo '<pre>';
        $param = $post;
//        print_r($param);

        $imagelist = $param['imglist'];
        if(is_array($imagelist)){
            foreach($imagelist as $key=>$value){
                $image[$key]['src'] = $value;
            }

            unset($post['image']);
//            print_r($image);
            $post['image'] = json_encode($image);
        }
        $post['thumb'] = $post['thumb'];
        $post['attr_value'] = @$post['json'];
        if(@$post['attr_status'] == 'on'){
            $post['attr_status'] = 1;
        }
        if(@$post['attr_status'] == 'off'){
            $post['attr_status'] = 0;
        }
        if(!empty($param['attrstock']) && !empty($param['attrprice'])){
            $attrstock= $param['attrstock'];
            $attrprice = $param['attrprice'];
            $attrthumb = $param['attrthumb'];
            @$id = $param['gid'];
            $newarr = array();
            $num = count($attrprice);
            for($k=0;$k<$num;$k++){//组成属性组 方便提交数据库
                if(!empty($param['gid'])){
                    $newarr[$k]['id'] = @$id[$k];
                }
                if(!empty($param['json'])){
                    $json = json_decode($param['json'],true);
                    $newarr[$k]['attr'] = join(" ",$json[$k]);
                }

                $newarr[$k]['thumb'] = $attrthumb[$k];
                $newarr[$k]['stock'] = $attrstock[$k];
                $newarr[$k]['price'] = $attrprice[$k];
            }


            echo '<pre>';
            echo '修改的';
            print_r($post);
            echo '</pre>';



            Db::startTrans();
            try {
                $attr = new GoodsAttr();
                echo $attr->saveAll($newarr);
                $res->save($post);
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                $result['data']['error'] = $e;
                // 回滚事务
                Db::rollback();
            }



        }
    }

    public function deleteOne($id){
        if($id){
            $res = static::find($id);
            $res->delete();
        }
    }


}
