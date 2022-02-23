<?php
declare (strict_types = 1);

namespace app\api\controller;

use http\Params;
use think\facade\Cache;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class post extends Common
{



    public function followUserPost(){
        echo '{ "code": 200, "msg": "请求成功", "result": { "total": 0, "per_page": 10, "current_page": 1, "last_page": 0, "data": [] } }';
        exit();
    }


    public function joinTopicPost(){
        echo '{ "code": 200, "msg": "请求成功", "result": { "total": 4, "per_page": 10, "current_page": 1, "last_page": 1, "data": [ { "id": 20, "uid": 3, "topic_id": 16, "discuss_id": 1, "vote_id": null, "title": "。。。", "content": "。。。", "media": [], "read_count": 7, "post_top": 0, "type": 1, "address": "武汉商学院南区寝室(东风大道816号)", "longitude": 114.08957, "latitude": 30.457817, "create_time": 1635837044, "comment_count": 0, "fabulous_count": 0, "collection_count": 1, "discuss_title": "测试", "is_collection": false, "comment_list": [], "userInfo": { "uid": 3, "mobile": null, "username": "彼岸", "password": null, "group_id": 2, "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/PoCYyicDxX5NpMLlfAyECS5CDaoJv8rgfvJEfddzun4wfblY4nbtqYtVYRDWueic1XUfV3jOtiaRwshI20F2K4q0g/132", "gender": "未知", "province": "", "city": "", "openid": "od4RU5ReZY5DYiAkQCDn34tQ2MIs", "mp_openid": null, "unionid": null, "status": 0, "intro": "这个人很懒，没留下什么", "integral": 0, "last_login_ip": "183.95.36.227", "tag_str": "[\"\\u4e91\\u5708\\u65b0\\u4eba\"]", "type": 0, "update_time": 1635838662, "create_time": 1635836591 }, "topicInfo": { "id": 16, "uid": 3, "cate_id": 1, "topic_name": "测试", "description": "来了来了来了", "cover_image": "https://kaiyuan.ymeoo.com/uploads/postImages/20211102/611b029785cc35ed69cd4a96f7cf2595.png", "bg_image": "https://kaiyuan.ymeoo.com/uploads/postImages/20211102/ee20d649f5a30d4892d7e08520954ff4.png", "top_type": 0, "status": 0, "index_recommend": 1, "user_num": 1, "create_time": 1635836986 } }, { "id": 19, "uid": 2, "topic_id": 13, "discuss_id": 0, "vote_id": null, "title": "", "content": "你好呀！", "media": [ "https://kaiyuan.ymeoo.com/uploads/postImages/20211018/780431d4642cb8ecbb5046388dfa61c2.jpg" ], "read_count": 18, "post_top": 0, "type": 1, "address": "云南农业大学", "longitude": 102.748923, "latitude": 0, "create_time": 1634521263, "comment_count": 0, "fabulous_count": 0, "collection_count": 0, "is_collection": false, "comment_list": [], "userInfo": { "uid": 2, "mobile": null, "username": "对方正在输入...", "password": null, "group_id": 2, "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/ibExFwaPU2hQGSslDicARo6ZvXnkvvhhZpDbE3potm9Y2G8skbEdo7fmkGliaXJXHMnUA3pLQhrCQicMkia2nfH9l2Q/132", "gender": "男", "province": "云南", "city": "昆明", "openid": "ocob94nVGqOOQr9zEN8-PTAaUNy4", "mp_openid": null, "unionid": null, "status": 0, "intro": "这个人很懒，没留下什么", "integral": 0, "last_login_ip": "39.129.248.133", "tag_str": "[\"\\u4e91\\u5708\\u65b0\\u4eba\"]", "type": 0, "update_time": 1633961189, "create_time": 1632300527 }, "topicInfo": { "id": 13, "uid": 2, "cate_id": 4, "topic_name": "随拍摄影", "description": "随拍摄影圈子", "cover_image": "https://oss.ymeoo.cn/20210928163279285720899.jpeg", "bg_image": "https://oss.ymeoo.cn/20210928163279286779643.png", "top_type": 0, "status": 0, "index_recommend": 1, "user_num": 12, "create_time": 1632792873 } }, { "id": 18, "uid": 2, "topic_id": 15, "discuss_id": 0, "vote_id": null, "title": "", "content": "大沙发沙发", "media": [ "https://kaiyuan.ymeoo.com/uploads/postImages/20211011/f2c10a2487596f1d473c9882f394964c.jpg", "https://kaiyuan.ymeoo.com/uploads/postImages/20211011/90334c762855f771f8fb394dc107d2cf.jpeg" ], "read_count": 49, "post_top": 0, "type": 1, "address": "昆明市盘龙区人民政府(北京路北)", "longitude": 102.75205, "latitude": 0, "create_time": 1633924729, "comment_count": 0, "fabulous_count": 0, "collection_count": 1, "is_collection": false, "comment_list": [], "userInfo": { "uid": 2, "mobile": null, "username": "对方正在输入...", "password": null, "group_id": 2, "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/ibExFwaPU2hQGSslDicARo6ZvXnkvvhhZpDbE3potm9Y2G8skbEdo7fmkGliaXJXHMnUA3pLQhrCQicMkia2nfH9l2Q/132", "gender": "男", "province": "云南", "city": "昆明", "openid": "ocob94nVGqOOQr9zEN8-PTAaUNy4", "mp_openid": null, "unionid": null, "status": 0, "intro": "这个人很懒，没留下什么", "integral": 0, "last_login_ip": "39.129.248.133", "tag_str": "[\"\\u4e91\\u5708\\u65b0\\u4eba\"]", "type": 0, "update_time": 1633961189, "create_time": 1632300527 }, "topicInfo": { "id": 15, "uid": 2, "cate_id": 1, "topic_name": "电影分享", "description": "电影分享圈子", "cover_image": "https://oss.ymeoo.cn/20210928163281070541888.jpg", "bg_image": "https://oss.ymeoo.cn/20210928163281079860227.jpg", "top_type": 0, "status": 0, "index_recommend": 1, "user_num": 13, "create_time": 1632810845 } }, { "id": 17, "uid": 2, "topic_id": 13, "discuss_id": 0, "vote_id": null, "title": "", "content": "爱就是好的哈更应该发女 阿萨德按时发 发给阿双方都是\n按时发付付发所多无！", "media": null, "read_count": 7, "post_top": 0, "type": 1, "address": "昆明市盘龙区人民政府(北京路北)", "longitude": 102.75205, "latitude": 0, "create_time": 1633923914, "comment_count": 0, "fabulous_count": 0, "collection_count": 0, "is_collection": false, "comment_list": [], "userInfo": { "uid": 2, "mobile": null, "username": "对方正在输入...", "password": null, "group_id": 2, "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/ibExFwaPU2hQGSslDicARo6ZvXnkvvhhZpDbE3potm9Y2G8skbEdo7fmkGliaXJXHMnUA3pLQhrCQicMkia2nfH9l2Q/132", "gender": "男", "province": "云南", "city": "昆明", "openid": "ocob94nVGqOOQr9zEN8-PTAaUNy4", "mp_openid": null, "unionid": null, "status": 0, "intro": "这个人很懒，没留下什么", "integral": 0, "last_login_ip": "39.129.248.133", "tag_str": "[\"\\u4e91\\u5708\\u65b0\\u4eba\"]", "type": 0, "update_time": 1633961189, "create_time": 1632300527 }, "topicInfo": { "id": 13, "uid": 2, "cate_id": 4, "topic_name": "随拍摄影", "description": "随拍摄影圈子", "cover_image": "https://oss.ymeoo.cn/20210928163279285720899.jpeg", "bg_image": "https://oss.ymeoo.cn/20210928163279286779643.png", "top_type": 0, "status": 0, "index_recommend": 1, "user_num": 12, "create_time": 1632792873 } } ] } }';
        exit();
    }


    public function classPostList(){
        echo '{ "code": 200, "msg": "请求成功", "result": { "total": 2, "per_page": 10, "current_page": 1, "last_page": 1, "data": [ { "id": 20, "uid": 3, "topic_id": 16, "discuss_id": 1, "vote_id": null, "title": "。。。", "content": "。。。", "media": [], "read_count": 7, "post_top": 0, "type": 1, "address": "武汉商学院南区寝室(东风大道816号)", "longitude": 114.08957, "latitude": 30.457817, "create_time": 1635837044, "comment_count": 0, "fabulous_count": 0, "collection_count": 1, "discuss_title": "测试", "is_collection": false, "comment_list": [], "userInfo": { "uid": 3, "mobile": null, "username": "彼岸", "password": null, "group_id": 2, "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/PoCYyicDxX5NpMLlfAyECS5CDaoJv8rgfvJEfddzun4wfblY4nbtqYtVYRDWueic1XUfV3jOtiaRwshI20F2K4q0g/132", "gender": "未知", "province": "", "city": "", "openid": "od4RU5ReZY5DYiAkQCDn34tQ2MIs", "mp_openid": null, "unionid": null, "status": 0, "intro": "这个人很懒，没留下什么", "integral": 0, "last_login_ip": "183.95.36.227", "tag_str": "[\"\\u4e91\\u5708\\u65b0\\u4eba\"]", "type": 0, "update_time": 1635838662, "create_time": 1635836591 }, "topicInfo": { "id": 16, "uid": 3, "cate_id": 1, "topic_name": "测试", "description": "来了来了来了", "cover_image": "https://kaiyuan.ymeoo.com/uploads/postImages/20211102/611b029785cc35ed69cd4a96f7cf2595.png", "bg_image": "https://kaiyuan.ymeoo.com/uploads/postImages/20211102/ee20d649f5a30d4892d7e08520954ff4.png", "top_type": 0, "status": 0, "index_recommend": 1, "user_num": 1, "create_time": 1635836986 } }, { "id": 18, "uid": 2, "topic_id": 15, "discuss_id": 0, "vote_id": null, "title": "", "content": "大沙发沙发", "media": [ "https://kaiyuan.ymeoo.com/uploads/postImages/20211011/f2c10a2487596f1d473c9882f394964c.jpg", "https://kaiyuan.ymeoo.com/uploads/postImages/20211011/90334c762855f771f8fb394dc107d2cf.jpeg" ], "read_count": 49, "post_top": 0, "type": 1, "address": "昆明市盘龙区人民政府(北京路北)", "longitude": 102.75205, "latitude": 0, "create_time": 1633924729, "comment_count": 0, "fabulous_count": 0, "collection_count": 1, "is_collection": false, "comment_list": [], "userInfo": { "uid": 2, "mobile": null, "username": "对方正在输入...", "password": null, "group_id": 2, "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/ibExFwaPU2hQGSslDicARo6ZvXnkvvhhZpDbE3potm9Y2G8skbEdo7fmkGliaXJXHMnUA3pLQhrCQicMkia2nfH9l2Q/132", "gender": "男", "province": "云南", "city": "昆明", "openid": "ocob94nVGqOOQr9zEN8-PTAaUNy4", "mp_openid": null, "unionid": null, "status": 0, "intro": "这个人很懒，没留下什么", "integral": 0, "last_login_ip": "39.129.248.133", "tag_str": "[\"\\u4e91\\u5708\\u65b0\\u4eba\"]", "type": 0, "update_time": 1633961189, "create_time": 1632300527 }, "topicInfo": { "id": 15, "uid": 2, "cate_id": 1, "topic_name": "电影分享", "description": "电影分享圈子", "cover_image": "https://oss.ymeoo.cn/20210928163281070541888.jpg", "bg_image": "https://oss.ymeoo.cn/20210928163281079860227.jpg", "top_type": 0, "status": 0, "index_recommend": 1, "user_num": 13, "create_time": 1632810845 } } ] } }';
        exit();
    }


    public function addComment(){
        $tempdata = Request::param();

        $userInfo = $tempdata['userInfo'];
        $say = $tempdata['say'];
        $add['content'] = $say['content'];
        $add['pid'] = 0;
        $add['post_id'] = $say['post_id'];
        $add['uid'] = $userInfo['id'];
        $add['to_uid'] = '0';//如果是留言的回复再修改。
        $add['type'] = '1';//默认1
        $add['create_time'] = date('Y-m-d h:i:s');
         Db::name('comments')->save($add);
        $this->rjson($tempdata);
    }


    public function addPost(){
        $tempdata = Request::param();

        $userInfo = $tempdata['userInfo'];
        $addtemp['uid']  = $userInfo['id'];
        $addtemp['content'] = $tempdata['content'];
        $addtemp['title'] = $tempdata['title']?$tempdata['title']:'';


        if($tempdata['media']){//不为空的话就变成 json？ 为空的话 就

            if(is_array($tempdata['media'])){
                $addtemp['media'] =  json_encode($tempdata['media']);
            }else{
                $addtemp['media'] = '["'.$tempdata['media'].'"]';
            }

        }else{
            $addtemp['media'] =  '????';
        }

        if(@$tempdata['videoInfo']){
            @$addtemp['videoInfo'] = json_encode(@$tempdata['videoInfo']);
        }

        $addtemp['latitude'] = $tempdata['latitude'];
        $addtemp['longitude'] = $tempdata['longitude'];
        $addtemp['topic_id'] = $tempdata['topic_id'];
        $addtemp['type'] = $tempdata['type'];
        $addtemp['address'] = $tempdata['address'];

        $id = Db::name('scenic_info')->insertGetId($addtemp);//发布成功 则需要加积分。 相应的 如果删除则扣除积分。
        if($id){//成功则加积分。
             $score = config::get('wushi.fatie_jifen');
             $type = 'article';
             $uid = $userInfo['id'];
             $this->addjifen($uid,$type,$score);//uid 类型。 积分
        }

        $addtemp['id'] = $id;


        $this->rjson($addtemp);
    }

    public function getVideoimg($videoInfo){

        $videoInfo = json_decode($videoInfo,true);

        //return $videoInfo['thumb'];
        return $videoInfo;

    }

    public function list(){
//      list?topic_id=15&page=1&order=id%20desc //这应该是最新
//        list?dis_id=1&page=1   这是按标签
        $tempdata = Request::param();
        $where = array();
        $page = input('page', 1);
        $pageSize = input('limit', 10);
        $userInfo = $tempdata['userInfo'];
        $where['topic_id'] = $tempdata['topic_id'];
        $order = input('order','id');
        $result = \think\facade\Db::name('scenic_info')->order($order.' desc')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();
        $u = new \app\admin\model\user();
        $scenic = Db::name("scenic")->where('id','=',1)->find();
        $res = $result['data'];
        foreach($res as $k=>$item){
            $res[$k]['userInfo'] = $u->getOne(1);
            if(!empty($userInfo)) {
                    if($this->if_redis_true($userInfo['id'],'appreciate_',$item['id'])){
                    $res[$k]['is_collection'] = true;//是否点赞了
                    }else{
                    $res[$k]['is_collection'] = false;
                    }
            }
            $res[$k]['topicInfo'] = $scenic;
            $res[$k]['media'] = json_decode($item['media'],true);
            $res[$k]['videoimg'] = $this->getVideoimg($item['videoInfo']);
            if($item['comment_list'] == ''){
                $res[$k]['comment_list'] = array();
            }
        }
        $result['order'] = $order;
        $result['data'] = $res;
        $this->rjson($result);
        /**
         *
         * {
        "code": 200,
        "msg": "请求成功",
        "result": {
        "total": 1,
        "per_page": 10,
        "current_page": 1,
        "last_page": 1,
        "data": [
        {
        "id": 18,
        "uid": 2,
        "topic_id": 15,
        "discuss_id": 0,
        "vote_id": null,
        "title": "",
        "content": "大沙发沙发",
        "media": [
        "https://kaiyuan.ymeoo.com/uploads/postImages/20211011/f2c10a2487596f1d473c9882f394964c.jpg",
        "https://kaiyuan.ymeoo.com/uploads/postImages/20211011/90334c762855f771f8fb394dc107d2cf.jpeg"
        ],
        "read_count": 49,
        "post_top": 0,
        "type": 1,
        "address": "昆明市盘龙区人民政府(北京路北)",
        "longitude": 102.75205,
        "latitude": 0,
        "create_time": 1633924729,
        "comment_count": 0,
        "fabulous_count": 0,
        "collection_count": 1,
        "is_collection": false,
        "comment_list": [],
        "userInfo": {
        "uid": 2,
        "mobile": null,
        "username": "对方正在输入...",
        "password": null,
        "group_id": 2,
        "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/ibExFwaPU2hQGSslDicARo6ZvXnkvvhhZpDbE3potm9Y2G8skbEdo7fmkGliaXJXHMnUA3pLQhrCQicMkia2nfH9l2Q/132",
        "gender": "男",
        "province": "云南",
        "city": "昆明",
        "openid": "ocob94nVGqOOQr9zEN8-PTAaUNy4",
        "mp_openid": null,
        "unionid": null,
        "status": 0,
        "intro": "这个人很懒，没留下什么",
        "integral": 0,
        "last_login_ip": "39.129.248.133",
        "tag_str": "[\"云圈新人\"]",
        "type": 0,
        "update_time": 1633961189,
        "create_time": 1632300527
        },
        "topicInfo": {
        "id": 15,
        "uid": 2,
        "cate_id": 1,
        "topic_name": "电影分享",
        "description": "电影分享圈子",
        "cover_image": "https://oss.ymeoo.cn/20210928163281070541888.jpg",
        "bg_image": "https://oss.ymeoo.cn/20210928163281079860227.jpg",
        "top_type": 0,
        "status": 0,
        "index_recommend": 1,
        "user_num": 13,
        "create_time": 1632810845
        }
        }
        ]
        }
        }
         *
         *
         *
         */

      // echo '{ "code": 200, "msg": "请求成功", "result": { "total": 1, "per_page": 10, "current_page": 1, "last_page": 1, "data": [ { "id": 18, "uid": 2, "topic_id": 15, "discuss_id": 0, "vote_id": null, "title": "", "content": "大沙发沙发", "media": [ "https://kaiyuan.ymeoo.com/uploads/postImages/20211011/f2c10a2487596f1d473c9882f394964c.jpg","https://kaiyuan.ymeoo.com/uploads/postImages/20211011/f2c10a2487596f1d473c9882f394964c.jpg", "https://kaiyuan.ymeoo.com/uploads/postImages/20211011/90334c762855f771f8fb394dc107d2cf.jpeg" ], "read_count": 49, "post_top": 0, "type": 1, "address": "昆明市盘龙区人民政府(北京路北)", "longitude": 102.75205, "latitude": 0, "create_time": 1633924729, "comment_count": 0, "fabulous_count": 0, "collection_count": 1, "is_collection": false, "comment_list": [], "userInfo": {  "mobile": null, "username": "对方正在输入...", "password": null, "group_id": 2, "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/ibExFwaPU2hQGSslDicARo6ZvXnkvvhhZpDbE3potm9Y2G8skbEdo7fmkGliaXJXHMnUA3pLQhrCQicMkia2nfH9l2Q/132", "gender": "男", "province": "云南", "city": "昆明", "openid": "ocob94nVGqOOQr9zEN8-PTAaUNy4", "mp_openid": null, "unionid": null, "status": 0, "intro": "这个人很懒，没留下什么", "integral": 0, "last_login_ip": "39.129.248.133", "tag_str": "[\"云圈新人\"]", "type": 0, "update_time": 1633961189, "create_time": 1632300527 }, "topicInfo": { "id": 15, "uid": 2, "cate_id": 1, "topic_name": "电影分享", "description": "电影分享圈子", "cover_image": "https://oss.ymeoo.cn/20210928163281070541888.jpg", "bg_image": "https://oss.ymeoo.cn/20210928163281079860227.jpg", "top_type": 0, "status": 0, "index_recommend": 1, "user_num": 13, "create_time": 1632810845 } } ] } }';

        exit();

    }


    function detail(){
        //detail?id=20

        /***
         *
         *
         * {
        "code":200,
        "msg":"请求成功",
        "result":{
        "id":20,
        "uid":3,
        "topic_id":16,
        "discuss_id":1,
        "vote_id":null,
        "title":"。。。",
        "content":"。。。",
        "media":[

        ],
        "read_count":16,
        "post_top":0,
        "type":1,
        "address":"武汉商学院南区寝室(东风大道816号)",
        "longitude":114.08957,
        "latitude":30.457817,
        "create_time":1635837044,
        "is_follow":false,
        "is_collection":false,
        "is_thumb":false,
        "topic_info":{
        "id":16,
        "uid":3,
        "cate_id":1,
        "topic_name":"测试",
        "description":"来了来了来了",
        "cover_image":"https://kaiyuan.ymeoo.com/uploads/postImages/20211102/611b029785cc35ed69cd4a96f7cf2595.png",
        "bg_image":"https://kaiyuan.ymeoo.com/uploads/postImages/20211102/ee20d649f5a30d4892d7e08520954ff4.png",
        "top_type":0,
        "status":0,
        "index_recommend":1,
        "user_num":1,
        "create_time":1635836986,
        "post_count":1,
        "user_count":1
        },
        "comment_count":0,
        "collection_count":1,
        "userInfo":{
        "uid":3,
        "mobile":null,
        "username":"彼岸",
        "password":null,
        "group_id":2,
        "avatar":"https://thirdwx.qlogo.cn/mmopen/vi_32/PoCYyicDxX5NpMLlfAyECS5CDaoJv8rgfvJEfddzun4wfblY4nbtqYtVYRDWueic1XUfV3jOtiaRwshI20F2K4q0g/132",
        "gender":"未知",
        "province":"",
        "city":"",
        "openid":"od4RU5ReZY5DYiAkQCDn34tQ2MIs",
        "mp_openid":null,
        "unionid":null,
        "status":0,
        "intro":"这个人很懒，没留下什么",
        "integral":0,
        "last_login_ip":"183.95.36.227",
        "tag_str":"[\"\\u4e91\\u5708\\u65b0\\u4eba\"]",
        "type":0,
        "update_time":1635838662,
        "create_time":1635836591
        }
        }
        }
         *
         *
         *
         *
         */
        $tempdata = Request::param();
        $id = input('id');
        $userInfo = $tempdata['userInfo'];
        $result = \think\facade\Db::name('scenic_info')->where('id','=',$id)->find();
        if(!empty($userInfo)){
            if($this->if_redis_true($userInfo['id'],'appreciate_',$result['id'])){
                $result['is_collection'] = true;//是否点赞了
            }else{
                $result['is_collection'] = false;
            }
        }else{
            $result['is_collection'] = false;
        }
        $userInfo = new \app\admin\model\user();
        $topic_id = $result['topic_id'];
        if($topic_id<=0){
            $topic_id = 1;
        }
        $scenic = Db::name("scenic")->where('id','=',$topic_id)->find();

        //临时

        $uid = $result['uid'];
        if($uid<=0){
            $uid = 1;
        }
            $result['userInfo'] = $userInfo->getOne($uid);
            $result['topicInfo'] = $scenic;
            $result['media'] = json_decode($result['media'],true);
            if($result['comment_list'] == ''){
                $result['comment_list'] = array();
            }


        //$result['data'] = $result;
        $this->rjson($result);
        exit();
//
//
//
//
//        echo '{ "code": 200, "msg": "请求成功", "result": { "id": 20, "uid": 3, "topic_id": 16, "discuss_id": 1, "vote_id": null, "title": "。。。", "content": "。。。", "media": [], "read_count": 16, "post_top": 0, "type": 1, "address": "武汉商学院南区寝室(东风大道816号)", "longitude": 114.08957, "latitude": 30.457817, "create_time": 1635837044, "is_follow": false, "is_collection": false, "is_thumb": false, "topic_info": { "id": 16, "uid": 3, "cate_id": 1, "topic_name": "测试", "description": "来了来了来了", "cover_image": "https://kaiyuan.ymeoo.com/uploads/postImages/20211102/611b029785cc35ed69cd4a96f7cf2595.png", "bg_image": "https://kaiyuan.ymeoo.com/uploads/postImages/20211102/ee20d649f5a30d4892d7e08520954ff4.png", "top_type": 0, "status": 0, "index_recommend": 1, "user_num": 1, "create_time": 1635836986, "post_count": 1, "user_count": 1 }, "comment_count": 0, "collection_count": 1, "userInfo": { "uid": 3, "mobile": null, "username": "彼岸", "password": null, "group_id": 2, "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/PoCYyicDxX5NpMLlfAyECS5CDaoJv8rgfvJEfddzun4wfblY4nbtqYtVYRDWueic1XUfV3jOtiaRwshI20F2K4q0g/132", "gender": "未知", "province": "", "city": "", "openid": "od4RU5ReZY5DYiAkQCDn34tQ2MIs", "mp_openid": null, "unionid": null, "status": 0, "intro": "这个人很懒，没留下什么", "integral": 0, "last_login_ip": "183.95.36.227", "tag_str": "[\"\\u4e91\\u5708\\u65b0\\u4eba\"]", "type": 0, "update_time": 1635838662, "create_time": 1635836591 } } }';
//
//        exit();
//

    }





}
