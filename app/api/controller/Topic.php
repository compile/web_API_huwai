<?php
declare (strict_types = 1);

namespace app\api\controller;

use think\facade\Cache;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class topic extends Common
{
//    public function userJoinTopic(){
//        echo '{ "code": 200, "msg": "请求成功", "result": { "total": 0, "per_page": 100, "current_page": 1, "last_page": 0, "data": [] } }';
//        exit();
//    }

    public function classList(){
        echo '{ "code": 200, "msg": "请求成功", "result": [ { "cate_id": 1, "cate_name": "校园", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 2, "cate_name": "音乐", "is_top": 1, "cover_image": "https://oss.ymeoo.cn/20201128160653247473674.jpg" }, { "cate_id": 3, "cate_name": "生活", "is_top": 1, "cover_image": "https://oss.ymeoo.cn/20201128160653247734811.jpg" }, { "cate_id": 4, "cate_name": "兴趣", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 5, "cate_name": "运动", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 6, "cate_name": "旅行", "is_top": 1, "cover_image": "https://oss.ymeoo.cn/20201128160653509571713.jpg" }, { "cate_id": 7, "cate_name": "知识", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 8, "cate_name": "动漫", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 9, "cate_name": "情感", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 10, "cate_name": "娱乐", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 11, "cate_name": "宠物", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 13, "cate_name": "美食", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 14, "cate_name": "职场", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 15, "cate_name": "摄影", "is_top": 1, "cover_image": "https://oss.ymeoo.cn/20201128160655959720380.jpg" }, { "cate_id": 16, "cate_name": "时尚", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 17, "cate_name": "阅读", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 18, "cate_name": "游戏", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 19, "cate_name": "打卡", "is_top": 0, "cover_image": "" }, { "cate_id": 20, "cate_name": "人文", "is_top": 0, "cover_image": "" }, { "cate_id": 21, "cate_name": "艺术", "is_top": 0, "cover_image": "" }, { "cate_id": 22, "cate_name": "同城", "is_top": 0, "cover_image": "" }, { "cate_id": 23, "cate_name": "头像", "is_top": 0, "cover_image": "" }, { "cate_id": 24, "cate_name": "粉丝", "is_top": 0, "cover_image": "" }, { "cate_id": 26, "cate_name": "交友", "is_top": 0, "cover_image": "" } ] }';
        exit();
    }

    public function hot(){
        $where = array();
//        $list = \think\facade\Db::name('order')->order('id desc')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();

        $res = Db::name('scenic')->select()->toArray();
        $this->rjson($res);
        exit();
    }

    public function getoneImg($media){

        $json= json_decode($media,true);
        return $json['0'];

    }
    public function substr_CN($str,$mylen){
        if(strlen($str)>$mylen){

            $res =  mb_substr($str, 0, $mylen).'...';

        }else{

            $res =  $str;

        }

        return $res;
    }

    public function userJoinTopic(){



        $where = array();
        $page = input('page', 1);
        $pageSize = input('limit', 10);
        $order = input('order','id');

        $result = \think\facade\Db::name('scenic')->order($order.' desc')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();








        $this->rjson($result);
            exit();


    }
    public function topic(){

        $param = Request::param();

        $pagenum = 10;
        $page = input('page', 1);
        $pageSize = input('limit', 10);//config('pageSize')

        $res2 = Db::name('scenic_info')
            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
            ->toArray();


        /**
        {
        //文字
        userimg:'../../static/userpic/19.jpg',
        username:'张三',
        userage:'30',
        sex:0,//0代表男，1 代表女
        isguanzhu:false,
        title:'庆祝祖国成立70周年！',
        titleimg:'',
        video:false,
        sharea:false,
        positiona:'深圳 龙岗',
        sharenum:30,
        pinglunnum:100,
        zannum:50

        },
        {
        //图文
        userimg:'../../static/userpic/19.jpg',
        username:'张三',
        userage:'30',
        sex:0,//0代表男，1 代表女
        isguanzhu:false,
        title:'庆祝祖国成立70周年！',
        titleimg:'../../static/datapic/44.jpg',
        video:false,
        sharea:false,
        positiona:'深圳 龙岗',
        sharenum:30,
        pinglunnum:100,
        zannum:50

        },
        {
        //视频
        userimg:'../../static/userpic/19.jpg',
        username:'李四',
        userage:'37',
        sex:1,//0代表男，1 代表女
        isguanzhu:false,
        title:'庆祝祖国成立70周年！',
        titleimg:'../../static/datapic/44.jpg',
        video:{
        bofangnum:'20w',
        shijian:'2:47'
        },
        sharea:false,
        positiona:'深圳 龙岗',
        sharenum:30,
        pinglunnum:100,
        zannum:50

        },
         **/







//        echo '<pre>';
        $temptest = array();
        foreach($res2['data'] as $k=>$item){
            //echo $item['id'];
            $user = Db::name('user')->where('id', '=', $item['id'])->find();
            $temptest[$k]['username'] = $user['username']? : '太懒了';
            $temptest[$k]['userimg'] = '';
            $temptest[$k]['title'] =  $this->substr_CN($item['content'],30);
            $temptest[$k]['sex'] = $user['sex']? : '1';
            $temptest[$k]['isguanzhu'] = 1;
            $temptest[$k]['titleimg'] = '';
            $temptest[$k]['id'] = $item['id'];
            $temptest[$k]['video'] = false;
            $temptest[$k]['sharea'] = false;
            $temptest[$k]['positiona'] = $item['address'];
            $temptest[$k]['sharenum'] = 30;
            $temptest[$k]['pinglunnum'] = 100;
            $temptest[$k]['zannum'] = 50;
            $temptest[$k]['titleimg'] = $this->getoneImg($item['media']);

            if($item['type'] == 2){
                $temptest[$k]['video']['bofangnum'] = '20W';
                $temptest[$k]['video']['shijian'] = '2:21';
            }
        }
//
//
//        echo '</pre>';


        $pagecount = count($temptest);


        $res['data']['total'] = $res2['total'];
        $res['data']['per_page'] = $res2['per_page'];
        $res['data']['last_page'] = $res2['last_page'];
        $res['data']['current_page'] = $res2['current_page'];
        $res['data']['status'] = 0;
        $res['data']['pagecount'] = $pagecount;
        $res['data']['res'] = $temptest;
        echo json_encode($res);
        exit();
    }

    public function user(){
        $param =  Request::param();
        $id = $param['id'];

        $res = Db::name('scenic')->where('id','=',$id)->find();

        $this->rjson($res);
        exit();
    }

    public function detail()
    {
        $param =  Request::param();
        $id = $param['id'];

        $res = Db::name('scenic')->where('id','=',$id)->find();

        $this->rjson($res);
        exit();
    }

    public function search(){
        echo '{ "code": 200, "msg": "请求成功", "result": { "total": 1, "per_page": 10, "current_page": 1, "last_page": 1, "data": [ { "id": 15, "uid": 2, "cate_id": 1, "topic_name": "电影分享", "description": "电影分享圈子", "cover_image": "https://oss.ymeoo.cn/20210928163281070541888.jpg", "bg_image": "https://oss.ymeoo.cn/20210928163281079860227.jpg", "top_type": 0, "status": 0, "index_recommend": 1, "user_num": 13, "create_time": 1632810845, "post_count": 1, "user_count": 1, "userInfo": { "uid": 2, "mobile": null, "username": "对方正在输入...", "password": null, "group_id": 2, "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/ibExFwaPU2hQGSslDicARo6ZvXnkvvhhZpDbE3potm9Y2G8skbEdo7fmkGliaXJXHMnUA3pLQhrCQicMkia2nfH9l2Q/132", "gender": "男", "province": "云南", "city": "昆明", "openid": "ocob94nVGqOOQr9zEN8-PTAaUNy4", "mp_openid": null, "unionid": null, "status": 0, "intro": "这个人很懒，没留下什么", "integral": 0, "last_login_ip": "39.129.248.133", "tag_str": "[\"\\u4e91\\u5708\\u65b0\\u4eba\"]", "type": 0, "update_time": 1633961189, "create_time": 1632300527 } } ] } }';
        exit();
//        search?keyword=电影&page=1
    }

}
