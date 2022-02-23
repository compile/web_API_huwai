<?php
namespace app\api\controller;
use app\api\model\goodsGrade;
use app\api\model\order;
use app\api\model\ShopAd;
use app\api\model\ShopNav;
use app\api\model\User;
use app\api\model\userGrade;
use app\common\model\Area;
use Firebase\JWT\ExpiredException;
use think\facade\Cache;
use think\facade\Db;
use app\api\BaseController;
use think\facade\Request;
use think\facade\Filesystem;
use \Firebase\JWT\JWT;

class Common
{
    protected $system,$cache_model,$adminRules,$HrefId;
    public function initialize()
    {

    }
    //空操作
    public function _empty(){
        return $this->error('空操作，返回上次访问页面中...');
    }

    function signToken($uinfo){//生成token

        $key='!@#$%*&';     //这里是自定义的一个随机字串，应该写在config文件中的，解密时也会用，相当 于加密中常用的 盐 salt
        $token =  array(
            "iss"=>$key,//签发者 可以为空
            "aud"=>'',//面象的用户，可以为空
            "iat"=>time(),//签发时间
            "nbf"=>time()+3, //在什么时候jwt开始生效 （这里表示生成100秒后才生效）
            //"exp"=>time()+200, //token 过期时间
            "exp" => 0,
            "data"=>$uinfo,
        );

        $jwt = JWT::encode($token,$key,"HS256");//根据参数生成了 token
        return $jwt;
    }

    function if_exists_redis($user,$key,$aid){
        $redis = Cache::store('redis')->handler();
        $userInfo = $user;
        $id = $userInfo['id'];
        $iftrue  = $redis->SISMEMBER($key.$id,$aid);//如果存在 则为 1
        return $iftrue;
    }

    function if_redis_true($uid,$key,$id){
        $redis = Cache::store('redis')->handler();
        //$key  = "appreciate_";
        return   $redis->SISMEMBER($key.$uid,$id);//如果存在 则为 1
    }

    function addjifen($uid,$type,$score,$who){
        //新增积分
        //uid 指定的用户id
        //type :    tiezi     article     tiezi_liuyan     article_liuyan   system  admin
        //score: 加减分数。
        //who 谁执行的    一般 system


    }

    function checkToken($token){//验证token

        $key='!@#$%*&';
        $status=array("code"=>2);
        try {
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($token, $key, array('HS256')); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            $res['code']=1;
            $res['data']=$arr['data'];
            return $res;
        } catch(\Firebase\JWT\SignatureInvalidException $e){//签名不正确
            $status['msg']="签名不正确";
            return $status;
        } catch(\Firebase\JWT\BeforeValidException $e){ //签名在某个时间点之后才能使用
            $status['msg'] = "token失效";
        } catch(\Firebase\JWT\ExpiredException $e){
            $status['msg'] = "token失效";
        } catch(ExpiredException $e){ //其他错误
            $status['msg'] = "未知错误";
            return $status;
        }

    }

    public function getList($table,$type=1,$where=array(),$order='0',$price ='1'){// order = 0 默认 order =1 销量排序 order =2 价格排序  $price = 1 升 2 降

        $page = input('page', 1);
        $pageSize = input('limit', 9);

        if($order == 0 ){
            $list = \think\facade\Db::name($table)->order('create_time desc')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();
        }elseif($order == 1){
            $list = \think\facade\Db::name($table)->order('sales desc')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();
        }elseif($order == 2){
            if($price == 1){
                $list = \think\facade\Db::name($table)->order('price desc')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();
            }else{
                $list = \think\facade\Db::name($table)->order('price asc')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();
            }
        }else{
            $list = \think\facade\Db::name($table)->order('create_time desc')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();
        }


        if($type == 1){
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
        }else{
            foreach($list['data'] as $item => $value){  //如果只有一个图片 就显示一张图片。 如果是一组图片 就显示第一张图片
                    if(!$this->is_not_json(@$value['image'])){//去否判断是json
                        $image = json_decode($value['image'],true);
                        $zimage = $image['0']['src'];
                        $list['data'][$item]['image'] = $zimage;
                    }

            }
            $result['data']['status'] = 0;
            $result['data']['res'] = $list['data'];
            echo json_encode($result);
        }

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
            case 'shopnav':
                $return = new ShopNav();
                $return->change($id,$post);
                break;
            case 'shopad':
                $return = new ShopAd();
                $return->change($id,$post);
                break;
            case 'article':
                $return = new \app\admin\model\article();
                $return->change($id,$post);
                break;
            case 'articlecate':
                $return = new \app\admin\model\articleCate();
                $return->change($id,$post);
                break;
            case 'order':
                echo 'order';
            break;

        }
    }


    public function deleteOne($tablecc,$id){//统一修改
        switch($tablecc){
            case 'user':
                $return = new User();
                $return->deleteOne($id);
                break;
            case 'usergrade':  //等级
                $return = new UserGrade();
                $return->deleteOne($id);
                break;
            case 'goodsgrade':
                echo 'here';
                $return = new GoodsGrade();
                $return->deleteOne($id);
                break;
            case 'shop':
                echo 'here';
                $return = new \app\admin\model\Shop();
                $return->deleteOne($id);
                break;
            case 'shopnav':
                $return = new ShopNav();
                $return->deleteOne($id);
                break;
            case 'shopad':
                $return = new ShopAd();
                $return->deleteOne($id);
                break;
            case 'article':
                $return = new \app\admin\model\article();
                $return->deleteOne($id);
                break;
            case 'articlecate':
                $return = new \app\admin\model\articleCate();
                $return->deleteOne($id);
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
            case 'article':
                $return = new \app\admin\model\article();
                $return->changeOneAttribute($id,$attribute);
                break;
            case 'shopad':
                $return = new ShopAd();
                $return->changeOneAttribute($id,$attribute);
                break;
            case 'shopnav':
                $return = new ShopNav();
                $return->changeOneAttribute($id,$attribute);
                break;
            case 'order':
                echo 'order';
                break;

        }
    }

    function is_not_json($str){
        return is_null(json_decode($str));
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


    public function uploadFile(){
        $file = Request::file('file');
        //验证文件规则
        $result=validate(['file' => ['fileSize:102400000,fileExt:gif,jpg,png']])->check(['file' => $file]);
        if($result){
            $md5 = $file->md5();
            $temp = Db::table("bb_resources")->where("md5",'=',$md5)->find();
            if($temp){
                $fileName = $temp['fileName'];
                $picCover = $temp['path'];
                $msg = "已经存储,直接使用";
            }else{
                //上传到服务器,
                $path = Filesystem::disk('public')->putFile('upload',$file);
                //结果是 $path = upload/20200825\***.jpg
                //图片路径，Filesystem::getDiskConfig('public','url')功能是获取public目录下的storage，
                $picCover = Filesystem::getDiskConfig('public','url').'/'.str_replace('\\','/',$path);
                //结果是 $picCover = storage/upload/20200825/***.jpg
                //获取图片名称
                $fileName = $file->getOriginalName();
                $data['path'] = $picCover;
                $data['fileName'] =$fileName;
                $data['md5'] = $file->md5();
                $data['create_time'] = time();
                $data['update_time'] = time();
                Db::table('bb_resources')->save($data);
                $msg = "新的，记录数据库";
            }
            $res = array('status' => 0, 'code'=> 200, 'msg' =>$msg,'url' => 'http://localhost/'.$picCover, 'info' => $fileName,'md5' => $md5);
            $res = json_encode($res);


            return $res;
        }
    }
    public function webCosUpload(){
        require '../vendor/cos-sdk-v5-7/vendor/autoload.php';
        echo __FUNCTION__;

        // SECRETID和SECRETKEY请登录访问管理控制台进行查看和管理
        $secretId = "AKID3uUptgDTTBcmgKgnfGaeRyESSCiz0mJb"; //替换为用户的 secretId，请登录访问管理控制台进行查看和管理，https://console.cloud.tencent.com/cam/capi
        $secretKey = "4sRjjSwA7oGRM0NUKJ6fxyiCQN4VgaDZ"; //替换为用户的 secretKey，请登录访问管理控制台进行查看和管理，https://console.cloud.tencent.com/cam/capi
        $region = "ap-guangzhou"; //替换为用户的 region，已创建桶归属的region可以在控制台查看，https://console.cloud.tencent.com/cos5/bucket
        $cosClient = new \Qcloud\Cos\Client(
            array(
                'region' => $region,
                'schema' => 'https', //协议头部，默认为http
                'credentials'=> array(
                    'secretId'  => $secretId ,
                    'secretKey' => $secretKey)));



        var_dump($cosClient);
    }
    public function uploadimg(){
        $file = Request::file('Image');
        //验证文件规则
        $result=validate(['file' => ['fileSize:102400000,fileExt:gif,jpg,png']])->check(['file' => $file]);
        if($result){
            $md5 = $file->md5();
            $temp = Db::table("bb_resources")->where("md5",'=',$md5)->find();
            if($temp){
                $fileName = $temp['fileName'];
                $picCover = $temp['path'];
                $msg = "已经存储,直接使用";
            }else{
                //上传到服务器,
                $path = Filesystem::disk('public')->putFile('upload',$file);
                //结果是 $path = upload/20200825\***.jpg
                //图片路径，Filesystem::getDiskConfig('public','url')功能是获取public目录下的storage，
                $picCover = Filesystem::getDiskConfig('public','url').'/'.str_replace('\\','/',$path);
                //结果是 $picCover = storage/upload/20200825/***.jpg
                //获取图片名称
                $fileName = $file->getOriginalName();
                $data['path'] = $picCover;
                $data['fileName'] =$fileName;
                $data['md5'] = $file->md5();
                $data['create_time'] = time();
                $data['update_time'] = time();
                Db::table('bb_resources')->save($data);
                $msg = "新的，记录数据库";
            }
            $res = array('status' => 0, 'code'=> 200, 'msg' =>$msg,'url' => 'http://localhost/'.$picCover, 'info' => $fileName,'md5' => $md5);
            $res = json_encode($res);


            return $res;
        }
    }
    public function upload($item)
    {

        $file = Request::file('image');
        //验证文件规则
        $result=validate(['file' => ['fileSize:102400000,fileExt:gif,jpg,png']])->check(['file' => $file]);
        if($result){

            $md5 = $file->md5();
            $temp = Db::table("bb_resources")->where("md5",'=',$md5)->find();
            if($temp){
                $fileName = $temp['fileName'];
                $picCover = $temp['path'];
                $msg = "已经存储,直接使用";
            }else{
                //上传到服务器,
                $path = Filesystem::disk('public')->putFile('upload',$file);
                //结果是 $path = upload/20200825\***.jpg
                //图片路径，Filesystem::getDiskConfig('public','url')功能是获取public目录下的storage，
                $picCover = Filesystem::getDiskConfig('public','url').'/'.str_replace('\\','/',$path);
                //结果是 $picCover = storage/upload/20200825/***.jpg
                //获取图片名称
                $fileName = $file->getOriginalName();
                $data['path'] = $picCover;
                $data['fileName'] =$fileName;
                $data['md5'] = $file->md5();
                $data['create_time'] = time();
                $data['update_time'] = time();
                Db::table('bb_resources')->save($data);
                $msg = "新的，记录数据库";
            }
            $res = array('status' => 0, 'msg' =>$msg,'url' => $picCover, 'info' => $fileName,'md5' => $md5);
            $res = json_encode($res);


            return $res;
        }
    }


    public function rjson($result,$code='200',$msg='请求成功'){

        $temp = array();
        $temp['code'] = $code;
        $temp['msg'] = $msg;
        $temp['result'] = $result;

        echo json_encode($temp);
    }



    public function uploadCos(){
        include 'qcloud-sts-sdk.php'; // 这里获取 sts.php https://github.com/tencentyun/qcloud-cos-sts-sdk/blob/master/php/sts/sts.php
        $sts = new STS();
// 配置参数
        $config = array(
            'url' => 'https://sts.tencentcloudapi.com/',
            'domain' => 'sts.tencentcloudapi.com',
            'proxy' => '',
            'secretId' => 'AKID3uUptgDTTBcmgKgnfGaeRyESSCiz0mJb', // 固定密钥
            'secretKey' => '4sRjjSwA7oGRM0NUKJ6fxyiCQN4VgaDZ', // 固定密钥
            'bucket' => 'yy-1255875008', // 换成你的 bucket
            'region' => 'ap-guangzhou', // 换成 bucket 所在园区
            'durationSeconds' => 1800, // 密钥有效期
            // 允许操作（上传）的对象前缀，可以根据自己网站的用户登录态判断允许上传的目录，例子： user1/* 或者 * 或者a.jpg
            // 请注意当使用 * 时，可能存在安全风险，详情请参阅：https://cloud.tencent.com/document/product/436/40265
            'allowPrefix' => '_ALLOW_DIR_/*',
            // 密钥的权限列表。简单上传和分片需要以下的权限，其他权限列表请看 https://cloud.tencent.com/document/product/436/31923
            'allowActions' => array (
                // 所有 action 请看文档 https://cloud.tencent.com/document/product/436/31923
                // 简单上传
                'name/cos:PutObject',
                'name/cos:PostObject',
                // 分片上传
                'name/cos:InitiateMultipartUpload',
                'name/cos:ListMultipartUploads',
                'name/cos:ListParts',
                'name/cos:UploadPart',
                'name/cos:CompleteMultipartUpload'
            )
        );
// 获取临时密钥，计算签名
        $tempKeys = $sts->getTempKeys($config);

// 返回数据给前端
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: http://127.0.0.1'); // 这里修改允许跨域访问的网站
        header('Access-Control-Allow-Headers: origin,accept,content-type');
        echo json_encode($tempKeys);
    }
}
