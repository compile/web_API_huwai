<?php
declare (strict_types = 1);

namespace app\api\controller;

use think\facade\Cache;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class comment extends Common
{

    public function list(){
        //comment/list?post_id=20&page=1
        $param = Request::param();
        $where = array();

        $where['post_id'] = $param['post_id'];
        $where['status'] = 1;
        $page = input('page', 1);
        $pageSize = input('limit', 10);
        $order = input('order','id');

        $result = \think\facade\Db::name('comments')->order($order.' desc')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();

        $user = new \app\api\model\user();


        foreach($result['data'] as $k=>$item){
                    $userInfo = $user->getOne($item['uid']);
                    $result['data'][$k]['userInfo'] =  $userInfo;
                    $result['data'][$k]['userInfo']['uid'] = $userInfo['id'];
                    $result['data'][$k]['is_thumbs'] = 1;
        }


//
//        $scenic = Db::name("scenic")->where('id','=',1)->find();
//        $res = $result['data'];
//        foreach($res as $k=>$item){
//            $res[$k]['userInfo'] = $userInfo->getOne(1);
//            $res[$k]['topicInfo'] = $scenic;
//            $res[$k]['media'] = json_decode($item['media'],true);
//            if($item['comment_list'] == ''){
//                $res[$k]['comment_list'] = array();
//            }
//        }







        $this->rjson($result);
        
        
        
    }

}
