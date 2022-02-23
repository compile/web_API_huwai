<?php
declare (strict_types = 1);

namespace app\api\controller;

use think\facade\Cache;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class discuss extends Common
{
    public function userJoinTopic(){
        echo '{ "code": 200, "msg": "请求成功", "result": { "total": 0, "per_page": 100, "current_page": 1, "last_page": 0, "data": [] } }';
        exit();
    }

    public function classList(){
        echo '{ "code": 200, "msg": "请求成功", "result": [ { "cate_id": 1, "cate_name": "校园", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 2, "cate_name": "音乐", "is_top": 1, "cover_image": "https://oss.ymeoo.cn/20201128160653247473674.jpg" }, { "cate_id": 3, "cate_name": "生活", "is_top": 1, "cover_image": "https://oss.ymeoo.cn/20201128160653247734811.jpg" }, { "cate_id": 4, "cate_name": "兴趣", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 5, "cate_name": "运动", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 6, "cate_name": "旅行", "is_top": 1, "cover_image": "https://oss.ymeoo.cn/20201128160653509571713.jpg" }, { "cate_id": 7, "cate_name": "知识", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 8, "cate_name": "动漫", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 9, "cate_name": "情感", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 10, "cate_name": "娱乐", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 11, "cate_name": "宠物", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 13, "cate_name": "美食", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 14, "cate_name": "职场", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 15, "cate_name": "摄影", "is_top": 1, "cover_image": "https://oss.ymeoo.cn/20201128160655959720380.jpg" }, { "cate_id": 16, "cate_name": "时尚", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 17, "cate_name": "阅读", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 18, "cate_name": "游戏", "is_top": 0, "cover_image": "https://oss.ymeoo.cn/20201128160653507763323.jpg" }, { "cate_id": 19, "cate_name": "打卡", "is_top": 0, "cover_image": "" }, { "cate_id": 20, "cate_name": "人文", "is_top": 0, "cover_image": "" }, { "cate_id": 21, "cate_name": "艺术", "is_top": 0, "cover_image": "" }, { "cate_id": 22, "cate_name": "同城", "is_top": 0, "cover_image": "" }, { "cate_id": 23, "cate_name": "头像", "is_top": 0, "cover_image": "" }, { "cate_id": 24, "cate_name": "粉丝", "is_top": 0, "cover_image": "" }, { "cate_id": 26, "cate_name": "交友", "is_top": 0, "cover_image": "" } ] }';
        exit();
    }


    public function list(){
        echo '{ "code": 200, "msg": "请求成功", "result": { "total": 1, "per_page": 10, "current_page": 1, "last_page": 1, "data": [ { "id": 1, "uid": 3, "topic_id": 16, "title": "测试", "introduce": "。。", "read_count": 1, "top_type": 0, "create_time": 1635837012, "userInfo": { "username": "彼岸", "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/PoCYyicDxX5NpMLlfAyECS5CDaoJv8rgfvJEfddzun4wfblY4nbtqYtVYRDWueic1XUfV3jOtiaRwshI20F2K4q0g/132" } } ] } }';
        exit();
    }

}
