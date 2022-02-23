<?php
declare (strict_types = 1);

namespace app\api\controller;

use think\facade\Cache;
use think\facade\Db;
use think\facade\Request;
use think\facade\Filesystem;
use app\api\BaseController;
use \Firebase\JWT\JWT;

class article
{
    public function goodsList()
    {
//        if (Request::isPost()) {
            $post = Request::param();
            $result['data']['status'] = 0;
            $result['data']['post'] = @$post['priceOrder'] . @$post['filterIndex'];
            $pageNum = @$post['pagenum'];//显示第几页
            $table = str_replace("List", '', __FUNCTION__);
            $common = new Common();

            if(@$post['catId']) {
                $where['type_id'] = $post['catId'];
            }else{
                $where= array();
            }
            echo $res = $common->getList($table, 2,$where,@$post['priceOrder'],@$post['filterIndex'],$pageNum);
//        }
    }

    public function index(){//文章列表
            $table = 'article';
            $where = array();

        $page = input('page', 1);
        $pageSize = input('limit', 9);

        $list = Db::name($table)->order('create_time desc')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();



        foreach($list['data'] as $k=>$item){
            $article[$k]['id'] = $item['id'];
            $article[$k]['title'] = $item['title'];
            $article[$k]['contents']=$item['title'];
            $article[$k]['photo_url'] = 'http://olife.weisite.org/api/common/bdimg.html?url=https%3A%2F%2Fpics7.baidu.com%2Ffeed%2F279759ee3d6d55fb39b91e2b7c07734220a4dd69.jpeg%3Ftoken%3D7cc70f7448d617cec7ca4613ce8345de';
            $article[$k]['read'] = rand(200,3000);
            $article[$k]['contentsimg'] = 'https://olife.weisite.org/api/common/bdimg.html?url=https%3A%2F%2Fpics7.baidu.com%2Ffeed%2F279759ee3d6d55fb39b91e2b7c07734220a4dd69.jpeg%3Ftoken%3D7cc70f7448d617cec7ca4613ce8345de';
            $article[$k]['create_time'] = date('Y-m-d');
            $article[$k]['sharenum'] = rand(0,10);
            $article[$k]['pinglunnum'] = rand(0,100);
            $article[$k]['zannum'] = rand(0,100);
            $article[$k]['username'] = '7funCC';
            $article[$k]['userimg'] =           'http://olife.weisite.org/api/common/bdimg.html?url=https%3A%2F%2Fpics7.baidu.com%2Ffeed%2F279759ee3d6d55fb39b91e2b7c07734220a4dd69.jpeg%3Ftoken%3D7cc70f7448d617cec7ca4613ce8345de';

            $article[$k]['userage'] = 19;
            $article[$k]['sex'] = 1;
            $article[$k]['source'] = '7Funcc';

            if($item['typeid'] == '12'){
                $state= 0;
            }else if($item['typeid'] == '13'){
                $state = 1;
            }else if($item['typeid'] == '14'){
                $state = 2;
            }else if($item['typeid'] == '15'){
                $state = 3;
            }
            $article[$k]['state'] = $state;
            $article[$k]['thumb'] = $item['thumb'];
            $article[$k]['link'] = array('type'=>'article','id'=>13411,'url'=>'');
        }



        $res['total'] = $list['total'];
        $res['per_page'] = $list['per_page'];
        $res['last_page'] = $list['last_page'];
        $res['current_page'] = $list['current_page'];
        $res['status'] = 0;



        $res['list'] = $article;
//        $res['res'] = $list;
        $res['slider'] = $article;
        $res['ad'] = $article;
        $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $res, 'count' => 1999, 'rel' => 1];
        echo json_encode($result);

        exit();
    }

    public function detail(){
        $post = Request::param();
        $id = $post['id'];
        $userInfo = @$post['userInfo'];
        $table = 'article';
        $where['id'] = $id;
        $list = Db::name($table)->where($where)->find();
        $res['id'] = $list['id'];
        $res['title'] = $list['title'];
        $res['read']  = rand(0,10);
        $res['source'] = '7Funcc';
        $res['create_time'] = date('Y-m-d');
        $res['photo_url'] = 'https:\/\/tukuimg.bdstatic.com\/scrop\/ae69df4d458f943ac854d8b2f3d15e8b.jpeg';
        $res['category_id'] = 1;
        $res['thumb'] = $list['thumb'];
        $res['content'] = $list['content'];
        $res['source_url'] = '7Funcc';
        $res['like_count'] = $list['likes'];
        if($userInfo){
                $common = new Common();
            if($common->if_exists_redis($userInfo,'like_',$list['id'])){
                $res['is_like'] = 1;
            }
            if($common->if_exists_redis($userInfo,'favorite_',$list['id'])){
                $res['is_favorite'] = 1;
            }
        }else{
            $res['is_like'] = 0;
            $res['is_favorite'] = 0;//这里再改
        }

        $res['comment']  = $this->comment();
        $res['category'] = array('id'=>1,'name'=>'心灵');
        $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $res, 'count' => 1999, 'rel' => 1];
        echo json_encode($result);
        exit();
    }


    public function comment(){
        $id =  Request::param('id');
        $table = 'article_comments';
        $where = array();
        $where['article_id'] = $id;
        $where['status'] = 1;
        $page = input('page', 1);
        $pageSize = input('limit', 9);
        $list = Db::name($table)->order('create_time desc')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();
        $result['list'] = $list['data'];
        $result['count'] = $list['total'];
        $result['page'] = $list['last_page'];
        return $result;
    }


    public function category(){//文章分类
        $table = 'article_cate';
        $common = new \app\api\controller\Common();
        $common->getList($table,1);
        exit();
    }

    public function saveHistory(){
        $redis = Cache::store('redis')->handler();
        $id = 1;
        $gid = 1;//浏览的商品id;
        $key = "history_";
        $redis->SADD($key.$id,$gid);//
    }

    public function like(){//点赞文章
        $redis = Cache::store('redis')->handler();
        $post = Request::param();
        $userInfo = $post['userInfo'];
        $id = $userInfo['id'];
        $aid = $post['article_id'];
        $key  = "like_";
        $iftrue  = $redis->SISMEMBER($key.$id,$aid);//如果存在 则为 1
        if($iftrue == true){//存在 则 移除
            $redis->SREM($key.$id,$aid);

            Db::name('article')
                ->where('id', $aid)
                ->dec('likes')
                ->update();


            $temp['like'] = false;
        }else{//不存在则 添加
            $temp['like'] = true;
            $redis->SADD($key.$id,$aid);//

            Db::name('article')
                ->where('id', $aid)
                ->inc('likes')
                ->update();
        }

        $result['code']  = 0;
        $result['data']['status'] = 0;
        $result['data']['res'] = $temp;
        echo json_encode($result);
    }

    public function addComment(){//添加评论
        $redis = Cache::store('redis')->handler();
        $post = Request::param();
        $userInfo = $post['userInfo'];
        $id = $userInfo['id'];
        $aid = $post['article_id'];
//        $key  = "like_";
//        $iftrue  = $redis->SISMEMBER($key.$id,$aid);//如果存在 则为 1
//        if($iftrue == true){//存在 则 移除
//            $redis->SREM($key.$id,$aid);
//            $temp['like'] = false;
//        }else{//不存在则 添加
//            $temp['like'] = true;
//            $redis->SADD($key.$id,$aid);//
//        }

        $comment['article_id'] = $post['article_id'];
        $comment['content'] = $post['content'];
        $comment['create_time'] = date('Y-m-d H:i:s');
        $comment['uid'] = 1;
        $comment['to_uid'] = 0;

        $do = Db::name('article_comments')->insertGetId($comment);
        if($do){
            $comment['id'] = $do;
        }

        $comment['avatar_url'] = 'https://img1.baidu.com/it/u=1571781282,101412201&fm=253&fmt=auto&app=120&f=PNG?w=144&h=144';
        $comment['nickname'] = '唔师';
        $result['code']  = 0;
        $result['data']['status'] = 0;
        $result['data']['res'] = $comment;
        echo json_encode($result);
    }


    public function favorite(){//收藏文章
        $redis = Cache::store('redis')->handler();
        $post = Request::param();
        $userInfo = $post['userInfo'];
        $id = $userInfo['id'];
        $aid = $post['article_id'];
        $key  = "favorite_";
        $iftrue  = $redis->SISMEMBER($key.$id,$aid);//如果存在 则为 1
        if($iftrue == true){//存在 则 移除
            $redis->SREM($key.$id,$aid);
            $temp['like'] = false;
        }else{//不存在则 添加
            $temp['like'] = true;
            $redis->SADD($key.$id,$aid);//
        }

        $result['code']  = 0;
        $result['data']['status'] = 0;
        $result['data']['res'] = $temp;
        echo json_encode($result);
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
    }


    public function goodsOne(){// 应该先从redis 获取。 如果没有再去sql里面
        $res = new \app\admin\model\goods();
        $id =  Request::param('id');
        $redis = Cache::store('redis')->handler();

        $keyvalue="goods";
        $exist = $redis->EXISTS($keyvalue.$id);
        if($exist){//存在 就从 缓存获取
//            $goodsRes = $res->getOne($id) ;
            $goodsRes = $redis->HGETALL($keyvalue.$id);
        }else{//不存在就sql获取并且保存
            $goodsRes = $res->getOne($id) ;
            $redis->HMSET($keyvalue.$id,$goodsRes);
            exit();
        }
        $result['data']['status'] = 0;
        $result['data']['res'] = $goodsRes;
        $result['data']['attr_value'] = $goodsRes['attr_value'];
        echo json_encode($result);

    }

}
