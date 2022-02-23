<?php
namespace app\admin\controller;
use app\admin\model\goodsGrade;
use app\admin\model\order;
use app\admin\model\User;
use app\admin\model\userGrade;
use app\common\model\Area;
use think\Db;
use app\admin\BaseController;
use think\facade\Request;

class Common
{
    protected $system,$cache_model,$adminRules,$HrefId;
    public function initialize()
    {
//        //判断管理员是否登录
//        if (!session('aid')) {
//            $this->redirect('guanli/login/index');
//        }
//        define('MODULE_NAME',strtolower(request()->controller()));
//        define('ACTION_NAME',strtolower(request()->action()));
//        //权限管理
//        //当前操作权限ID
//        if(session('aid')!=1){
//            $this->HrefId = db('auth_rule')->where('href',MODULE_NAME.'/'.ACTION_NAME)->value('id');
//            //当前管理员权限
//            $map['a.admin_id'] = session('aid');
//            $rules=Db::table(config('database.prefix').'guanli')->alias('a')
//                ->join(config('database.prefix').'auth_group ag','a.group_id = ag.group_id','left')
//                ->where($map)
//                ->value('ag.rules');
//            $this->adminRules = explode(',',$rules);
//            if($this->HrefId){
//                if(!in_array($this->HrefId,$this->adminRules)){
//                    $this->error('您无此操作权限');
//                }
//            }
//        }
//        $this->cache_model=array('AuthRule','System');
//        foreach($this->cache_model as $r){
//            if(!cache($r)){
//                savecache($r);
//            }
//        }
//        $this->system = cache('System');
//        $this->rule = cache('AuthRule');
//
//        $this->redis = redis();
    }
    //空操作
    public function _empty(){
        return $this->error('空操作，返回上次访问页面中...');
    }

    public function getList($table){
        $page = input('page', 1);
        $pageSize = input('limit', 10);
        $list = \think\facade\Db::name($table)
            ->order('create_time desc')
            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
            ->toArray();
        $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        echo json_encode($result);
        exit();
    }



    public function updateOne($tablecc,$post,$id){//统一修改
        switch($tablecc){
            case 'user':
                $return = new User();
                $return->change($id,$post);
            break;
            case 'usergrade':  //等级
                $return = new UserGrade();
                $return->change($id,$post);
                break;
            case 'goodsgrade':
                echo 'here';
                $return = new GoodsGrade();
                $return->change($id,$post);
                break;
            case 'shop':
                echo 'here';
                $return = new \app\admin\model\Shop();
                $return->change($id,$post);
                break;
            case 'article':
                $return = new \app\admin\model\article();
                $return->change($id,$post);
                break;
            case 'scenic_info':
                echo 'here';
                $return = new \app\admin\model\scenicinfo();
                $return->change($id,$post);
                break;
            case 'scenic':
                $return = new \app\admin\model\scenic();
                $return->change($id,$post);
                break;
            case 'articlecate':
                $return = new \app\admin\model\articleCate();
                $return->change($id,$post);
                break;
            case 'html':
                $return = new \app\admin\model\html();
                $return->change($id,$post);
                break;
            case 'order':
                echo 'order';
            break;

        }
    }


    public function changeOneAttribute($table,$attribute,$id){//修改的表，修改的状态名，id，状态值 0|1 取反
//        \app\guanli\model\common::changeOneAttribute($table,$attribute,$id);
        switch($table){
            case 'user':
                $return = new \app\admin\model\user();
                $return->changeOneAttribute($id,$attribute);
                break;
            case 'usergrade':  //等级
                $return = new \app\admin\model\userGrade();
                $return->changeOneAttribute($id,$attribute);
                break;
            case 'goodsgrade':
                $return = new \app\admin\model\goodsGrade();
                $return->changeOneAttribute($id,$attribute);
                break;
            case 'shop':
                $return = new \app\admin\model\Shop();
                $return->changeOneAttribute($id,$attribute);
                break;
            case 'goods':
                $return = new \app\admin\model\goods();
                $return->changeOneAttribute($id,$attribute);
                break;
            case 'article':
                $return = new \app\admin\model\article();
                $return->changeOneAttribute($id,$attribute);
                break;
            case 'order':
                echo 'order';
                break;

        }
    }



    public function searchCityArray(){//取得城市代码和名
        $area_code = $_GET['area_code'];
        //$area_code = '350000000000,350206000000,350203000000,110101000000';
        $array = explode(',',$area_code);
        $array = array_filter($array);
        foreach($array as $item){
            $province = Area::getAreaChild($this->redis,  $item);
            foreach($province as $item=>$value){
                $result[$item]['area_code'] = $item;
                $result[$item]['area_name'] = $value;
            }
        }
        return $result;
    }

    public function searchCity(){//取得城市代码和名
        $area_code = $_GET['area_code'];

            $temp = Area::getAreaChild($this->redis,  $area_code);
            foreach($temp as $item=>$value){
                $result[$item]['area_code'] = $item;
                $result[$item]['area_name'] = $value;
            }
        return $result;
    }

    public function searchProvince(){//取得城市代码和名
        $province = Area::getAreaChild($this->redis, 0);
        foreach($province as $item=>$value){
            $provinceData[$item]['area_code'] = $item;
            $provinceData[$item]['area_name'] = $value;
        }
        return $provinceData;
    }

    public function common($temp){
        $data['title'] = $temp['title'];
        /**  地区  start */
        //如果地区为空 则默认12个0。 否则就处理成为字符串
        $data['province']  = $temp['province'] ? $temp['province']:['000000000000'];
        $data['city']      = $temp['city'] ? $temp['city']:['000000000000'];
        $data['region']    = $temp['region'] ? $temp['region']:['000000000000'];
        $data['town']      = $temp['town'] ? $temp['town']:['000000000000'];
        $data['village']   = $temp['village'] ? $temp['village']:['000000000000'];

        //转化为字符串
        $data['province'] = trim(implode(",", $data['province']),',');
        $data['city']     = trim(implode(",", $data['city']),',');
        $data['region']   = trim(implode(",", $data['region']),',');
        $data['town']     = trim(implode(",", $data['town']),',');
        $data['village']  = trim(implode(",", $data['village']),',');
        /** 地区 **  end */
        if(is_array($temp['content'])) {//如果是数组。 则返回json
            $num = count($temp['content']);
            for ($i = 0; $i < $num; $i++) {
                $content[$i]['type'] = $temp['type'][$i];
                if ($temp['type'][$i] == 'text') {
                    $content[$i]['content'] = $temp['content'][$i];
                } elseif ($temp['type'][$i] == 'img') {
                    $content[$i]['url'] = $temp['content'][$i];
                } else {
                    $content[$i]['url'] = $temp['content'][$i];
                }
            }

            $data['content'] = json_encode($content);
        }else{
            $data['content'] = $temp['content'];
        }
        return $data;
    }


    public function comment(){
        $info = Request::param();
        if (Request::isAjax()) {
            $map = input('post.');
            $seeid = $info['seeid'];
            $type = $info['seetype'];

            $where = [];
            $page = [
                'page' => intval(input('page', 1)),
                'list_rows' => intval(input('limit', config('pageSize')))
            ];
            $where[] = ['type_id', 'eq', $seeid];
            $where[] = ['type', 'eq', $type];
            if ($map['nickname'] != ''){
            $user = db('user')->where('nickname', '=', $map['nickname'])->find();
            $where[] = ['user_id', '=', $user['id']];
            }
            if ($map['status'] != '') $where[] = ['status', '=', $map['status']];
            $search_time = $map['start_time'];
            $today_start = strtotime(date("$search_time 00:00:00"));
            $today_end = strtotime(date("$search_time 23:59:59"));
            if ($map['start_time'] != '' && $map['end_time'] != '' ) {
                $where[] = ['create_time', '>=', $today_start];
                $where[] = ['create_time', '<=', $today_end];
            }
            if($map['ordertype'] == 1){
                $ordertype = 'likes_num ';
            }else{
                $ordertype = 'reply_num ';
            }
            if($map['orderdirection'] == 1){
                $order  = ' desc';
            }else{
                $order  = ' asc';
            }
            $order_desc = $ordertype . $order;
            $page = input('page', 1);
            $pageSize = input('limit', config('pageSize'));

            $list = Db::table(config('database.prefix') . 'user_comment')
                ->where($where)
                ->order($order_desc)
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            //数据处理
            foreach ($list['data'] as $k => $v) {
                $user = db('user')->where('id', '=', $list['data'][$k]['user_id'])->find();
                $list['data'][$k]['nickname'] =  $user['nickname'];
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        }
        $this->assign('info', $info);
        return view();
    }

    public function opera(){
        $info = Request::param();
        if (Request::isAjax()) {
            $map = input('post.');
            $seeid = $info['seeid'];
            $type = $info['seetype'];

            $where = [];
            $page = [
                'page' => intval(input('page', 1)),
                'list_rows' => intval(input('limit', config('pageSize')))
            ];
            $where[] = ['object_id', 'eq', $seeid];
            $where[] = ['object_type', 'eq', $type];
            if ($map['nickname'] != ''){
                $user = db('user')->where('nickname', '=', $map['nickname'])->find();
                $where[] = ['user_id', '=', $user['user_id']];
            }
            if ($map['status'] != '') $where[] = ['status', '=', $map['status']];
            $search_time = $map['start_time'];
            $today_start = strtotime(date("$search_time"));
            $today_end = strtotime(date("$search_time"));
            if ($map['start_time'] != '' && $map['end_time'] != '' ) {
                $where[] = ['create_time', '>=', $today_start];
                $where[] = ['create_time', '<=', $today_end];
            }
            $order_desc = 'create_time desc';
            $page = input('page', 1);
            $pageSize = input('limit', config('pageSize'));

            $list = Db::table(config('database.prefix') . 'opera_log')
                ->where($where)
                ->order($order_desc)
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            //数据处理
            foreach ($list['data'] as $k => $v) {
                if($list['data'][$k]['user_id'] == NULL){
                    $list['data'][$k]['user_id'] = 1;
                }
                $user = db('user')->where('id', '=', $list['data'][$k]['user_id'])->find();
                $list['data'][$k]['nickname'] =  $user['nickname'];
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        }
        $this->assign('info', $info);
        return view();
    }

    public function villageManagement(){
        $info = Request::param();
        if (Request::isAjax()) {
            $map = input('post.');
            $area_code = $info['area_code'];
            $where[] = ['status','=',2];
            $where[] = ['area_code','=',$area_code];
            $page = [
                'page' => intval(input('page', 1)),
                'list_rows' => intval(input('limit', config('pageSize')))
            ];

            $order_desc = 'create_time desc';
            $page = input('page', 1);
            $pageSize = input('limit', config('pageSize'));

            $list = Db::table(config('database.prefix') . 'villager_apply')
                ->where($where)
                ->order($order_desc)
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            //数据处理
            foreach ($list['data'] as $k => $v) {
                if($list['data'][$k]['user_id'] == NULL){
                    $list['data'][$k]['user_id'] = 1;
                }
                $user = db('user')->where('id', '=', $list['data'][$k]['user_id'])->find();
                $list['data'][$k]['nickname'] =  $user['nickname'];

                $list['data'][$k]['announce_num'] =  $user['announce_num'];
                $list['data'][$k]['article_num'] =  $user['article_num'];
                $list['data'][$k]['activity_num'] =  $user['activity_num'];
                $list['data'][$k]['seek_num'] =  $user['seek_num'];
                $list['data'][$k]['topic_num'] =  $user['topic_num'];
                $list['data'][$k]['album_num'] =  $user['album_num'];
                $list['data'][$k]['video_num'] =  $user['video_num'];
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        }
        $this->assign('info', $info);
        return view();
    }

    public function setStatusNo(){
        $post = Request::param();

        if($post['id'] !== '') {
            $id = $post['id'];
            $data['status'] = 2;
            $res = db('user_comment')->where('id', '=', $id)->update($data);
            if ($res) {
                return json(['code' => 1, 'msg' => '修改成功!' . $id, 'url' => url('adList')]);
            } else {
                return json(['code' => 0, 'msg' => '修改失败!'.json_encode($res)]);
            }
        }else{
            return $result = ['code'=>0,'msg'=>'审核失败!'];

        }

    }


    public function setStatusOk(){
        $post = Request::param();
        if($post['id'] !== '') {
            $id = $post['id'];
            $data['status'] = 1;
            $res = db('user_comment')->where('id', '=', $id)->update($data);
            if ($res) {
                return json(['code' => 1, 'msg' => '修改成功!' . $id, 'url' => url('adList')]);
            } else {
                return json(['code' => 0, 'msg' => '修改失败!']);
            }
        }else{
            return $result = ['code'=>0,'msg'=>'审核失败!'];

        }

    }










    public function common_zone($temp){

        /**  地区  start */
        //如果地区为空 则默认12个0。 否则就处理成为字符串
        $data['province']  = $temp['province'] ? $temp['province']:['000000000000'];
        $data['city']      = $temp['city'] ? $temp['city']:['000000000000'];
        $data['region']    = $temp['region'] ? $temp['region']:['000000000000'];
        $data['town']      = $temp['town'] ? $temp['town']:['000000000000'];
        $data['village']   = $temp['village'] ? $temp['village']:['000000000000'];

        //转化为字符串
        $data['province'] = trim(implode(",", $data['province']),',');
        $data['city']     = trim(implode(",", $data['city']),',');
        $data['region']   = trim(implode(",", $data['region']),',');
        $data['town']     = trim(implode(",", $data['town']),',');
        $data['village']  = trim(implode(",", $data['village']),',');
        /** 地区 **  end */
        return $data;
    }

    function getYulan(){
        $dataJson = @$_GET['dataJson'];
        if($dataJson !== '' && !is_not_json($dataJson)){
            $temp = json_decode($dataJson,true);
            $province = $temp['province'];


            if($province == ''){
                $in = '未选省份,请返回选择';
            }else{
                $zone = '';
                $ztemp =  $province;
                foreach ($ztemp as $item) {
                    $zone .= Area::getAreaName($item) . ',';
                }
                $in =  '发布在:'. $zone = trim($zone, ',');
            }
            $city     = $temp['city'];
            $region   = $temp['region'];
            $town     = $temp['town'];
            $village  = $temp['village'];
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>'.$temp['title'].'</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="Cache-Control" content="no-transform" />
    <meta name="applicable-device" content="pc,mobile">
    <meta name="MobileOptimized" content="width" />
    <meta name="HandheldFriendly" content="true" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://www.heduwang.com/statics/css/css/index-two.css">
    <script type="text/javascript" src="https://www.heduwang.com/statics/css/css/jquery.min.js"></script>
</head>
<body>
<header>
    <div class="fm-header">
        <div class="in-logo" style="line-height: 52px;
    color: #b3bbcd;font-size: 20px;">预览页面<div class="clear"></div></div>
        <div class="in-nav">
        </div>
        <div class="in-sub">
            <ul>
                <div class="clear"></div>
            </ul>
        </div>
        <div class="in-other-icon">
            <ul>

            </ul>
        </div>
        <div class="clear"></div>
    </div>
</header>
<section class="mini">
    <div class="mini-in-nav">
        <div class="mini-top">
            <div class="close"></div>
            <div class="login">
            </div>
            <div class="clear"></div>
        </div>
    </div>
</section>
<!-- header end --><!-- main begin -->
<div class="fm-index-main show">
    <div class="show-left">
        <div class="fm-show">
            <div class="infor">
                <br>
                <div class="clear"></div>
            </div>
            <hgroup style="margin-bottom: 15px;padding-bottom: 10px;">
                <h1>'.$temp['title'].'</h1>
                <span style="color:#404040;font-size:12px;width:100%;display:block;padding-top: 20px;">　'.$in.'</span>
            </hgroup>
            <div class="text" style="color:#333">
                <article>
                    <div id="fm_article" class="fm_article">
                            '.$temp['content'].'
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
</div>
<!-- main end -->

<!-- footer begin -->
<footer>
    <div class="fm-footer">
        <div class="foot-text fl">
            <div class="copyright" style="text-align: center;">预览页面</div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</footer>
</body>
</html>';










            //return view()->assign(['article'=>$article,'classname'=>'information']);
        }
    }

}
