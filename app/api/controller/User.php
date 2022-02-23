<?php
declare (strict_types = 1);

namespace app\api\controller;

use app\api\model\Address;
use think\facade\Cache;
use think\facade\Config;
use think\facade\Request;
use think\facade\View;
use think\facade\Db;
include_once "wxBizDataCrypt.php";


class User
{

    public function wxlogin()
    {
        $temp['test'] = 'test';
        $temp['code'] = 0;
        $temp['msg'] = 'hehehe';
        echo json_encode($temp);


        $appid =  'wx1fb8c758026e3eb3';
        $secret = '2fcf2d1e0108659a8331f2e16c016d7d';
        $js_code =  input('js_code', 1);
        $grant_type = 'authorization_code';


        $url = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$js_code}&grant_type={$grant_type}";
        $temp = file_get_contents($url);

        echo json_encode($temp);
    }

    public function logout(){//这些需要保存 用户的 购物车数据。 还有其他以后需要保存的。 嗯。 比如 收藏的也需要？
        $temppost = Request::param();//


        $userInfo = $temppost['userInfo'];
        if($userInfo){
            $cartdata['uid'] = $userInfo['id'];
            $cartdata['create_time'] = time();
            $cartdata['update_time'] = time();
            $cartdata['json'] = json_encode($temppost['cartInfo']);
            $cart = Db::name("goods_cart")->where('uid','=',$userInfo['id'])->update($cartdata);//保存购物车数据。



            $result['data']['status'] = 0;
            $result['data']['res'] = $cart;// 1表示 完成//退出应该要删除 token了？？？？？？？？  redis 的。 因为还没建立。

        }else{
            $result['data']['res'] = '222';
        }


        echo json_encode($result);

    }

    public function login(){

        $data = Request::post();

        $res = new \app\api\model\user();
        $user = $res->getInfo($data);//这个登陆是不是太简单了 - - 只是去验证信息？ 应该再生成验证的token。在redis里面。

        if($user){
            $result['data']['login'] = 1;
        }else{
            $result['data']['login'] = 0;
        }
        $result['data']['status'] = 0;
        $result['data']['res'] = $user;
        $result['data']['cartInfo'] = $this->getCartInfo($user['id']);
        echo json_encode($result);
        exit();
    }


    public function userInfoById(){
        //userInfoById?uid=3

        echo '{ "code": 200, "msg": "请求成功", "result": { "uid": 3, "mobile": null, "username": "彼岸", "password": null, "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/PoCYyicDxX5NpMLlfAyECS5CDaoJv8rgfvJEfddzun4wfblY4nbtqYtVYRDWueic1XUfV3jOtiaRwshI20F2K4q0g/132", "gender": "未知", "province": "", "city": "", "mp_openid": null, "unionid": null, "intro": "这个人很懒，没留下什么", "integral": 0, "last_login_ip": "183.95.36.227", "tag_str": [ "云圈新人" ], "type": 0, "update_time": 1635838662, "follow": 0, "fans": 0, "post_num": 1, "is_follow": false, "create_topic_list": [ { "id": 16, "uid": 3, "cate_id": 1, "topic_name": "测试", "description": "来了来了来了", "cover_image": "https://kaiyuan.ymeoo.com/uploads/postImages/20211102/611b029785cc35ed69cd4a96f7cf2595.png", "bg_image": "https://kaiyuan.ymeoo.com/uploads/postImages/20211102/ee20d649f5a30d4892d7e08520954ff4.png", "top_type": 0, "status": 0, "index_recommend": 1, "user_num": 1, "create_time": 1635836986, "post_count": 1, "user_count": 1, "userInfo": { "uid": 3, "mobile": null, "username": "彼岸", "password": null, "group_id": 2, "avatar": "https://thirdwx.qlogo.cn/mmopen/vi_32/PoCYyicDxX5NpMLlfAyECS5CDaoJv8rgfvJEfddzun4wfblY4nbtqYtVYRDWueic1XUfV3jOtiaRwshI20F2K4q0g/132", "gender": "未知", "province": "", "city": "", "openid": "od4RU5ReZY5DYiAkQCDn34tQ2MIs", "mp_openid": null, "unionid": null, "status": 0, "intro": "这个人很懒，没留下什么", "integral": 0, "last_login_ip": "183.95.36.227", "tag_str": "[\"\\u4e91\\u5708\\u65b0\\u4eba\"]", "type": 0, "update_time": 1635838662, "create_time": 1635836591 } } ] } }';
        exit();

    }


    public function getCartInfo($uid){

        $res = Db::name('goods_cart')->where('uid','=',$uid)->find();
        return $res['json'];
    }

    public function  address(){
        $address = new Address();
        $temp  = Request::post();
        $uid = $temp['userInfo']['id'];

        $res = $address->getAll($uid);


        $result['data']['status'] = 0;
        $result['data']['res'] = $res;

        echo json_encode($result);
        exit();
    }

    public function scenicOne(){
        $res = Db::name('scenic')->find();
        $result['data']['status'] = 0;
        $result['data']['res'] = $res;

        echo json_encode($result);
        exit();
    }

    public function  scenic(){

        $res = Db::name('scenic')->select()->toArray();
        $result['data']['status'] = 0;
        $result['data']['res'] = $res;

        echo json_encode($result);
        exit();
    }


    public function  addAddress(){
        $temp  = Request::post();
        $add = $temp['addressData'];
        $userInfo = $temp['userInfo'];
        $address = new Address();
        $data['address'] = $add['address'];
        $data['addressName'] = $add['addressName'];
        $data['status'] = 1;//显示
        $data['uid'] = $userInfo['id'];
        $data['create_time'] = time();
        $data['area'] = $add['area'];
        $data['mobile'] = $add['mobile'];
        $data['name'] = $add['name'];
        @$data['default'] = false;

        $data['default'] = 1;
        $address->save($data);




        $result['data']['status'] = 0;
        $result['data']['res'] = $data;

        echo json_encode($result);
        exit();
    }


    public function verificationCode(){
        $redis = Cache::store('redis')->handler(); // 这条代码等于  $redis = new \Redis();
        $temppost = Request::param();// 有 goodsOne 和用户信息 。 用于验证。 如果 redis 没有存在信息。则说明过期？？？？需要重新登陆。
        $mobile=$temppost['mobile'];
        $res = new \app\api\model\user();
        $ifexistts = $res->ifExists($mobile);
        if($ifexistts){
            $code = '手机号存在了';
            $result['data']['error']= '存在了';
        }else{
            $code = rand(1000,9999);//记录在redis
            //这里需要发短信。
            $redis->SET('code_'.$mobile,$code);
        }


        $result['data']['status'] = 0;
        $result['data']['res'] = $code;

        echo json_encode($result);
        exit();
    }

    public function register(){//注册验证
        $redis = Cache::store('redis')->handler(); // 这条代码等于  $redis = new \Redis();
        $temppost = Request::param();// 有 goodsOne 和用户信息 。 用于验证。 如果 redis 没有存在信息。则说明过期？？？？需要重新登陆。
        $mobile=$temppost['mobile'];
        $passwd = $temppost['password'];
        $code = $temppost['code'];
        $res = new \app\api\model\user();
        $ifexistts = $res->ifExists($mobile);
        if($ifexistts){
            $code = '手机号存在了';
            $result['data']['error']= '存在了';
        }else{//不存在则验证
            //这里需要发短信。
            $ver_code = $redis->GET('code_'.$mobile);
            if($code == $ver_code){//成功 则注册账号然后返回结果 登陆。
                $userinfo['phone'] = $mobile;
                $userinfo['passwd'] = $passwd;
                $userinfo['nickname'] = rand(999,99999);
                $user = new \app\api\model\user();
                $user->save($userinfo);
                $res = 1;
                $result['data']['userInfo'] = $userinfo;
            }else{
                $res = 0;
            }
        }


        $result['data']['status'] = 0;
        $result['data']['res'] = $res;

        echo json_encode($result);

    }

    public function code2seesion(){
        $appid = 'wx73ed36e0bffe6d94';
        $secret = '6f8e10b03d48dafcfb79cbe7a268108a';
        $param = Request::param();
        $jscode = $param['code'];
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$jscode.'&grant_type=authorization_code';
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $res = file_get_contents($url, false, stream_context_create($arrContextOptions));

        echo $res;
    }

    function getSSLPage($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSLVERSION,3);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * post: 用户&&商家注册或登陆
     * path: register
     * method: register
     * param: phone - {string}  手机号
     * param: type - {int} 1为用户 2为商家
     * param: friend_id - {int}  用户id  分享是传入
     */
    function miniRegisterOrLogin(){
        $param = Request::param();
        $type = input('type');
        $wxCode = $param['code'];


        $encryptedData = $param['encryptedData'];
        $iv = $param['iv'];

        $appid = 'wx1fb8c758026e3eb3';
        $appsecret = '863f0229a0de0bed5d0999cbd2ebdd4f';
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $oauth2Url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$appsecret."&js_code=".$wxCode."&grant_type=authorization_code";
        $result = file_get_contents($oauth2Url, false, stream_context_create($arrContextOptions));
        $obj = json_decode($result);

        $session_key = $obj->session_key;
        $openid = $obj->openid;
        //$unionid = $obj->unionid;


        $pc = new wxBizDataCrypt($appid, $session_key);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );
        $result = array();
        if ($errCode == 0) {
            $numDatas = json_decode($data);
            $phone = $numDatas->phoneNumber;



            $userinfo = $this->is_register($phone);

            if (! $userinfo){
                // 在db插入新用户
                $data = [
                    //'username' => 'U' . $phone.$type,
                    'avatar' => '/uploads/default/head.png',
                    'phone' => $phone,
                    'addtime' => date("Y-m-d H:i:s"),
                    // 'type' => $type,
                    'openid' => $openid
                ];
                $res = Db::name('user')->insertGetId($data);

                if ($res){
                    $returnData = [
                        'phone' => $phone,
                        'id' => $res,
                        'avatar' => 'http://app.51oil.net.cn'.$res['avatar'],
                    ];
                    $result['data']['error'] = 0; //正常
                    $result['data']['code'] = 200;//正常

                }else{

                    $result['data']['error'] = 1;//报错
                    $result['data']['code'] = 202;//报错
                }

            }else{
                $returnData = [
                    'id' => $userinfo['id'],
                    'phone' => $userinfo['phone'],
                    'avatar' => $userinfo['avatar'],
                ];

                $result['data']['error'] = 0; //正常
                $result['data']['code'] = 200; //正常
            }


            $result['data']['status'] = 0;
            $result['data']['res'] = $returnData;

            echo json_encode($result);
            exit();

        } else {
            print($errCode . "\n");
        }


    }

    /**
     * post: 手机号查询用户信息
     * path: is_register
     * method: is_register
     * param: phone - {string} 手机号
     */
    public function is_register($phone)
    {
        if (!$phone || !$this->is_phone($phone)) {
            $this->result('', 0, '请输入正确格式的手机号码');
        }

        $find = Db::name('user')->where('phone', $phone)->find();

        return $find;
    }
    protected  function is_phone($phonenumber){
        if(preg_match("/^1[34578]{1}\d{9}$/",$phonenumber)){
            return true;
        }else{
            return false;
        }
    }
    //https请求（支持GET和POST）
    public function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        //https
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }


}
