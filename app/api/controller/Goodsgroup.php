<?php
declare (strict_types = 1);

namespace app\api\controller;

use think\facade\Cache;
use think\facade\Db;
use think\facade\Request;

class goodsgroup
{
    public function goodsGroupList()
    {
//        if (Request::isPost()) {
            $post = Request::param();
            $result['data']['status'] = 0;
            $result['data']['post'] = @$post['priceOrder'] . @$post['filterIndex'];
            $pageNum = @$post['pagenum'];//显示第几页
            $table = "goodsgroup";
            $common = new Common();

            if(@$post['catId']) {
                $where['type_id'] = $post['catId'];
            }else{
                $where= array();
            }

            echo $res = $common->getList($table, 2,$where,@$post['priceOrder'],@$post['filterIndex'],$pageNum);
            exit();
//        }
    }

    public function goodscate(){
        $key = 'goodscate';
        $redis = Cache::store('redis')->handler();
        $exist = $redis->EXISTS($key);
        if($exist) {//存在 就从 缓存获取
            $res =  $redis->get($key);
        }else{
            $table = 'goods_cate';
            $where['status'] = 1;
            $list = \think\facade\Db::name($table)->order('create_time desc')->order('pId asc')->where($where)->select()->toArray();
            $result['data']['status'] = 0;
            $result['data']['res'] = $list;
            $res = json_encode($result);
            $redis->set($key,$res);
        }
        echo $res;
        exit();
    }

    public function saveHistory(){
        $redis = Cache::store('redis')->handler();
        $id = 1;
        $gid = 1;//浏览的商品id;
        $key = "history_";
        $redis->SADD($key.$id,$gid);//
    }


    public function collectionGoodsGroup(){//收藏商品。 如果存在 则删除。 如果不存在 则添加。 也是不能重复的。
        $redis = Cache::store('redis')->handler();
        $post = Request::param();
        $userInfo = $post['userInfo'];
        $id = $userInfo['id'];
        $gid = $post['goodsGroupOne']['id'];//浏览的商品id;
        $key  = "collection_goodsGroup_";
        $iftrue  = $redis->SISMEMBER($key.$id,$gid);//如果存在 则为 1
        if($iftrue == true){//存在 则 移除
            $redis->SREM($key.$id,$gid);
            $temp['fav'] = false;
        }else{//不存在则 添加
            $temp['fav'] = true;
            $redis->SADD($key.$id,$gid);//
        }

        $result['data']['status'] = 0;
        $result['data']['res'] = $temp;
        echo json_encode($result);
        exit();
    }

    public function getAttrInfo(){// 这里是返回单个库存结果。 实时的 如果库存为0 就要提示无法购买
        $post = Request::param();
        $result['data']['status'] = 0;
        $result['data']['res'] = $post;
        $temp= array();
        foreach($post as $k=>$item){
           $temp[$k]= $item['name'];//组合搜索词。 其实后面需要加 商家 和商品id  另外用 attr 的 id 经过排序后 再搜索 结果会好一点？？
        }
        $where['attr'] = join(" ",$temp);
        $skutemp = Db::name("goodsattr")->where($where)->find();
        $result['data']['stock'] = $skutemp;
        echo json_encode($result);
        exit();
    }


    public function goodsGroupOnefromid($id){
        $res = new \app\sj\model\goodsGroup();
        $redis = Cache::store('redis')->handler();
        $keyvalue="goodsgroup";
        $exist = $redis->EXISTS($keyvalue.$id);
        if($exist){//存在 就从 缓存获取
//            $goodsRes = $res->getOne($id) ;
            $goodsgroupRes = $redis->HGETALL($keyvalue.$id);
        }else{//不存在就sql获取并且保存
            $goodsgroupRes = $res->getOne($id) ;
            $redis->HMSET($keyvalue.$id,$goodsgroupRes);

        }

        return $goodsgroupRes;
    }

    public function goodsGroupOne(){// 应该先从redis 获取。 如果没有再去sql里面
        $res = new \app\sj\model\goodsGroup();
        $id =  Request::param('id');
        $userInfo =  Request::param('userInfo');
        $redis = Cache::store('redis')->handler();
        $keyvalue="goodsgroup";
        $exist = $redis->EXISTS($keyvalue.$id);
        if($exist){//存在 就从 缓存获取
//            $goodsRes = $res->getOne($id) ;
            $goodsgroupRes = $redis->HGETALL($keyvalue.$id);
        }else{//不存在就sql获取并且保存
            $goodsgroupRes = $res->getOne($id) ;
            $redis->HMSET($keyvalue.$id,$goodsgroupRes);

        }

        if($userInfo){//是否收藏
            $uid = $userInfo['id'];
            $key  = "collection_goodsGroup_";
            $iftrue  = $redis->SISMEMBER($key.$uid,$id);//如果存在 则为 1
            if($iftrue == true) {//存在 则 移除
                $goodsgroupRes['collection']= true;//收藏
            }else{
                $goodsgroupRes['collection']= false;//没有收藏
            }
        }else{
            $goodsgroupRes['collection']= false;//没有收藏
        }
        $result['data']['status'] = 0;
        $result['data']['res'] = $goodsgroupRes;
        $result['data']['reserve'] = $this->getgoodsGroup($id);
        echo json_encode($result);
        exit();
    }


    function getgoodsGroup($id){
       $res =  Db::name('goodsgroup_reserve')->where('gg_id','=',$id)->field('start_time,res_time')->select()->toArray();

       $result = array();
       foreach($res as $k=>$val){
           $result[$k]['begin_time'] = $val['start_time'];
           $result[$k]['end_time']   = $val['res_time'];
       }
       return $result;
    }

    public function index(){
        echo __FUNCTION__;
    }
}
