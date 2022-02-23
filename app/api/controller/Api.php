<?php
declare (strict_types = 1);

namespace app\api\controller;

use think\facade\Cache;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Api extends Common
{

    public function __construct(Request $request)

    {



    }


    public function getArticle(){
        @$tempdata = Request::param();

        if(@$tempdata['title'] !== '') {
            $add['title'] = $tempdata['title'];
            $add['uid'] = 1;
            $add['typeid'] = 15;
            $add['content'] = $tempdata['content'];
            $add['thumb'] = $tempdata['thumb'];
            $add['create_time'] = $tempdata['create_time'];


            echo Db::name('article')->save($add);
        }else{
            echo '404';
            exit();
        }
    }

    public function tab(){
        $tab['0'] = '首页';
        $tab['1'] = '户外';


        $result['data']['tab'] = $tab;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);
    }

    public function swiperInfo(){
        $where['type'] = 0;
        $where['status'] = 1;
        $swiperInfo = Db::name('swiper')->where($where)->select()->toArray();
        $result['data']['swiperInfo'] = $swiperInfo;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);

    }


    public function gridMenuData(){

        $where['type'] = 0;
        $where['status'] = 1;
        $gridmenu = Db::name('nav_app')->where($where)->select()->toArray();


        $result['data']['gridMenuData'] = $gridmenu;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);
    }



    public function gridSortData(){
        $where['type'] = 1;
        $where['status'] = 1;
        $gridSortData = Db::name('nav_app')->where($where)->select()->toArray();

        $result['data']['gridSortData'] = $gridSortData;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);
    }

    public function identifyData(){
        //[{"id":1,"name":"图文鉴别","text":"验过的更放心","img":"/static/images/home/sundry/3.png"},{"id":2,"name":"免费鉴别","text":"专家24h在线","img":"/static/images/home/sundry/4.png"},{"id":3,"name":"连麦鉴别","text":"2114人正在看","img":"/static/images/home/sundry/5.png"}

        $identifyData[0]['id'] = 1;
        $identifyData[0]['name'] = "鉴定好玩";
        $identifyData[0]['text'] = "验过的玩放心";
        $identifyData[0]['img'] = "/static/images/home/sundry/3.png";

        $identifyData[1]['id'] = 1;
        $identifyData[1]['name'] = "偷偷告诉你";
        $identifyData[1]['text'] = "带娃24h在线";
        $identifyData[1]['img'] = "/static/images/home/sundry/4.png";

        $identifyData[2]['id'] = 1;
        $identifyData[2]['name'] = "呼朋唤友";
        $identifyData[2]['text'] = "24132在看";
        $identifyData[2]['img'] = "/static/images/home/sundry/5.png";



        $result['data']['identifyData'] = $identifyData;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);
    }


    public function quickly_swiper(){
        //[{"text":"xxx赚了560元","img":"/static/images/avatar/1.jpg"},{"text":"xxx赚了3元","img":"/static/images/avatar/2.jpg"},{"text":"xx赚了20元","img":"/static/images/avatar/3.jpg"},{"text":"xxx赚了98元","img":"/static/images/avatar/4.jpg"},{"text":"xx赚了0.1元","img":"/static/images/avatar/5.jpg"}

        $quickly_swiper[0]['text'] = "xxx 去 胡里山公园玩了20小时";
        $quickly_swiper[0]['img']   = "/static/images/avatar/1.jpg";

        $quickly_swiper[1]['text'] = "xxx 去 下谭尾公园玩了3小时";
        $quickly_swiper[1]['img']   = "/static/images/avatar/1.jpg";

        $quickly_swiper[2]['text'] = "xxx 去 中山公园玩了8小时";
        $quickly_swiper[2]['img']   = "/static/images/avatar/1.jpg";

        $result['data']['quickly_swiper'] = $quickly_swiper;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);
    }

    public function quickly_list(){
        //[{"id":1,"title":"手机保卖","text":"99%卖出","img":"/static/images/home/sundry/6.png"},{"id":2,"title":"拍卖报名","text":"24小时高价卖","img":"/static/images/home/sundry/7.png"},{"id":3,"title":"扫码读书","text":"好书高价卖","img":"/static/images/home/sundry/8.png"}]

        $quickly_list[0]['id']= 1;
        $quickly_list[0]['title'] = "帐篷租借";
        $quickly_list[0]['text'] = "99%新";
        $quickly_list[0]['img'] = "/static/images/home/sundry/6.png";

        $quickly_list[1]['id']= 2;
        $quickly_list[1]['title'] = "户外用品";
        $quickly_list[1]['text'] = "99%新";
        $quickly_list[1]['img'] = "/static/images/home/sundry/7.png";

        $quickly_list[2]['id']= 3;
        $quickly_list[2]['title'] = "新奇好物";
        $quickly_list[2]['text'] = "品鲜";
        $quickly_list[2]['img'] = "/static/images/home/sundry/8.png";

        $result['data']['quickly_list'] = $quickly_list;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);
    }


    public function activity(){
        //[{"id":1,"title":"转转社区","text":"发现有趣","img":"/static/images/home/sundry/11.png"},{"id":2,"title":"手机直播","text":"直降400元","img":"/static/images/home/sundry/10.png"},{"id":3,"title":"新人专享","text":"","img":"/static/images/home/sundry/12.png"},{"id":4,"title":"爆款大促","text":"","img":"/static/images/home/sundry/13.png"},{"id":5,"title":"5元3本","text":"","img":"/static/images/home/sundry/14.png"},{"id":6,"title":"全新拍卖","text":"","img":"/static/images/home/sundry/15.png"}]
        $activity[0]['id'] = 1;
        $activity[0]['title'] = "7Fun社区";
        $activity[0]['text'] = "发现有趣";
        $activity[0]['img']  = "/static/images/home/sundry/11.png";
        $activity[1]['id'] = 2;
        $activity[1]['title'] = "手机直播";
        $activity[1]['text'] = "蛮享生活";
        $activity[1]['img']  = "/static/images/home/sundry/10.png";
        $activity[1]['id'] = 3;
        $activity[1]['title'] = "新人专享";
        $activity[1]['text'] = "红包";
        $activity[1]['img']  = "/static/images/home/sundry/12.png";
        $activity[1]['id'] = 4;
        $activity[1]['title'] = "租游玩";
        $activity[1]['text'] = "官方自营";
        $activity[1]['img']  = "/static/images/home/sundry/13.png";
        $result['data']['activity'] = $activity;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);
    }


    public function goodsTabData_list(){
        //[{"title":"看推荐","tag":""},{"title":"逛附近","tag":""},{"title":"直播","tag":"秒杀中"},{"title":"实惠好货","tag":""},{"title":"短视频","tag":""}]
        $goodsTabData_list[0]['title']='看推荐';
        $goodsTabData_list[0]['tag'] = '';
//        $goodsTabData_list[1]['title'] = "逛附近";
//        $goodsTabData_list[1]['tag'] = "";
//        $goodsTabData_list[2]['title'] = "直播";
//        $goodsTabData_list[2]['tag'] = "秒杀中";
//        $goodsTabData_list[3]['title'] = "实惠好货";
//        $goodsTabData_list[3]['tag'] = "";
        $goodsTabData_list[4]['title'] = "攻略";
        $goodsTabData_list[4]['tag'] = "";
        $result['data']['goodsTabData_list'] = $goodsTabData_list;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);
    }


    public function TieZi(){//这里改成 动态。 和 攻略一起。 后面流量多了再分开。
        /**
        $GoodsData[0]['v'] =  false;
        $GoodsData[0]['pay'] = true;
        $GoodsData[0]['type'] = '';
        $GoodsData[0]['mold'] = array();
        $GoodsData[0]['service'][0] = "实地考察";
        $GoodsData[0]['service'][1] = "专业带玩";
        $GoodsData[0]['price'] = "2280";
        $GoodsData[0]['servicePlus'] = '';
        $GoodsData[0]['username'] = "面仔膏";
        $GoodsData[0]['time'] = "1小时前来过";
        $GoodsData[0]['title'] = "铁路文化公园风景优美";
        $GoodsData[0]['img'] = "https://bkimg.cdn.bcebos.com/pic/7acb0a46f21fbe0953aff1576d600c338644adfb?x-bce-process=image/resize,m_lfit,w_536,limit_1/format,f_jpg";
        $GoodsData[0]['avatar'] = "/static/images/avatar/2.jpg";



        $GoodsData[1]['v'] =  true;
        $GoodsData[1]['pay'] = false;
        $GoodsData[1]['type'] = '';
        $GoodsData[1]['mold']['bg'] = 'red';
        $GoodsData[1]['mold']['title'] = '自营';
        $GoodsData[1]['service']  = array();
        $GoodsData[1]['price'] = "5049";
        $GoodsData[1]['servicePlus'] = '支持验机';
        $GoodsData[1]['username'] = "正品保障";
        $GoodsData[1]['time'] = "7天无理由";
        $GoodsData[1]['title'] = "万石植物园空气好";
        $GoodsData[1]['img'] = "http://www.sifanghua.com.cn/attachment/news/20200506/0hkqtpve0zv.jpg";
        $GoodsData[1]['avatar'] = "/static/images/avatar/2.jpg";


        $GoodsData[2]['v'] =  false;
        $GoodsData[2]['pay'] = false;
        $GoodsData[2]['type'] = '';
        $GoodsData[2]['mold']['bg'] = 'blue';
        $GoodsData[2]['mold']['title'] = '寄卖';
        $GoodsData[2]['service']  = array();
        $GoodsData[2]['price'] = "2089";
        $GoodsData[2]['servicePlus'] = '已验机';
        $GoodsData[2]['username'] = "沙茶面";
        $GoodsData[2]['time'] = "当前在线";
        $GoodsData[2]['title'] = "园博苑真真大";
        $GoodsData[2]['img'] = "http://www.sifanghua.com.cn/attachment/news/20200506/5vs1w34rv0i.jpg";
        $GoodsData[2]['avatar'] = "/static/images/avatar/3.jpg";


        $GoodsData[3]['v'] =  false;
        $GoodsData[3]['pay'] = false;
        $GoodsData[3]['type'] = '';
        $GoodsData[3]['mold']['bg'] = 'blue';
        $GoodsData[3]['mold']['title'] = '寄卖';
        $GoodsData[3]['service']  = array();
        $GoodsData[3]['price'] = "2089";
        $GoodsData[3]['servicePlus'] = '已验机';
        $GoodsData[3]['username'] = "沙茶面";
        $GoodsData[3]['time'] = "当前在线";
        $GoodsData[3]['title'] = "集美学校村多好玩";
        $GoodsData[3]['img'] = "http://www.sifanghua.com.cn/attachment/news/20200506/4auwuqfbm22.jpg";
        $GoodsData[3]['avatar'] = "/static/images/avatar/3.jpg";

        */
        $tempdata = Request::param();
        $where = array();
        $page = input('page', 1);
        $pageSize = input('limit', 10);
//        $where['topic_id'] = $tempdata['topic_id'];
        $order = input('order','id');
        $result222 = \think\facade\Db::name('scenic_info')->order($order.' desc')->field('id,title,uid,media,create_time,read_count,address,type')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();
        if($result222['data']) {
            foreach ($result222['data'] as $k => $v) {
                $thumb = $this->getoneImg($v['media']);
                if(!$thumb){
                    $thumb = 'https://bkimg.cdn.bcebos.com/pic/7acb0a46f21fbe0953aff1576d600c338644adfb?x-bce-process=image/resize,m_lfit,w_536,limit_1/format,f_jpg';
                }
                $mold['bg'] = 'red';
                $mold['title'] = '租用';
                if ($thumb) {
                    $user = $this->getUser($v['uid']);
                    $TieZi[$k]['id'] = $v['id'];
                    $TieZi[$k]['v'] = true;
                    $TieZi[$k]['pay'] = true;
                    $TieZi[$k]['type'] = "";
                    $TieZi[$k]['leixing'] = $v['type'];//1图文 2视频
                    $TieZi[$k]['title'] = $v['title'];
                    $TieZi[$k]['mold'] = $mold;
                    $TieZi[$k]['service'] = array();
//                    $TieZi[$k]['price'] = "221";
                    $TieZi[$k]['username'] =  $user['username'];
                    $TieZi[$k]['time'] = date('Y-m-d H:i:s');
                    $TieZi[$k]['img'] = "$thumb";
                    $TieZi[$k]['avatar'] = $user['avatar'];
                }
            }
        }else{
            $TieZi = array();
        }
        $result['data']['TieZi'] = $TieZi;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);
    }


    public function getUser($id){
            if($id <=0){
                $id = 1;
            }
           $user = new \app\api\model\user();
          $result =  $user->getOne($id);
           return $result;
    }

    public function getoneImg($media){
        $json= json_decode($media,true);
        return $json['0'];
    }

    public function GongLue(){
        //[{"title":"某某某的视频","name":"某某某","appreciate":"499","avatar":"/static/images/avatar/1.jpg","cover_img":"/static/images/home/video/1.jpg"},{"title":"某某某的视频","name":"某某某","appreciate":"499","avatar":"/static/images/avatar/2.jpg","cover_img":"/static/images/home/video/2.gif"},{"title":"某某某的视频","name":"某某某","appreciate":"499","avatar":"/static/images/avatar/3.jpg","cover_img":"/static/images/home/video/3.gif"},{"title":"某某某的视频","name":"某某某","appreciate":"499","avatar":"/static/images/avatar/4.jpg","cover_img":"/static/images/home/video/4.gif"},{"title":"某某某的视频","name":"某某某","appreciate":"499","avatar":"/static/images/avatar/5.jpg","cover_img":"/static/images/home/video/5.gif"},{"title":"某某某的视频","name":"某某某","appreciate":"499","avatar":"/static/images/avatar/6.jpg","cover_img":"/static/images/home/video/6.gif"},{"title":"某某某的视频","name":"某某某","appreciate":"499","avatar":"/static/images/avatar/7.jpg","cover_img":"/static/images/home/video/7.jpg"},{"title":"某某某的视频","name":"某某某","appreciate":"499","avatar":"/static/images/avatar/8.jpg","cover_img":"/static/images/home/video/8.gif"},{"title":"某某某的视频","name":"某某某","appreciate":"499","avatar":"/static/images/avatar/1.jpg","cover_img":"/static/images/home/video/9.gif"},{"title":"某某某的视频","name":"某某某","appreciate":"499","avatar":"/static/images/avatar/2.jpg","cover_img":"/static/images/home/video/10.gif"}]
        /**
        $videoData[0]['title']="长白山滑雪攻略最全";
        $videoData[0]['name'] = "唔师";
        $videoData[0]['appreciate'] = '339';
        $videoData[0]['avatar'] = '/static/images/avatar/1.jpg';
        $videoData[0]['cover_img'] = 'https://ss0.baidu.com/94o3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=710bdd36c61373f0ea3f699f940e4b8b/0bd162d9f2d3572cb197d9919d13632762d0c302.jpg';

        $videoData[1]['title']="";
        $videoData[1]['name'] = "就吼一句";
        $videoData[1]['appreciate'] = '642';
        $videoData[1]['avatar'] = '/static/images/avatar/2.jpg';
        $videoData[1]['cover_img'] = 'https://ss1.baidu.com/-4o3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=366ebf8109178a82d13c79a0c602737f/6c224f4a20a44623bdbfe02f8f22720e0cf3d702.jpg';

        $videoData[2]['title']="天门外此门中。一如既往的喜欢";
        $videoData[2]['name'] = "微醺";
        $videoData[2]['appreciate'] = '512';
        $videoData[2]['avatar'] = '/static/images/avatar/3.jpg';
        $videoData[2]['cover_img'] = 'https://ss1.baidu.com/-4o3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=366ebf8109178a82d13c79a0c602737f/6c224f4a20a44623bdbfe02f8f22720e0cf3d702.jpg';


        $videoData[3]['title']="去过长白山吗。滑雪太赞了";
        $videoData[3]['name'] = "微醺";
        $videoData[3]['appreciate'] = '21';
        $videoData[3]['avatar'] = '/static/images/avatar/4.jpg';
        $videoData[3]['cover_img'] = 'https://img2.baidu.com/it/u=403675762,1706244167&fm=253&fmt=auto&app=120&f=JPEG?w=667&h=500';
        **/
        $tempdata = Request::param();
        $where = array();
        $where['typeid'] = 14;
        $page = input('page', 1);
        $pageSize = input('limit', 10);
//        $where['topic_id'] = $tempdata['topic_id'];
        $order = input('order','id');
        $result = \think\facade\Db::name('article')->order($order.' desc')->field('id,title,uid,typeid,thumb,create_time,click,likes')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();

        if($result['data']){
            foreach($result['data'] as $k=>$v){
                $GongLue[$k]['id'] = $v['id'];
                $GongLue[$k]['title'] = $v['title'];
                $GongLue[$k]['name'] = "唔师";
                $GongLue[$k]['appreciate'] = $v['likes'];
                $GongLue[$k]['avatar'] = $v['thumb'];
                $GongLue[$k]['cover_img'] = $v['thumb'];
            }
        }else{
            $GongLue = array();
        }



        $result['data']['GongLue'] = $GongLue;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);
    }


    public function notice(){

        $tempdata = Request::param();
        $userInfo = @$tempdata['userInfo'];
        $where = array();
        $page = input('page', 1);
        $pageSize = input('limit', 10);

        $where['toid'] = $userInfo['id'];//接收方

        $order = input('order','id');


        $result222 = \think\facade\Db::name('notice')->order($order.' desc')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();
        $fllow = array(true,false);
        if($result222['data']){
            foreach($result222['data'] as $k=>$v){
                $user = $this->getUser($userInfo['id']);
                $notice[$k]['id'] = $v['id'];
                $notice[$k]['title'] = $v['title'];
                $notice[$k]['uid'] = $user['id'];
                $notice[$k]['state'] = $v['msgtype'];
                $notice[$k]['content'] = $v['content'];
                $notice[$k]['username'] = $user['username'];
                $notice[$k]['create_time'] = $v['create_time'];
                $notice[$k]['status'] = $v['status'];
            }
        }else{
            $notice = array();
        }


        $result['data']['notice'] = $notice;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);

    }


    public function trendsData(){
        //[{"id":1,"avatar":"/static/images/avatar/1.jpg","username":"仔仔","time":"1小时前","follow":false,"text":"测试的测试测试测试的test,demo,1231321ce测试的...","text_btn":false,"talk":"你在说些啥","comment":"12","appreciate":"80","appreciate_btn":false,"img":["/static/images/home/goods/1.png"]},{"id":2,"avatar":"/static/images/avatar/2.jpg","username":"仔仔ZaiZ","time":"2小时前","follow":true,"text":"测试的测试测试的测试测试的测试测试测试的test,demo,1231321ce测试的...","text_btn":true,"talk":"你在说些啥呢","comment":"12万","appreciate":"80万","appreciate_btn":true,"img":["/static/images/home/goods/1.png","/static/images/home/goods/2.png"]},{"id":3,"avatar":"/static/images/avatar/3.jpg","username":"仔仔ZaiZ","time":"1年前","follow":false,"text":"测试的测试测试的测试测试的测试测试测试的test,demo,1231321ce测试的...","text_btn":true,"talk":"你在说些啥呢","comment":"12万","appreciate":"80万","appreciate_btn":true,"img":["/static/images/home/goods/1.png","/static/images/home/goods/2.png","/static/images/home/goods/3.png"]},{"id":4,"avatar":"/static/images/avatar/4.jpg","username":"仔仔ZaiZ","time":"1年前","follow":false,"text":"测试的测试测试的测试测试的测试测试测试的test,demo,1231321ce测试的...","text_btn":true,"talk":"你在说些啥呢","comment":"12万","appreciate":"80万","appreciate_btn":true,"img":["/static/images/home/goods/1.png","/static/images/home/goods/2.png","/static/images/home/goods/3.png","/static/images/home/goods/4.png"]},{"id":5,"avatar":"/static/images/avatar/5.jpg","username":"仔仔ZaiZ","time":"1年前","follow":false,"text":"测试的测试测试的测试测试的测试测试测试的test,demo,1231321ce测试的...","text_btn":true,"talk":"你在说些啥呢","comment":"12万","appreciate":"80万","appreciate_btn":true,"img":["/static/images/home/goods/1.png","/static/images/home/goods/2.png","/static/images/home/goods/3.png","/static/images/home/goods/4.png","/static/images/home/goods/5.png"]},{"id":6,"avatar":"/static/images/avatar/6.jpg","username":"仔仔ZaiZ","time":"1年前","follow":false,"text":"测试的测试测试的测试测试的测试测试测试的test,demo,1231321ce测试的...","text_btn":true,"talk":"你在说些啥呢","comment":"12万","appreciate":"80万","appreciate_btn":true,"img":["/static/images/home/goods/1.png","/static/images/home/goods/2.png","/static/images/home/goods/3.png","/static/images/home/goods/4.png","/static/images/home/goods/5.png","/static/images/home/goods/6.png"]},{"id":7,"avatar":"/static/images/avatar/7.jpg","username":"仔仔ZaiZ","time":"1年前","follow":false,"text":"测试的测试测试的测试测试的测试测试测试的test,demo,1231321ce测试的...","text_btn":true,"talk":"你在说些啥呢","comment":"12万","appreciate":"80万","appreciate_btn":false,"img":["/static/images/home/goods/1.png","/static/images/home/goods/2.png","/static/images/home/goods/3.png","/static/images/home/goods/4.png","/static/images/home/goods/5.png","/static/images/home/goods/6.png","/static/images/home/goods/7.png"]},{"id":8,"avatar":"/static/images/avatar/8.jpg","username":"仔仔ZaiZ","time":"1年前","follow":false,"text":"测试的测试测试的测试测试的测试测试测试的test,demo,1231321ce测试的...","text_btn":true,"talk":"你在说些啥呢","comment":"12万","appreciate":"80万","appreciate_btn":false,"img":["/static/images/home/goods/1.png","/static/images/home/goods/2.png","/static/images/home/goods/3.png","/static/images/home/goods/4.png","/static/images/home/goods/5.png","/static/images/home/goods/6.png","/static/images/home/goods/7.png","/static/images/home/goods/8.png"]},{"id":9,"avatar":"/static/images/avatar/1.jpg","username":"仔仔ZaiZ","time":"1年前","follow":false,"text":"测试的测试测试的测试测试的测试测试测试的test,demo,1231321ce测试的...","text_btn":true,"talk":"你在说些啥呢","comment":"12万","appreciate":"80万","appreciate_btn":false,"img":["/static/images/home/goods/1.png","/static/images/home/goods/2.png","/static/images/home/goods/3.png","/static/images/home/goods/4.png","/static/images/home/goods/5.png","/static/images/home/goods/6.png","/static/images/home/goods/7.png","/static/images/home/goods/8.png","/static/images/home/goods/9.png"]}]
        /**
        $trendsData[0]['id'] = 1;
        $trendsData[0]['avatar'] = '/static/images/avatar/1.jpg';
        $trendsData[0]['username'] = "唔师傅";
        $trendsData[0]['time'] = '1小时前...';
        $trendsData[0]['follow'] = false;
        $trendsData[0]['text'] = "测试的咯.....";
        $trendsData[0]['text_btn'] = false;
        $trendsData[0]['talk'] = "说啥呢";
        $trendsData[0]['comment'] = "122";
        $trendsData[0]['appreciate'] = "90";
        $trendsData[0]['appreciate_btn'] = false;
        $trendsData[0]['img'][0]= "/static/images/home/goods/3.png";



        $trendsData[1]['id'] = 2;
        $trendsData[1]['avatar'] = '/static/images/avatar/2.jpg';
        $trendsData[1]['username'] = "秘密";
        $trendsData[1]['time'] = '12小时前...';
        $trendsData[1]['follow'] = true;
        $trendsData[1]['text'] = "oooooo";
        $trendsData[1]['text_btn'] = false;
        $trendsData[1]['talk'] = "这是个问题";
        $trendsData[1]['comment'] = "122";
        $trendsData[1]['appreciate'] = "90";
        $trendsData[1]['appreciate_btn'] = false;
        $trendsData[1]['img'][0]= "/static/images/home/goods/2.png";
        $trendsData[1]['img'][1]= "/static/images/home/goods/3.png";
        $trendsData[1]['img'][2]= "/static/images/home/goods/4.png";


        $trendsData[2]['id'] = 3;
        $trendsData[2]['avatar'] = '/static/images/avatar/3.jpg';
        $trendsData[2]['username'] = "secret";
        $trendsData[2]['time'] = '4小时前...';
        $trendsData[2]['follow'] = true;
        $trendsData[2]['text'] = "OMIGA";
        $trendsData[2]['text_btn'] = false;
        $trendsData[2]['talk'] = "行吧";
        $trendsData[2]['comment'] = "1212";
        $trendsData[2]['appreciate'] = "90";
        $trendsData[2]['appreciate_btn'] = false;
        $trendsData[2]['img'][0]= "/static/images/home/goods/2.png";
        **/


        $tempdata = Request::param();
        $userInfo = @$tempdata['userInfo'];
        $where = array();
        $page = input('page', 1);
        $pageSize = input('limit', 10);

//        $where['topic_id'] = $tempdata['topic_id'];

        $order = input('order','id');


        $result = \think\facade\Db::name('scenic_info')->order($order.' desc')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();
        $fllow = array(true,false);
        if($result['data']){
            foreach($result['data'] as $k=>$v){
                $thumb = $this->getoneImg($v['media']);
                $user = $this->getUser($userInfo['id']);
                if(!$thumb){
                    $thumb = 'https://bkimg.cdn.bcebos.com/pic/7acb0a46f21fbe0953aff1576d600c338644adfb?x-bce-process=image/resize,m_lfit,w_536,limit_1/format,f_jpg';
                }
                $trendsData[$k]['id'] = $v['id'];
                $trendsData[$k]['title'] = $v['title'];
                $trendsData[$k]['uid'] = $user['id'];
                $trendsData[$k]['username'] = $user['username'];
                $trendsData[$k]['time'] = date('Y-m-d H:i:s');
                $trendsData[$k]['follow'] = false;
                $trendsData[$k]['text'] = true;
                if($v['type'] == 2){
                    $video = json_decode($v['media'],true);
                    $trendsData[$k]['video'] = $video[0];
                }else{
                    $trendsData[$k]['img'] = json_decode($v['media'],true);
                }
                $trendsData[$k]['type'] = $v['type'];
                $trendsData[$k]['talk'] = $v['address'];
                $trendsData[$k]['avatar'] = $user['avatar'];
                $trendsData[$k]['comment'] = $v['read_count'];
                $trendsData[$k]['appreciate'] = $v['read_count'];
                $trendsData[$k]['appreciate_btn'] = $fllow[rand(0,1)];

            }
        }else{
            $trendsData = array();
        }


        $result['data']['trendsData'] = $trendsData;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);
    }




    public function topicGridData(){
        //[{"id":1,"title":"数码","img":"/static/images/home/goods/1.png"},{"id":2,"title":"穿搭","img":"/static/images/home/goods/2.png"},{"id":3,"title":"美妆","img":"/static/images/home/goods/3.png"},{"id":4,"title":"文玩","img":"/static/images/home/goods/4.png"},{"id":5,"title":"远动","img":"/static/images/home/goods/5.png"},{"id":6,"title":"数码","img":"/static/images/home/goods/6.png"},{"id":7,"title":"穿搭","img":"/static/images/home/goods/7.png"},{"id":8,"title":"美妆","img":"/static/images/home/goods/8.png"}]



        $topicGridData[0]['id'] = 1;
        $topicGridData[0]['title'] = "数码";
        $topicGridData[0]['img'] = "/static/images/home/goods/1.png";

        $topicGridData[1]['id'] = 2;
        $topicGridData[1]['title'] = "穿搭";
        $topicGridData[1]['img'] = "/static/images/home/goods/2.png";

        $topicGridData[2]['id'] = 3;
        $topicGridData[2]['title'] = "美妆";
        $topicGridData[2]['img'] = "/static/images/home/goods/3.png";

        $topicGridData[3]['id'] = 4;
        $topicGridData[3]['title'] = "野营";
        $topicGridData[3]['img'] = "/static/images/home/goods/4.png";


        $topicGridData[3]['id'] = 5;
        $topicGridData[3]['title'] = "探险";
        $topicGridData[3]['img'] = "/static/images/home/goods/5.png";



        $topicGridData = array();
        $result['data']['topicGridData'] = $topicGridData;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);
    }


    public function topicCardData(){
        //[{"id":1,"type":"数码","type_text":"游戏玩家的法宝是什么","bg_img":"/static/images/home/goods/1.png","list":[{"id":1,"img":"/static/images/home/goods/2.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":2,"img":"/static/images/home/goods/3.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":3,"img":"/static/images/home/goods/4.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":4,"img":"/static/images/home/goods/5.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":5,"img":"/static/images/home/goods/6.png","title":"游戏玩家的至宝","text":"110篇内容"}]},{"id":2,"type":"测试","type_text":"测试玩家的法宝是什么","bg_img":"/static/images/home/goods/7.png","list":[{"id":1,"img":"/static/images/home/goods/8.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":2,"img":"/static/images/home/goods/9.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":3,"img":"/static/images/home/goods/10.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":4,"img":"/static/images/home/goods/11.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":5,"img":"/static/images/home/goods/12.png","title":"游戏玩家的至宝","text":"110篇内容"}]},{"id":3,"type":"数码","type_text":"游戏玩家的法宝是什么","bg_img":"/static/images/home/goods/13.png","list":[{"id":1,"img":"/static/images/home/goods/14.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":2,"img":"/static/images/home/goods/15.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":3,"img":"/static/images/home/goods/16.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":4,"img":"/static/images/home/goods/17.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":5,"img":"/static/images/home/goods/18.png","title":"游戏玩家的至宝","text":"110篇内容"}]},{"id":4,"type":"数码","type_text":"游戏玩家的法宝是什么","bg_img":"/static/images/home/goods/19.png","list":[{"id":1,"img":"/static/images/home/goods/20.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":2,"img":"/static/images/home/goods/1.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":3,"img":"/static/images/home/goods/2.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":4,"img":"/static/images/home/goods/3.png","title":"游戏玩家的至宝","text":"110篇内容"},{"id":5,"img":"/static/images/home/goods/4.png","title":"游戏玩家的至宝","text":"110篇内容"}]}]

        //广场的内容。 暂时先这样。
        $topicCardData[0]['id'] = 1;
        $topicCardData[0]['type'] = "户外生活";
        $topicCardData[0]['type_text'] = "适当的户外生活缓解工作压力";
        $topicCardData[0]['bg_img'] = "/static/images/home/goods/2.png";
        $topicCardData[0]['list'][0]['id'] = 1;
        $topicCardData[0]['list'][0]['img'] = "/static/images/home/goods/2.png";
        $topicCardData[0]['list'][0]['title'] = "畅所欲言";
        $topicCardData[0]['list'][0]['text'] = "112篇讨论";
        $topicCardData[0]['list'][0]['path'] = '/pages/article/list?state=1';


        $topicCardData[0]['list'][1]['id'] = 1;
        $topicCardData[0]['list'][1]['img'] = "/static/images/home/goods/3.png";
        $topicCardData[0]['list'][1]['title'] = "方方面面";
        $topicCardData[0]['list'][1]['text'] = "90篇内容";
        $topicCardData[0]['list'][1]['path'] = '/pages/article/list?state=0';


        $topicCardData[1]['id'] = 1;
        $topicCardData[1]['type'] = "景致";
        $topicCardData[1]['type_text'] = "这里整理了厦门以周边可玩景点";
        $topicCardData[1]['bg_img'] = "/static/images/home/goods/3.png";
        $topicCardData[1]['list'][0]['id'] = 1;
        $topicCardData[1]['list'][0]['img'] = "/static/images/home/goods/2.png";
        $topicCardData[1]['list'][0]['title'] = "景点";
        $topicCardData[1]['list'][0]['text'] = "112篇内容";
        $topicCardData[1]['list'][0]['path'] = '/pages/scenic/scenic';

        $topicCardData[1]['list'][1]['id'] = 1;
        $topicCardData[1]['list'][1]['img'] = "/static/images/home/goods/3.png";
        $topicCardData[1]['list'][1]['title'] = "文章";
        $topicCardData[1]['list'][1]['text'] = "90篇内容";
        $topicCardData[1]['list'][1]['path'] = '/pages/article/list?state=2';


        $topicCardData[2]['id'] = 1;
        $topicCardData[2]['type'] = "新奇Fun";
        $topicCardData[2]['type_text'] = "看看有什么奇奇怪怪的东西";
        $topicCardData[2]['bg_img'] = "/static/images/home/goods/3.png";
        $topicCardData[2]['list'][0]['id'] = 1;
        $topicCardData[2]['list'][0]['img'] = "/static/images/home/goods/2.png";
        $topicCardData[2]['list'][0]['title'] = "奇物志";
        $topicCardData[2]['list'][0]['text'] = "112篇内容";
        $topicCardData[2]['list'][0]['path'] = '/pages/article/list?state=3';



        $result['data']['topicCardData'] = $topicCardData;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);
    }

    public function followTrendsData(){

        //[{"id":1,"avatar":"/static/images/avatar/1.jpg","username":"仔仔","time":"1个月前","text":"测试的测试测试测试的test,demo,1231321ce测试的...","text_btn":false,"comment":"2","appreciate":"8","appreciate_btn":false,"img":[],"cover":"/static/images/home/goods/2.png","video":"https://img.cdn.aliyun.dcloud.net.cn/guide/uniapp/%E7%AC%AC1%E8%AE%B2%EF%BC%88uni-app%E4%BA%A7%E5%93%81%E4%BB%8B%E7%BB%8D%EF%BC%89-%20DCloud%E5%AE%98%E6%96%B9%E8%A7%86%E9%A2%91%E6%95%99%E7%A8%8B@20181126.mp4"},{"id":2,"avatar":"/static/images/avatar/2.jpg","username":"仔仔ZaiZ","time":"2小时前","text":"测试的测试测试的测试测试的测试测试测试的test,demo,1231321ce测试的...","text_btn":false,"comment":"12万","appreciate":"80万","appreciate_btn":true,"img":[],"cover":"/static/images/home/goods/1.png","video":"https://img.cdn.aliyun.dcloud.net.cn/guide/uniapp/%E7%AC%AC1%E8%AE%B2%EF%BC%88uni-app%E4%BA%A7%E5%93%81%E4%BB%8B%E7%BB%8D%EF%BC%89-%20DCloud%E5%AE%98%E6%96%B9%E8%A7%86%E9%A2%91%E6%95%99%E7%A8%8B@20181126.mp4"},{"id":3,"avatar":"/static/images/avatar/3.jpg","username":"仔仔ZaiZ","time":"1年前","follow":false,"text":"测试的测试测试的测试测试的测试测试测试的test,demo,1231321ce测试的...","text_btn":true,"talk":"你在说些啥呢","comment":"12万","appreciate":"80万","appreciate_btn":true,"img":["/static/images/home/goods/1.png","/static/images/home/goods/2.png"]},{"id":4,"avatar":"/static/images/avatar/4.jpg","username":"仔仔ZaiZ","time":"1年前","follow":false,"text":"测试的测试测试的测试测试的测试测试测试的test,demo,1231321ce测试的...","text_btn":true,"talk":"你在说些啥呢","comment":"12万","appreciate":"80万","appreciate_btn":true,"img":["/static/images/home/goods/1.png"]},{"id":5,"avatar":"/static/images/avatar/5.jpg","username":"仔仔ZaiZ","time":"1年前","follow":false,"text":"测试的测试测试的测试测试的测试测试测试的test,demo,1231321ce测试的...","text_btn":true,"talk":"你在说些啥呢","comment":"12万","appreciate":"80万","appreciate_btn":true,"img":["/static/images/home/goods/1.png","/static/images/home/goods/2.png","/static/images/home/goods/3.png"]}]
        /**
        $followTrendsData[0]['id'] =1;
        $followTrendsData[0]['avatar'] = '/static/images/avatar/1.jpg';
        $followTrendsData[0]['username'] = "唔";
        $followTrendsData[0]['time'] = "一个月前";
        $followTrendsData[0]['text'] = "说什么好。";
        $followTrendsData[0]['text_btn'] = false;
        $followTrendsData[0]['comment'] = 2;
        $followTrendsData[0]['appreciate'] = 9;
        $followTrendsData[0]['appreciate_btn'] =false;
        $followTrendsData[0]['img']= array();
        $followTrendsData[0]['cover'] = '/static/images/home/goods/2.png';
        $followTrendsData[0]['video'] = 'http://yy-1255875008.cos.ap-guangzhou.myqcloud.com/wxFile/test.mp4';


        $followTrendsData[1]['id'] =2;
        $followTrendsData[1]['avatar'] = '/static/images/avatar/1.jpg';
        $followTrendsData[1]['username'] = "唔";
        $followTrendsData[1]['time'] = "一个月前";
        $followTrendsData[1]['text'] = "说什么好。";
        $followTrendsData[1]['text_btn'] = true;
        $followTrendsData[1]['comment'] = 2;
        $followTrendsData[1]['appreciate'] = 9;
        $followTrendsData[1]['appreciate_btn'] =false;
        $followTrendsData[1]['img'][0] = '/static/images/home/goods/2.png';
        $followTrendsData[1]['img'][1] = '/static/images/home/goods/3.png';
        $followTrendsData[1]['cover'] = '/static/images/home/goods/2.png';



        $followTrendsData[2]['id'] =3;
        $followTrendsData[2]['avatar'] = '/static/images/avatar/1.jpg';
        $followTrendsData[2]['username'] = "师";
        $followTrendsData[2]['time'] = "一个月前";
        $followTrendsData[2]['text'] = "说什么好。";
        $followTrendsData[2]['text_btn'] = true;
        $followTrendsData[2]['comment'] = 2;
        $followTrendsData[2]['appreciate'] = 9;
        $followTrendsData[2]['appreciate_btn'] =false;
        $followTrendsData[2]['img'][0] = '/static/images/home/goods/2.png';
        $followTrendsData[2]['img'][1] = '/static/images/home/goods/3.png';
        $followTrendsData[2]['img'][2] = '/static/images/home/goods/2.png';
        $followTrendsData[2]['img'][3] = '/static/images/home/goods/3.png';



        $followTrendsData[3]['id'] =1;
        $followTrendsData[3]['avatar'] = '/static/images/avatar/1.jpg';
        $followTrendsData[3]['username'] = "唔";
        $followTrendsData[3]['time'] = "一个月前";
        $followTrendsData[3]['text'] = "说什么好。";
        $followTrendsData[3]['text_btn'] = false;
        $followTrendsData[3]['comment'] = "20万";
        $followTrendsData[3]['appreciate'] = "90万";
        $followTrendsData[3]['appreciate_btn'] =true;
        $followTrendsData[3]['img']= array();
        $followTrendsData[3]['cover'] = '/static/images/home/goods/2.png';
        $followTrendsData[3]['video'] = 'http://yy-1255875008.cos.ap-guangzhou.myqcloud.com/wxFile/test.mp4';
        **/
        $post = Request::param();
        $userInfo = @$post['userInfo'];
        //$page = $post['page']?$post['page']:1;
        $where['uid'] = $userInfo['id'];
        $where = array();
        $followTrendsData = Db::name('scenic_info')->where($where)->select()->toArray();
        if(!$followTrendsData){
            $followTrendsData = array();
        }

        $result['data']['followTrendsData'] = $followTrendsData;
        $result['data']['status'] = 0;
        $result['data']['code'] = 200;
        echo json_encode($result);
    }



    public function subscribe(){//订阅用户
        $redis = Cache::store('redis')->handler();
        $post = Request::param();
        $userInfo = $post['userInfo'];
        $id = $userInfo['id'];
        $subuid = $post['subuid'];
        $key  = "subscribe_";
        $iftrue  = $redis->SISMEMBER($key.$id,$subuid);//如果存在 则为 1
        if($iftrue == true){//存在 则 移除
            $redis->SREM($key.$id,$subuid);
            $temp['subscribe'] = false;
        }else{//不存在则 添加
            $temp['subscribe'] = true;
            $redis->SADD($key.$id,$subuid);//
        }

        $result['code']  = 0;
        $result['data']['status'] = 0;
        $result['data']['res'] = $temp;
        echo json_encode($result);
    }





    public function like(){//点赞topic的
        $redis = Cache::store('redis')->handler();
        $post = Request::param();
        $userInfo = $post['userInfo'];
        $id = $userInfo['id'];
        $tid = $post['t_id'];
        $key  = "appreciate_";
        $iftrue  = $redis->SISMEMBER($key.$id,$tid);//如果存在 则为 1
        if($iftrue == true){//存在 则 移除
            $redis->SREM($key.$id,$tid);

            Db::name('scenic_info')
                ->where('id', $tid)
                ->dec('likes')
                ->update();


            $temp['like'] = false;
        }else{//不存在则 添加
            $temp['like'] = true;
            $redis->SADD($key.$id,$tid);//

            Db::name('scenic_info')
                ->where('id', $tid)
                ->inc('likes')
                ->update();
        }

        $result['code']  = 0;
        $result['data']['status'] = 0;
        $result['data']['res'] = $temp;
        echo json_encode($result);
    }


    public function index(){
        $uinfo['id'] = 1;
        $uinfo['name'] = '测试';
        $uinfo['passwd'] = '2123123123';
        echo $token = $this->signToken($uinfo);
        $res = $this->checkToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiIhQCMkJSomIiwiYXVkIjoiIiwiaWF0IjoxNjM2Njk5NzAxLCJuYmYiOjE2MzY2OTk3MDQsImV4cCI6MTYzNjY5OTkwMSwiZGF0YSI6eyJpZCI6MSwibmFtZSI6Ilx1NmQ0Ylx1OGJkNSIsInBhc3N3ZCI6IjIxMjMxMjMxMjMifX0.OROwTG6B2Mv6CRaTPv5dLEdVArr_OnZxBK9qR_wnnqo');
        echo '<pre>';
        print_r(json_decode(json_encode($res),true));
        echo '</pre>';
    }

    public function miniConfig(){
        echo '{ "code": 200, "msg": "请求成功", "result": { "config": "miniapp", "value": "wx3e120210c76e1c21", "extend": "cc9fc39f175f793e63a043be291d825f", "intro": "https://oss.ymeoo.cn/20210530162236700645876.png" } }';
        exit();
    }

    public function followUserPost(){
        echo '{ "code": 200, "msg": "请求成功", "result": { "total": 0, "per_page": 10, "current_page": 1, "last_page": 0, "data": [] } }';
        exit();
    }

    public function joinTopicPost(){
//        joinTopicPost?page=1

        echo '{ "code": 200, "msg": "请求成功", "result": { "total": 4, "per_page": 10, "current_page": 1, "last_page": 1, "data": [ { "id": 20, "uid": 3, "topic_id": 16, "discuss_id": 1, "vote_id": null, "title": "。。。", "content": "。。。", "media": [], "read_count": 7, "post_top": 0, "type": 1, "address": "武汉商学院南区寝室(东风大道816号)", "longitude": 114.08957, "latitude": 30.457817, "create_time": 1635837044, "comment_count": 0, "fabulous_count": 0, "collection_count": 1, "discuss_title": "测试", "is_collection": false, "comment_list": [], "userInfo": { "uid": 3, "mobile": null, "username": "彼岸", "password": null, "group_id": 2, "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/PoCYyicDxX5NpMLlfAyECS5CDaoJv8rgfvJEfddzun4wfblY4nbtqYtVYRDWueic1XUfV3jOtiaRwshI20F2K4q0g/132", "gender": "未知", "province": "", "city": "", "openid": "od4RU5ReZY5DYiAkQCDn34tQ2MIs", "mp_openid": null, "unionid": null, "status": 0, "intro": "这个人很懒，没留下什么", "integral": 0, "last_login_ip": "183.95.36.227", "tag_str": "[\"\\u4e91\\u5708\\u65b0\\u4eba\"]", "type": 0, "update_time": 1635838662, "create_time": 1635836591 }, "topicInfo": { "id": 16, "uid": 3, "cate_id": 1, "topic_name": "测试", "description": "来了来了来了", "cover_image": "https://kaiyuan.ymeoo.com/uploads/postImages/20211102/611b029785cc35ed69cd4a96f7cf2595.png", "bg_image": "https://kaiyuan.ymeoo.com/uploads/postImages/20211102/ee20d649f5a30d4892d7e08520954ff4.png", "top_type": 0, "status": 0, "index_recommend": 1, "user_num": 1, "create_time": 1635836986 } }, { "id": 19, "uid": 2, "topic_id": 13, "discuss_id": 0, "vote_id": null, "title": "", "content": "你好呀！", "media": [ "https://kaiyuan.ymeoo.com/uploads/postImages/20211018/780431d4642cb8ecbb5046388dfa61c2.jpg" ], "read_count": 18, "post_top": 0, "type": 1, "address": "云南农业大学", "longitude": 102.748923, "latitude": 0, "create_time": 1634521263, "comment_count": 0, "fabulous_count": 0, "collection_count": 0, "is_collection": false, "comment_list": [], "userInfo": { "uid": 2, "mobile": null, "username": "对方正在输入...", "password": null, "group_id": 2, "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/ibExFwaPU2hQGSslDicARo6ZvXnkvvhhZpDbE3potm9Y2G8skbEdo7fmkGliaXJXHMnUA3pLQhrCQicMkia2nfH9l2Q/132", "gender": "男", "province": "云南", "city": "昆明", "openid": "ocob94nVGqOOQr9zEN8-PTAaUNy4", "mp_openid": null, "unionid": null, "status": 0, "intro": "这个人很懒，没留下什么", "integral": 0, "last_login_ip": "39.129.248.133", "tag_str": "[\"\\u4e91\\u5708\\u65b0\\u4eba\"]", "type": 0, "update_time": 1633961189, "create_time": 1632300527 }, "topicInfo": { "id": 13, "uid": 2, "cate_id": 4, "topic_name": "随拍摄影", "description": "随拍摄影圈子", "cover_image": "https://oss.ymeoo.cn/20210928163279285720899.jpeg", "bg_image": "https://oss.ymeoo.cn/20210928163279286779643.png", "top_type": 0, "status": 0, "index_recommend": 1, "user_num": 12, "create_time": 1632792873 } }, { "id": 18, "uid": 2, "topic_id": 15, "discuss_id": 0, "vote_id": null, "title": "", "content": "大沙发沙发", "media": [ "https://kaiyuan.ymeoo.com/uploads/postImages/20211011/f2c10a2487596f1d473c9882f394964c.jpg", "https://kaiyuan.ymeoo.com/uploads/postImages/20211011/90334c762855f771f8fb394dc107d2cf.jpeg" ], "read_count": 49, "post_top": 0, "type": 1, "address": "昆明市盘龙区人民政府(北京路北)", "longitude": 102.75205, "latitude": 0, "create_time": 1633924729, "comment_count": 0, "fabulous_count": 0, "collection_count": 1, "is_collection": false, "comment_list": [], "userInfo": { "uid": 2, "mobile": null, "username": "对方正在输入...", "password": null, "group_id": 2, "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/ibExFwaPU2hQGSslDicARo6ZvXnkvvhhZpDbE3potm9Y2G8skbEdo7fmkGliaXJXHMnUA3pLQhrCQicMkia2nfH9l2Q/132", "gender": "男", "province": "云南", "city": "昆明", "openid": "ocob94nVGqOOQr9zEN8-PTAaUNy4", "mp_openid": null, "unionid": null, "status": 0, "intro": "这个人很懒，没留下什么", "integral": 0, "last_login_ip": "39.129.248.133", "tag_str": "[\"\\u4e91\\u5708\\u65b0\\u4eba\"]", "type": 0, "update_time": 1633961189, "create_time": 1632300527 }, "topicInfo": { "id": 15, "uid": 2, "cate_id": 1, "topic_name": "电影分享", "description": "电影分享圈子", "cover_image": "https://oss.ymeoo.cn/20210928163281070541888.jpg", "bg_image": "https://oss.ymeoo.cn/20210928163281079860227.jpg", "top_type": 0, "status": 0, "index_recommend": 1, "user_num": 13, "create_time": 1632810845 } }, { "id": 17, "uid": 2, "topic_id": 13, "discuss_id": 0, "vote_id": null, "title": "", "content": "爱就是好的哈更应该发女 阿萨德按时发 发给阿双方都是\n按时发付付发所多无！", "media": null, "read_count": 7, "post_top": 0, "type": 1, "address": "昆明市盘龙区人民政府(北京路北)", "longitude": 102.75205, "latitude": 0, "create_time": 1633923914, "comment_count": 0, "fabulous_count": 0, "collection_count": 0, "is_collection": false, "comment_list": [], "userInfo": { "uid": 2, "mobile": null, "username": "对方正在输入...", "password": null, "group_id": 2, "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/ibExFwaPU2hQGSslDicARo6ZvXnkvvhhZpDbE3potm9Y2G8skbEdo7fmkGliaXJXHMnUA3pLQhrCQicMkia2nfH9l2Q/132", "gender": "男", "province": "云南", "city": "昆明", "openid": "ocob94nVGqOOQr9zEN8-PTAaUNy4", "mp_openid": null, "unionid": null, "status": 0, "intro": "这个人很懒，没留下什么", "integral": 0, "last_login_ip": "39.129.248.133", "tag_str": "[\"\\u4e91\\u5708\\u65b0\\u4eba\"]", "type": 0, "update_time": 1633961189, "create_time": 1632300527 }, "topicInfo": { "id": 13, "uid": 2, "cate_id": 4, "topic_name": "随拍摄影", "description": "随拍摄影圈子", "cover_image": "https://oss.ymeoo.cn/20210928163279285720899.jpeg", "bg_image": "https://oss.ymeoo.cn/20210928163279286779643.png", "top_type": 0, "status": 0, "index_recommend": 1, "user_num": 12, "create_time": 1632792873 } } ] } }';
        exit();

    }

    public function userJoinTopic(){

        echo '{ "code": 200, "msg": "请求成功", "result": { "total": 0, "per_page": 100, "current_page": 1, "last_page": 0, "data": [] } }';
        exit();

    }

    public function num(){
        echo '{ "code": 200, "msg": "请求成功", "result": { "thumb_collect": 0, "follow": 0, "comment": 0, "all_count": 0, "article_msg_list": [], "chat_msg_list": [] } }';
        exit();
    }


    public function config(){

        $config['appName'] = '7Fun';

        $config['if_buy'] = config::get('wushi.if_buy');
        $config['if_buylist'] = config::get('wushi.if_buylist');
        $config['if_say'] = config::get('wushi.if_say');
        $config['if_say'] = config::get('wushi.if_say');
        $config['if_say_notice'] = config::get('wushi.if_say_notice');
        $result['data']['config'] = $config;


        $result['data']['status'] = 0;
        $result['data']['code'] = 0;
        echo json_encode($result);

    }
}
