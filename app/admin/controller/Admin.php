<?php
declare (strict_types = 1);

namespace app\admin\controller;
use app\admin\BaseController;
use think\facade\Db;
use think\facade\Config;
use think\facade\View;
use think\facade\Request;
use think\facade\Session;
use think\Facade\Cache;
use app\admin\model\Test;
use think\cache\driver\Redis;
use think\Model;

use QL\QueryList;
use QL\Ext\PhantomJs;

class Admin extends BaseController
{

    public $redis;

    /**
     *
    原来里面写了一个_initialize()的方法，原来是子类的构造函数覆盖了父类的，所以报错了。
    解决办法：
    将__construct()改为_initialize()
     */
    public function _initialize(){
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1',6379);
    }
    function curl_get3($url)
    {
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        $result=curl_exec($ch);
        $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);
        if($code!='404' && $result)
        {
            return $result;
        }
        curl_close($ch);
    }
    public function ttt(){

       // $content = $this->curl_get3("http://pan.baidu.com/wap/link?uk=2788992893&shareid=4095420072");


        echo file_get_contents('http://pan.baidu.com/wap/link?uk=2788992893&shareid=4095420072');
       // echo $content;

    }
    public  function redistest(){
         $value = 'test2';
        // 设置缓存数据
        cache('name', $value, 3600);

        Cache::set('name1', $value, 3600);// 这个也可以

//        Cache::set('name', $value,  data('2019-10-01 12:00:00'));//可以使用DateTime对象设置过期时间。如果设置成功返回true，否则返回false。

//        针对数值类型的缓存数据，可以使用自增操作，例如：
        Cache::set('name', 1);
// name自增（步进值为1）
        Cache::inc('name');
// name自增（步进值为3）
        Cache::inc('name',3);

//        只能对数字或者浮点型数据进行自增和自减操作。
//        针对数值类型的缓存数据，可以使用自减操作，例如：

// name自减（步进值为1）
Cache::dec('name');
// name自减（步进值为3）
Cache::dec('name',3);


        Cache::get('name');//获取缓存如果name值不存在，则默认返回 null。
        Cache::get('name',''); //支持指定默认值，例如：

        //追加   如果缓存数据是一个数组，可以通过push方法追加一个数据。
        Cache::set('name', [1,2,3]);
        Cache::push('name', 4);
        Cache::get('name'); // [1,2,3,4]

// 删除缓存
//        Cache::delete('name');
//        获取并删除缓存
         $res =  Cache::pull('name'); //删除获得的缓存
         print_r($res);
        Cache::clear();//清空缓存 所有的


//        不存在则写入缓存数据后返回 remember方法的第三个参数可以设置缓存的有效期。
        Cache::remember('start_time', time());//如果start_time缓存数据不存在，则会设置缓存数据为当前时间。

        Cache::remember('start_time', function(Request $request){
            return $request->time();
        });//第二个参数可以使用闭包方法获取缓存数据，并支持依赖注入。




//        支持给缓存数据打标签，例如：

        Cache::tag('tag')->set('name1','value1');
        Cache::tag('tag')->set('name2','value2');

        // 清除tag标签的缓存数据
        Cache::tag('tag')->clear();

//        并支持同时指定多个缓存标签操作
        Cache::tag(['tag1', 'tag2'])->set('name1', 'value1');
        Cache::tag(['tag1', 'tag2'])->set('name2', 'value2');

// 清除多个标签的缓存数据
        Cache::tag(['tag1','tag2'])->clear();


        Cache::tag('tag')->append('name3');//可以追加某个缓存标识到标签


        Cache::getTagItems('tag');//获取标签的缓存标识列表


//        助手函数
// 设置缓存数据
        cache('name', $value, 3600);
// 获取缓存数据
        var_dump(cache('name'));
// 删除缓存数据
        cache('name', NULL);
// 返回缓存对象实例
        $cache = cache();



        //redis 五大数据类型常用操作


        // string 字符     String类型是二进制安全的。意思是redis的string可以包含任何数据。比如jpg图片或者序列化的对象 。 String类型是Redis最基本的数据类型，一个键最大能存储512MB。 自增 自减 incr decr    加 incrby  减 decrby
        //        常用命令：get、set、incr、decr、mget等。


        // hash 哈希       Redis hash是一个string类型的field和value的映射表，hash特别适合用于存储对象。每个 hash 可以存储 232 - 1键值对（40多亿）。

        // list 列表      Redis 列表是简单的字符串列表，按照插入顺序排序。你可以添加一个元素导列表的头部（左边）或者尾部（右边）。列表最多可存储 232 - 1元素 (4294967295, 每个列表可存储40多亿)。

        // set 集合       Redis的Set是string类型的无序集合。集合是通过哈希表实现的，所以添加，删除，查找的复杂度都是O(1)。集合中最大的成员数为 232 - 1 (4294967295, 每个集合可存储40多亿个成员)。

        // zset 有序集合    Redis zset 和 set 一样也是string类型元素的集合,且不允许重复的成员。不同的是每个元素都会关联一个double类型的分数。redis正是通过分数来为集合中的成员进行从小到大的排序。zset的成员是唯一的,但分数(score)却可以重复。






























    }


    function testcheck(){
        echo 'test';
        $path = './manhua.txt';
        $fopen = fopen($path,"rb");

        while (!feof($fopen)){
            $temp =  fgets($fopen);

            $temp2 = explode("######",$temp);
            $info['manhua']=$temp2['0'];
            $info['picurl'] = $temp2['1'];


            $checkarray[] = $info;
        }

         echo '<pre>';
         print_r($checkarray);

         foreach($checkarray as $k=>$v){
             echo $v['picurl'].'<br>';
             $this->dlfile(trim($v['picurl']));
         }

         echo '</pre>';
    }

    function dlfile($file_url, $save_to = 'images/')
    {
        if (!file_exists ($save_to))
        {
            if (mkdir ($save_to))
            {
                echo 'mkdir ok';
            }
            else
            {
                echo 'mkdir fail';
                return false;
            }
        }
        $stream_opts = [
            "ssl" => [
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ]
        ];
        $content = file_get_contents($file_url,false, stream_context_create($stream_opts));
        file_put_contents($save_to.'hehe.jpg', $content);
    }
    function download($url, $path = 'images/')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $file = curl_exec($ch);
        curl_close($ch);
        $filename = pathinfo($url, PATHINFO_BASENAME);
        if (!file_exists ($path))
        {
            if (mkdir ($path))
            {
                echo 'mkdir ok';
            }
            else
            {
                echo 'mkdir fail';
                return false;
            }
        }
        $resource = fopen($path . $filename, 'a');
        fwrite($resource, $file);
        fclose($resource);
    }
    function getPage(){

        $A['link'] = 'https://www.sohu.com/a/514825750_121286289';
        $A['hot'] = 0;
        require_once '../mmmmm/autoload.php';

        $id = $A['link'];
        $if_hot = $A['hot'];
        //echo $url = "https://www.sohu.com/a/".$A['link'];
        echo $url = $A['link'];
        $ql = QueryList::getInstance();
// 安装时需要设置PhantomJS二进制文件路径
        /**
        $ql->use(PhantomJs::class, '/usr/local/bin/phantomjs');
        $ql->use(PhantomJs::class, '/usr/local/bin/phantomjs', 'browser');
         * **/
        $ql->use(PhantomJs::class, '/usr/bin/phantomjs');//服务器
        $ql->use(PhantomJs::class, '/usr/bin/phantomjs', 'browser');
        $ql->bind('myHttp',function ($url){
            //echo   //$html = curl_file_get_contents($url,$url);
            $html = $this->getContents($url);
            $this->setHtml($html);
            return $this;
        });
        $rules = [
            'title' => ['title','text']
        ];
        $temp = $ql->myHttp($url)->rules($rules)->query()->getData();
        echo '<pre>';
        print_r($temp[0]['title']);
        exit();
    }

    function getContents($url){
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $contents = curl_exec($ch);
        curl_close($ch);
        return $contents;
    }

    public function ceshi(){
        $arr['offset'] = 0;
        $arr['count'] = 20;
        $arr['no_content'] = 0;
        $token = '52_um3Ig2x0QOBOrKm6PxYiyWZiNqhxitVa-IyaiSmQpCyZl4FX38D92-zGlV4v0IVDiqNk89wJrkxVbqe0tG-XJsdfvCmIaLc4lZ22XFK4vnyyXC3GRoEEIO6wZ5z1zS_zEbzyf86oYU6yc_E1ANAeAAATGT';
        $test = $this->curl3($arr,$api='https://api.weixin.qq.com/cgi-bin/freepublish/batchget?access_token='.$token);

        echo $test;

    }

    public function curl3($arrs,$api){
        $data = json_encode($arrs);//转为 json 格式
        //$api = 'http://baijiahao.baidu.com/builderinner/open/resource/article/publish';//百家号图文接口
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;//返回结果为 json 格式数据
    }


    public function index()
    {
        $this->ifLogin();
        $menu = $this->menujson();
        $menu = $this->unicode2Chinese($menu);
        View::assign('menu', $menu);

//        Cache::store('redis')->set('name1','小花2',60);
//        Cache::set('name222','value',3600);
//        $cache = Cache::store('redis')->get('name1');
//        var_dump($cache);
//        echo  Cache::get('name1');
        Cache::tag(['tag1', 'tag2'])->set('name1', 'value1');//设置
        $data = [
            'name' => '2222222222222',
            'email' => '3920699@qq.com'
        ];

        $validate = new \app\admin\validate\User;
        if(!$validate->check($data)){
            dump($validate->getError());
        }
//        $test = new Test;
//        echo $test->test1();

//        $res = [
//            'name' => 'tes333t',
//            'email' => '23333@qq.com'
//        ];
//        $test->create($res);

//        echo '<pre>';
//        $t = Test::where('id','<',10)->select();
//
//        print_r($t);
//
//        $test = new Test([
//            'name'  =>  '22',
//            'email' =>  'thinkphp@qq.com'
//        ]);
//        echo $test->save();

//        echo $test->id;
//
//        $test = new Test;
//        $list = [
//            ['name'=>'thinkphp','email'=>'thinkphp@qq.com'],
//            ['name'=>'onethink','email'=>'onethink@qq.com']
//        ];
//        $test->saveAll($list);

        //查找并且更新
        /**
        $user = Test::where('id',1)
//            ->where('name','liuchen')
            ->find();
        $user->name     = 'cc';
        $user->email    = 't2p@qq.com';
        $user->save();
         **/
        //save方法更新数据，只会更新变化的数据，对于没有变化的数据是不会进行重新更新的   强制更新 $user->force()->save();


//        Test::where('id', 1)
//            ->update(['name' => '22222']);

//        Test::update(['id' => 2, 'name' => '0c']);

//        删除

//        Test::where('id','>',10)->delete();
//        Test::destroy(1);
//        Test::destroy('1,2,3');

//        echo '<pre>';
       return View();
    }

    public function main()
    {
        $test = Config::get('config');
        $userinfo = Session::get('admininfo');
        $request = Request::instance();
//        echo $request->ip();
        $version = Db::query('SELECT VERSION() AS ver');
        $config = [
            'url' => $_SERVER['HTTP_HOST'],
            'document_root' => $_SERVER['DOCUMENT_ROOT'],
            'server_os' => PHP_OS,
            'server_port' => $_SERVER['SERVER_PORT'],
            'server_ip' => $_SERVER['SERVER_ADDR'],
            'server_soft' => $_SERVER['SERVER_SOFTWARE'],
            'php_version' => PHP_VERSION,
            'mysql_version' => $version[0]['ver'],
            'max_upload_size' => ini_get('upload_max_filesize')
        ];
        View::assign('config', $config);
        return View();
    }

    public function login()//登陆
    {
        $bool = Session::has('admininfo');
        if ($bool) {
            redirect('/admin/admin/index')->send();
        }
        if ($this->request->isPost()) {
            $data = Request::post();
            $user = Db::name('admin')->where('username', $data['user'])->find();
            if ($user) {
                $pwd = $data['pwd'];
                $mdemail = $user['mdemail'];
                $pwd = md5($mdemail . $pwd . $mdemail);
                if ($pwd == $user['pwd']) {
                    $request = Request::instance();
                    $ip = $request->ip();
                    //登记
                    $landing_record['ip'] = $ip;
                    $landing_record['username'] = $user['username'];
                    $landing_record['userid'] = $user['admin_id'];
                    $landing_record['create_time'] = time();
                    $do = Db::name('landing_record')->save($landing_record);
                    Session::set('admininfo', $user);
                    $userinfo = Session::get('admininfo');
                    $bool = Session::has('admininfo');
                    if ($bool) {
                        $this->json_back('0', 'ok', $userinfo);
                    } else {
                        $this->json_back('205', 'false', '异常');
                    }
                } else {
                    $this->errorlogin($data);
                    $this->json_back('204', '密码错误,请重试', '');
                }
            } else {
                $this->errorlogin($data);
                $this->json_back('203', '用户名错误，是否被禁用', '');
            }
        } else {
            return View();
        }
    }

    public function landing_record()
    {
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $list = Db::name('landing_record')
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();
    }


    public function opera_log()
    {
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $list = Db::name('operalog')
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();
    }


    public function errlogin_log()
    {
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $list = Db::name('errorlog')
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();
    }


    public function web_cache()
    {
        //$this->ifLogin();
        Session::delete('admininfo');
        redirect('/guanli/Guanli/login')->send();

        return View();
    }

    protected function okin()
    {
        Session::set('admininfo', 'okkk');
        return true;
    }


    public function out()
    {
        session('admininfo', null);
        echo '<script>sessionStorage.clear();localStorage.clear();window.location.href="login.html";</script>';
    }

    public function user_index()
    {

        return View();
    }

    public function user_add()
    {
        return View();
    }

    public function type_index()
    {

        return View();
    }

    public function article_index()
    {

        return View();
    }

    public function article_add()
    {

        return View();
    }

    public function type_add()
    {

        return View();
    }

    public function web_index()
    {

        return View();
    }

    public function flink_index()
    {

        return View();
    }

    public function nav_index()
    {

        return View();
    }

    public function web_pwd()
    {

        return View();
    }

    public function db_backup()
    {

        return View();
    }

    public function db_reduction()
    {

        return View();
    }


    public function pages_component()
    {

        return View();
    }

    public function pages_model()
    {

        return View();
    }

    public function pages_msg()
    {

        return View();
    }

    public function video_index()
    {

        return View();
    }


    public function adminlist()
    {
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $list = Db::name('guanli')
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();
    }

    public function testadmin()
    {

        $page = input('page', 1);
        $pageSize = input('limit', 10);
        $list = Db::name('guanli')
            ->order('create_time desc')
            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
            ->toArray();
        $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        echo json_encode($result);
        exit();

    }

    public function addAdmin()
    {
        $this->ifLogin();
        $if_edit = Request::has('id', 'get');
        if ($if_edit) {
            $id = Request::param('id');
            $tempadmin = Db::name('guanli')->where('admin_id', $id)->find();
        } else {
            $tempadmin = array('username' => '', 'pwd' => '', 'group_id' => '1', 'email' => '', 'realname' => '', 'tel' => '', 'is_open' => '', 'avatar' => '', 'status' => '1', 'wx_openid' => '', 'username' => '');
        }
        $create_time = time();
        if ($this->request->isPost()) {
            $data = Request::post();
            $if_edit = Request::has('id', 'get');
            if ($if_edit) {
                $data['update_time'] = $create_time;
                $data['admin_id'] = $id;//修改模式
                $mdemail = $tempadmin['mdemail'];
                $typename = '编辑用户';
            } else {
                $data['mdemail'] = bin2hex(random_bytes(3));//添加模式
                $data['create_time'] = $create_time;
                $mdemail = bin2hex(random_bytes(16));
                $typename = '添加用户';
            }

            $pwd = trim(Request::param('pwd'));//是否设置
            if ($_POST['pwd'] !== '') {//如果不为空则更改
                $pwd = md5($mdemail . $pwd . $mdemail);
                $data['pwd'] = $pwd;
            } else {
                unset($data['pwd']);
            }

            $this->inlog(__FUNCTION__, $typename);
            $do = Db::name('guanli')->save($data);
            if ($do) {
                $this->json_back(1, $pwd, '');
            } else {
                $this->json_back(0, $pwd, '');
            }
            exit();
        }
        View::assign('data', $tempadmin);
        return View("addAdmin");
    }

    public function inlog($funtion, $typename)
    {
        //行为记录
        $request = Request::instance();
        $ip = $request->ip();
        $user = Session::get('admininfo');
        $operalog['ip'] = $ip;
        $operalog['username'] = $user['username'];
        $operalog['userid'] = $user['admin_id'];
        $operalog['create_time'] = time();
        $operalog['typename'] = $typename;
        $operalog['opera'] = strtoupper($funtion);
        $do = Db::name('operalog')->save($operalog);
    }

    public function errorlogin($data)
    {
        $request = Request::instance();
        $ip = $request->ip();
        $error_temp['username'] = $data['user'];
        $error_temp['passwd'] = $data['pwd'];
        $error_temp['ip'] = $ip;
        $error_temp['create_time'] = time();
        $do = Db::name('errorlog')->save($error_temp);
    }

    public function weblog()
    {
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $map = input('post.');
            $where = array();
//            $where[] = ['status', '=', 1];
            if (@$map['testing'] != '') $where[] = ['testpage', '=', $map['testing']];
            if (@$map['status'] != '') {

                if ($map['status'] == '200') {
                    $where[] = ['remark', '=', '200'];
                } else {
                    $where[] = ['remark', '<>', '200'];
                }
            }
            if (@$map['start_time'] != '') {
                $start_time = $map['start_time'];
                $today_start = strtotime(date($start_time));
                $where[] = ['create_time', '>=', $today_start];
            }

            if (@$map['end_time'] != '') {
                $end_time = $map['end_time'];
                $today_end = strtotime(date($end_time));
                $where[] = ['create_time', '<=', $today_end];
            }


            $list = Db::name('web_log')
                ->where($where)
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();
    }

    public function serset()
    {//设置配置文件。生成
        $this->ifLogin();
        return View();
    }


    public function statuslist()
    {
        $this->ifLogin();
        echo __FUNCTION__;
    }

    public function setlist()
    {//配置文件查看
        $this->ifLogin();
//        echo "<pre>";
//        var_dump($this->my_dir("set"));
//        echo "</pre>";

        $temp = file_get_contents("./set/.setall");
        $temp = json_decode($temp, true);
        echo '<pre>';
        print_r($temp);
        echo '</pre>';

    }

    public function setchatalert()
    {
        $this->ifLogin();
        $list = Db::name('guanli')
            ->where('wx_openid', '<>', '')
            ->where('wx_openid', '<>', '')
            ->column('wx_openid');
        $str = implode($list, ',');
        $str = trim($str, ',');

        $do = file_put_contents('./set/.wechat', $str);
        echo $str;
    }


    public function defaultlist()
    {
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $map = input('post.');
            $where = array();
//            $where[] = ['status', '=', 1];
            if (@$map['ip'] != '') $where[] = ['ip', '=', $map['ip']];
            if (@$map['typename'] != '') $where[] = ['typename', '=', $map['typename']];
            if (@$map['start_time'] != '') {
                $start_time = $map['start_time'];
                $today_start = strtotime(date($start_time));
                $where[] = ['create_time', '>=', $today_start];
            }

            if (@$map['end_time'] != '') {
                $end_time = $map['end_time'];
                $today_end = strtotime(date($end_time));
                $where[] = ['create_time', '<=', $today_end];
            }


            $list = Db::name('default')
                ->where($where)
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();
    }

    public function setDefault()
    {
        $this->ifLogin();

        $where[] = ['status', '=', '1'];
        $temp = Db::name('web')
            ->where($where)
            ->select();
        $testing = '';
        foreach ($temp as $k => $item) {
            if ($item['testing'] !== '') {
                $testing .= $item['testing'] . ',';
            }
        }
        $test['testing'] = trim($testing, ',');
        $temp = Db::name('guanli')
            ->where($where)
            ->select();
        $wxopenid = '';
        foreach ($temp as $k => $item) {
            if ($item['wx_openid'] !== '') {
                $wxopenid .= $item['wx_openid'] . ',';
            }
        }
        $test['wxopenid'] = trim($wxopenid, ',');

        $temp = Db::name('server')
            ->where($where)
            ->select();
        $ip = '';
        $ip_remark = '';
        $monitor = '';
        foreach ($temp as $k => $item) {
            if ($item['ip'] !== '') {
                $ip .= $item['ip'] . ',';
                $monitor .= $item['ip_remark'] . ' ' . $item['monitor'] . '#';
            }
            if ($item['ip_remark'] !== '') {
                $ip_remark .= $item['ip_remark'] . ',';
            }
        }
        $test['monitor'] = trim($monitor, '#');
        $test['ip'] = trim($ip, ',');
        $test['ip_remark'] = trim($ip_remark, ',');
        $where[] = ['type', '=', '2'];
        $defaultlist = array();
        $temp = Db::name('default')
            ->where($where)
            ->order('create_time desc')
            ->select();
        foreach ($temp as $k => $item) {
            if ($item['defaultvalue'] !== '') {
                $defaultlist[$item['defaultname']] = $item['defaultvalue'];
            }
        }
        $test['default'] = $defaultlist;
        $test = json_encode($test);
        $do = file_put_contents('./set/.setall', $test);
        if ($do) {
            $this->json_back('0', 'ok', $test);
        } else {
            $this->json_back('200', 'error', '写入失败');
        }
        exit();
        //}
    }

    public function addDefault()
    {
        $this->ifLogin();
        $if_edit = Request::has('id', 'get');
        if ($if_edit) {
            $id = Request::param('id');
            $data = Db::name('default')->where('id', $id)->find();
            View::assign('data', $data);
        } else {
            $data = array('type' => '', 'defaultname' => '', 'defaultvalue' => '', 'remark' => '', 'status' => '');
        }
        $create_time = time();
        if ($this->request->isPost()) {
            $data = Request::post();
            $data['create_time'] = $create_time;

            $if_edit = Request::has('id', 'get');
            if ($if_edit) {
                $data['id'] = $id;
                $typename = '编辑定义值';
            } else {
                $typename = '添加定义值';
            }
            $this->inlog(__FUNCTION__, $typename);
            $do = Db::name('default')->save($data);
            if ($do) {
                $this->json_back(1, '创建成功', '');
            } else {
                $this->json_back(0, '创建失败', '');
            }
            exit();
        }
        View::assign('data', $data);
        return View();
    }

    public function serlog()
    {
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $map = input('post.');
            $where = array();
            if (@$map['ip'] != '') $where[] = ['ip', '=', $map['ip']];
            if (@$map['typename'] != '') $where[] = ['typename', '=', $map['typename']];
            if (@$map['start_time'] != '') {
                $start_time = $map['start_time'];
                $today_start = strtotime(date($start_time));
                $where[] = ['create_time', '>=', $today_start];
            }
            if (@$map['end_time'] != '') {
                $end_time = $map['end_time'];
                $today_end = strtotime(date($end_time));
                $where[] = ['create_time', '<=', $today_end];
            }
            $list = Db::name('ser')
                ->where($where)
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();
    }

    public function serlist()
    {
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 20);
            $map = input('post.');
            $where[] = ['del', '=', 0];
//            if ($map['ip'] != '') $where[] = ['ip', 'like', '%' . $map['ip'] . '%'];
//            if ($map['typename'] != '') $where[] = ['typename', '=',  $map['typename'] ];
            $list = Db::name('server')
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();

            foreach ($list['data'] as $k => $v) {
                $file = "/etc/linuxsh/logs/" . $v['ip_remark'] . "_disk.txt";
                if (file_exists($file)) {
                    $harddisk = file_get_contents($file);
                    $list['data'][$k]['harddisk'] = $harddisk;
                } else {
                    $list['data'][$k]['harddisk'] = 'null';
                }

                $monitorItem = explode(',', $v['monitor']);

                $list['data'][$k]['monitor'] = '';
                foreach ($monitorItem as $item) {
                    if ($item == '1') {
                        $list['data'][$k]['monitor'] .= 'harddisk &nbsp;';
                    }
                    if ($item == '2') {
                        $list['data'][$k]['monitor'] .= 'nginx &nbsp;';
                    }
                    if ($item == '3') {
                        $list['data'][$k]['monitor'] .= 'php-fpm &nbsp;';
                    }
                    if ($item == '4') {
                        $list['data'][$k]['monitor'] .= 'mysql &nbsp;';
                    }
                    if ($item == '5') {
                        $list['data'][$k]['monitor'] .= 'redis &nbsp;';
                    }
                    if ($item == '6') {
                        $list['data'][$k]['monitor'] .= 'ssh &nbsp;';
                    }
                    if ($item == '7') {
                        $list['data'][$k]['monitor'] .= 'load &nbsp;';
                    }
                }


                $file = "/etc/linuxsh/logs/" . $v['ip_remark'] . "_net.txt";
                if (file_exists($file)) {
                    $net = file_get_contents($file);
                    $list['data'][$k]['net'] = $net;
                } else {
                    $list['data'][$k]['net'] = 'null';
                }


            }


            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();
    }

    public function diffloglist()
    {
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 20);
            $map = input('post.');
            $where = array();
            if (@$map['ip_remark'] != '') $where[] = ['ip_remark', '=', $map['ip_remark']];
            $list = Db::name('difflog')
                ->where($where)
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();

            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();
    }

    public function seedifflog()
    {
        $this->ifLogin();
        $if_edit = Request::has('id', 'get');
        if ($if_edit) {
            $id = Request::param('id');
            $data = Db::name('difflog')->where('id', $id)->find();
            $content = $data['content'];
            $content = str_replace("__", "/\r", $content);
            $content = str_replace("_", "&nbsp;", $content);
            echo $content;
        } else {
            $this->json_back(203, 'error', '');
        }
    }


    public function addSer()
    {
        $this->ifLogin();
        $if_edit = Request::has('id', 'get');
        if ($if_edit) {
            $id = Request::param('id');
            $data = Db::name('server')->where('id', $id)->find();
            View::assign('data', $data);
            $typename = '编辑服务器' . $id;
        } else {
            $data = array('ip' => '', 'ip_remark' => '', 'status' => '1', 'remark' => '', 'ipname' => '', 'monitor' => '');
            $typename = '添加服务器';
        }
        $create_time = time();
        if ($this->request->isPost()) {
            $data = Request::post();
            $data['create_time'] = $create_time;
            $if_edit = Request::has('id', 'get');
            if ($if_edit) {
                $data['id'] = $id;
            }
            //unset($data['monitor']);
            $monitor = Db::name('default')->where('type', 1)->select();//这里是全部的项目
            foreach ($monitor as $key => $value) {
                $monitorItemName[] = $value['defaultvalue'];
            }
            $tor = '';
            $tempmonitor = $data['monitor'];
            foreach ($tempmonitor as $key => $item) {
                if (in_array($key, $monitorItemName)) {
                    if ($key == 'harddisk') {
                        $tor .= '1,';
                    }
                    if ($key == 'nginx') {
                        $tor .= '2,';
                    }
                    if ($key == 'php-fpm') {
                        $tor .= '3,';
                    }
                    if ($key == 'mysql') {
                        $tor .= '4,';
                    }
                    if ($key == 'redis') {
                        $tor .= '5,';
                    }
                    if ($key == 'ssh') {
                        $tor .= '6,';
                    }
                    if ($key == 'load') {
                        $tor .= '7,';
                    }
                }
            }
            $data['monitor'] = trim($tor, ',');


            $this->inlog(__FUNCTION__, $typename);
            $do = Db::name('server')->save($data);
            if ($do) {
                $this->json_back(1, '创建成功', '');
            } else {
                $this->json_back(0, '创建失败', '');
            }
            exit();
        }
        $monitorItem = $data['monitor'];//选中的
        $monitorItemName = array();
        if ($monitorItem !== '') {
            $monitorItem = explode(',', $monitorItem);
            foreach ($monitorItem as $item) {
                if ($item == '1') {
                    $monitorItemName[] = 'harddisk';
                }
                if ($item == '2') {
                    $monitorItemName[] = 'nginx';
                }
                if ($item == '3') {
                    $monitorItemName[] = 'php-fpm';
                }
                if ($item == '4') {
                    $monitorItemName[] = 'mysql';
                }
                if ($item == '5') {
                    $monitorItemName[] = 'redis';
                }
                if ($item == '6') {
                    $monitorItemName[] = 'ssh';
                }
                if ($item == '7') {
                    $monitorItemName[] = 'load';
                }
            }
        } else {
            $monitorItemName = array();
        }
        $monitorstatus = array();
        $monitor = Db::name('default')->where('type', 1)->select();//这里是全部的项目
        foreach ($monitor as $k => $item) {//如果有选中。 则  值为1  。 如果没有选择。 则值为0
            if (in_array($item['defaultvalue'], $monitorItemName)) {//如果在数组里面。 说明选中
                $monitorstatus[$item['defaultvalue']] = 1;
            } else {
                $monitorstatus[$item['defaultvalue']] = 0;
            }
        }
        View::assign('monitorstatus', $monitorstatus);
        View::assign('monitoritem', $monitor);
        View::assign('data', $data);
        return View('addSer');
    }


    public function getDefault($id)
    {
        $temp = Db::name('default')->where('id', $id)->find();
        return $temp['defaultname'];
    }


    public function weblist()
    {
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $map = input('post.');
            $where[] = ['del', '=', 0];
            $list = Db::name('web')
                ->where($where)
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();

            foreach ($list['data'] as $k => $v) {
                $temp = Db::name('server')->where('id', $list['data'][$k]['ip'])->find();
                $list['data'][$k]['ip'] = $temp['ipname'];
            }
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();
    }

    public function getSerlist()
    {
        $this->ifLogin();
        $serlist = Db::name('server')
            ->where('status', 1)
            ->order('create_time desc')
            ->column('*', 'id');
        return $this->json_back(1, 'ok', $serlist);
    }

    public function getWeblist()
    {
        $this->ifLogin();
        $serlist = Db::name('web')
            ->where('status', '=', '1')
            ->order('create_time desc')
            ->column('*', 'id');
        return $this->json_back(1, 'ok', $serlist);
    }

    public function memulist()
    {
        $this->ifLogin();
        if (Request::isAjax()) {
            $list = Db::name('menu')
                ->field("id,name,pid,ord,icon,status,concat(pid,'-',id) as bpath")
                ->order('bpath')
                ->select();
            $num = count($list);
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list, 'count' => $num, 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();
    }

    public function addMenu()
    {
        $this->ifLogin();
        $if_edit = Request::has('id', 'get');
        if ($if_edit) {
            $id = Request::param('id');
            $data = Db::name('menu')->where('id', $id)->find();

            $pid = explode('-', $data['pid']);
            if (count($pid) >= 2) {
                $pid = $pid[1];
                $data['pid'] = $pid;
            }


            View::assign('data', $data);
        } else {
            $data = array('name' => '', 'pid' => '', 'icon' => '', 'url' => '', 'hidden' => '', 'ord' => '', 'status' => '');
        }
        $create_time = time();
        if ($this->request->isPost()) {
            $data = Request::post();
            $data['create_time'] = $create_time;
            $if_edit = Request::has('id', 'get');
            if ($if_edit) {
                $data['id'] = $id;
                $typename = '编辑菜单';
            } else {
                $typename = '添加菜单';
            }
            $data['pid'] = trim('0-' . $data['pid'], '-');
            $this->inlog(__FUNCTION__, $typename);
            $do = Db::name('menu')->save($data);
            if ($do) {
                $this->json_back(1, '创建成功', '');
            } else {
                $this->json_back(0, '创建失败', '');
            }
            exit();
        }
        View::assign('data', $data);
        return View('addMenu');


    }

    public function menujson()
    {
        $list = Db::name('menu')
            ->field("id,name,icon,url,hidden")
            ->where('pid', '=', '0')
            ->where('status', '=', '1')
            ->order('ord')
            ->select()
            ->toArray();
        foreach ($list as $k => $item) {
            unset($list[$k]['id']);
            $list[$k]['list'] = $this->getsonmemu($item['id']);
        }
        return json_encode($list);
    }

    protected function getsonmemu($pid)
    {
        $list = Db::name('menu')
            ->field("name,icon,url")
            ->where('pid', '=', '0-' . $pid)
            ->where('status', '=', '1')
            ->order('ord')
            ->select()
            ->toArray();

        foreach ($list as $k => $item) {
            if ($item['icon'] == '') {
                unset($list[$k]['icon']);
            }
        }

        return $list;
    }

    protected function unicode2Chinese($str)
    {
        return preg_replace_callback("#\\\u([0-9a-f]{4})#i",
            function ($r) {
                return iconv('UCS-2BE', 'UTF-8', pack('H4', $r[1]));
            },
            $str);
    }

    public function getPid()
    {
        $this->ifLogin();
        $pid = Db::name('menu')
            ->where('pid', 0)
            ->order('create_time desc')
            ->column('*', 'id');

        return $this->json_back(1, 'ok', $pid);
    }


    public function getTypeName()
    {
        $this->ifLogin();
        $serlist = Db::name('default')
            ->where('status', 1)
            ->where('type', 1)
            ->order('id desc')
            ->column('*', 'id');
        return $this->json_back(1, 'ok', $serlist);
    }


    public function changestatus()
    {
        $this->ifLogin();
        $temp = Request::post();
        $if_id = Request::has('id', 'post');
        if ($if_id) {
            $checked = $temp['checked'];
            if ($checked == 'true') {
                $data['status'] = 1;
                $msg = '开启';
            } else {
                $data['status'] = 0;
                $msg = '关闭';
            }
            $data['id'] = $temp['id'];

            if (Request::has('type', 'post') && $temp['type'] == 'ser') {
                $this->inlog(__FUNCTION__, '修改服务器监控状态');
                $do = Db::name('server')->save($data);
            } else if (Request::has('type', 'post') && $temp['type'] == 'menu') {
                $this->inlog(__FUNCTION__, '修改菜单显示状态');
                $do = Db::name('menu')->save($data);
            } else {
                $this->inlog(__FUNCTION__, '修改网站监控状态');
                $do = Db::name('web')->save($data);
            }
            if ($do !== false) {
                $this->json_back('0', $msg, '');
            } else {
                $this->json_back('2', '操作失败', '');
            }
        } else {
            $this->json_back('203', '错误参数', '');
        }


    }

    function httpcode()
    {
        $this->ifLogin();
        $if_url = Request::has('testing', 'post');
        if ($if_url) {
            $url = Request::post('testing');
            $url = explode(',', $url);
            $temp = array();
            if (is_array($url)) {
                foreach ($url as $k => $item) {
                    $temp[$k]['code'] = $this->getcode($item);
                    $temp[$k]['url'] = $item;
                }
                $this->json_back('0', 'ok', $temp);
            } else {
                $this->json_back('2', 'false', '2');
            }
        }
    }

    function getcode($url)
    {
        $ch = curl_init();
        $timeout = 3;
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_exec($ch);
        return $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    }

    function goping()
    {
        $this->ifLogin();
        $if_ip = Request::has('ip', 'post');
        if ($if_ip) {
            $ip = Request::post('ip');
            $ip = explode(',', $ip);
            $temp = array();
            if (is_array($ip)) {
                foreach ($ip as $k => $item) {
                    $temp[$k]['info'] = $this->ping($item, 30);
                    $temp[$k]['ip'] = $item;
                }
                $this->json_back('0', 'ok', $this->ping($item, 30));
            } else {
                $this->json_back('2', 'false', '2');
            }
        }
    }

    function ping($ip, $times = 90)
    {
        $server = 'ls -al';
        $last_line = exec($server, $arr);


        $arr['test'] = 'test';
        $arr['last_line'] = $last_line;


        return $arr;
    }


    function testping()
    {
        $server = 'ls -al';
        $last_line = exec($server, $arr);
        echo "$last_line"; //最后总结结果
        echo '<pre>';
        print_r($arr); //PING命令详细数据数组
    }

    function getnet()
    {
        $ip_remark = Request::has('ip', 'get');
        if (!$ip_remark) {
            $this->json_back(202, '错误', '');
            exit();
        }
        $ip = Request::get('ip');
        $file = "/etc/linuxsh/logs/{$ip}net.txt";
        if (file_exists($file)) {
            $net = file_get_contents($file);
            View::assign('data', $net);
        } else {
            $net = 'null';
            View::assign('data', $net);
        }
        return View('testnet');
    }

    function getnettest()
    {

        $ip = 217;
        $file = "/Volumes/51/bb/{$ip}net.txt";
        if (file_exists($file)) {
            $net = file_get_contents($file);
            $temp = explode("RX", $net);
            foreach ($temp as $k => $item) {
                if ($item !== '') {

                    $element = explode(" ", $item);
                    $element = array_filter($element);
                    $net = array();
                    foreach ($element as $key => $value) {
                        $str = trim($value);
                        if ($str !== '') {
                            $net[] = $this->DeleteHtml($str);
                        }
                    }
                    $num = count($net);
                    $i = $num / 3;
                    $count = count($net);
                    if ($count >= 1) {
                        $create_time = $net['0'];
                        echo $create_time = strtotime($create_time);
                        echo '<br>';
                        for ($c = 1; $c <= $i; $c++) {
                            $n = $c * 3;

                            $name = $net[($n - 2)];
                            $net1 = $net[($n - 1)];
                            $net2 = $net[$n];

                            $tempnet['create_time'] = $create_time;
                            $tempnet['name'] = $name;
                            $tempnet['net1'] = $net1;
                            $tempnet['net2'] = $net2;
                            $tempnet['ip'] = $ip;

                            echo $net[($n - 2)] . '|' . $net[($n - 1)] . '|' . $net[$n] . '<br>';
                            print_r($tempnet);


                            $do = Db::name('net')->save($tempnet);

                        }

                        echo '<hr>';
                    }
                }
            }


            $element = explode(" ", $temp['999']);
            $element = array_filter($element);
            $net = array();
            foreach ($element as $key => $value) {
                $str = trim($value);
                if ($str !== '') {
                    $net[] = $this->DeleteHtml($str);
                }
            }
            $num = count($net);
            $i = $num / 3;
            echo '时间:';
            echo $net['0'];
            echo '<hr>';
            for ($c = 1; $c <= $i; $c++) {
                $n = $c * 3;
                echo $net[($n - 2)] . '|' . $net[($n - 1)] . '|' . $net[$n] . '<br>';
            }


        }
    }

    function DeleteHtml($str)
    {
        $str = trim($str);
        $str = str_replace("\t", "", $str);
        $str = str_replace("\r\n", "", $str);
        $str = str_replace("\r", "", $str);
        $str = str_replace("\n", "", $str);
        return trim($str);
    }

    function getdisk()
    {
        $ip_remark = Request::has('ip', 'get');
        if (!$ip_remark) {
            $this->json_back(202, '错误', '');
            exit();
        }
        $ip = Request::get('ip');
        $file = "/etc/linuxsh/logs/{$ip}_disk.txt";
        if (file_exists($file)) {
            $net = file_get_contents($file);
            View::assign('data', $net);
        } else {
            $net = 'null';
            View::assign('data', $net);
        }

        View::assign('ip', $ip);
        return View();
    }

    function testnet()
    {
        $file = "/etc/linuxsh/logs/176_net.txt";
        if (file_exists($file)) {
            $net = file_get_contents($file);
            View::assign('data', $net);

        }
        return View();
    }

    public function addWeb()
    {
        $this->ifLogin();
        $if_edit = Request::has('id', 'get');
        if ($if_edit) {
            $id = Request::param('id');
            $data = Db::name('web')->where('id', $id)->find();
            View::assign('data', $data);
        } else {
            $data = array('ip' => '', 'status' => '1', 'remark' => '', 'webname' => '', 'domainname' => '', 'testing' => '');
        }
        $create_time = time();
        if ($this->request->isPost()) {
            $data = Request::post();
            $data['create_time'] = $create_time;
            $if_edit = Request::has('id', 'get');
            if ($if_edit) {
                $data['id'] = $id;
                $typename = '编辑网站';
            } else {
                $typename = '添加网站';
            }
            $this->inlog(__FUNCTION__, $typename);
            $do = Db::name('web')->save($data);
            if ($do) {
                $this->json_back(1, '创建成功', '');
            } else {
                $this->json_back(0, '创建失败', '');
            }
            exit();
        }
        View::assign('data', $data);
        return View('addWeb');
    }

    public function ifLogin()
    {
        $bool = Session::has('admininfo');
        if (!$bool) {
            redirect('/admin/admin/login')->send();
        }
    }

    public function testadmins()
    {
        echo __FUNCTION__;

        echo '<br>';
//        Session::delete('admininfo');
//        Session::clear();
        session('admininfo', null);
//        Session::set('admininfo', 'asdfasdfasdf');
        $userinfo = Session::get('admininfo');


        print_r($userinfo);
    }


    public function video_batch()
    {

        if ($this->request->isPost()) {// 如果是post 就验证是否登陆。 如果错则提示错误。 如果正确则登陆
            //验证数据。

            $app_id = '1672969461062585';
            $app_token = '4908c6a12702b8797dcdfdc663e426a9';

            //小程序
            // $mapp_procedure = array();
            //     		$mapp_procedure['mapp_id'] = '16553734';
            //     		$mapp_procedure['material_id'] = '651006204411710953';
            //     		$mapp_procedure['cover_type'] = 'big';
            //     		$mapp_procedure = json_encode($mapp_procedure);

            $mapp_procedure = "[{\"mapp_id\":\"16553734\",\"material_id\":\"651006204411710953\",\"cover_type\":\"big\"}]";


            //小程序

            $temp = $_POST;
            $num = count($_POST['title']);//判断个数
            $url = 'http://bjh.qilaixiu.com/storage/';
            for ($i = 0; $i < $num; $i++) {
                $tem['app_id'] = $app_id;
                $tem['app_token'] = $app_token;
                $tem['title'] = $temp['title'][$i];
                $tem['video_url'] = $url . $temp['path'][$i];
                $tem['cover_images'] = $url . $temp['img'][$i];
                $tem['tag'] = trim($temp['tag'][$i]);
                $tem['is_original'] = 1;
                $tem['use_auto_cover'] = 0;
                $tem['mapp_procedure'] = $mapp_procedure;
                $url2 = "https://baijiahao.baidu.com/builderinner/open/resource/video/publish";
                echo $temps = $this->curl2($tem, $url2);
                $logs['log'] = $temps;
                $logs['json'] = json_encode($tem);
                $create_time = time();
                $log = Db::name('log')->save($logs);
                if ($log !== '') {
                    $temps = json_decode($temps, true);
                    echo $article_id = $temps['data']['article_id'];
                    echo '<br>';
                    $errno = $temps['errno'];
                    $msg = $temps['errmsg'];
                    $data = ['create_time' => $create_time, 'msg' => $msg, 'status' => $errno, 'article_id' => $article_id, 'title' => $tem['title'], 'video_url' => $tem['video_url'], 'cover_images' => $tem['cover_images'], 'tag' => $tem['tag'], 'is_original' => $tem['is_original'], 'use_auto_cover' => $tem['use_auto_cover']];
                    $do = Db::name('videoinfo')->save($data);
                    if ($do) {
                        echo 'ok,记录了' . $tem['title'] . '<br>';
                    } else {
                        echo 'false.记录失败' . $tem['title'] . '请告诉管理员<br>';
                    }
                } else {
                    echo '返回空';
                }
            }
            //接口地址:https://baijiahao.baidu.com/builderinner/open/resource/video/publish
        }
        return View();
    }


    function file_in_web()
    {
        if ($this->request->isPost()) {
            $url = 'http://bjh.qilaixiu.com/storage/';
        }
        return View();
    }

    function file_list()
    {
        $path = 'file';
        $this->getDir($path);
    }
    function batch_save(){//编辑 videoinfo 状态为0的内容。 添加好数据
        $where[] = ['status', '=', 0];
        $temp = Db::name('videoinfo')
            ->where($where)
            ->select()
            ->toArray();
//        echo '<pre>';
//
//        print_r($temp);
//
//        exit();
        if ($this->request->isPost()) {
            $result = @$_POST;
            $num = count(@$result['title']);
            for ($i = 0; $i < $num; $i++) {

                $savedata['id'] = $result['id'][$i];
                $savedata['title'] = $result['title'][$i];
                $savedata['video_url'] = $result['path'][$i];
                $savedata['cover_images'] = $result['img'][$i];
                $savedata['tag']  =         $result['tag'][$i];
                $savedata['is_original'] = 1;
                $savedata['status'] = 1;

                $savedata['pass'] = 1;//表示可以推送的

                $do = $this->add_one($savedata);
                if($do){
                    echo $savedata['title'].'is ok, wating for input baijiahao api<br>';
                }else{
                    echo $savedata['title'].'is false , call wushi<br>';
                }

            }


            echo '</pre>';
        }

        View::assign('videonum',count($temp));
        View::assign('item', $temp);


        return View();
    }

    function command_list(){
        echo '这里显示需要使用的常见命令。 需要选择服务器。 然后再使用。 不允许使用危险命令。';



        echo '<li>获得服务器的硬盘</li>';
        echo '<li>获得服务器的内存使用率</li>';
        echo '<li>服务器时间</li>';
        echo '<li>nginx / mysql 状态和是否重启。关闭</li>';


    }

    function test2(){

        $ctime = '16041655205655';



        $url = "https://haokan.baidu.com/web/author/listall?app_id=1672969461062585&ctime=16041655205655&rn=10&_api=1";

        $get= file_get_contents($url);

        $json = json_decode($get,true);

        echo '<pre>';
        print_r($json);

        echo $ctime =  $json['data']['ctime'];
        echo $has_more = $json['data']['has_more'];//如果1 应该表示还有。这个就作为循环停止的条件。







    }

    function get_json($ctime = '16041655205655' ){
        exit();
        $url = "https://haokan.baidu.com/web/author/listall?app_id=1672969461062585&ctime={$ctime}&rn=20&_api=1";
        $get= file_get_contents($url);

        $json = json_decode($get,true);
        echo '<pre>';
        print_r($json);
        echo '</pre>';

        $data = array();
        foreach($json['data']['results'] as $k => $item){
                    $data['vid'] = $item['content']['vid'];
                    $data['publish_time'] = $item['content']['publish_time'];
                    $data['title'] = $item['content']['title'];
                    $data['cover_src'] = $item['content']['cover_src'];
                    $data['cover_src_pc'] = $item['content']['cover_src_pc'];
                    $data['thumbnails'] = $item['content']['thumbnails'];
                    $data['video_src'] = $item['content']['video_src'];
                    $data['duration'] = $item['content']['duration'];
                    $data['poster'] = $item['content']['poster'];
                    $data['playcnt'] = $item['content']['playcnt'];
                    $data['playcntText'] = $item['content']['playcntText'];

            $do =  Db::name('haokan')->save($data);

        }





        echo $ctime =  $json['data']['ctime'];
        echo '<br>';
        echo $has_more = $json['data']['has_more'];//如果1 应该表示还有。这个就作为循环停止的条件。
        echo '<br>';
        if($has_more == 1) {
            $this->get_json($ctime);
        }

    }

    function file_get_mp4(){//这里导入 videoinfo
        /**
         *
         * 1.逻辑。 先检测一遍有没有错。
         * 2.再提交到数据库。
         * 3.再批量添加标题和 其他内容。    并更改状态。
         * 4.确认无误后提交到百家号。
         *
         **/
        $path = '/Users/a50/Downloads/Dear-迪丽热巴';
        $dir = scandir($path);
        $create_time = time();
        $domain = 'http://res1.qilaixiu.com/';
        foreach ($dir as $value) {
            if ($value == '.' || $value == '..' || !strstr($value,'mp4')) {
                continue;
            } else {
                //.$path 可以省略，直接输出文件名
                $filename = str_replace(strrchr($value, "."),"",$value);
//                $imgstatus = $this->checkFileExists($path.$filename.'.png');
//                $imgstatus2 = $this->checkFileExists($path.$filename.'.jpg');
                $video_url = $filename.'.mp4';
                $noimgorerror = array();

//                    if($imgstatus2){
                        $img = $filename.'.jpg';
//                        echo $filename.'.mp4&nbsp;&nbsp;&nbsp;'.$img.'<br>';
//                        if($this->checkIfExists('http://res1.qilaixiu.com/'.$img)){//存在
//                            echo '存在,过滤'.$filename.'<br>';
//                        }else{
//                           echo '不存在,添加入库<hr>';
                           echo  $temp['title']     = $value;
                           echo '<br>';
                            $temp['video_url'] = $domain.$video_url;
                            $temp['cover_images'] = $domain.$img;
                            $temp['create_time'] = $create_time;
                            //这些写入数据库。 然后一个个一循环即可。 每次一个
                            //$result =   $this->add_one($temp);
//                            if($result){
//                                echo $filename .' is ok in sql<br>';
//                            }else{
//                                echo $filename .' is ok in sql is error,please call wushi<br>';
//                            }
//                        }
//                    }else{
//                        $noimgorerror[] =  $filename.' is no img';
//                    }

                /**
                 *  id, title , article_id  video_url  cover_images tag is_original  use_auto_cover  status  msg create_time  bjh_status
                 */
            }
        }

        $path = '/Users/a50/Downloads/Dear-迪丽热巴';
        echo '<hr>这里显示异常信息,为空表示正常<br>';
        print_r($noimgorerror);

    }

    function ttttt(){
        /**
         *
         * 1.逻辑。 先检测一遍有没有错。
         * 2.再提交到数据库。
         * 3.再批量添加标题和 其他内容。    并更改状态。
         * 4.确认无误后提交到百家号。
         *
         **/
        $path = '/Volumes/50/video';
        $dir = scandir($path);
        $file= file_get_contents($path.'/word.txt');
        $word = explode(PHP_EOL,$file);
        foreach($word as $key=>$value){
            $words[] = trim($value);
        }

//        if(is_array($words) ){
//            echo '数组';
//        }else{
//            echo '不是数组';
//        }

        foreach ($dir as $value) {
            if ($value == '.' || $value == '..' || !strstr($value,'mp4')) {
                continue;
            } else {
                $filename = str_replace(strrchr($value, "."),"",$value);
//                $imgstatus = $this->checkFileExists($path.$filename.'.png');
//                $imgstatus2 = $this->checkFileExists($path.$filename.'.jpg');
                   $video = strtolower($filename);
                   if(in_array(trim($video),$words)){
                       $do = unlink($path.'/'.$value);
                        if($do){
                            echo '删除'.$value.'<span style="color:red;">成功</span><br>';
                        }else{
                            echo '删除'.$value.'<span style="color:green;"失败</span><br>';
                        }
                   }else{
                       $video = '没有找到'.$video.'<br>';
                   }
                   echo $value.'<br>';
                   echo $video . '<br>';

            }
        }

                echo '<pre>';
        echo '<hr>';
        echo $word['0'];
            print_r($word);
        echo '</pre>';





    }


    function delstatus1(){
        $temp = Db::name('shipin')
            ->where('status', '=','1')
            ->orderRaw('rand()')
            ->select();
        $count= count($temp);

        foreach($temp as $key => $item){
            $file =  urldecode($item['shipinpath']);
            $img = str_replace('.mp4','.jpg',$file);

            echo $file;
            echo '<br>';
            echo $img;
            echo '<br>';

            if(file_exists($file)){
                unlink($file);
            }else{
                echo '啥也不干';
            }

            if(file_exists($file)) {
                unlink($img);
            }else{
                echo '啥也不干';
            }
        }

    }

    function testapi(){//读取文件夹入shipin库。 然后等方法shipinapi2 一条一条提取到正式表cmf_user_video。另外 还需要建立用户。
//        $path = '/Users/a50/Downloads/Dear-迪丽热巴';
        $path = '/home/shipin';
        //1、首先先读取文件夹
        $this->list_file($path,'qinggan');
    }

    function rewuapi(){//读取文件夹入shipin库。 然后等方法shipinapi2 一条一条提取到正式表cmf_user_video。另外 还需要建立用户。
//        $path = '/Users/a50/Downloads/Dear-迪丽热巴';
         echo 'test';
        $path = '/home/rewu';
        //1、首先先读取文件夹
        $this->list_file($path,'rewu');
    }

    function qingganapi(){//读取文件夹入shipin库。 然后等方法shipinapi2 一条一条提取到正式表cmf_user_video。另外 还需要建立用户。
//        $path = '/Users/a50/Downloads/Dear-迪丽热巴';
        $path = '/home/qinggan';
        //1、首先先读取文件夹
        $this->list_file($path,'qinggan');
    }

    function tiyuapi(){//读取文件夹入shipin库。 然后等方法shipinapi2 一条一条提取到正式表cmf_user_video。另外 还需要建立用户。
//        $path = '/Users/a50/Downloads/Dear-迪丽热巴';
        $path = '/home/tiyu';
        //1、首先先读取文件夹
        $this->list_file($path,'tiyu');
    }

    function dianyingapi(){//读取文件夹入shipin库。 然后等方法shipinapi2 一条一条提取到正式表cmf_user_video。另外 还需要建立用户。
//        $path = '/Users/a50/Downloads/Dear-迪丽热巴';
        $path = '/home/dianying';
        //1、首先先读取文件夹
        $this->list_file($path,'dianying');
    }

    function qicheapi(){//读取文件夹入shipin库。 然后等方法shipinapi2 一条一条提取到正式表cmf_user_video。另外 还需要建立用户。
//        $path = '/Users/a50/Downloads/Dear-迪丽热巴';
        $path = '/home/qiche';
        //1、首先先读取文件夹
        $this->list_file($path,'qiche');
    }

    function lizhiapi(){//读取文件夹入shipin库。 然后等方法shipinapi2 一条一条提取到正式表cmf_user_video。另外 还需要建立用户。
//        $path = '/Users/a50/Downloads/Dear-迪丽热巴';
        $path = '/home/lizhi';
        //1、首先先读取文件夹
        $this->list_file($path,'lizhi');
    }

    function youxiapi(){//读取文件夹入shipin库。 然后等方法shipinapi2 一条一条提取到正式表cmf_user_video。另外 还需要建立用户。
//        $path = '/Users/a50/Downloads/Dear-迪丽热巴';
        $path = '/home/youxi';
        //1、首先先读取文件夹
        $this->list_file($path,'youxi');
    }

    function list_file($date,$type){
        //1、首先先读取文件夹
        $temp=scandir($date);
        //遍历文件夹
        foreach($temp as $v){
            $a=$date.'/'.$v;
            if(is_dir($a)){//如果是文件夹则执行

                if($v=='.' || $v=='..'){//判断是否为系统隐藏的文件.和..  如果是则跳过否则就继续往下走，防止无限循环再这里。
                    continue;
                }
//                echo "<font color='red'>$a</font>","<br/>"; //把文件夹红名输出

                $this->list_file($a,$type);//因为是文件夹所以再次调用自己这个函数，把这个文件夹下的文件遍历出来
            }else{

                if(strstr($a , '.mp4')) {
                echo $a,"<br>";

                //这里检查是否有重复
//                    $a = str_replace("/Users/a50/Downloads/Dear-迪丽热巴","",$a);
                echo $tempdatA['shipinpath'] = urlencode($a);
                echo '<br>';


                    echo '<pre>';
                    $temp = Db::name('shipin')
                        ->where('shipinpath', $tempdatA['shipinpath'])
                        ->find();
//                    print_r($temp);
                    echo '</pre>';

                    if ($temp) {
                        echo '找到了就不添加';
                    } else {
                        echo '没找到'.$tempdatA['shipinpath'].'就添加<br>';
//                $temp = Db::name('shipin')
//                    ->where('shipinpath', $tempdatA['shipinpath'])
//                    ->find();
//                if ($temp) {
//                            $a = str_replace("/Users/a50/Downloads/Dear-迪丽热巴","",$a);
//                    echo $tempdatA['shipinpath'] = urldecode($a);
                        echo $tempdatA['shipinpath'] = urlencode($a);
                             $tempdatA['video_type'] = $type;

                        $do = Db::name('shipin')
                            ->save($tempdatA);
//                }else{
//                    echo '有了，过掉.<br>';
//                }
                    }
                }


            }

        }
    }


    function shipinapi2(){ // 一条一条提取到正式表cmf_user_video。另外 还需要建立用户。
        echo '<pre>';
        $this->proStartTime();
        $t = array("dianying","youxi","tiyu","lizhi","qiche","qinggan","rewu");
        echo $nt = rand(0,6);
        echo '<br>';
        echo $ctype = $t[$nt];
        echo '<br>';
        $temp = Db::name('shipin')
            ->where('status', '=','0')
           // ->where('video_type', '=', $ctype)
            ->orderRaw('rand()')
            ->find();
        $this->proEndTime();
        if($temp) {

            $video_type = $temp['video_type'];
            echo '分类';
            echo $video_type;
            echo '<br>';
            $id = $temp['id'];
            echo $shipinpath = urldecode($temp['shipinpath']);
            echo '<br>';
            echo $imgpath = str_replace(".mp4", ".jpg", $shipinpath);


            $temp1 = explode('/', $shipinpath);


            echo '<hr>';
            $title = str_replace('.mp4', '', end($temp1));
            $user = $temp1[count($temp1) - 2];

            echo $title;
            echo '<br>去掉非普通字符:';
            echo $this->filter_Emoji($title);
            echo '<hr>';
            echo '<br>名字:';
            echo $user;// 新建立用户。 并且返回id

            echo "<br>去掉特殊字符后的user名:";
            $user =  $this->filter_Emoji($user);

            echo $user;

            $temp = Db::table('cmf_user')
                ->where('user_nicename', $user)
                ->find();
//                    print_r($temp);

            $this->proEndTime();
            echo '</pre>';

            if ($temp) {
                echo '找到了就不添加直接使用这个id' . $temp['id'];

                $video['uid'] = $temp['id'];

            } else {
                echo '没找到' . $user . '就添加<br>';

                //新增用户

                $userinfo['user_login'] = $user;
                $userinfo['user_pass'] = '###ea1e6729b1bcd5575033baf0e8cd127b';
                $userinfo['user_nicename'] = $user;
                $userinfo['user_email'] = '';
                $userinfo['user_url'] = '';
                $userinfo['avatar'] = '/default.png';
                $userinfo['avatar_thumb'] = '/default_thumb.png';
                $userinfo['sex'] = 2;
                $userinfo['age'] = 18;
                $userinfo['birthday'] = '2000-01-01';
                $userinfo['signature'] = '这家伙很懒，什么都没留下';
                $userinfo['last_login_ip'] = '';
                $userinfo['last_login_time'] = '';
                $userinfo['create_time'] = strtotime("-10 day");
                $userinfo['user_activation_key'] = '';
                $userinfo['user_status'] = 1;
                $userinfo['score'] = 0;
                $userinfo['user_type'] = 2;
                $userinfo['coin'] = 0;
                $userinfo['mobile'] = '';
                $userinfo['weixin'] = '';
                $userinfo['province'] = '';
                $userinfo['city'] = '';
                $userinfo['area'] = '';
                $userinfo['isrecommend'] = '0';
                $userinfo['openid'] = '';
                $userinfo['login_type'] = '';
                $userinfo['isauth'] = '';
                $userinfo['code'] = '4U39RT';
                $userinfo['is_ad'] = '0';
                $userinfo['source'] = 'android';
                $userinfo['votes'] = '5';
                $userinfo['vip_endtime'] = '0';
                $userinfo['mobileid'] = '99ff7cbbfc82501a394697467d54646f';
                $userinfo['ip'] = '466210525';
                $userinfo['votestotal'] = '0';
                $userinfo['issuper'] = '0';
                $userinfo['consumption'] = '0';
                $userinfo['balance'] = '0.00';
                $userinfo['balance_total'] = '0.00';
                $userinfo['balance_consumption'] = '0.00';
                $userinfo['recommend_time'] = '0';
//            print_r($userinfo);
                $uid = Db::table('cmf_user')->insertGetId($userinfo);

                $video['uid'] = $uid;
            }
            $this->proEndTime();
            echo '看这里';
            echo '<hr>';
            echo $shipin = $this->shipinapi($shipinpath, md5($shipinpath) . '.mp4');
            echo '<hr>';
            echo '<hr><hr>';
            $this->proEndTime();
            echo $img = $this->shipinapi($imgpath, md5($imgpath) . '.jpg');
            $img2 = $img;
            $shipin2 = $shipin;
            echo 'shipin';
            echo "here";
            echo $shipin2;
            echo "here";
            $this->proEndTime();
            $temp2 = Db::table('cmf_user_video')
                ->where('href', $shipin)
                ->find();
//                    print_r($temp);
            echo '</pre>';

            if (!$temp2) {//没有这个视频地址。 则可以新增
                echo '不存在视频地址 就可以上传了<br>';



                if($video_type == 'qinggan'){
                    $classid = 18;
                }else if($video_type == 'tiyu'){
                    $classid = 6;
                }else if($video_type == 'qiche'){
                    $classid = 17;
                }else if($video_type == 'youxi'){
                    $classid = 4;
                }else if($video_type == 'rewu'){
                    $classid = 13;
                }else if($video_type == 'lizhi'){
                    $classid = 3;
                }else if($video_type == 'dianying'){
                    $classid = 5;
                }else{
                    echo 'error';
                    exit();
                }

                $video['title'] = $this->filter_Emoji($title);
                $video['thumb'] = $img2;
                $video['thumb_s'] = $img2;
                $video['href'] = $shipin2;
                $video['href_w'] = $shipin2;
                $video['likes'] = rand(50, 300);
                $video['views'] = rand(50, 300);
                $video['comments'] = 0;
                $video['steps'] = rand(0, 39);
                $video['shares'] = rand(0, 50);
                $video['addtime'] = strtotime("-2 day");
                $video['lat'] = 24.526012;
                $video['lng'] = 118.155776;
                $video['city'] = '厦门';
                $video['isdel'] = 0;
                $video['status'] = 1;
                $video['music_id'] = 0;
                $video['classid'] = $classid;
                $video['xiajia_reason'] = '';
                $video['show_val'] = rand(500, 10000);
                $video['watch_ok'] = 1;
                $video['is_ad'] = 0;
                $video['ad_endtime'] = 0;
                $video['ad_url'] = '';
                $video['orderno'] = 0;
                $video['labelid'] = 0;
                $video['isgoods'] = 0;
                $video['ispay'] = 0;

                echo '<pre>';
                print_r($video);
                echo '</pre>';
                $this->proEndTime();
                $uid = Db::table('cmf_user_video')->insertGetId($video);
                if ($uid) {
                    Db::name('shipin')
                        ->where('id', $id)
                        ->update(['status' => '1']);
                    echo '成功插入一条';

                    //删除视频文件
                    if (!unlink($shipinpath))
                    {
                        echo ("Error deleting $shipinpath");
                    }
                    else
                    {
                        echo ("Deleted $shipinpath");
                    }

                    //删除图片文件
                    if (!unlink($imgpath))
                    {
                        echo ("Error deleting $imgpath");
                    }
                    else
                    {
                        echo ("Deleted $imgpath");
                    }
                    $this->proEndTime();

                }else{
                    echo '没有成功插入';
                }
            } else {
                echo $title . '存在了,那就标记过了';


                Db::name('shipin')
                    ->where('id', $id)
                    ->update(['status' => '1']);
                $this->proEndTime();
            }

        }else{
            echo '没有数据了';
        }

        exit();









    }
    function shipinapi($local_path,$local_name){//视频
//        exit();
        include dirname(__FILE__) . '/coss/vendor/autoload.php';

        $secretId = "AKID3uUptgDTTBcmgKgnfGaeRyESSCiz0mJb"; //"云 API 密钥 SecretId";
        $secretKey = "4sRjjSwA7oGRM0NUKJ6fxyiCQN4VgaDZ"; //"云 API 密钥 SecretKey";
        $region = "ap-guangzhou"; //设置一个默认的存储桶地域
        $cosClient = new \Qcloud\Cos\Client(
            array(
                'region' => $region,
                'schema' => 'https', //协议头部，默认为http
                'credentials'=> array(
                    'secretId'  => $secretId ,
                    'secretKey' => $secretKey)));
       // $local_path = "/Users/a50/Downloads/word2.txt";//改为文件列表

        $printbar = function($totolSize, $uploadedSize) {
            printf("uploaded [%d/%d]\n", $uploadedSize, $totolSize);
        };

        try {
            $result = $cosClient->upload(
                $bucket = 'duomiao-1252699049', //格式：BucketName-APPID
                $key = $local_name,#资源id # 就这样子。 判断文件夹内有多少的文件。 然后传到oss。再传数据库里
                $body = fopen($local_path, 'rb')
            /*
            $options = array(
                'ACL' => 'string',
                'CacheControl' => 'string',
                'ContentDisposition' => 'string',
                'ContentEncoding' => 'string',
                'ContentLanguage' => 'string',
                'ContentLength' => integer,
                'ContentType' => 'string',
                'Expires' => 'string',
                'GrantFullControl' => 'string',
                'GrantRead' => 'string',
                'GrantWrite' => 'string',
                'Metadata' => array(
                    'string' => 'string',
                ),
                'ContentMD5' => 'string',
                'ServerSideEncryption' => 'string',
                'StorageClass' => 'string', //存储类型
                'Progress'=>$printbar, //指定进度条
                'PartSize' => 10 * 1024 * 1024, //分块大小
                'Concurrency' => 5 //并发数
            )
            */
            );
            // 请求成功

            return $result['Location'];


        } catch (\Exception $e) {
            // 请求失败
            echo($e);
        }





    }

    function checkIfExists($cover_images)
    {
        $temp = Db::name('videoinfo')
            ->where('cover_images', (string)$cover_images)
            ->find();
        if ($temp) {
            return true;
        } else {
            return false;
        }
    }
    function add_one($temp){
        $do = Db::name('videoinfo')
            ->save($temp);
        return $do;
    }
    function checkFileExists($file){
        if(file_exists($file))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function getDir($path)
    {

        if (is_dir($path)) {

            $dir = scandir($path);
            foreach ($dir as $value) {
                $sub_path = $path . '/' . $value;
                $subpath = ltrim($path,'/file').'/';
                $subpath = ltrim($subpath,'/');
                if ($value == '.' || $value == '..') {
                    continue;
                } else if (is_dir($sub_path)) {
                    //echo '目录名:' . $value . '<br/>';
                    $this->getDir($sub_path);
                } else {
                    //.$path 可以省略，直接输出文件名
                    echo ' 文件: ' . $subpath.$value . ' 下载地址:<a href="http://f1.qilaixiu.com/' . $value . '">http://f1.qilaixiu.com/' . $subpath.$value . '</a><hr/>';
                }
            }
        }
    }

    function speedlist()
    {
        return View();
    }

    function get_speed()
    {
        $where[] = ['name', '=', 'TXlo'];
        $list = Db::name('net')
            ->where($where)
            ->order('create_time desc')
            ->select()
            ->toArray();
        $in_speed = array();
        $out_speed = array();
        foreach ($list as $key => $item) {
            $create_time = $item['create_time'];
            $create_time = date("Y-m-d H:i:s", (int)$create_time);
            $speed_in = (int)$item['net1']/1024;
            $speed_out = (int)$item['net2']/1024;
            $in_speed[$key][] = $create_time;
            $in_speed[$key][] = $speed_in;
            $out_speed[$key][] = $create_time;
            $out_speed[$key][] = $speed_out;
        }
        $result['in_speed'] = $in_speed;
        $result['out_speed'] = $out_speed;
        echo json_encode($result);
    }

    function getsysmd5(){
        $list = Db::name('server')
            ->order('create_time desc')
            ->field('ip_remark')
            ->select()
            ->toArray();
         $create_time = time();
         $result = array();
         foreach($list as $item){//循环判断是否有相关的文件
             $ip = $item['ip_remark'];
             $file = "/Volumes/51/bb/sbin.md5.{$ip}";
             if (file_exists($file)) {
                 $file = fopen($file, "r");
                 $user=array();
                 $i=0;
                 while(! feof($file))
                 {
                     $user[$i]= fgets($file);//fgets()函数从文件指针中读取一行
                     $i++;
                 }
                 fclose($file);
                 $user=$this->merge_spaces(array_filter($user));
                 foreach($user as $key=>$item){
                     $temp =  explode(" ",$item);
                     if(@$temp['1']!=='' || empty(@$temp['1'])){
                        $result['sysmd5'] =  @$temp['0'];
                         $result['path'] = @$temp['1'];
                         $result['ip_remark'] = $ip;
                         $result['create_time'] = $create_time;
                         $result['md5'] = md5($ip.$temp['1']);
                         try {
                             // 这里是主体代码
                             $do = Db::name('sysmd5')->save($result);
                         } catch(\Throwable $e){
                             // 这是进行异常捕获
                             print_r($e);
                         }

                     }
                 }
             }
         }
    }

    function getsysmd5_simple(){
            $ip = '176';
            $file = "/Volumes/51/bb/sbin.md5.{$ip}";
            if (file_exists($file)) {
                $file = fopen($file, "r");
                $user=array();
                $i=0;
                while(! feof($file))
                {
                    $user[$i]= fgets($file);//fgets()函数从文件指针中读取一行
                    $i++;
                }
                fclose($file);
                $user=$this->merge_spaces(array_filter($user));
                $create_time = time();
                foreach($user as $key=>$item){
                    $temp =  explode(" ",$item);
                    if(@$temp['1']!=='' || empty(@$temp['1'])){
                        $result['sysmd5'] =  @$temp['0'];
                        $result['path'] = @$temp['1'];
                        $result['ip_remark'] = $ip;
                        $result['create_time'] = $create_time;
                        $result['md5'] = md5($ip.$temp['1']);
                        try {
                            // 这里是主体代码
                            $do = Db::name('sysmd5')->save($result);
                        } catch(\Throwable $e){
                            // 这是进行异常捕获
                            print_r($e);
                        }

                    }
                }
            }
    }
    function addsysmd5_simple(){
        $this->ifLogin();
        if (Request::isAjax()) {
            $data = Request::post('data');
            $say = array();
            foreach($data as $k => $i){//这边可以循环记录。要先检测是否存在。 存在则不添加。
                /****
                 *
                 * 这里需要判断 是新增的还是 需要更改的。  如果是新增的就新增。 如果是 更改的。就找到相应id 然后更改
                 */
//                $say['id']= $i['id'];
//                $say['ip_remark']= $i['ip_remark'];
//                $say['content']= $i['content'];
                $ip_remark = $i['ip_remark'];
                $result = $i['content'];
                $id = $i['id'];
                $result = explode("##",$result);
                $result = array_filter($result);
                $result  = str_replace("command:",'',$result);
                $result = str_replace("old:","",$result);
                $result = str_replace("check:","",$result);
                foreach($result as $k=>$item){
                    $temp2 = explode("#",$item);//这边切割后 有两个 。 然后再通过 ｜ 再切割。
                    /*
                     * 格式 path , oldmd5 ， check地址: path|checkmd5
                     *
                     * 两种
                     * 1  old:# check:/sbin/e2fsck|a408cdf8e748448c8734fa24e8e6c893##
                     * 2  command:/sbin/e2fsck#old:# check:/sbin/e2fsck|a408cdf8e748448c8734fa24e8e6c893##
                     */
                    $old = explode('|',$temp2['0']);
                    $check=explode('|',$temp2['1']);

                    $temp[] = @$old['0'];//path
                    $temp[] = @$old['1'];//md5
                    $temp[] = @$check['0'];//path
                    $temp[] = @$check['1'];//  md5
                    $temp['ip_remark'] = $ip_remark;
                    if(@$old['1']){
                        $temp['say'][] = '旧的,只是被改动了,则更新';
                        $result1['sysmd5'] = $check['1'];
                        $result1['path'] = $check['0'];
                        $result1['ip_remark'] = $ip_remark;
                        $result1['create_time'] = time();
                        $md5 = md5($ip_remark.trim($old['1']));
                        $result1['md5'] = md5($ip_remark.$check['1']);

                        $temp['md5'] = md5($ip_remark.$check['1']);
                        $result1['sysmd5'] = trim($check['1']);

                        $where['md5'] = md5($ip_remark.$check['1']);
                        $where['ip_remark'] = $ip_remark;
                        //查找是否存在
                        $tm2 = Db::name('sysmd5')->where($where)->find();
                        $tm['md5'] = $md5;
                        if($tm2){
                            $tm[] = '存在就更新'.$old['1'];
                            $result1['id'] = $tm2['id'];
                            $do = Db::name('sysmd5')->save($result1);

                            $status['id'] = $id;
                            $status['status'] = 3;
                            $do = Db::name('md5log')->save($status);
//                            if($do == true){
//                                $temp['result'][] = '操作成功';
//                            }elseif($do == '0'){
//                                $temp['result'][] = '没有修改的地方';
//                            }elseif($do == false){
//                                $temp['result'][] = '操作失败';
//                            }
                        }else{
                            $tm[] = '不存在，就新增'.json_encode($tm2);
                            $tm[] = json_encode($result1);
                            //$result['id'] = $tm2['id'];
                            $do = Db::name('sysmd5')->save($result1);


                        }
//

                    }else{
                        $temp['say'][] = '没有旧的。 说明是新增的，查看是否技术安装，否则可疑,则新增';
                        $result2['sysmd5'] = $check['1'];
                        $result2['path'] = $check['0'];
                        $result2['ip_remark'] = $ip_remark;
                        $result2['create_time'] = time();
                        $md5 = md5($ip_remark.$old['1']);
                        $result2['md5'] = md5($ip_remark.$check['1']);
                        $result2['sysmd5'] = trim($check['1']);
                        $temp['md5'] = md5($ip_remark.$check['1']);
                        $tm2 = Db::name('sysmd5')->where('md5',md5($ip_remark.$check['1']))->find();
                        if($tm2){
                            $tm[] = '存在,就更新'.$check['0'];//
                            $result2['id'] = $tm2['id'];
                            $do = Db::name('sysmd5')->save($result2);
                            $status['id'] = $id;
                            $status['status'] = 3;
                            $do = Db::name('md5log')->save($status);
                        }else{
                            $tm[] = '不存在,添加入库';
                            $do = Db::name('sysmd5')->save($result2);
                            $status['id'] = $id;
                            $status['status'] = 3;
                            $do = Db::name('md5log')->save($status);
                        }

                    }
                }
//                $item  = str_replace("command:",'',$result);
//                $item = str_replace("old:","",$item);
//                $item = str_replace("check:","",$item);
                //$t = explode("#",$item);
                //$say = $t;
                $say = $tm;
                //$say['hehe'] = array_filter($t);
            }
            $this->json_back(1,$say,'');
        }

    }
    function addsysmd5_simple_one(){
        $this->ifLogin();
        if (Request::isAjax()) {
            $data = Request::post('data');
            $say = array();
            //这边可以循环记录。要先检测是否存在。 存在则不添加。
                /****
                 *
                 * 这里需要判断 是新增的还是 需要更改的。  如果是新增的就新增。 如果是 更改的。就找到相应id 然后更改
                 */
//                $say['id']= $i['id'];
//                $say['ip_remark']= $i['ip_remark'];
//                $say['content']= $i['content'];
                $ip_remark = $data['ip_remark'];
                $result = $data['content'];
                $id = $data['id'];
                $result = explode("##",$result);
                $result = array_filter($result);
                $result  = str_replace("command:",'',$result);
                $result = str_replace("old:","",$result);
                $result = str_replace("check:","",$result);
                foreach($result as $k=>$item){
                    $temp2 = explode("#",$item);//这边切割后 有两个 。 然后再通过 ｜ 再切割。
                    /*
                     * 格式 path , oldmd5 ， check地址: path|checkmd5
                     *
                     * 两种
                     * 1  old:# check:/sbin/e2fsck|a408cdf8e748448c8734fa24e8e6c893##
                     * 2  command:/sbin/e2fsck#old:# check:/sbin/e2fsck|a408cdf8e748448c8734fa24e8e6c893##
                     */
                    $old = explode('|',$temp2['0']);
                    $check=explode('|',$temp2['1']);

                    $temp[] = @$old['0'];//path
                    $temp[] = @$old['1'];//md5
                    $temp[] = @$check['0'];//path
                    $temp[] = @$check['1'];//  md5
                    $temp['ip_remark'] = $ip_remark;
                    if(@$old['1']){
                        $temp['say'][] = '旧的,只是被改动了,则更新';
                        $result1['sysmd5'] = $check['1'];
                        $result1['path'] = $check['0'];
                        $result1['ip_remark'] = $ip_remark;
                        $result1['create_time'] = time();
                        $md5 = md5($ip_remark.trim($old['1']));
                        $result1['md5'] = md5($ip_remark.$check['1']);

                        $temp['md5'] = md5($ip_remark.$check['1']);
                        $result1['sysmd5'] = trim($check['1']);

                        $where['md5'] = md5($ip_remark.$check['1']);
                        $where['ip_remark'] = $ip_remark;
                        //查找是否存在
                        $tm2 = Db::name('sysmd5')->where($where)->find();
                        $tm['md5'] = $md5;
                        if($tm2){
                            $tm[] = '存在就更新'.$old['1'];
                            $result1['id'] = $tm2['id'];
                            $do = Db::name('sysmd5')->save($result1);

                            $status['id'] = $id;
                            $status['status'] = 3;
                            $do = Db::name('md5log')->save($status);
//                            if($do == true){
//                                $temp['result'][] = '操作成功';
//                            }elseif($do == '0'){
//                                $temp['result'][] = '没有修改的地方';
//                            }elseif($do == false){
//                                $temp['result'][] = '操作失败';
//                            }
                        }else{
                            $tm[] = '不存在，就新增'.json_encode($tm2);
                            $tm[] = json_encode($result1);
                            //$result['id'] = $tm2['id'];
                            $do = Db::name('sysmd5')->save($result1);


                        }
//

                    }else{
                        $temp['say'][] = '没有旧的。 说明是新增的，查看是否技术安装，否则可疑,则新增';
                        $result2['sysmd5'] = $check['1'];
                        $result2['path'] = $check['0'];
                        $result2['ip_remark'] = $ip_remark;
                        $result2['create_time'] = time();
                        $md5 = md5($ip_remark.$old['1']);
                        $result2['md5'] = md5($ip_remark.$check['1']);
                        $result2['sysmd5'] = trim($check['1']);
                        $temp['md5'] = md5($ip_remark.$check['1']);
                        $tm2 = Db::name('sysmd5')->where('md5',md5($ip_remark.$check['1']))->find();
                        if($tm2){
                            $tm[] = '存在,就更新'.$check['0'];//
                            $result2['id'] = $tm2['id'];
                            $do = Db::name('sysmd5')->save($result2);
                            $status['id'] = $id;
                            $status['status'] = 3;
                            $do = Db::name('md5log')->save($status);
                        }else{
                            $tm[] = '不存在,添加入库';
                            $do = Db::name('sysmd5')->save($result2);
                            $status['id'] = $id;
                            $status['status'] = 3;
                            $do = Db::name('md5log')->save($status);
                        }

                    }
                }
//                $item  = str_replace("command:",'',$result);
//                $item = str_replace("old:","",$item);
//                $item = str_replace("check:","",$item);
                //$t = explode("#",$item);
                //$say = $t;
                $say = $tm;
                //$say['hehe'] = array_filter($t);

            $this->json_back(1,$say,'');
        }
    }
    function md5(){
        echo md5('211/sbin/accessdb
');
    }
    function sysmd5list(){
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $map = input('post.');
            $where = array();

            if (@$map['ip'] != '') $where[] = ['ip_remark', '=', $map['ip']];
            if (@$map['path'] != '') $where[] = ['path', 'like', '%' . $map['path'] . '%'];
            $list = Db::name('sysmd5')
                ->where($where)
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();

            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();

    }

    function sysmd5log_one(){
            $temp = Db::name('md5log')
                ->where('status',1)
                ->find();
            $this->json_back(1,$temp,'');
    }

    function sysmd5log_checkone(){//检测是否已经修改完毕。 否则会一直报警最多十次
        $temp = Db::name('md5log')
            ->where('status',1)
            ->find();
        if(!$temp){
            echo '没有记录，不用工作了';
            exit();
        }
        echo '<pre>';
        echo $ip = $temp['ip_remark'];
        $result = explode("##",$temp['content']);
        $result = (array_filter($result));
        $true = true;
        foreach($result as $k=>$item){
            $item = str_replace("old:","",$item);
            $item = str_replace("check:","",$item);
            $t = explode("#",$item);
            $check =  explode('|',$t[1]);//check
            $content = '';
            if($t[0]!==''){//不为空
                $old = explode('|',$t[0]);//old
#                $content.= $check['0'].'原来的值:'.$old['1'].'检测结果为:'.$check['1'].' ';
                $sysmd5 = @$old[1];
                $result = $this->getfilearray($ip);
                $old[0] = str_replace("command:",'',$old[0]);
                $path = @$old[0];
                foreach($result as $key=>$i){

                    if(trim($i['path']) == trim((string)$path)){
                        if((string)$i['sysmd5'] == (string)$old[1]){//一致的话。 就修改状态为2
                            echo $i['sysmd5'];
                            echo $path;
                            #  $say[] =  $path .' 一致.';//一致。 修改状态。
                        }else{
                            echo  $content .=  'command:'.$path .'|old:'.$old['1'].'#check:'.$path.'|'.$i['sysmd5'].'##';
                            $true = false;
                        }
                    }
                }
            }else{//原不存在的。 则就是检测是否存在
                $content.= $check['0'].'是新增的 ';
                $path = $check['0'];
                $result = $this->getfilearray($ip);
                foreach($result as $key=>$i){
                    if(trim($i['path']) == trim((string)$path)){
                        $true = false;//如果存在就为false。
                        echo '说明有新增的';
                    }else{
                        echo '检测不到了,说明没有新增的了';
                    }
                }
            }
            echo '<hr>';
            if($true){//如果false。 新增记录。然后更改状态
                echo 'true';
                $mdslog['status'] = 2;
                echo $mdslog['id'] = $temp['id'];
                $do =  Db::name('md5log')->save($mdslog);
            }else{//如果为true。则更改状态。
                echo 'false';

                $mdslog['status'] = 2;
                $mdslog['id'] = $temp['id'];
                $do =  Db::name('md5log')->save($mdslog);

                $mdslognew['ip_remark']= $ip;
                $mdslognew['md5'] = md5($ip.$content);
                $mdslognew['create_time'] = time();
                $mdslognew['status'] = 1;
                $mdslognew['content'] = $content;
                $do =  Db::name('md5log')->save($mdslognew);
            }
        }
    }

    function test222(){


        $redis = $this->redis;
        //        echo $redis->ping();
        //$redis->set('test','hello redis');
        $redis->hSet('user', 'realname', '2222');



        if($redis->hGet('user','realn2ame')){
            echo '有';
        }else{
            echo '无';
        }
        echo '<hr>';
        if($redis->get('str2')){//如果有就直接读取。
            echo 'you str';
        }else{//如果没有就数据库拿。 然后记录在redis里面。
            echo '没有 str';
            $redis->set('str2','this is 222redis_str');
        }
        echo '<hr>';

        var_dump($redis->get('str'));

            print_r($redis->hGetAll('user'));
        echo  $redis->hGet('user', 'realname');


        $this->print_hr();


        $redis->set('test',"1111111111111");

        $redis->setnx('test',"22222222");

        echo $redis->get('test'); //结果：1111111111111

        $redis->delete('test');

        $redis->setnx('test',"22222222");

        echo $redis->get('test'); //结果：22222222



        $this->print_hr();
        echo '是否存在';
        echo $redis->exists('test22222'); //结果：bool(true)



        $this->print_hr();
        $redis->set('test',"123");

//        var_dump($redis->incr("test")); //结果：int(124)

        var_dump($redis->incr("test")); //结果：int(125)

        var_dump($redis->incr("test")); //结果：int(125)
        var_dump($redis->incr("test")); //结果：int(125)
        var_dump($redis->incr("test")); //结果：int(125)

        var_dump($redis->decr("test")); //结果：int(122)

        var_dump($redis->decr("test")); //结果：int(121)



        $this->print_hr();

        $redis->set('test1',"1");

        $redis->set('test2',"2");

        $result = $redis->getMultiple(array('test1','test2'));

        print_r($result); //结果：Array ( [0] => 1 [1] => 2 )



        $this->print_hr();
        $redis->delete('test');

        var_dump($redis->lpush("test","111")); //结果：int(1)

        var_dump($redis->lpush("test","222")); //结果：int(2)


        $this->print_hr();

        $redis->delete('test');

        var_dump($redis->lpush("test","111")); //结果：int(1)

        var_dump($redis->lpush("test","222")); //结果：int(2)

        var_dump($redis->rpush("test","333")); //结果：int(3)

        var_dump($redis->rpush("test","444")); //结果：int(4)



        $this->print_hr();
        echo '返回和移除列表的第一个元素';
        $redis->delete('test');

        $redis->lpush("test","131");
        $redis->lpush("test","818");

        $redis->rpush("test","19");

        $redis->rpush("test","3");

        $redis->rpush("test","444");

        $redis->lpush("test","122");

        var_dump($redis->lpop("test")); //结果：string(3) "222"
        var_dump($redis->lpop("test")); //结果：string(3) "222"
        var_dump($redis->lpop("test")); //结果：string(3) "222"
        var_dump($redis->lpop("test")); //结果：string(3) "222"
        var_dump($redis->lpop("test")); //结果：string(3) "222"
        var_dump($redis->lpop("test")); //结果：string(3) "222"
        echo 'heheh';


        $this->print_hr();

        $redis->delete('test');

        $redis->lpush("test","111");

        $redis->lpush("test","222");

        var_dump($redis->lget("test",1)); //结果：string(3) "111"

        var_dump($redis->lset("test",1,"333")); //结果：bool(true)

        var_dump($redis->lget("test",1)); //结果：string(3) "333"


        $this->print_hr();
        $redis->delete('test');

        $redis->lpush("test","111");

        $redis->lpush("test","222");

        print_r($redis->lgetrange("test",0,-1)); //结果：Array ( [0] => 222 [1] => 111 )



        $this->print_hr();
        $redis->delete('test');

        $redis->lpush('test','a');

        $redis->lpush('test','b');

        $redis->lpush('test','c');

        $redis->rpush('test','a');


        echo 'here rpush';
        echo '<br>';

        print_r($redis->lgetrange('test', 0, -1)); //结果：Array ( [0] => c [1] => b [2] => a [3] => a )

        var_dump($redis->lremove('test','a',2)); //结果：int(2)

        print_r($redis->lgetrange('test', 0, -1)); //结果：Array ( [0] => c [1] => b )


        $this->print_hr();
        $redis->delete('test');

        var_dump($redis->sadd('test','111')); //结果：bool(true)

        var_dump($redis->sadd('test','333')); //结果：bool(true)

        print_r($redis->sort('test')); //结果：Array ( [0] => 111 [1] => 333 )


        $this->print_hr();

        $redis->delete('test');

        $redis->sadd('test','111');

        $redis->sadd('test','333');

        $redis->sremove('test','111');

        print_r($redis->sort('test')); //结果：Array ( [0] => 333 )




        $this->print_hr();

        $redis->delete('test');

        $redis->delete('test1');

        $redis->sadd('test','111');

        $redis->sadd('test','333');

        $redis->sadd('test1','222');

        $redis->sadd('test1','444');

        $redis->smove('test',"test1",'111');

        print_r($redis->sort('test1')); //结果：Array ( [0] => 111 [1] => 222 [2] => 444 )



        $this->print_hr();

        $redis->delete('test');

        $redis->sadd('test','111');

        $redis->sadd('test','112');

        $redis->sadd('test','113');

        var_dump($redis->scontains('test', '111')); //结果：bool(true)


        $this->print_hr();
        $redis->delete('test');

        $redis->sadd('test','111');

        $redis->sadd('test','112');

        echo $redis->ssize('test'); //结果：2




        $this->print_hr();

        $redis->delete('test');

        $redis->sadd("test","111");

        $redis->sadd("test","222");

        $redis->sadd("test","333");

        var_dump($redis->spop("test")); //结果：string(3) "333"




        $this->print_hr();
        $redis->delete('test');

        $redis->sadd("test","111");

        $redis->sadd("test","222");

        $redis->sadd("test","333");

        $redis->sadd("test1","111");

        $redis->sadd("test1","444");

        var_dump($redis->sinter("test","test1")); //结果：array(1) { [0]=> string(3) "111" }



        $redis->delete('test');

        $redis->sadd("test","111");

        $redis->sadd("test","222");

        $redis->sadd("test","333");

        $redis->sadd("test1","111");

        $redis->sadd("test1","444");

        var_dump($redis->sinterstore('new',"test","test1")); //结果：int(1)

        var_dump($redis->smembers('new')); //结果:array(1) { [0]=> string(3) "111" }




        $this->print_hr();
        $redis->delete('test');

        $redis->sadd("test","111");

        $redis->sadd("test","222");

        $redis->sadd("test","333");

        $redis->sadd("test1","111");

        $redis->sadd("test1","444");

        print_r($redis->sunion("test","test1")); //结果：Array ( [0] => 111 [1] => 222 [2] => 333 [3] => 444 )


        $this->print_hr();

        $redis->delete('test');

        $redis->sadd("test","111");

        $redis->sadd("test","222");

        $redis->sadd("test","333");

        $redis->sadd("test1","111");

        $redis->sadd("test1","444");

        var_dump($redis->sinterstore('new',"test","test1")); //结果：int(4)

        print_r($redis->smembers('new')); //结果:Array ( [0] => 111 [1] => 222 [2] => 333 [3] => 444 )



        $this->print_hr();
        $redis->delete('test');

        $redis->sadd("test","111");

        $redis->sadd("test","222");

        $redis->sadd("test","333");

        $redis->sadd("test1","111");

        $redis->sadd("test1","444");

        print_r($redis->sdiff("test","test1")); //结果：Array ( [0] => 222 [1] => 333 )




        $this->print_hr();
        $redis->delete('test');

        $redis->sadd("test","111");

        $redis->sadd("test","222");

        $redis->sadd("test","333");

        $redis->sadd("test1","111");

        $redis->sadd("test1","444");

        var_dump($redis->sdiffstore('new',"test","test1")); //结果：int(2)

        print_r($redis->smembers('new')); //结果:Array ( [0] => 222 [1] => 333 )




        $this->print_hr();
        $redis->delete('test');

        $redis->sadd("test","111");

        $redis->sadd("test","222");

        print_r($redis->smembers('test')); //结果:Array ( [0] => 111 [1] => 222 )


        $redis->close();











//        }

    }

    function redistest8(){
        $redis = Cache::store('redis')->handler(); // 这条代码等于  $redis = new \Redis();

        $redis->set("info",'hello world');   // 设置字段
        $result =   $redis->expire("info",10);  // 设置过期时间
//
//       echo $redis->get('info');
        echo $redis_status = $redis->exists("info");


        $redis->set('zifu','字符');
        $redis->append('zifu','ooooo');
        echo $redis->get('zifu');


//        $redis->set('num','1');
        $redis->incr('num');
        echo $redis->get('num');
        echo '<hr>';
        echo $redis->strlen('num'); //字数
        echo $redis->exists('num');//存在 1 否则 0         exist ？ 1 ： 0
//        $redis->lpush('llist',21);
//        $redis->lpush('llist','2123123');
//        $redis->lrem('llist',0,1);
//        $redis->rpop('llist');//移除右侧第一个
//        $redis->lpop('llist');//移除左边第一个
//        $redis->lRem("llist",0,10); //这个无效
       $list =  $redis->lrange('llist',0,-1);
       var_dump($list);
       echo '<hr>';
       echo $redis->llen('llist');//列表的数
       var_dump($list);




       /*
        * 设置hash
        */
        //$redis->hset('haxi','one','china');
        //$redis->hset('haxi','two','canana');
        //$redis->hset('haxi','three','USA');
        //$redis->hset('haxi','four',1);
        $result = $redis->hgetall('haxi');//取得haxi所有的数值

        $redis->hincrby("haxi","four",10); //数字加
        $redis->hdel("haxi","two");// 哈希删
        $this->br();
        echo $redis->hexists("haxi","three");//存在显示1

        $this->br();
        $res = $redis->hkeys("haxi");//显示所有的key
        $resval = $redis->hvals("haxi");//显示所有的value
        var_dump(array_merge($res,$resval));

        $this->br();
        echo $redis->hsetnx("haxi","guojia","jianada");//如果不存在这个值。就添加"jianada"

        $redis->hdel("haxi","canana");//删除
        $this->br();
        echo $redis->hlen("haxi");// 哈希的个数

        var_dump($result);

        static::br();

        $redis->sadd("setlist","one");
        $redis->sadd("setlist","two");
        $redis->sadd("setlist","three");
        $redis->sadd("setlist","21");
        $redis->sadd("setlist","124");
        $redis->sadd("setlist","141");

        $res =  $redis->smembers("setlist");
        static::pin($redis->scard('setlist'));

        $redis->sadd("setlist2","three","four","five");

        static::pin($redis->sdiffstore("test","setlist","setlist2"));
        //static::pin($redis->smembers("test"));
        //static::pin($redis->smembers("setlist"));
        //static::pin($redis->smembers("setlist2"));

        static::pin($redis->sdiff("setlist2","test"));
        //        SMOVE source destination member  将 member 元素从 source 集合移动到 destination 集合
        //        $redis->spop('setlist');//随机移除
        $redis->srem('setlist2','three');//移除
        $redis->srem('setlist2','three');//移除

        $bing = $redis->sunion('setlist2,','test');//并集

        static::pin($redis->srandmember('setlist',2));

        $redis->zadd('zset',1,'one');
        $redis->zadd('zset',2,'two');
        $redis->zadd('zset',3,'three');
        $redis->zadd('zset',4,'four');
        $redis->zadd('zset',5,'five');

        static::pin($redis->zrange('zset',0,-1));
        static::pin($redis->zcard('zset'));
        static::pin($redis->zrem('zset', 'five'));

//        $redis->PFADD("testkey","redis","mysql","php","nginx");
//
//        //static::pin($redis->pfcount('testkey'));



        static::pin($redis->keys('*'));

    }
    function br(){
        echo '<br>';
    }
    function pin($p){
        echo '<br>';

        is_array($p) ? var_dump($p) :  static::read($p);

        echo '<br>';
    }
    function read($p){
        echo $p;
    }
    function print_hr(){
        echo "<hr>";
        echo "<hr><hr>";
    }

    function sysmd5test(){
        $this->ifLogin();
        if (Request::isAjax()) {
            $ip = Request::post('ip');
            $sysmd5 = Request::post('sysmd5');
            $path = Request::post('path');
            $result = $this->getfilearray($ip);
            foreach($result as $key=>$item){
                if($item['path'] == $path){
                    if($item['sysmd5'] == $sysmd5){
                        $say =  $path .' 一致';
                        $this->json_back(1,$say,'');
                    }else{
                        $say =  $path .' 不一致,请检查是否被篡改了';
                        $this->json_back(2,$say,'');
                    }
                }
            }
        }
    }


    function sysmd5testbatch(){
        $this->ifLogin();
        if (Request::isAjax()) {
            $data = Request::post('data');
            $say = array();
            foreach($data as $k => $i){
                $ip = $i['ip_remark'];
                $sysmd5 = $i['sysmd5'];
                $path = $i['path'];
                $result = $this->getfilearray($ip);
                foreach($result as $key=>$item){
                    if($item['path'] == $path){
                        if($item['sysmd5'] == $sysmd5){
                            $say[] =  $path .' 一致';
                        }else{
                            $say[] =  $path .' 不一致,请检查是否被篡改了';
                        }
                    }
                }
            }
            $this->json_back(1,$say,'');
        }
    }

    function sysmd5log(){
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $map = input('post.');
            $where = array();

            if (@$map['ip'] != '') $where[] = ['ip_remark', '=', $map['ip']];
            if (@$map['path'] != '') $where[] = ['path', 'like', '%' . $map['path'] . '%'];
            $list = Db::name('md5log')
                ->where($where)
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();

            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();
    }

    function checkmd5work(){//按IP去检测。 一次也就是一千多个
        //if (Request::isAjax()) {
           $test =  Db::name('server')->where('next', 0)->find();
           if($test){
               $ip = $test['ip_remark'];
               $ip = 156;
               $result = $this->getfilearray($ip);
               #检测的文件数组
               foreach($result as $k=>$item){
                   $temp[]= trim($item['path']).'|'.trim($item['sysmd5']);
               }
               $test2 =  Db::name('sysmd5')->where('status', 0)->select()->toArray();
               foreach($test2 as $k=>$item){
                    $temp3[trim($item['path'])]= trim($item['sysmd5']);
                    $temp2[]= trim($item['path']).'|'.trim($item['sysmd5']);
               }
               $tem = array_diff($temp,$temp2);
               $result = $tem;
               $word = '';
               if($result){//如果存在的话 。记录到数据库。 并 定时让shell去通知用户。
                   foreach(@$result as $key => $item){
                      $itemtemp=explode("|",$item);
                      $key2 = trim($itemtemp['0']);
                      $word .= 'command:'.$key2 .'|';
                      $word .= 'old:'.@$temp3[$key2].'#';
                      $word .= ' check:'.trim($item).'##';
                   }
                   $mdslog['content'] = $word;
                   echo $word;
                   $mdslog['ip_remark'] = $ip;
                   $mdslog['create_time'] =time();
                   $mdslog['status'] = 1;
                   $mdslog['md5'] = md5($word.$ip);

                   $true =  Db::name('md5log')->where('md5', $mdslog['md5'])->find();
                   if(!$true){
                       $do =  Db::name('md5log')->save($mdslog);
                   }else{
                       echo '存在，还没处理';
                   }
               }
               Db::name('server')
                   ->where('id', $test['id'])
                   ->data(['next' => '1'])
                   ->update();
           }else{
               Db::name('server')
                   ->where('del', 0)
                   ->data(['next' => '0'])
                   ->update();
           }
    }

    function getfilearray($ip){
        $file = "/Volumes/51/bb/sbin.md5.{$ip}";
        if (file_exists($file)) {
            $file = fopen($file, "r");
            $user=array();
            $i=0;
            while(! feof($file))
            {
                $user[$i]= fgets($file);
                $i++;
            }
            fclose($file);
            $user=$this->merge_spaces(array_filter($user));
            foreach($user as $key=>$item){
                $temp =  explode(" ",$item);
                if(@$temp['1']!=='' || empty(@$temp['1'])){
                    $result[$key]['sysmd5'] =  @$temp['0'];
                    $result[$key]['path'] = @$temp['1'];
                }
            }
        }
        return $result;
    }


    function md5test(){

    }

    function getsysinfo(){
        echo number_format(888.3456, 2, '.', '');
        $ip = Request::get('ip');
        $file = "/Volumes/51/bb/{$ip}sys.txt";
        if (file_exists($file)) {
            $file = fopen($file, "r");
            $user=array();
            $i=0;
            while(! feof($file))
            {
                $user[$i]= fgets($file);//fgets()函数从文件指针中读取一行
                $i++;
            }
            fclose($file);
            $user=$this->merge_spaces(array_filter($user));
            $tempcard= array();
            $sysinfo = array();
            foreach($user as $key=>$item){
               $temp =  explode(":",$item);
               if(@$temp['1']!=='' || empty(@$temp['1'])){
               $sysinfo[$key]['key']= @$temp['0'];
               $sysinfo[$key]['item'] = @$temp['1'];
               }

                if(strpos($temp['0'],'eth') !== false || strpos($temp['0'],'em') !== false  || strpos($temp['0'],'eno') !== false ){
                    $tempcard[] = $temp['0'];
                }
            }
            $tempcard[]='lo';
            $tempcard = array_values(array_unique($tempcard));
            $num = count($tempcard)+1;
                View::assign('ip',$ip);
                View::assign('num',$num);
                View::assign('cardname',trim($tempcard['0']));
                View::assign("card",$tempcard);
                View::assign("system",$sysinfo);
                return View();
        }
    }

    function showiftop(){
        $ip = Request::get('ip');
        View::assign('ip',$ip);

        if ($this->request->isAjax()) {
            $output = shell_exec('python /etc/python/test.py $ip');
            $temp = explode("UCD-SNMP-MIB::ucdavis",$output);
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $temp];
            echo json_encode($result);
        }

        return View();
    }

    function getnetfornet()
    {

        $ip = Request::post('ip');
        $card = Request::post('card');
        $chunk_num = Request::post('num');
        $file = "/Volumes/51/bb/{$ip}net.txt";
        if (file_exists($file)) {
            $file = fopen($file, "r");
            $user=array();
            $i=0;
            while(! feof($file))
            {
                $user[$i]= fgets($file);//fgets()函数从文件指针中读取一行
                $i++;
            }
            fclose($file);
            $user=$this->merge_spaces(array_filter($user));
            $num = (int)$chunk_num;//根据网卡数定//根据网卡数定
            $chunk_result = array_chunk($user,$num);//切割数组
            $tempnet = array();
            foreach($chunk_result as $key=>$item){
                $time =  $this->DeleteHtml($item['0']);
                $time = str_replace('RX','',$time);
                $time = str_replace('TX','',$time);
                $time = trim($time);
                for($i=1;$i<$num;$i++){//切割
                    $netcard = explode(" ",$item[$i]);
                    $tempnet['speeditem'][$netcard['0']][$key]['in_speed']= number_format((int)$netcard['1']/1024,2,'.','');
                    $tempnet['speeditem'][$netcard['0']][$key]['out_speed']= number_format((int)$netcard['2']/1024,2,'.','');
                    $tempnet['speeditem'][$netcard['0']][$key]['time']= date("Y-m-d ",time()).$time;
                }
            }
//            echo '<pre>';
//            print_r($tempnet);
            $temp = array();
            foreach($tempnet['speeditem'] as $key=>$item){
                if($key == $card){
                    foreach($item as $k=>$v){
                        $temp['in_speed'][$k][]=$v['time'];
                        $temp['in_speed'][$k][]=$v['in_speed'];
                        $temp['out_speed'][$k][]=$v['time'];
                        $temp['out_speed'][$k][]=$v['out_speed'];
                    }
                }
            }
            echo json_encode($temp);
        }
    }

    function getnetfornet2()
    {

        $ip = Request::get('ip');
        $card = Request::get('card');
        $chunk_num = Request::get('num');
        $file = "/Volumes/51/bb/{$ip}net.txt";
        if (file_exists($file)) {
            $file = fopen($file, "r");
            $user=array();
            $i=0;
            while(! feof($file))
            {
                $user[$i]= fgets($file);//fgets()函数从文件指针中读取一行
                $i++;
            }
            fclose($file);
            $user=$this->merge_spaces(array_filter($user));
            $num = (int)$chunk_num;//根据网卡数定
            $chunk_result = array_chunk($user,$num);//切割数组
            $tempnet = array();
            foreach($chunk_result as $key=>$item){
                $time =  $this->DeleteHtml($item['0']);
                $time = str_replace('RX','',$time);
                $time = str_replace('TX','',$time);
                $time = trim($time);
                for($i=1;$i<$num;$i++){//切割
                    $netcard = explode(" ",$item[$i]);
                    $tempnet['speeditem'][$netcard['0']][$key]['in_speed']= (int)$netcard['2']/1024;
                    $tempnet['speeditem'][$netcard['0']][$key]['out_speed']= (int)$netcard['1']/1024;
                    $tempnet['speeditem'][$netcard['0']][$key]['time']= date("Y-m-d ",time()).$time;
                }
            }
//            echo '<pre>';
//            print_r($tempnet);
            $temp = array();
            foreach($tempnet['speeditem'] as $key=>$item){
                if($key == $card){
                    foreach($item as $k=>$v){
                        $temp['in_speed'][$k][]=$v['time'];
                        $temp['in_speed'][$k][]=$v['in_speed'];
                        $temp['out_speed'][$k][]=$v['time'];
                        $temp['out_speed'][$k][]=$v['out_speed'];
                    }
                }
            }
            echo json_encode($temp);
        }
    }

    function merge_spaces($string){
        return preg_replace("/\s(?=\s)/","\\1",$string);
    }

    public function video_list(){

        if ($this->request->isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 20);
            $list = Db::table('videoinfo')
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
        }
        // 渲染模板输出
        return view();
    }
    public function video_in(){
        if($this->request->isPost()){// 如果是post 就验证是否登陆。 如果错则提示错误。 如果正确则登陆
            //验证数据。

            $map = input('post.');

            $app_id =       '1672969461062585';
            $app_token =   '4908c6a12702b8797dcdfdc663e426a9';
            $mapp_procedure = "[{\"mapp_id\":\"16553734\",\"material_id\":\"651006204411710953\",\"cover_type\":\"big\"}]";
            //小程序
            $url = 'http://bjh.qilaixiu.com/storage/';

            foreach($map['data'] as $k=> $item){
                $tem['app_id'] = $app_id;
                $tem['app_token'] = $app_token;
                $tem['title'] = @$item['title'];
                $tem['video_url'] =  @$item['video_url'];
                $time = time();
                $tem['video_url'] =  $tem['video_url'].'?time='.$time;
                $tem['cover_images'] = @$item['cover_images'];
                $tem['tag'] = @$item['tag'];
                $tem['is_original'] = 1;
                $tem['use_auto_cover'] = 0;
                $tem['mapp_procedure'] = $mapp_procedure;
                $url2 = "https://baijiahao.baidu.com/builderinner/open/resource/video/publish";
                $temps =  $this->curl2($tem, $url2);
                $temps = json_decode($temps,true);
                $article_id =  $temps['data']['article_id'];
                if($article_id !== ''){
                    $data['id'] = @$item['id'];
                    $data['msg'] = '成功';
                    $data['create_time']=time();
                    $data['article_id'] = $article_id;
                    $data['video_url'] = $tem['video_url'];
                    $do =  Db::name('videoinfo')->save($data);
                    $dos['msg'][$k]= '成功';
                    $dos['title'][$k]= $item['title'];
                }else{
                    $dos['msg'][$k]= '失败';
                    $dos['title'][$k]= $item['title'].$tem['video_url'];
                }
            }


            $this->json_back('1',$dos,$temps);

            exit();

            //接口地址:https://baijiahao.baidu.com/builderinner/open/resource/video/publish
        }
    }



    public function auto_in_bjhao(){//自动提交。一次一个



        $where[] = ['msg', '<>', 'publish'];
        $where[] = ['pass', '=', '1'];

        $item = Db::name("videoinfo")
            ->where($where)
            ->find();



        $app_id =       '1672969461062585';
        $app_token =   '4908c6a12702b8797dcdfdc663e426a9';
        $mapp_procedure = "[{\"mapp_id\":\"16553734\",\"material_id\":\"651006204411710953\",\"cover_type\":\"big\"}]";
        //小程序
        $tem['app_id'] = $app_id;
        $tem['app_token'] = $app_token;
        $tem['title'] = $item['title'];
        $tem['video_url'] =  $item['video_url'];
        $time = time();
        $tem['video_url'] =  $tem['video_url'].'?time='.$time;
        $tem['cover_images'] = $item['cover_images'];
        $tem['tag'] = $item['tag'];
        $tem['is_original'] = 1;
        $tem['use_auto_cover'] = 0;
        $tem['mapp_procedure'] = $mapp_procedure;
        $url2 = "https://baijiahao.baidu.com/builderinner/open/resource/video/publish";
        echo $temps =  $this->curl2($tem, $url2);
        $temps = json_decode($temps,true);
        $article_id =  $temps['data']['article_id'];
        if($article_id !== ''){
            $data['id'] = $item['id'];
            $data['msg'] = '成功';
            $data['create_time']=time();
            $data['article_id'] = $article_id;
            $data['video_url'] = $tem['video_url'];
            $data['pass'] = 2;

            $do =  Db::name('videoinfo')->save($data);
            if($do){
                echo $item['title'].' input baijiahao is ok and get the '.$article_id;
            }else{
                echo $item['title'].' input baijiahao is ok but no update sql  '.$article_id;
            }

        }else{
            echo $item['title'] .' is false';
        }

        exit();
                //接口地址:https://baijiahao.baidu.com/builderinner/open/resource/video/publish

    }

    function auto_get_status(){//这里写自动更新状态。 一次20个。不断更新

        $where[] = ['here', '=', '0'];
        $where[] = ['msg', '<>', 'publish'];
        $where[] = ['article_id', '<>', ''];
        $where[] = ['pass' , '=' , '1'];



        $list = Db::name("videoinfo")
            ->where($where)
            ->limit(20)
            ->select()
            ->toArray();

        if(!$list){
            echo 'no data ';
            $data['here'] = 0;
            $do =  Db::name('videoinfo')->save($data);
            if($do){
                echo 'start ';
            }
            exit();
        }
        $article_id = '';
        foreach ($list as $k => $v) {
            $article_id .= $v['article_id'].',';
        }
        echo $article_id = trim($article_id,',');
        $url = 'https://baijiahao.baidu.com/builderinner/open/resource/query/status';
        $app_id =       '1672969461062585';
        $app_token =   '4908c6a12702b8797dcdfdc663e426a9';
        $tem['app_id'] = $app_id;
        $tem['app_token'] = $app_token;
        $tem['article_id'] = $article_id;
        $temps =  $this->curl2($tem,$url);
        echo '<pre>';
        $temps = json_decode($temps,true);
        print_r($temps);
            if($temps['errno'] == 0){//查询成功则对应
                $tempinfo = $temps['data'];



                foreach($list as $k=>$v){
                   $status =  $tempinfo[$v['article_id']]['status'];
                   $article_id = $v['article_id'];
                   if($tempinfo[$article_id]['status'] == 'publish'){
//                       $path = $tempinfo[$article_id]['url'];//公开地址, 这里不需要了。
                   }
                       echo  $video['id'] = $v['id'];
                       echo  $video['msg'] = $tempinfo[$article_id]['status'];
                             $video['here'] =1;//寻址
                       $do =  Db::name('videoinfo')->save($video);

                }
//                         $list['data'][$k]['info'] = $tempinfo[$articleid]['status'];
//                    if($tempinfo[$articleid]['status'] == 'publish'){//公开的话则显示地址
//                        $list['data'][$k]['path'] = $tempinfo[$articleid]['url'];
//                    }
//                    $video['id'] = $list['data'][$k]['id'];
//                    $video['msg'] = $tempinfo[$articleid]['status'];
//                    $do =  Db::name('videoinfo')->save($video);
              
            }

    }
    public function video_in_one(){
        if($this->request->isPost()){// 如果是post 就验证是否登陆。 如果错则提示错误。 如果正确则登陆
            //验证数据。
            $map = input('post.');
            $app_id =       '1672969461062585';
            $app_token =   '4908c6a12702b8797dcdfdc663e426a9';
            $mapp_procedure = "[{\"mapp_id\":\"16553734\",\"material_id\":\"651006204411710953\",\"cover_type\":\"big\"}]";
            //小程序
            $url = 'http://bjh.qilaixiu.com/storage/';

            foreach($map as $k=> $item){
                $tem['app_id'] = $app_id;
                $tem['app_token'] = $app_token;
                $tem['title'] = @$item['title'];
                $tem['video_url'] =  @$item['video_url'];
                $time = time();
                $tem['video_url'] =  $tem['video_url'].'?time='.$time;
                $tem['cover_images'] = @$item['cover_images'];
                $tem['tag'] = @$item['tag'];
                $tem['is_original'] = 1;
                $tem['use_auto_cover'] = 0;
                $tem['mapp_procedure'] = $mapp_procedure;
                $url2 = "https://baijiahao.baidu.com/builderinner/open/resource/video/publish";
                $temps =  $this->curl2($tem, $url2);
                $temps = json_decode($temps,true);
                $article_id =  $temps['data']['article_id'];
                if($article_id !== ''){
                    $data['id'] = @$item['id'];
                    $data['msg'] = '成功';
                    $data['create_time']=time();
                    $data['article_id'] = $article_id;
                    $data['pass'] = 2;
                    $data['video_url'] = $tem['video_url'];
                    $do =  Db::name('videoinfo')->save($data);
                    $dos['msg'][$k]= '成功';
                    $dos['title'][$k]= $item['title'].$tem['video_url'];
                }else{
                    $dos['msg'][$k]= '失败';
                    $dos['title'][$k]= $item['title'].$tem['video_url'];
                }
            }
            //$this->json_back('1',$dos,$temps);
            $datatemp['code'] = 1;
            $datatemp['msg'] = $dos;
            $datatemp['data'] = $temps;
            echo json_encode($datatemp);
            exit();
            //接口地址:https://baijiahao.baidu.com/builderinner/open/resource/video/publish
        }
    }

    public function video_edit(){
        $if_edit = Request::has('id', 'get');
        if ($if_edit) {
            $id = Request::param('id');
            $data = Db::name('videoinfo')->where('id', $id)->find();
            View::assign('data', $data);
        } else {
            $data = array('title' => '', 'cover_images' => '', 'video_url' => '', 'tag' => '');
        }
        $create_time = time();
        if ($this->request->isPost()) {
            $data = Request::post();
            $data['create_time'] = $create_time;
            $if_edit = Request::has('id', 'get');
            if ($if_edit) {
                $data['id'] = $id;
                $typename = '编辑';
            } else {
                $typename = '添加';
            }
//            $this->inlog(__FUNCTION__, $typename);
            $do = Db::name('videoinfo')->save($data);
            if ($do) {
                $this->json_back(1, '创建成功', '');
            } else {
                $this->json_back(0, '创建失败', '');
            }
            exit();
        }
        View::assign('data', $data);
        return View();
    }

    public function video_list_api(){
        if ($this->request->isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $map = input('post.');
            $where[] = ['status', '=', 1];
            if (@$map['title'] != '') $where[] = ['title', 'like', '%' . $map['title'] . '%'];
            if (@$map['msg'] != ''){

                if (@$map['msg'] == 'no_publish') {
                    $where[] = ['msg', '<>',  'publish' ];
                }else{
                    $where[] = ['msg', '=',  $map['msg'] ];
                }
            }
            if (@$map['article_id'] != '') $where[] = ['article_id', '=',  $map['article_id'] ];


            $list = Db::name('videoinfo')
                ->where($where)
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            /**
            $article_id = '';
            foreach ($list['data'] as $k => $v) {
                $article_id .= $v['article_id'].',';
            }

            $article_id = trim($article_id,',');
            $url = 'https://baijiahao.baidu.com/builderinner/open/resource/query/status';
            $app_id =       '1672969461062585';
            $app_token =   '4908c6a12702b8797dcdfdc663e426a9';
            $tem['app_id'] = $app_id;
            $tem['app_token'] = $app_token;
            $tem['article_id'] = $article_id;
            $temp = $this->curl2($tem,$url);
            $temp = json_decode($temp,true);


            if($temp['errno'] == 0){//查询成功则对应
                $tempinfo = $temp['data'];
                foreach($list['data'] as $k => $item){
                    $articleid = $list['data'][$k]['article_id'];
                    $list['data'][$k]['info'] = $tempinfo[$articleid]['status'];
                    if($tempinfo[$articleid]['status'] == 'publish'){//公开的话则显示地址
                        $list['data'][$k]['path'] = $tempinfo[$articleid]['url'];
                    }
                    $video['id'] = $list['data'][$k]['id'];
                    $video['msg'] = $tempinfo[$articleid]['status'];
                    $do =  Db::name('videoinfo')->save($video);
                }
            }
            **/
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
        }
    }


    public function video_status(){
        $app_id =       '1672969461062585';
        $app_token =   '4908c6a12702b8797dcdfdc663e426a9';
        $tem['app_id'] = $app_id;
        $tem['app_token'] = $app_token;
        $tem['article_id'] = '1675433394452136949,1675433395747249397,1673356603101501836';
        $url= 'https://baijiahao.baidu.com/builderinner/open/resource/query/status';//文章状态。 支持最多不超过20篇文章
        $temp =  $this->curl($tem,$url);
        $temp = json_decode($temp,true);

        print_r($temp);


    }


    public function curl($arrs,$api='http://baijiahao.baidu.com/builderinner/open/resource/article/publish'){
        $data = json_encode($arrs);//转为 json 格式
        //$api = 'http://baijiahao.baidu.com/builderinner/open/resource/article/publish';//百家号图文接口
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        echo $output;//返回结果为 json 格式数据
    }

    public function curl2($arrs,$api='http://baijiahao.baidu.com/builderinner/open/resource/article/publish'){
        $data = json_encode($arrs);//转为 json 格式
        //$api = 'http://baijiahao.baidu.com/builderinner/open/resource/article/publish';//百家号图文接口
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;//返回结果为 json 格式数据
    }

    //小程序素材 https://baijiahao.baidu.com/builderinner/open/resource/query/searchMappSource
    public function material(){
        $url = 'https://baijiahao.baidu.com/builderinner/open/resource/query/searchMappSource';
        $app_id =       '1672969461062585';
        $app_token =   '4908c6a12702b8797dcdfdc663e426a9';

        $tem['app_id'] = $app_id;
        $tem['app_token'] = $app_token;
        $tem['mapp_id'] = '16553734';
        $tem['query'] = '学而思';
//        $tem['page'] = $_GET['page'];
//        $tem['size'] = 30;
        $tem['material_type'] = 'official';
        $tem['cover_type'] = 'big';
        $temp = $this->curl2($tem,$url);
        $temp = json_decode($temp,true);

        echo '<pre>';
        print_r($tem);
        print_r($temp);

        echo '</pre>';

        exit();

        $mapp_procedure = array();
        $mapp_procedure['mapp_id'] = '16553734';
        $mapp_procedure['material_id'] = '651006204411710953';
        $mapp_procedure['cover_type'] = 'big';

        $mapp_procedure = json_encode($mapp_procedure);

        echo $mapp_procedure;

    }


    public function test3(){
//        $mapp_procedure = array();
//        $mapp_procedure['mapp_id'] = '16553734';
//        $mapp_procedure['material_id'] = '651006204411710953';
//        $mapp_procedure['cover_type'] = 'big';
//
//        $mapp_procedure = json_encode($mapp_procedure);
//
//        echo $mapp_procedure;



            $test = '嗨学英语extract单词详解#嗨学英语fleeting单词详解#嗨学英语efficiency单词详解#嗨学英语Province单词详解#嗨学英语hump单词详解#complement十秒单词速记#嗨学英语borderland单词详解#嗨学英语charge单词详解#嗨学英语gruff单词详解#嗨学英语shaking单词详解#嗨学英语mating单词详解#嗨学英语investigator单词详解#嗨学英语input单词详解#嗨学英语conformity单词详解#嗨学英语adjustable单词详解#嗨学英语cultivating单词详解#嗨学英语divinity单词详解#嗨学英语percent单词详解#嗨学英语taker单词详解#嗨学英语Seldom单词详解#front十秒单词速记#嗨学英语caring单词详解#perform十秒单词速记#嗨学英语alternatives单词详解#嗨学英语circulatory单词详解#嗨学英语proud单词详解#嗨学英语reed单词详解#嗨学英语spill单词详解#嗨学英语visit单词详解#嗨学英语handle单词详解#嗨学英语devastating单词详解#relax十秒单词速记#嗨学英语moaning单词详解#嗨学英语slam单词详解#嗨学英语dogs单词详解#嗨学英语transitional单词详解#嗨学英语horticultural单词详解#嗨学英语flux单词详解#嗨学英语argumentation单词详解#嗨学英语eff单词详解#嗨学英语bungalow单词详解#嗨学英语vacancy单词详解#嗨学英语disinfect单词详解#嗨学英语sin单词详解#嗨学英语dismantle单词详解#嗨学英语prices单词详解#嗨学英语provides单词详解#嗨学英语welding单词详解#嗨学英语outlook单词详解#嗨学英语sophomore单词详解#expensive十秒单词速记#嗨学英语delegate单词详解#嗨学英语redeem单词详解#嗨学英语depletion单词详解#嗨学英语product单词详解#identify十秒单词速记#嗨学英语chorus单词详解#嗨学英语pawn单词详解#separate十秒单词速记#divide十秒单词速记#嗨学英语learns单词详解#嗨学英语sandal单词详解#嗨学英语dialogue单词详解#嗨学英语disabilities单词详解#fragment十秒单词速记#嗨学英语firing单词详解#嗨学英语chrysalis单词详解#contact十秒单词速记#嗨学英语appliances单词详解#嗨学英语september单词详解#嗨学英语astonish单词详解#嗨学英语castanets单词详解#嗨学英语walked单词详解#嗨学英语sizes单词详解#嗨学英语enlist单词详解#嗨学英语much单词详解#嗨学英语ground单词详解#嗨学英语lighter单词详解#嗨学英语harness单词详解#嗨学英语extraction单词详解#嗨学英语spring单词详解#嗨学英语eliminated单词详解#嗨学英语slipped单词详解#嗨学英语prolific单词详解#嗨学英语include单词详解#嗨学英语statistic单词详解#嗨学英语warranty单词详解#嗨学英语areas单词详解#嗨学英语near单词详解#嗨学英语resultant单词详解#嗨学英语anything单词详解#嗨学英语how far词组详解#嗨学英语recover单词详解#嗨学英语videos单词详解#嗨学英语canton单词详解#嗨学英语chimps单词详解#嗨学英语engineering单词详解#嗨学英语stamps单词详解#嗨学英语firefighter单词详解#嗨学英语supporter单词详解#嗨学英语magnum单词详解#嗨学英语actors单词详解#嗨学英语furnace单词详解#嗨学英语goalkeeper单词详解#嗨学英语appliances单词详解#嗨学英语how单词详解#嗨学英语salon单词详解#嗨学英语ritual单词详解#嗨学英语mythology单词详解#嗨学英语well单词详解#passage十秒单词速记#嗨学英语patented单词详解#嗨学英语alienate单词详解#finish十秒单词速记#嗨学英语whirlpool单词详解#嗨学英语thanks单词详解#嗨学英语invite单词详解#嗨学英语bandwidth单词详解#嗨学英语aged单词详解#separate十秒单词速记#嗨学英语oldest单词详解#嗨学英语valued单词详解#嗨学英语yacht单词详解#嗨学英语considerable单词详解#嗨学英语clocks单词详解#嗨学英语shrink单词详解#嗨学英语grenade单词详解#嗨学英语smoothie单词详解#嗨学英语spying单词详解#嗨学英语diabetes单词详解#嗨学英语welding单词详解#嗨学单词dinner#嗨学英语nib单词详解#嗨学英语illy单词详解#嗨学英语stung单词详解#嗨学英语combat单词详解#嗨学英语citizenship单词详解#嗨学英语elite单词详解#嗨学英语reciprocal单词详解#嗨学英语stumble单词详解#嗨学英语editor单词详解#嗨学英语chile单词详解#嗨学英语wacko单词详解#嗨学英语take单词详解#嗨学英语fishing单词详解#嗨学英语painted单词详解#嗨学英语ninety单词详解#嗨学英语sanitation单词详解#嗨学英语pack单词详解#嗨学英语amazement单词详解#嗨学英语sorting单词详解#嗨学英语rigorous单词详解#嗨学英语facing单词详解#嗨学英语field单词详解#嗨学英语dome单词详解#嗨学英语bribery单词详解#嗨学英语quilt单词详解#嗨学英语battle单词详解#嗨学英语aisles单词详解#嗨学英语dimmest单词详解#responsible十秒单词速记#嗨学英语filthy单词详解#嗨学英语historically单词详解#嗨学英语goodbye单词详解#嗨学英语wharf单词详解#嗨学英语vaguely单词详解#嗨学英语regulation单词详解#嗨学英语microblog单词详解#嗨学英语decorative单词详解#嗨学英语upper单词详解#嗨学英语astronomical单词详解#嗨学英语reflect单词详解#嗨学英语lighter单词详解#嗨学英语hurray单词详解#嗨学英语aeronautics单词详解#嗨学英语opposites单词详解#嗨学英语mistress单词详解#嗨学英语subjects单词详解#嗨学英语width单词详解#嗨学英语ripple单词详解#嗨学英语unlock单词详解#嗨学英语argon单词详解#嗨学英语gladiator单词详解#嗨学英语tern单词详解#嗨学英语alway单词详解#嗨学英语moon cakes词组详解#嗨学英语brushes单词详解#嗨学英语gaseous单词详解#嗨学英语pets单词详解#嗨学英语teapot单词详解#嗨学英语trifles单词详解#嗨学英语bake单词详解#hall十秒单词速记#嗨学英语foil单词详解#compact十秒单词速记#嗨学英语excavate单词详解#嗨学英语irreversible单词详解#嗨学英语explained单词详解#嗨学英语train单词详解#嗨学英语easygoing单词详解#嗨学英语abracadabra单词详解#嗨学英语attire单词详解#嗨学英语constructed单词详解#嗨学英语vagrant单词详解#嗨学英语loosen单词详解#嗨学英语instead单词详解#嗨学英语addict单词详解#嗨学英语glitch单词详解#嗨学英语signals单词详解#嗨学英语feast单词详解#caution十秒单词速记#嗨学英语gravitational单词详解#disappoint十秒单词速记#嗨学英语steps单词详解#嗨学英语delicately单词详解#嗨学英语interpretation单词详解#嗨学英语chess单词详解#嗨学英语drastically单词详解#嗨学英语elements单词详解#嗨学英语grimace单词详解#嗨学英语drowned单词详解#嗨学英语strange单词详解#嗨学英语industry单词详解#嗨学英语whatever单词详解#嗨学英语terminate单词详解#嗨学英语decoration单词详解#嗨学英语Success单词详解#嗨学英语enchant单词详解#嗨学英语bunnies单词详解#嗨学英语violated单词详解#嗨学英语steel单词详解#嗨学英语aloof单词详解#嗨学英语jig单词详解#嗨学英语chains单词详解#嗨学英语ladybug单词详解#嗨学英语mitochondria单词详解#嗨学英语guests单词详解#嗨学英语founding单词详解#嗨学英语churches单词详解#constitute十秒单词速记#嗨学英语lemonade单词详解#嗨学英语skills单词详解#嗨学英语oriental单词详解#嗨学英语settled单词详解#嗨学英语canal单词详解#嗨学英语cavalier单词详解#嗨学英语surgery单词详解#嗨学英语seal单词详解#嗨学英语outperform单词详解#嗨学英语rooster单词详解#嗨学英语intellect单词详解#嗨学英语canola单词详解#嗨学英语fatal单词详解#嗨学英语cardiovascular单词详解#嗨学英语gold单词详解#嗨学英语actress单词详解#嗨学英语tables单词详解#嗨学英语acceleration单词详解#嗨学英语arsenal单词详解#嗨学英语empty单词详解#嗨学英语exclude单词详解#嗨学英语lab单词详解# away #嗨学英语cosy单词详解#嗨学英语beautifully单词详解#嗨学英语healthy单词详解#嗨学英语ones单词详解#嗨学英语booze单词详解#smile十秒单词速记#嗨学英语faction单词详解#嗨学英语greeting单词详解#嗨学英语based单词详解#嗨学英语invaluable单词详解#嗨学英语surfing单词详解#嗨学英语fit单词详解#嗨学英语users单词详解#嗨学英语sixth单词详解#嗨学英语session单词详解#rely十秒单词速记#嗨学英语october单词详解#嗨学英语inheritance单词详解#嗨学英语praise单词详解#嗨学英语in charge词组详解#dominate十秒单词速记#嗨学英语immigrant单词详解#嗨学英语intelligence单词详解#嗨学英语abandoned单词详解#嗨学英语clothing单词详解#嗨学英语cues单词详解#嗨学英语Frenchman单词详解#daze十秒单词速记#嗨学英语instance单词详解#嗨学英语hospice单词详解#嗨学英语ward单词详解#嗨学英语accessibility单词详解#嗨学英语wanted单词详解#嗨学英语announced单词详解#嗨学英语busted单词详解#嗨学英语baffled单词详解#嗨学英语carelessly单词详解#嗨学英语volatile单词详解#嗨学英语excessive单词详解#嗨学英语medication单词详解#嗨学英语height单词详解#嗨学英语notorious单词详解#嗨学英语wanted单词详解#嗨学英语incidence单词详解#lip十秒单词速记#嗨学英语trifles单词详解#嗨学英语assured单词详解#careful十秒单词速记#嗨学英语metro单词详解#嗨学英语republic单词详解#嗨学英语intervene单词详解#嗨学英语him单词详解#嗨学英语equip单词详解#嗨学英语raster单词详解#嗨学英语lists单词详解#嗨学英语galaxies单词详解#嗨学英语fighters单词详解#嗨学英语crows单词详解#嗨学英语sender单词详解#嗨学英语aggression单词详解#嗨学英语covenience单词详解#嗨学英语dispatched单词详解#嗨学英语traditionally单词详解#嗨学英语gorillas单词详解#嗨学英语compared单词详解#嗨学英语amusing单词详解#嗨学英语hoped单词详解#嗨学英语icon单词详解#嗨学英语ceiling单词详解#嗨学英语prove单词详解#嗨学英语autocratic单词详解#嗨学英语empress单词详解#嗨学英语timely单词详解#嗨学英语lynx单词详解#嗨学英语ants单词详解#嗨学英语fled单词详解#attempt十秒单词速记#嗨学英语let单词详解#嗨学英语hollow单词详解#嗨学英语faucet单词详解#嗨学英语zap单词详解#嗨学英语deceive单词详解#嗨学英语handmade单词详解#嗨学英语uneven单词详解#嗨学英语mine单词详解#嗨学英语hypo单词详解#嗨学单词Mind#嗨学英语description单词详解#嗨学英语bring单词详解#嗨学英语dependable单词详解#嗨学英语unveil单词详解#enforce十秒单词速记#嗨学英语mad单词详解#嗨学英语gate单词详解#嗨学英语dictionaries单词详解#嗨学单词lose快速记忆#嗨学英语features单词详解#嗨学英语enhancement单词详解#嗨学英语nutshell单词详解#嗨学英语disadvantages单词详解#嗨学英语dry单词详解#enjoy十秒单词速记#嗨学英语minor单词详解#嗨学英语biodegradable单词详解#嗨学英语zebra单词详解#嗨学英语dagger单词详解#嗨学英语native单词详解#嗨学英语released单词详解#嗨学英语glamour单词详解#嗨学英语nose单词详解#嗨学英语intensity单词详解#嗨学英语feel单词详解#嗨学英语memento mori词组详解#嗨学英语trainee单词详解#嗨学英语hydraulic单词详解#嗨学英语scruffy单词详解#嗨学英语clean单词详解#嗨学单词favorite#嗨学英语click单词详解#嗨学英语plaza单词详解#嗨学英语octopus单词详解#嗨学英语raincoat单词详解#嗨学英语divided单词详解#嗨学英语anaerobic单词详解#嗨学英语happy单词详解#嗨学英语kill单词详解#嗨学英语amazement单词详解#嗨学英语affiliate单词详解#嗨学英语antenna单词详解#嗨学英语enriched单词详解#嗨学英语banned单词详解#嗨学英语bugle单词详解#嗨学英语baffle单词详解#嗨学英语astounding单词详解#嗨学英语inscription单词详解#嗨学英语nostalgia单词详解#portable十秒单词速记#嗨学英语cringe单词详解#嗨学英语rover单词详解#company十秒单词速记#嗨学英语aster单词详解#嗨学英语infinite单词详解#嗨学英语propose单词详解#嗨学英语hindsight单词详解#嗨学英语canada单词详解#嗨学单词patient#嗨学英语radiator单词详解#嗨学英语singapore单词详解#嗨学英语asymmetry单词详解#嗨学英语Tourist单词详解#嗨学英语baggage单词详解#嗨学英语larger单词详解#嗨学英语walks单词详解#嗨学英语acre单词详解#嗨学英语transitive单词详解#嗨学英语all day词组详解#嗨学英语heroes单词详解#嗨学英语catalog单词详解#嗨学英语participant单词详解#嗨学英语striped单词详解#嗨学英语sunbath单词详解#嗨学英语sympathetic单词详解#嗨学英语starting单词详解#嗨学英语tempting单词详解#嗨学英语improving单词详解#嗨学英语ranging单词详解#嗨学英语chick单词详解#嗨学英语baseline单词详解#嗨学英语hypothetical单词详解#嗨学英语spectral单词详解#嗨学英语backcountry单词详解#disappoint十秒单词速记#嗨学英语caused单词详解#嗨学英语alias单词详解#嗨学英语argon单词详解#嗨学英语professional单词详解#嗨学英语vocal单词详解#嗨学英语tart单词详解#嗨学英语bloody单词详解#嗨学英语outpouring单词详解#嗨学英语reek单词详解#嗨学英语tossed单词详解#嗨学单词Record#嗨学英语six单词详解#fascinate十秒单词速记#嗨学英语dark side词组详解#嗨学英语alpaca单词详解#嗨学英语nautilus单词详解#嗨学英语scheduled单词详解#嗨学英语event单词详解#嗨学英语fearless单词详解#嗨学英语whisk单词详解#嗨学英语on duty词组详解#嗨学英语pingpong单词详解#嗨学单词blue#dispute十秒单词速记#嗨学英语educated单词详解#嗨学英语turn单词详解#嗨学英语brag单词详解#嗨学英语hardware单词详解#嗨学单词solve#fascinate十秒单词速记#嗨学英语serendipity单词详解#嗨学英语continuum单词详解#嗨学英语as a whole词组详解#嗨学英语visitinng单词详解#嗨学英语impurity单词详解#greenhouse十秒单词速记#嗨学英语design单词详解#嗨学英语combining单词详解#嗨学英语brighter单词详解#嗨学英语realized单词详解#嗨学英语billiard单词详解#嗨学英语alchemist单词详解#嗨学英语anus单词详解#嗨学英语beans单词详解#嗨学英语findings单词详解#tolerate十秒单词速记#嗨学英语hint单词详解#嗨学英语argumentation单词详解#嗨学英语superficial单词详解#嗨学单词Scared快速记忆#嗨学英语distract单词详解#嗨学英语embarrassing单词详解#嗨学英语exercises单词详解#educate十秒单词速记#嗨学英语standards单词详解#嗨学英语poet单词详解#嗨学英语slid单词详解#嗨学英语humane单词详解#嗨学英语formally单词详解#嗨学英语aggregate单词详解#嗨学英语consign单词详解#嗨学英语helping单词详解#嗨学英语brake单词详解#嗨学英语altitude单词详解#嗨学英语supper单词详解#嗨学英语cue单词详解#endure十秒单词速记#嗨学英语trapped单词详解#嗨学英语entree单词详解#嗨学英语needle单词详解#coordinate十秒单词速记#嗨学英语loan单词详解#嗨学英语toggle单词详解#嗨学英语oppose单词详解#pesticide十秒单词速记#嗨学英语lip单词详解#嗨学英语boiled单词详解#嗨学英语fraternity单词详解#嗨学英语queries单词详解#嗨学英语fondly单词详解#嗨学英语berries单词详解#嗨学英语aurora单词详解#嗨学英语service单词详解#嗨学英语bugle单词详解#嗨学英语disagreement单词详解#嗨学英语enter单词详解#嗨学英语ideological单词详解#嗨学英语icicle单词详解#嗨学英语conglomerate单词详解#嗨学英语quote单词详解#嗨学单词fly#嗨学英语enhancement单词详解#嗨学英语entertain单词详解#嗨学单词kitchen#嗨学英语submerge单词详解#嗨学英语suicide单词详解#嗨学英语associate单词详解#嗨学英语absent单词详解#嗨学英语whereby单词详解#嗨学英语light on词组详解#嗨学英语funfair单词详解#嗨学英语millennia单词详解#嗨学英语embraced单词详解#invent十秒单词速记#嗨学英语ineffable单词详解#嗨学英语ferocious单词详解#嗨学英语cataract单词详解#嗨学单词Simple#嗨学英语bead单词详解#嗨学英语seconds单词详解#嗨学英语fluff单词详解#嗨学英语typewriter单词详解#嗨学英语cashless单词详解#嗨学英语granted单词详解#嗨学英语eleventh单词详解#嗨学英语adapted单词详解#嗨学英语tenth单词详解#嗨学英语notion单词详解#嗨学英语telescope单词详解#fall十秒单词速记#嗨学英语chats单词详解#嗨学英语darn单词详解#嗨学英语vocabulary单词详解#嗨学英语benevolent单词详解#嗨学英语clap单词详解#嗨学英语must单词详解#嗨学单词lose#嗨学英语embarrassment单词详解#overwhelm十秒单词速记#嗨学英语twisting单词详解#嗨学英语similarly单词详解#嗨学英语visitors单词详解#嗨学英语creating单词详解#嗨学英语grandson单词详解#嗨学英语restriction单词详解#嗨学英语returning单词详解#嗨学英语attenuation单词详解#嗨学英语amidst单词详解#嗨学英语intervention单词详解#嗨学英语ankylosaurus单词详解#嗨学英语curbside单词详解#嗨学英语bastion单词详解#嗨学英语access denied词组详解#嗨学英语cognition单词详解#嗨学英语enthusiast单词详解#嗨学英语tall单词详解#嗨学英语badge单词详解#嗨学英语asthma单词详解#嗨学英语tons单词详解#嗨学英语sage单词详解#bitter十秒单词速记#嗨学英语despite单词详解#嗨学英语irrigation单词详解#嗨学英语integral单词详解#emigrate十秒单词速记#嗨学英语sunny单词详解#嗨学英语administrator单词详解#嗨学英语fore单词详解#嗨学英语guard单词详解#嗨学英语courtesy单词详解#嗨学英语frame单词详解#嗨学英语fortress单词详解#嗨学英语millionaire单词详解#嗨学英语expressing单词详解#嗨学英语watch单词详解#嗨学英语code单词详解#嗨学英语penetrate单词详解#嗨学英语tag单词详解#嗨学英语evasion单词详解#嗨学英语overwatch单词详解#嗨学英语clasp单词详解#嗨学英语choppy单词详解#嗨学英语automatic单词详解#嗨学英语deserts单词详解#嗨学英语lavatory单词详解#嗨学英语piss单词详解#嗨学英语tedious单词详解#嗨学英语cannot单词详解#嗨学英语coding单词详解#嗨学单词dirty#嗨学英语disagree单词详解#嗨学英语confidently单词详解#嗨学单词easy#嗨学英语thermo单词详解#嗨学英语church单词详解#嗨学英语expenses单词详解#嗨学英语grease单词详解#嗨学英语visibly单词详解#嗨学英语comforting单词详解#嗨学英语absurd单词详解#嗨学英语method单词详解#嗨学单词End#嗨学英语exactly单词详解#嗨学英语limes单词详解#嗨学英语fabrication单词详解#嗨学英语smoker单词详解#嗨学英语instalments单词详解#嗨学英语something单词详解#嗨学英语String单词详解#嗨学英语evoke单词详解#嗨学英语obviously单词详解#嗨学英语clumsily单词详解#嗨学英语greeted单词详解#嗨学英语placement单词详解#嗨学英语disastrous单词详解#嗨学英语bonded单词详解#嗨学英语paraphrase单词详解#嗨学英语tort单词详解#嗨学英语geographical单词详解#嗨学英语airbag单词详解#嗨学英语putting单词详解#嗨学英语uniformity单词详解#嗨学英语bridges单词详解#嗨学英语vertices单词详解#嗨学英语capability单词详解#嗨学英语denomination单词详解#嗨学英语washed单词详解#valuable十秒单词速记#嗨学英语drones单词详解#alter十秒单词速记#嗨学英语socket单词详解#嗨学英语humanity单词详解#嗨学英语deductive单词详解#嗨学英语endpoint单词详解#嗨学英语polo单词详解#嗨学英语Nevermind单词详解#嗨学英语uses单词详解#嗨学英语vertica单词详解#嗨学英语leaned单词详解#attachment十秒单词速记#invent十秒单词速记#嗨学英语altar单词详解#嗨学英语information单词详解#display十秒单词速记#嗨学英语arouse单词详解#嗨学英语renowned单词详解#嗨学英语dishonesty单词详解#嗨学单词Night#嗨学英语Text单词详解#嗨学英语nurture单词详解#嗨学英语consciousness单词详解#嗨学英语conscientious单词详解#嗨学英语critter单词详解#嗨学英语flora单词详解#嗨学英语genneration单词详解#嗨学英语signs单词详解#嗨学英语mall单词详解#嗨学英语amino单词详解#嗨学英语mouthful单词详解#divert十秒单词速记#嗨学英语accountant单词详解#嗨学英语etymology单词详解#嗨学英语syllable单词详解#嗨学英语champion单词详解#嗨学英语tutorial单词详解#嗨学英语bit单词详解#嗨学英语anguish单词详解#嗨学英语sell单词详解#嗨学英语science单词详解#嗨学英语fitted单词详解#嗨学英语board game词组详解#嗨学英语scallion单词详解#嗨学英语sacrifice单词详解#嗨学英语autocratic单词详解#嗨学英语kitty单词详解#嗨学英语enlightened单词详解#嗨学英语bikini单词详解#嗨学英语slew单词详解#嗨学英语stricken单词详解#嗨学英语willpower单词详解#entertain十秒单词速记#嗨学英语automate单词详解#嗨学英语prefect单词详解#嗨学英语emphatic单词详解#嗨学英语student单词详解#嗨学英语slug单词详解#嗨学英语recommended单词详解#嗨学英语craft单词详解#嗨学英语Unity单词详解#嗨学英语cities单词详解#嗨学英语tutor单词详解#嗨学英语fridge单词详解#嗨学英语furnishing单词详解#嗨学英语attentive单词详解#嗨学英语flourishing单词详解#嗨学英语squeak单词详解#嗨学英语faucet单词详解#嗨学英语atone单词详解#嗨学英语menthol单词详解#嗨学英语resultant单词详解#嗨学英语abort单词详解#嗨学英语beggar单词详解#considerate十秒单词速记#嗨学英语comparisons单词详解#嗨学英语complacency单词详解#嗨学英语rgue with单词详解#嗨学英语pest单词详解#嗨学英语duck单词详解#嗨学英语excessively单词详解#嗨学英语crayons单词详解#嗨学英语tester单词详解#嗨学英语vitality单词详解#嗨学英语other单词详解#嗨学英语hurricane单词详解#嗨学英语analysis单词详解#嗨学英语purposes单词详解#嗨学英语launching单词详解#嗨学英语honorary单词详解#嗨学英语living单词详解#嗨学英语conceal单词详解#嗨学英语vacant单词详解#invent十秒单词速记#嗨学英语rang单词详解#嗨学英语midday单词详解#嗨学英语moves单词详解#嗨学英语deception单词详解#嗨学英语discovery单词详解#嗨学英语imp单词详解#嗨学英语mold单词详解#嗨学英语transmission单词详解#嗨学英语archaeology单词详解#嗨学英语condensed单词详解#嗨学英语disassemble单词详解#嗨学英语ornament单词详解#嗨学英语Success单词详解#嗨学英语continent单词详解#嗨学英语rags单词详解#嗨学英语others单词详解#嗨学英语beads单词详解#嗨学英语taxi单词详解#嗨学英语cosmopolitan单词详解#嗨学英语enrolled单词详解#嗨学英语dishes单词详解#嗨学单词poor#嗨学单词colour#嗨学英语trot单词详解#嗨学英语blooming单词详解#嗨学英语cold单词详解#嗨学英语index单词详解#嗨学英语against单词详解#嗨学英语universe单词详解#嗨学英语ranged单词详解#嗨学英语apt单词详解#嗨学英语skate单词详解#effort十秒单词速记#嗨学英语paints单词详解#嗨学英语buckingham palace词组详解#嗨学英语biking单词详解#嗨学英语wallaby单词详解#嗨学英语frighten单词详解#嗨学英语unfair单词详解#嗨学英语dirty单词详解#嗨学英语reckon单词详解#嗨学英语patriarch单词详解#嗨学英语homeland单词详解#嗨学英语generous单词详解#嗨学英语teacher单词详解#嗨学英语admiral单词详解#嗨学英语tug单词详解#嗨学英语tips单词详解#嗨学英语cooling单词详解#嗨学英语fidget单词详解#嗨学单词wear#嗨学英语asked单词详解#嗨学英语story单词详解#嗨学英语parted单词详解#嗨学英语fuel单词详解#嗨学英语desired单词详解#嗨学英语earn单词详解#嗨学英语tumor单词详解#嗨学英语updated单词详解#嗨学英语governor单词详解#嗨学英语wet单词详解#嗨学英语chinese单词详解#嗨学单词patient#嗨学英语sneak单词详解#嗨学英语earphone单词详解#嗨学英语Volume单词详解#嗨学英语holler单词详解#嗨学英语hangs单词详解#嗨学英语taker单词详解#discrete十秒单词速记#嗨学英语tang单词详解#嗨学英语interior单词详解#嗨学英语ordinal单词详解#嗨学英语refreshment单词详解#嗨学英语discharged单词详解#emigrate十秒单词速记#嗨学英语booking单词详解#嗨学英语improving单词详解#嗨学英语terrified单词详解#嗨学单词verbally#嗨学英语milk单词详解#嗨学英语grammy单词详解#嗨学英语foot单词详解#嗨学英语toluene单词详解#嗨学英语windmill单词详解#嗨学英语asking单词详解#嗨学英语summon单词详解#嗨学英语seeds单词详解#嗨学英语anaerobic单词详解#嗨学英语unveil单词详解#嗨学英语bastion单词详解#嗨学英语palpitate单词详解#嗨学英语drawback单词详解#嗨学英语disabled单词详解#嗨学英语ridiculous单词详解#嗨学英语spectacle单词详解#嗨学英语tighten单词详解#嗨学英语empirical单词详解#嗨学英语broom单词详解#嗨学英语reckon单词详解#嗨学英语ideas单词详解#嗨学英语cinematic单词详解#嗨学英语bureaucracy单词详解#嗨学英语troops单词详解#conduct十秒单词速记#嗨学英语signed单词详解#嗨学英语unless单词详解#嗨学英语disparage单词详解#share十秒单词速记#嗨学英语degradation单词详解#嗨学英语dynamo单词详解#嗨学英语conscientiously单词详解#嗨学英语phenomenal单词详解#嗨学英语drown单词详解#嗨学英语bathroom单词详解#嗨学英语july单词详解#嗨学英语characterize单词详解#嗨学英语allowed单词详解#嗨学英语remains单词详解#嗨学英语adonis单词详解#qualify十秒单词速记#嗨学英语biographical单词详解#嗨学英语bases单词详解#嗨学英语reflect单词详解#嗨学英语conveniently单词详解#嗨学英语excitedly单词详解#嗨学英语brute单词详解#嗨学英语workday单词详解#嗨学英语huntsman单词详解#嗨学英语generous单词详解#嗨学英语stickre单词详解#嗨学英语brow单词详解#嗨学英语checkers单词详解#嗨学英语nominate单词详解#嗨学英语transcendentalism单词详解#嗨学英语null单词详解#嗨学英语happily单词详解#嗨学英语holden单词详解#嗨学英语dodgers单词详解#嗨学英语accepted单词详解#嗨学单词phone#嗨学英语crowded单词详解#嗨学英语wish单词详解#嗨学英语relic单词详解#嗨学英语vaguely单词详解#嗨学英语attach单词详解#嗨学英语praised单词详解#request十秒单词速记#嗨学英语prepaid单词详解#嗨学英语credibility单词详解#fruit十秒单词速记#嗨学英语plow单词详解#caution十秒单词速记#嗨学英语scientific单词详解#嗨学英语popper单词详解#嗨学英语comedies单词详解#嗨学英语open单词详解#嗨学英语afloat单词详解#嗨学英语maniac单词详解#嗨学英语wondering单词详解#嗨学英语grudge单词详解#嗨学英语twilight单词详解#嗨学英语career单词详解#嗨学英语boot单词详解#嗨学英语triton单词详解#嗨学英语glaciers单词详解#嗨学英语records单词详解#嗨学英语over单词详解#嗨学英语erected单词详解#嗨学英语tuxedo单词详解#嗨学英语spend单词详解#嗨学英语so单词详解#嗨学英语firefighter单词详解#嗨学英语coordination单词详解#嗨学英语fiercely单词详解#嗨学英语exceed单词详解#嗨学英语viability单词详解#嗨学英语moisturizer单词详解#嗨学英语twins单词详解#嗨学英语dishwasher单词详解#嗨学英语hesitated单词详解#嗨学英语potty单词详解#嗨学英语reflector单词详解#嗨学英语washed单词详解#嗨学英语fugitive单词详解#嗨学英语gagman单词详解#嗨学英语exotic单词详解#嗨学英语permissive单词详解#嗨学英语onion单词详解#嗨学英语clothes单词详解#嗨学英语consisting单词详解#嗨学英语scissors单词详解#嗨学英语crunchy单词详解#嗨学英语encouragement单词详解#嗨学英语cut in line词组详解#嗨学英语chocolate单词详解#嗨学英语sanitary单词详解#嗨学英语lectures单词详解#嗨学英语tools单词详解#嗨学英语raise单词详解#attachment十秒单词速记#嗨学单词found#absorb十秒单词速记#嗨学英语red单词详解#嗨学英语consultant单词详解#嗨学英语life单词详解#嗨学英语doctorate单词详解#嗨学英语slurp单词详解#嗨学英语nap单词详解#嗨学英语shutterbug单词详解#嗨学英语rocker单词详解#嗨学英语earphone单词详解#嗨学英语undermine单词详解#嗨学英语comfortably单词详解#passage十秒单词速记#嗨学英语fetched单词详解#嗨学英语tap单词详解#嗨学英语relieve单词详解#嗨学英语wedding单词详解#嗨学英语beijing单词详解#invent十秒单词速记#嗨学英语electrical单词详解#嗨学英语denote单词详解#嗨学英语docs单词详解#嗨学英语substantiate单词详解#嗨学英语montage单词详解#嗨学英语hardware单词详解#嗨学英语medal单词详解#嗨学英语exists单词详解#嗨学英语freshness单词详解#warehouse十秒单词速记#嗨学英语struggles单词详解#嗨学英语translator单词详解#嗨学英语concerts单词详解#嗨学英语establishing单词详解#嗨学英语duel单词详解#absorb十秒单词速记#嗨学英语bulletin单词详解#嗨学英语hankie单词详解#嗨学英语example单词详解#嗨学英语railway单词详解#afford十秒单词速记#嗨学英语measured单词详解#嗨学英语hype单词详解#嗨学英语revere单词详解#嗨学英语visage单词详解#嗨学英语spade单词详解#嗨学英语asymmetry单词详解#嗨学英语hopelessly单词详解#嗨学英语labeled单词详解#嗨学英语amphibian单词详解#嗨学英语shellfish单词详解#嗨学英语telescope单词详解#嗨学英语intellect单词详解#嗨学英语nod单词详解#嗨学英语thriller单词详解#嗨学英语disillusioned单词详解#嗨学英语comma单词详解#嗨学英语lanterns单词详解#嗨学英语relocation单词详解#嗨学英语defeat单词详解#嗨学英语deed单词详解#嗨学英语cages单词详解#嗨学英语lettuce单词详解#嗨学英语parents单词详解#嗨学英语monday单词详解#嗨学英语function单词详解#嗨学英语generator单词详解#嗨学英语alleviate单词详解#嗨学英语armpit单词详解#嗨学英语donors单词详解#嗨学英语ages单词详解#嗨学英语barber单词详解#嗨学英语scarcely单词详解#嗨学英语pass by词组详解#嗨学英语garner单词详解#嗨学单词race#嗨学英语craw单词详解#嗨学英语article单词详解#嗨学英语bumble单词详解#嗨学英语jack单词详解#嗨学英语dinghy单词详解#嗨学英语shines单词详解#嗨学英语anticipate单词详解#嗨学英语cruelty单词详解#嗨学英语banking单词详解#嗨学英语hilarious单词详解#嗨学英语as a whole单词详解#嗨学英语playground单词详解#嗨学英语seals单词详解#嗨学英语make the bed词组详解#嗨学英语friendship单词详解#嗨学英语biological单词详解#嗨学英语institutions单词详解#嗨学英语architectural单词详解#嗨学英语satisfied单词详解#嗨学英语codex单词详解#嗨学英语glamorous单词详解#responsible十秒单词速记#嗨学英语malice单词详解#嗨学英语consultative单词详解#嗨学单词solve#嗨学英语iron单词详解#嗨学英语smoothly单词详解#嗨学英语chic单词详解#嗨学英语hymn单词详解#嗨学单词easy#嗨学英语bandwidth单词详解#嗨学英语beings单词详解#嗨学英语enclosure单词详解#嗨学英语affordable单词详解#magic十秒单词速记#嗨学英语scratched单词详解#嗨学英语trash单词详解#嗨学英语others单词详解#嗨学英语manipulated单词详解#嗨学英语structures单词详解#嗨学英语brood单词详解#嗨学英语stochastic单词详解#嗨学英语mossy单词详解#嗨学英语esteem单词详解#嗨学单词climb#嗨学英语gimme单词详解#嗨学英语cosmetics单词详解#嗨学英语tout单词详解#嗨学英语affix单词详解#嗨学英语admiral单词详解#嗨学英语duvet单词详解#aim十秒单词速记#嗨学英语gazelle单词详解#嗨学英语jaws单词详解#嗨学英语amaze单词详解#嗨学英语jut单词详解#嗨学英语Thing单词详解#嗨学英语books单词详解#compile十秒单词速记#exhaust十秒单词速记#嗨学英语geranium单词详解#嗨学英语halve单词详解#嗨学英语pouring单词详解#嗨学英语ever单词详解#嗨学英语burn单词详解#嗨学英语any单词详解#嗨学英语characters单词详解#嗨学英语lagoon单词详解#嗨学英语comet单词详解#嗨学英语Banana单词详解#warehouse十秒单词速记#嗨学英语so单词详解#嗨学单词solution#嗨学英语onward单词详解#嗨学单词true#嗨学英语rose单词详解#嗨学英语lightening单词详解#嗨学英语astronomical单词详解#嗨学英语bandit单词详解#嗨学英语homepage单词详解#嗨学英语undertaken单词详解#嗨学英语capitalist单词详解#嗨学英语priority单词详解#嗨学英语mere单词详解#嗨学英语backspace单词详解#嗨学英语realism单词详解#condition十秒单词速记#嗨学英语submitted单词详解#aggressive十秒单词速记#嗨学英语regards单词详解#嗨学英语wedding单词详解#嗨学英语loosen单词详解#嗨学单词lovely#嗨学英语fortune单词详解#narrow十秒单词速记#嗨学英语reopen单词详解#嗨学英语distinguished单词详解#嗨学英语contingency单词详解#嗨学英语euphoria单词详解#嗨学英语folly单词详解#嗨学英语astronomer单词详解#嗨学英语believe单词详解#嗨学英语clarinet单词详解#quarrel十秒单词速记#嗨学英语antitrust单词详解#嗨学英语bring out单词详解#display十秒单词速记#嗨学英语recreation单词详解#嗨学英语projection单词详解#嗨学英语word单词详解#嗨学英语shellfish单词详解#嗨学英语handled单词详解#嗨学英语confidence单词详解#嗨学英语human单词详解#嗨学英语maiden单词详解#嗨学英语losing单词详解#嗨学英语eve单词详解#嗨学英语accessories单词详解#嗨学英语zebra单词详解#divert十秒单词速记#嗨学英语flavour单词详解#嗨学英语lacking单词详解#嗨学英语concentrate单词详解#嗨学英语anticipation单词详解#嗨学英语independent单词详解#嗨学英语armpit单词详解#嗨学英语distinguishing单词详解#嗨学英语gratification单词详解#嗨学英语acoustic单词详解#嗨学英语antiseptic单词详解#嗨学英语preset单词详解#嗨学英语snowflake单词详解#嗨学英语filetype单词详解#submit十秒单词速记#嗨学英语harper单词详解#嗨学英语weeping单词详解#嗨学英语pop单词详解#嗨学英语pursuit单词详解#嗨学英语logs单词详解#嗨学英语coyote单词详解#嗨学英语inventive单词详解#嗨学英语throwing单词详解#嗨学英语unseen单词详解#嗨学英语considerably单词详解#嗨学英语universe单词详解#嗨学英语messaging单词详解#嗨学英语heritage单词详解#嗨学英语predict单词详解#嗨学英语tries单词详解#嗨学单词else#嗨学英语awesome单词详解#嗨学英语degree单词详解#嗨学英语surveillance单词详解#嗨学英语eff单词详解#嗨学英语surfing单词详解#嗨学英语forestry单词详解#嗨学英语operating单词详解#嗨学英语scratched单词详解#嗨学单词lose#嗨学英语grammatical单词详解#嗨学英语arrows单词详解#嗨学英语bonded单词详解#嗨学英语asthma单词详解#嗨学英语prostate单词详解#嗨学英语crook单词详解#嗨学英语lean on词组详解#嗨学英语gamers单词详解#嗨学英语join单词详解#嗨学英语forward单词详解#嗨学英语losing单词详解#嗨学英语run around词组详解#嗨学英语rising单词详解#嗨学英语international单词详解#嗨学英语homesick单词详解#嗨学英语stickre单词详解#嗨学英语bore单词详解#嗨学英语chimp单词详解#嗨学英语bias单词详解#嗨学英语deans单词详解#嗨学英语enzyme单词详解#嗨学英语destined单词详解#嗨学英语sweaty单词详解#嗨学英语tractor单词详解#嗨学英语battles单词详解#嗨学英语organised单词详解#嗨学英语runner单词详解#嗨学英语saw单词详解#嗨学英语moustache单词详解#嗨学英语nip单词详解#嗨学英语narrate单词详解#嗨学英语canna单词详解#嗨学英语quotation单词详解#foresee十秒单词速记#expensive十秒单词速记#嗨学英语factor单词详解#嗨学英语vessels单词详解#嗨学英语irrelevant单词详解#嗨学英语exec单词详解#嗨学英语jaws单词详解#嗨学英语detected单词详解#嗨学单词Scared#嗨学英语alias单词详解#嗨学英语dock单词详解#嗨学英语baptist单词详解#嗨学英语exceptional单词详解#嗨学单词Desk#嗨学英语gluttony单词详解#嗨学英语chorus单词详解#嗨学英语lamb单词详解#嗨学英语deficit单词详解#嗨学英语mental单词详解#嗨学英语understand单词详解#嗨学英语sever单词详解#嗨学英语purposes单词详解#嗨学英语realism单词详解#嗨学英语carbonate单词详解#嗨学英语intestines单词详解#嗨学英语homogeneous单词详解#嗨学英语hibernation单词详解#嗨学英语ago单词详解#嗨学英语bonsai单词详解#嗨学英语cupboard单词详解#嗨学英语notification单词详解#嗨学英语hurting单词详解#嗨学单词boat#嗨学英语astronomical单词详解#嗨学英语fallout单词详解#嗨学英语formal单词详解#嗨学英语inference单词详解#嗨学英语buildings单词详解#嗨学英语environmentally单词详解#嗨学英语winner单词详解#嗨学英语beings单词详解#嗨学英语froggy单词详解#嗨学英语abracadabra单词详解#cooperate十秒单词速记#嗨学英语prac单词详解#嗨学单词available#嗨学英语obsessed单词详解#adventure十秒单词速记#嗨学英语snail单词详解#嗨学单词kitchen#嗨学英语gaze单词详解#嗨学英语eternally单词详解#嗨学英语outside单词详解#嗨学英语crystalline单词详解#嗨学英语tech单词详解#嗨学英语perception单词详解#嗨学英语confrontation单词详解#嗨学英语replay单词详解#嗨学英语speechless单词详解#嗨学英语filler单词详解#嗨学英语heighten单词详解#嗨学英语denial单词详解#嗨学英语fundraising单词详解#嗨学英语elevate单词详解#嗨学英语abound单词详解#嗨学英语tits单词详解#嗨学英语sought单词详解#嗨学英语counterbalance单词详解#嗨学英语dialed单词详解#嗨学英语excessively单词详解#嗨学英语fertilizer单词详解#嗨学英语rehearsal单词详解#嗨学英语friendly单词详解#嗨学英语quintessence单词详解#嗨学英语enforced单词详解#defer十秒单词速记#嗨学英语egg单词详解#嗨学英语cipher单词详解#嗨学英语dimension单词详解#嗨学英语modulate单词详解#嗨学英语honesty单词详解#嗨学英语research单词详解#嗨学英语conn单词详解#resist十秒单词速记#嗨学英语relief单词详解#嗨学英语handed单词详解#嗨学英语confidential单词详解#嗨学英语baboon单词详解#嗨学英语twitter单词详解#嗨学英语involuntary单词详解#嗨学英语lanterns单词详解#嗨学英语disciplines单词详解#嗨学英语degradation单词详解#嗨学英语latitude单词详解#嗨学英语accident单词详解#嗨学英语adjustable单词详解#嗨学英语instructions单词详解#嗨学英语continue单词详解#嗨学英语lips单词详解#嗨学英语plantation单词详解#嗨学英语worldwide单词详解#嗨学英语informative单词详解#嗨学英语riddle单词详解#嗨学英语civilian单词详解#嗨学英语airbag单词详解#嗨学英语brunch单词详解#嗨学英语avert单词详解#嗨学英语saliva单词详解#careful十秒单词速记#嗨学英语vampire单词详解#嗨学英语froggy单词详解#嗨学英语path单词详解#嗨学英语cellular单词详解#嗨学单词Simple#considerate十秒单词速记#嗨学英语signs单词详解#嗨学英语pure单词详解#convict十秒单词速记#嗨学英语filled单词详解#嗨学英语equity单词详解#嗨学英语horizons单词详解#嗨学英语daisies单词详解#convert十秒单词速记#嗨学英语configure单词详解#嗨学英语plants单词详解#嗨学英语billiard单词详解#嗨学英语no problem词组详解#嗨学英语space单词详解#嗨学英语sting单词详解#嗨学英语spirit单词详解#嗨学英语divides单词详解#嗨学英语cheerleader单词详解#嗨学英语linear单词详解#嗨学英语gird单词详解#嗨学英语wire单词详解#嗨学英语vindicate单词详解#嗨学英语retention单词详解#嗨学英语billiard单词详解#嗨学英语challenged单词详解#嗨学英语wealthy单词详解#嗨学英语angelica单词详解#嗨学英语promise单词详解#嗨学英语excited单词详解#嗨学英语celesta单词详解#嗨学英语decathlon单词详解#嗨学英语lexical单词详解#嗨学英语shout单词详解#嗨学英语blurry单词详解#嗨学单词artist#嗨学英语preset单词详解#嗨学英语dimples单词详解#嗨学英语calmly单词详解#嗨学英语treatment单词详解#嗨学英语massacre单词详解#嗨学英语arise单词详解#嗨学单词baby#嗨学英语mercy单词详解#嗨学英语prohibit单词详解#嗨学英语slogan单词详解#嗨学英语decisive单词详解#嗨学英语in case of词组详解#嗨学英语yet单词详解#嗨学单词climb#嗨学英语headlight单词详解#嗨学英语sharks单词详解#嗨学英语lotus单词详解#lip十秒单词速记#嗨学英语aster单词详解#嗨学英语wretched单词详解#嗨学英语keyboard单词详解#嗨学英语basement单词详解#嗨学英语guaranteed单词详解#嗨学英语do单词详解#嗨学英语close单词详解#嗨学英语dreary单词详解#嗨学英语gravitational单词详解#嗨学英语costs单词详解#嗨学英语art单词详解#嗨学英语ham单词详解#嗨学英语regional单词详解#嗨学英语founding单词详解#嗨学英语antitrust单词详解#嗨学英语barriers单词详解#嗨学英语lax单词详解#嗨学英语disadvantage单词详解#嗨学英语inflict单词详解#嗨学英语areas 单词详解#嗨学英语electron单词详解#嗨学英语did单词详解#嗨学英语say单词详解#嗨学英语valley单词详解#嗨学英语iguana单词详解#嗨学英语lot单词详解#嗨学英语spur单词详解#嗨学英语sustainable单词详解#嗨学英语anus单词详解#嗨学英语ruck单词详解#嗨学英语detrimental单词详解#嗨学英语prognosis单词详解#嗨学英语rising单词详解#嗨学英语doubted单词详解#嗨学英语learner单词详解#嗨学英语tendency单词详解#嗨学英语get home词组详解#嗨学英语movie单词详解#嗨学英语explosion单词详解#嗨学英语hamburgers单词详解#嗨学英语celestial单词详解#嗨学英语continuity单词详解#enroll十秒单词速记#嗨学英语tripped单词详解#嗨学英语butler单词详解#嗨学英语reptile单词详解#嗨学英语nonsensical单词详解#嗨学英语broken单词详解#嗨学英语penetrate单词详解#嗨学英语billion单词详解#嗨学单词Project#commit十秒单词速记#嗨学英语cavity单词详解#嗨学英语Recognize单词详解#嗨学英语potter单词详解#嗨学英语platinum单词详解#嗨学英语auntie单词详解#嗨学英语booth单词详解#嗨学英语respectful单词详解#嗨学英语pingpong单词详解#嗨学英语clues单词详解#嗨学英语mile单词详解#嗨学英语barefoot单词详解#嗨学英语access denied单词详解#嗨学英语rewarded单词详解#嗨学英语kitchen单词详解#嗨学英语vowed单词详解#refuge十秒单词速记#嗨学英语airports单词详解#嗨学英语survivors单词详解#嗨学英语faux单词详解#嗨学英语stove单词详解#嗨学英语complimentary单词详解#嗨学英语endogenous单词详解#嗨学英语fetched单词详解#嗨学英语conundrum单词详解#嗨学英语credential单词详解#嗨学英语blurry单词详解#嗨学英语waterproof单词详解#嗨学英语bless单词详解#嗨学英语sensor单词详解#嗨学英语firemen单词详解#fruit十秒单词速记#嗨学英语moonlight单词详解#嗨学英语savior单词详解#嗨学英语unconventional单词详解#greenhouse十秒单词速记#嗨学英语sharpen单词详解#嗨学英语uprising单词详解#嗨学英语advertised单词详解#嗨学英语bliss单词详解#嗨学英语incorporate单词详解#嗨学英语tulip单词详解#嗨学英语audacious单词详解#嗨学英语citron单词详解#嗨学英语alpaca单词详解#嗨学英语eradicate单词详解#嗨学英语peak单词详解#嗨学英语notify单词详解#嗨学英语copy单词详解#嗨学英语diagram单词详解#嗨学英语pair单词详解#嗨学英语bray单词详解#嗨学英语fib单词详解#嗨学英语thirst单词详解#嗨学英语dog单词详解#嗨学英语epicenter单词详解#嗨学英语conditioner单词详解#嗨学英语dauntless单词详解#嗨学英语caring单词详解#嗨学英语biographical单词详解#嗨学英语lobster单词详解#嗨学英语admiring单词详解#嗨学英语corrosive单词详解#嗨学英语brightest单词详解#嗨学英语withstand单词详解#嗨学英语slide单词详解#subsequent十秒单词速记#嗨学英语torpedo单词详解#嗨学英语comforting单词详解#嗨学英语Crawling单词详解#嗨学英语heroes单词详解#嗨学英语aspirational单词详解#嗨学英语injuries单词详解#嗨学英语exercising单词详解#嗨学英语fists单词详解#嗨学英语uncertainty单词详解#嗨学单词Fantastic#嗨学英语oatmeal单词详解#嗨学英语amidst单词详解#contact十秒单词速记#conduct十秒单词速记#嗨学英语fruitless单词详解#嗨学单词lovely快速记忆#嗨学英语hanged单词详解#嗨学英语essay单词详解#嗨学英语divergence单词详解#嗨学英语beliefs单词详解#嗨学英语laser单词详解#嗨学英语homes单词详解#together十秒单词速记#嗨学英语gangster单词详解#advocate十秒单词速记#嗨学英语dreamed单词详解#嗨学英语integer单词详解#嗨学英语moments单词详解#嗨学英语rub单词详解#嗨学英语anaerobic单词详解#嗨学英语victor单词详解#嗨学英语badges单词详解#嗨学英语cede单词详解#嗨学英语aloof单词详解#嗨学英语might单词详解#嗨学英语pale单词详解#嗨学英语foretell单词详解#嗨学英语beijing单词详解#嗨学英语kicked单词详解#嗨学英语knee单词详解#嗨学英语start单词详解#嗨学英语return单词详解#嗨学英语virtually单词详解#嗨学英语fortune单词详解#嗨学英语harsh单词详解#嗨学单词Large快速记忆#嗨学英语similarity单词详解#嗨学英语substrate单词详解#嗨学英语untamed单词详解#嗨学英语lectures单词详解#嗨学英语hostess单词详解#嗨学英语avoidable单词详解#嗨学英语scratch单词详解#嗨学英语affix单词详解#嗨学英语exquisite单词详解#嗨学英语contemporary单词详解#doubt十秒单词速记#嗨学英语rendering单词详解#嗨学英语praised单词详解#嗨学英语butter单词详解#嗨学英语help单词详解#嗨学英语halo单词详解#嗨学英语scientific单词详解#嗨学英语bee单词详解#afford十秒单词速记#嗨学英语correct单词详解#嗨学英语quizzes单词详解#嗨学单词bored#嗨学英语clink单词详解#嗨学英语stations单词详解#嗨学英语gem单词详解#嗨学英语copper单词详解#嗨学单词lose快速记忆#嗨学英语guys单词详解#嗨学英语beast单词详解#嗨学英语alway单词详解#嗨学英语convention单词详解#嗨学英语provocative单词详解#嗨学英语make up one词组详解#嗨学英语uptown单词详解#嗨学单词mother#嗨学英语Success单词详解#嗨学单词family#嗨学英语booster单词详解#嗨学英语robbers单词详解#嗨学英语revised单词详解#嗨学英语ritual单词详解#嗨学英语hides单词详解#嗨学英语loaded单词详解#嗨学英语aspiring单词详解#嗨学英语table单词详解#嗨学英语surrounding单词详解#嗨学英语cannibal单词详解#嗨学英语nylon单词详解#嗨学英语will单词详解#嗨学英语vastly单词详解#嗨学英语aerobic单词详解#嗨学英语celebrate单词详解#嗨学英语plunged单词详解#nominate十秒单词速记#嗨学英语lawn单词详解#嗨学英语sometimes单词详解#嗨学英语tennis单词详解#嗨学英语afloat单词详解#嗨学英语financial单词详解#嗨学英语vanish单词详解#嗨学英语squad单词详解#嗨学英语bustling单词详解#嗨学英语our单词详解#嗨学英语make out词组详解#嗨学英语angelica单词详解#action十秒单词速记#嗨学英语diabetes单词详解#嗨学英语addressed单词详解#嗨学英语automated单词详解#嗨学单词waited#嗨学英语spline单词详解#嗨学英语cocktail单词详解#嗨学英语shape单词详解#嗨学英语godfather单词详解#嗨学英语foster单词详解#嗨学英语literature单词详解#嗨学英语weaver单词详解#嗨学英语crowbar单词详解#嗨学英语workshop单词详解#嗨学英语magnet单词详解#嗨学英语gerbil单词详解#嗨学英语shuttle单词详解#嗨学英语fuel单词详解#嗨学英语freezes单词详解#contigious十秒单词速记#嗨学英语strict单词详解#嗨学英语hiss单词详解#嗨学英语gowns单词详解#vice十秒单词速记#嗨学英语bitterness单词详解#嗨学英语elan单词详解#嗨学英语luggage单词详解#嗨学英语atone单词详解#嗨学英语tactic单词详解#嗨学英语see off词组详解#嗨学英语euphemism单词详解#嗨学英语stammer单词详解#嗨学英语austra单词详解#嗨学英语identified单词详解#嗨学英语clumsily单词详解#嗨学英语words单词详解#嗨学英语demonstrated单词详解#嗨学英语wreak单词详解#嗨学英语vowel单词详解#嗨学英语accuracy单词详解#嗨学英语beard单词详解#嗨学英语voucher单词详解#嗨学英语maker单词详解#嗨学英语seeker单词详解#嗨学英语grave单词详解#嗨学英语blast单词详解#嗨学英语tragic单词详解#嗨学单词solution#嗨学英语values单词详解#嗨学英语catastrophic单词详解#嗨学英语correspondent单词详解#嗨学英语accustomed单词详解#嗨学英语sane单词详解#嗨学英语guru单词详解#嗨学英语attest单词详解#嗨学英语theatre单词详解#嗨学英语cling单词详解#嗨学英语crisps单词详解#嗨学英语broadcast单词详解#嗨学英语grow单词详解#嗨学英语firefighter单词详解#嗨学英语countryside单词详解#嗨学英语saturated单词详解#嗨学英语outlaw单词详解#嗨学英语airbag单词详解#嗨学英语dull单词详解#嗨学英语harmonica单词详解#嗨学英语whereas单词详解#嗨学英语trill单词详解#嗨学英语impala单词详解#嗨学英语bomber单词详解#嗨学英语lemur单词详解#嗨学英语hang单词详解#嗨学单词poor#嗨学英语screen单词详解#嗨学单词patient#嗨学英语yurt单词详解#嗨学英语admiration单词详解#嗨学英语bough单词详解#嗨学英语fooled单词详解#嗨学英语straight单词详解#嗨学英语equipped单词详解#嗨学英语mean单词详解#嗨学英语excavate单词详解#嗨学英语Mr right词组详解#嗨学英语cracker单词详解#嗨学英语crux单词详解#嗨学英语depot单词详解#嗨学英语exalt单词详解#嗨学英语cadence单词详解#嗨学英语hinder单词详解#嗨学英语extra单词详解#submit十秒单词速记#嗨学英语chapel单词详解#嗨学英语consideration单词详解#嗨学英语declining单词详解#嗨学英语forced单词详解#嗨学英语peck单词详解#嗨学英语ranking单词详解#嗨学英语sliding单词详解#嗨学英语strings单词详解#嗨学英语holdup单词详解#嗨学英语brass单词详解#嗨学英语imitate单词详解#嗨学英语high school词组详解#嗨学英语yip单词详解#嗨学英语detection单词详解#compassion十秒单词速记#嗨学英语blended单词详解#嗨学英语diaper单词详解#嗨学英语uniformity单词详解#tolerate十秒单词速记#嗨学英语unify单词详解#嗨学英语besiege单词详解#嗨学英语metres单词详解#嗨学英语artillery单词详解#嗨学英语became单词详解#嗨学英语pedagogy单词详解#嗨学英语fillet单词详解#嗨学英语region单词详解#aggressive十秒单词速记#嗨学英语written单词详解#嗨学英语awoke单词详解#嗨学英语thunderstorm单词详解#嗨学英语workstation单词详解#嗨学英语beside the door单词详解#嗨学英语yoke单词详解#嗨学英语surroundings单词详解#嗨学英语accession单词详解#valuable十秒单词速记#嗨学英语flies单词详解#嗨学英语doable单词详解#嗨学英语backbone单词详解#嗨学英语entrance单词详解#嗨学英语sliver单词详解#嗨学英语stream单词详解#嗨学英语paradoxical单词详解#嗨学英语tumble单词详解#happen十秒单词速记#嗨学单词colour#嗨学英语colors单词详解#嗨学英语vigorously单词详解#嗨学英语revoke单词详解#嗨学英语lorry单词详解#嗨学单词about#嗨学英语cub单词详解#嗨学英语coercive单词详解#嗨学英语anorexia单词详解#嗨学英语blunt单词详解#嗨学英语booger单词详解#嗨学英语chiick单词详解#嗨学英语lament单词详解#嗨学英语hobby单词详解#嗨学英语relieve单词详解#season十秒单词速记#嗨学单词Scared快速记忆#嗨学英语hectic单词详解#嗨学英语clove单词详解#嗨学英语trivial单词详解#嗨学英语clinical单词详解#嗨学英语accountant单词详解#嗨学英语hazard单词详解#嗨学英语chastity单词详解#嗨学英语banner单词详解#嗨学英语pointed单词详解#嗨学英语speak单词详解#嗨学英语percent单词详解#嗨学英语spurious单词详解#嗨学英语technology单词详解#嗨学英语beauty单词详解#嗨学英语cordial单词详解#嗨学英语greedy单词详解#嗨学英语ice单词详解#嗨学英语chaotic单词详解#嗨学英语falsehood单词详解#嗨学英语racist单词详解#嗨学单词high#嗨学英语derived单词详解#嗨学英语goose单词详解#嗨学英语scheme单词详解#嗨学英语escalate单词详解#嗨学英语fledgling单词详解#嗨学英语influx单词详解#嗨学英语plow单词详解#嗨学英语correlate单词详解#嗨学英语advocated单词详解#嗨学英语cheerleader单词详解#pool十秒单词速记#嗨学英语unprecedented单词详解#嗨学英语continued单词详解#嗨学英语criticise单词详解#嗨学英语apostrophe单词详解#嗨学英语unreal单词详解#嗨学英语bubbles单词详解#嗨学英语snail单词详解#嗨学英语bulge单词详解#嗨学英语ending单词详解#嗨学英语scoop单词详解#嗨学英语faceless单词详解#嗨学英语tails单词详解#嗨学英语recipient单词详解#嗨学英语carmine单词详解#permit十秒单词速记#嗨学英语eagerness单词详解#嗨学英语heads单词详解#嗨学英语bootleg单词详解#嗨学英语snatch单词详解#嗨学英语privacy单词详解#嗨学英语meet with词组详解#嗨学英语self control词组详解#嗨学英语dud单词详解#嗨学英语shool单词详解#嗨学英语accidents单词详解#嗨学英语sure单词详解#嗨学英语due单词详解#嗨学英语solemn单词详解#嗨学英语involuntary单词详解#嗨学英语gene单词详解#嗨学英语vessel单词详解#嗨学英语leg单词详解#嗨学英语improve单词详解#嗨学英语void单词详解#嗨学英语daisy单词详解#嗨学英语settings单词详解#嗨学英语ideas单词详解#嗨学英语mates单词详解#compare十秒单词速记#嗨学英语corporation单词详解#嗨学英语daycare单词详解#passage十秒单词速记#嗨学英语crisis单词详解#嗨学英语clang单词详解#嗨学英语brown单词详解#嗨学英语lifts单词详解#嗨学英语subside单词详解#嗨学英语someone单词详解#嗨学英语prawn单词详解#嗨学英语shadow单词详解#嗨学英语policemen单词详解#嗨学英语alternatives单词详解#嗨学英语attitudes单词详解#postpone十秒单词速记#嗨学英语dominating单词详解#嗨学英语ink单词详解#嗨学英语personalized单词详解#嗨学英语preliminary单词详解#嗨学英语trapezoid单词详解#嗨学英语confucian单词详解#嗨学英语cereal单词详解#嗨学英语Huge单词详解#confluence十秒单词速记#嗨学英语positive单词详解#嗨学英语gymnastics单词详解#嗨学英语requirement单词详解#嗨学英语columns单词详解#嗨学英语mommy单词详解#嗨学英语bulge单词详解#嗨学英语dozen单词详解#嗨学英语gap year词组详解#congress十秒单词速记#嗨学英语adaptive单词详解#嗨学英语benign单词详解#嗨学英语gregarious单词详解#嗨学英语groan单词详解#嗨学英语blazer单词详解#嗨学英语cement单词详解#嗨学英语on no account词组详解#嗨学英语seemingly单词详解#嗨学英语comedian单词详解#嗨学英语firing单词详解#嗨学英语stereo单词详解#嗨学英语peasant单词详解#嗨学英语ghosting单词详解#嗨学英语grill单词详解#嗨学英语terminated单词详解#嗨学英语upset单词详解#嗨学英语villager单词详解#嗨学英语love is blind词组详解#嗨学英语executed单词详解#嗨学英语bathing单词详解#嗨学英语revelation单词详解#嗨学英语sip单词详解#嗨学英语disgusting单词详解#capable十秒单词速记#嗨学英语vampire单词详解#嗨学英语militant单词详解#嗨学英语prepare单词详解#嗨学英语faker单词详解#嗨学英语accordion单词详解#嗨学英语thriller单词详解#嗨学英语microwave单词详解#嗨学英语chile单词详解#嗨学英语thought单词详解#嗨学英语elective单词详解#嗨学英语dragged单词详解#invent十秒单词速记#嗨学英语keep alive词组详解#嗨学英语april单词详解#嗨学英语vase单词详解#嗨学英语wolf单词详解#嗨学英语scissor单词详解#嗨学英语attendance单词详解#嗨学英语traditionally单词详解#嗨学英语serial单词详解#嗨学英语provides单词详解#嗨学英语sunflower单词详解#嗨学英语spar单词详解#嗨学英语stabilize单词详解#嗨学英语bases单词详解#嗨学英语disinformation单词详解#嗨学英语frankly单词详解#嗨学英语flat单词详解#嗨学英语cracks单词详解#嗨学英语muscles单词详解#嗨学英语languish单词详解#嗨学英语unrest单词详解#嗨学英语appropriate单词详解#嗨学英语mountainous单词详解#嗨学英语coffin单词详解#嗨学英语status单词详解#嗨学英语seeing单词详解#嗨学英语uncertain单词详解#嗨学英语clue单词详解#嗨学英语enforcement单词详解#嗨学英语outward单词详解#嗨学英语forty单词详解#嗨学英语matters单词详解#嗨学英语eternity单词详解#嗨学英语desalination单词详解#嗨学英语cooking单词详解#嗨学英语appreciated单词详解#嗨学英语coil单词详解#嗨学英语transcend单词详解#嗨学英语ethic单词详解#嗨学英语fade away词组详解#嗨学英语sticky单词详解#嗨学英语deeper单词详解#嗨学英语standardization单词详解#嗨学英语amiable单词详解#request十秒单词速记#嗨学英语a handful of单词详解#嗨学英语worn单词详解#嗨学英语outing单词详解#嗨学英语slat单词详解#嗨学英语clef单词详解#嗨学英语whoop单词详解#嗨学英语hop单词详解#嗨学英语heroism单词详解#嗨学英语mainly单词详解#嗨学英语teach单词详解#嗨学英语norms单词详解#嗨学英语territory单词详解#嗨学英语blooming单词详解#嗨学英语saved单词详解#嗨学英语premium单词详解#嗨学英语leopard单词详解#嗨学英语lock单词详解#enclose十秒单词速记#嗨学英语barking单词详解#嗨学英语acceptance单词详解#嗨学英语bio单词详解#嗨学英语benevolent单词详解#warm十秒单词速记#嗨学英语sprain单词详解#嗨学英语alcoholic单词详解#嗨学英语powers单词详解#嗨学英语personal单词详解#嗨学英语suspicious单词详解#嗨学英语tripped单词详解#嗨学英语etymology单词详解#嗨学英语fermentation单词详解#嗨学英语chance单词详解#嗨学英语gloom单词详解#嗨学英语receive单词详解#嗨学英语attenuation单词详解#嗨学英语trail单词详解#嗨学英语montage单词详解#嗨学英语inspiring单词详解#嗨学英语elapse单词详解#嗨学英语cucumbers单词详解#嗨学英语starts单词详解#嗨学英语sermon单词详解#嗨学英语see to it词组详解#嗨学英语android单词详解#嗨学英语clockwork单词详解#嗨学英语emergence单词详解#嗨学英语trophy单词详解#嗨学英语if单词详解#嗨学英语Huge单词详解#嗨学英语prevail单词详解#嗨学英语picnic单词详解#嗨学英语maybe单词详解#嗨学英语synchronized单词详解#嗨学英语express单词详解#comprehend十秒单词速记#嗨学英语found单词详解#嗨学英语designing单词详解#嗨学英语anticipation单词详解#嗨学英语attest单词详解#嗨学英语boxer单词详解#嗨学英语electrician单词详解#嗨学英语cultivation单词详解#嗨学英语afraid单词详解#嗨学英语upside单词详解#嗨学英语deserts单词详解#嗨学英语enabling单词详解#fall十秒单词速记#嗨学英语berry单词详解#divide十秒单词速记#嗨学英语additionally单词详解#嗨学英语append单词详解#嗨学英语humiliation单词详解#嗨学英语morph单词详解#嗨学英语favor单词详解#嗨学英语aristocracy单词详解#嗨学英语mom单词详解#嗨学英语submarine单词详解#嗨学英语roundabout单词详解#嗨学英语soldiers单词详解#嗨学英语exposure单词详解#嗨学英语chemicals单词详解#嗨学英语annual单词详解#嗨学英语pipes单词详解#嗨学英语digest单词详解#嗨学英语suspicious单词详解#嗨学英语underneath单词详解#嗨学英语rags单词详解#嗨学英语shorts单词详解#嗨学英语brevity单词详解#嗨学英语sere单词详解#嗨学英语brocade单词详解#嗨学英语ferry单词详解#嗨学英语lest单词详解#嗨学英语potty单词详解#嗨学英语already单词详解#嗨学英语subsidiary单词详解#嗨学英语add单词详解#嗨学英语adequately单词详解#嗨学英语discounts单词详解#嗨学英语chain单词详解#嗨学英语caddy单词详解#嗨学英语restaurants单词详解#嗨学英语whiskey单词详解#嗨学英语under单词详解#嗨学英语solved单词详解#嗨学英语casino单词详解#嗨学英语restricted单词详解#嗨学英语fluke单词详解#嗨学英语dummy单词详解#嗨学英语swag单词详解#refuge十秒单词速记#嗨学英语laugher单词详解#嗨学英语accusation单词详解#嗨学英语riot单词详解#嗨学英语ashore单词详解#嗨学英语everywhere单词详解#嗨学英语tiny单词详解#嗨学英语celeste单词详解#嗨学英语night单词详解#嗨学英语script单词详解#嗨学英语prize单词详解#嗨学英语sore单词详解#嗨学英语being单词详解#嗨学英语notice单词详解#嗨学英语drowning单词详解#嗨学英语vulgar单词详解#嗨学英语policemen单词详解#嗨学英语traveled单词详解#嗨学英语record单词详解#嗨学英语fabric单词详解#嗨学英语demons单词详解#嗨学英语margin单词详解#嗨学英语sight单词详解#嗨学英语filled单词详解#嗨学英语remove单词详解#嗨学英语billboard单词详解#嗨学英语giraffes单词详解#嗨学英语fen单词详解#嗨学英语selection单词详解#嗨学英语integer单词详解#嗨学英语chances单词详解#嗨学英语char单词详解#嗨学英语smile单词详解#嗨学英语written单词详解#嗨学英语gets单词详解#嗨学英语pressing单词详解#嗨学英语hock单词详解#嗨学英语polka单词详解#嗨学英语brewing单词详解#嗨学英语relaxing单词详解#嗨学英语exceptional单词详解#嗨学英语revel单词详解#嗨学英语stare单词详解#嗨学英语monitor单词详解#嗨学英语housing单词详解#嗨学英语secret单词详解#report十秒单词速记#嗨学英语execution单词详解#嗨学英语heterogeneous单词详解#嗨学英语overwhelming单词详解#嗨学英语powder单词详解#嗨学英语violation单词详解#adventure十秒单词速记#bunch十秒单词速记#嗨学英语surround单词详解#嗨学英语baptist单词详解#嗨学英语jug单词详解#嗨学英语uncertain单词详解#嗨学英语dementia单词详解#consequence十秒单词速记#嗨学英语hunt单词详解#嗨学英语aims单词详解#嗨学英语handclap单词详解#嗨学英语cognitive单词详解#嗨学英语brim单词详解#advance十秒单词速记#嗨学英语sledge单词详解#嗨学英语collect单词详解#嗨学英语inventions单词详解#嗨学英语preliminary单词详解#hand十秒单词速记#嗨学英语imaginative单词详解#嗨学单词know#嗨学英语paly单词详解#嗨学英语bourgeois单词详解#嗨学英语materials单词详解#嗨学英语operated单词详解#嗨学英语too单词详解#嗨学英语thriller单词详解#嗨学英语heater单词详解#嗨学英语recommendation单词详解#嗨学英语chef单词详解#嗨学英语chair单词详解#嗨学英语perpetual单词详解#嗨学英语repaint单词详解#嗨学英语numb单词详解#嗨学英语torque单词详解#consume十秒单词速记#嗨学英语gourd单词详解#嗨学英语volcanic单词详解#嗨学英语apprehensive单词详解#try十秒单词速记#嗨学英语ragtime单词详解#嗨学英语asking单词详解#嗨学英语closure单词详解#嗨学英语overwatch单词详解#enforce十秒单词速记#嗨学英语confine单词详解#嗨学英语apathetic单词详解#嗨学英语nip单词详解#嗨学英语budge单词详解#嗨学英语dal单词详解#嗨学英语rainbow单词详解#嗨学英语sham单词详解#嗨学英语calculation单词详解#嗨学英语competition单词详解#嗨学英语gourd单词详解#嗨学英语fantasy单词详解#嗨学英语savannah单词详解#vice十秒单词速记#嗨学英语unilateral单词详解#嗨学英语image单词详解#嗨学英语disk单词详解#嗨学英语nationality单词详解#嗨学英语forgiveness单词详解#嗨学英语confined单词详解#嗨学英语insured单词详解#overwhelm十秒单词速记#嗨学英语furlough单词详解#嗨学英语addressed单词详解#嗨学英语belonging单词详解#嗨学英语boxing单词详解#嗨学英语dribble单词详解#嗨学英语lawyer单词详解#嗨学英语fruitful单词详解#嗨学英语software单词详解#嗨学英语censorship单词详解#report十秒单词速记#嗨学英语as busy as a bee词组详解#嗨学英语crows单词详解#嗨学英语spring单词详解#capable十秒单词速记#嗨学英语scout单词详解#嗨学英语face单词详解#嗨学英语mutton单词详解#嗨学英语swot单词详解#alter十秒速记#嗨学英语hung单词详解#嗨学单词Simple快速记忆#嗨学英语afterward单词详解#嗨学英语ignore单词详解#嗨学英语tar单词详解#嗨学英语utilitarian单词详解#嗨学英语estate单词详解#嗨学英语slowdown单词详解#submit十秒单词速记#嗨学英语officer单词详解#嗨学英语large单词详解#嗨学英语as busy as a bee单词详解#refuge十秒单词速记#嗨学英语toluene单词详解#嗨学英语lid单词详解#cherish十秒单词速记#嗨学英语despicable单词详解#嗨学英语phones单词详解#嗨学英语dwell单词详解#嗨学英语applauded单词详解#嗨学英语hostage单词详解#嗨学英语residence单词详解#嗨学英语sufficiency单词详解#嗨学英语blender单词详解#嗨学英语deal单词详解#嗨学英语showing单词详解#嗨学英语thermal单词详解#qualify十秒单词速记#嗨学英语hooves单词详解#嗨学英语congratulations单词详解#satisfy十秒单词速记#greenhouse十秒单词速记#嗨学英语indicative单词详解#嗨学英语deteriorate单词详解#borrow十秒单词速记#嗨学英语flamingo单词详解#嗨学英语absent单词详解#divert十秒单词速记#嗨学英语anaerobic单词详解#嗨学英语voluntary单词详解#嗨学英语fancy单词详解#嗨学英语item单词详解#嗨学英语cloth单词详解#嗨学英语terminated单词详解#嗨学英语diameter单词详解#嗨学英语hummel单词详解#嗨学英语seemed单词详解#嗨学英语rampage单词详解#嗨学英语extreme单词详解#嗨学英语lover单词详解#嗨学英语architecture单词详解#devote十秒单词速记#嗨学英语nonsensical单词详解#delicious十秒单词速记#嗨学英语kook单词详解#嗨学英语polka单词详解#嗨学英语recent单词详解#嗨学英语balls单词详解#嗨学英语greedy单词详解#嗨学英语our单词详解#嗨学英语opinions单词详解#嗨学单词Scared#嗨学英语file单词详解#嗨学英语disapproving单词详解#嗨学英语shake单词详解#嗨学英语conundrum单词详解#嗨学英语vibe单词详解#嗨学英语pit单词详解#嗨学英语sixth单词详解#嗨学英语crayon单词详解#嗨学英语mesa单词详解#嗨学英语flames单词详解#嗨学英语violinist单词详解#嗨学英语doctorate单词详解#嗨学英语original单词详解#嗨学英语get the hang of词组详解#嗨学英语intersect单词详解#嗨学英语cartoons单词详解#嗨学英语youthful单词详解#嗨学英语rover单词详解#嗨学英语thoughtful单词详解#嗨学英语rag单词详解#嗨学英语tricks单词详解#expensive十秒单词速记#嗨学英语headquarter单词详解#嗨学英语these单词详解#嗨学英语result单词详解#嗨学英语towards单词详解#嗨学英语magnificent单词详解#嗨学英语optimum单词详解#嗨学英语advice单词详解#嗨学英语surprisingly单词详解#嗨学英语recognized单词详解#嗨学英语spider单词详解#嗨学英语centric单词详解#嗨学英语lubricant单词详解#嗨学英语flexibility单词详解#嗨学英语business单词详解#嗨学英语bowling单词详解#嗨学英语conjecture单词详解#嗨学英语scanner单词详解#嗨学英语sucrose单词详解#嗨学英语location单词详解#嗨学英语bear单词详解#嗨学英语fucker单词详解#嗨学英语blooms单词详解#嗨学英语backcountry单词详解#嗨学英语Text单词详解#嗨学英语grey单词详解#嗨学英语sources单词详解#嗨学英语represents单词详解#嗨学英语burst单词详解#嗨学英语indeed单词详解#嗨学英语Tummy单词详解#嗨学英语cage单词详解#嗨学英语accessibility单词详解#嗨学英语hatched单词详解#嗨学英语cue单词详解#嗨学单词Promise#嗨学英语wonders单词详解#rely十秒单词速记#嗨学英语rant单词详解#嗨学英语grandpas单词详解#嗨学英语aptitude单词详解#嗨学英语appliances单词详解#嗨学单词Large#嗨学英语outperform单词详解#嗨学英语backlog单词详解#嗨学英语awoke单词详解#嗨学英语reservoir单词详解#嗨学英语treated单词详解#嗨学英语crouch单词详解#嗨学英语horseshoe单词详解#嗨学英语harem单词详解#嗨学英语missed单词详解#嗨学英语skim单词详解#嗨学英语sigh单词详解#嗨学英语attest单词详解#嗨学英语azure单词详解#嗨学英语terrify单词详解#嗨学英语hostage单词详解#嗨学英语dragged单词详解#嗨学英语wrist单词详解#嗨学英语absorption单词详解#嗨学英语thirsty单词详解#嗨学英语underlie单词详解#嗨学英语beside the door词组详解#嗨学英语retail单词详解#嗨学英语hanged单词详解#嗨学英语lorry单词详解#嗨学英语Knife单词详解#嗨学英语exemplify单词详解#嗨学英语sofa单词详解#嗨学英语press单词详解#嗨学英语believer单词详解#嗨学英语communication单词详解#嗨学英语biking单词详解#嗨学英语accounting单词详解#嗨学英语sneaky单词详解#嗨学英语burnt单词详解#嗨学单词boat#嗨学英语unseen单词详解#嗨学英语enema单词详解#嗨学英语spilt单词详解#嗨学英语improbable单词详解#嗨学单词lovely快速记忆#嗨学英语crystallize单词详解#嗨学英语fatality单词详解#嗨学英语amenities单词详解#嗨学英语stupid单词详解#嗨学英语simply单词详解#嗨学英语depose单词详解#嗨学英语generally单词详解#嗨学英语officially单词详解#嗨学英语flame单词详解#嗨学英语stair单词详解#嗨学英语stairs单词详解#嗨学英语bell单词详解#嗨学英语quote单词详解#嗨学英语imagery单词详解#嗨学英语waved单词详解#嗨学英语exceedingly单词详解#嗨学英语finds单词详解#嗨学英语evenly单词详解#嗨学英语fulfilling单词详解#嗨学英语economist单词详解#嗨学英语bait单词详解#嗨学英语majesty单词详解#嗨学英语nor单词详解#嗨学英语power单词详解#嗨学英语chewing单词详解#嗨学英语whilst单词详解#嗨学英语advertised单词详解#嗨学英语instructions单词详解#嗨学英语inherit单词详解#嗨学英语overdraft单词详解#嗨学英语occasionally单词详解#borrow十秒单词速记#嗨学英语snuggle单词详解#嗨学英语in summer词组详解#嗨学英语artery单词详解#嗨学英语thermal单词详解#identify十秒单词速记#嗨学英语sentimental单词详解#嗨学英语oversleep单词详解#嗨学英语proposed单词详解#嗨学英语belief单词详解#嗨学英语ironing单词详解#嗨学英语interpolation单词详解#嗨学英语brief单词详解#嗨学英语castanets单词详解#嗨学英语earnest单词详解#嗨学英语elderly单词详解#嗨学英语aisles单词详解#嗨学英语greater单词详解#compare十秒单词速记#嗨学英语cruse单词详解#嗨学英语gator单词详解#嗨学英语mile单词详解#嗨学英语never单词详解#嗨学英语pentagon单词详解#嗨学单词bathroom#嗨学英语source单词详解#嗨学英语bowl单词详解#嗨学英语bulky单词详解#嗨学英语fern单词详解#嗨学英语coursework单词详解#嗨学英语group单词详解#嗨学英语crossroads单词详解#嗨学英语redline单词详解#嗨学英语won单词详解#嗨学英语pronoun单词详解#嗨学单词Simple快速记忆#嗨学英语workbook单词详解#嗨学英语immortals单词详解#嗨学英语easier单词详解#嗨学英语tracer单词详解#considerate十秒单词速记#嗨学英语cherry单词详解#嗨学英语absorption单词详解#嗨学英语admirable单词详解#嗨学英语after单词详解#嗨学英语letter单词详解#嗨学英语from time to time词组详解#嗨学英语oak单词详解#嗨学单词Simple#嗨学英语astounding单词详解#嗨学英语caused单词详解#daze十秒单词速记#嗨学英语shines单词详解#嗨学英语hutch单词详解#嗨学英语dynasties单词详解#嗨学英语japanese单词详解#嗨学英语contacts单词详解#嗨学英语base单词详解#嗨学英语asthma单词详解#嗨学英语trump单词详解#嗨学英语bamboo单词详解#嗨学英语caricature单词详解#嗨学英语padding单词详解#嗨学英语coaches单词详解#嗨学英语concentrations单词详解#嗨学英语casual单词详解#嗨学英语terribly单词详解#嗨学英语sale单词详解#嗨学英语drilling单词详解#嗨学英语rigid单词详解#嗨学英语coarse单词详解#嗨学英语khaki单词详解#嗨学英语helicopter单词详解#嗨学英语look back词组详解#嗨学英语loneliness单词详解#嗨学英语harpoon单词详解#嗨学英语hazardous单词详解#嗨学英语sizes单词详解#嗨学英语not only词组详解#嗨学英语catch out词组详解#嗨学英语symmetrical单词详解#嗨学英语moral单词详解#嗨学英语cognac单词详解#嗨学英语desires单词详解#嗨学英语civilization单词详解#嗨学英语villain单词详解#嗨学英语ignored单词详解#嗨学英语fiance单词详解#嗨学英语fleece单词详解#嗨学英语advocated单词详解#嗨学英语radiator单词详解#嗨学英语germs单词详解#嗨学英语utilities单词详解#嗨学英语anode单词详解#嗨学英语avenger单词详解#嗨学英语results单词详解#嗨学英语holidays单词详解#嗨学英语vessel单词详解#嗨学英语finishing单词详解#嗨学英语claims单词详解#嗨学英语cap单词详解#嗨学英语fought单词详解#嗨学英语survivors单词详解#嗨学英语feeble单词详解#嗨学英语wharf单词详解#嗨学英语genome单词详解#嗨学英语limousine单词详解#嗨学英语circumstance单词详解#嗨学英语vlog单词详解#嗨学英语sidewalk单词详解#嗨学英语villa单词详解#嗨学英语archer单词详解#嗨学英语magent单词详解#嗨学英语carb单词详解#嗨学英语indifferent单词详解#endure十秒单词速记#嗨学英语enquiry单词详解#嗨学英语germs单词详解#嗨学英语gifted单词详解#嗨学英语spill单词详解#嗨学英语coat单词详解#嗨学英语candle单词详解#嗨学英语verse单词详解#嗨学英语sportsman单词详解#嗨学英语concert hall词组详解#嗨学英语current单词详解#嗨学英语reproduce单词详解#嗨学英语austrian单词详解#嗨学英语unwrap单词详解#嗨学英语handsome单词详解#嗨学英语wand单词详解#嗨学英语brotherhood单词详解#嗨学英语superb单词详解#嗨学英语apathetic单词详解#嗨学英语sunshine单词详解#嗨学英语bartender单词详解#嗨学英语amateurs单词详解#嗨学英语coaster单词详解#嗨学英语specialties单词详解#嗨学英语glancing单词详解#嗨学英语crowns单词详解#嗨学英语apostrophe单词详解#declare十秒单词速记#doubt十秒单词速记#嗨学英语builder单词详解#嗨学英语butcher单词详解#flexible十秒单词速记#嗨学英语tape单词详解#嗨学英语highway单词详解#嗨学英语analyzing单词详解#嗨学英语opinions单词详解#嗨学英语high单词详解#perform十秒单词速记#嗨学英语target单词详解#嗨学英语all day单词详解#divide十秒单词速记#嗨学英语expressed单词详解#嗨学英语throne单词详解#嗨学英语interested单词详解#嗨学英语brigade单词详解#嗨学英语exotic单词详解#嗨学英语expressing单词详解#嗨学英语encompasses单词详解#嗨学英语outlet单词详解#嗨学英语jet单词详解#嗨学英语alpaca单词详解#嗨学英语chase单词详解#嗨学英语magician单词详解#嗨学英语attraction单词详解#dive十秒单词速记#嗨学英语outlaw单词详解#嗨学英语wife单词详解#嗨学英语name单词详解#嗨学英语supermen单词详解#嗨学英语frame单词详解#嗨学英语use单词详解#嗨学英语commercial单词详解#嗨学英语trash单词详解#嗨学英语spectre单词详解#嗨学英语intermediary单词详解#嗨学英语unauthorized单词详解#嗨学英语beaten单词详解#嗨学英语trapped单词详解#嗨学英语adopt单词详解#嗨学英语digit单词详解#嗨学英语learned单词详解#嗨学英语snakes单词详解#嗨学英语dependable单词详解#嗨学单词airline#嗨学英语citrus单词详解#嗨学英语correctly单词详解#嗨学英语breach单词详解#嗨学英语vitamin单词详解#嗨学英语harem单词详解#嗨学英语trifles单词详解#嗨学英语hotel单词详解#嗨学单词honey#嗨学英语constellation单词详解#嗨学英语nothing单词详解#嗨学英语lips单词详解#嗨学英语fork单词详解#嗨学英语adventures单词详解#dash十秒单词速记#嗨学英语aspiration单词详解#嗨学英语eye单词详解#嗨学英语provision单词详解#嗨学英语bespoke单词详解#嗨学英语separately单词详解#嗨学英语wobbly单词详解#嗨学英语paintings单词详解#嗨学英语favorable单词详解#嗨学英语gluttony单词详解#嗨学英语lined单词详解#嗨学英语clung单词详解#嗨学英语oak单词详解#嗨学英语lessons单词详解#嗨学英语screen单词详解#嗨学英语hearted单词详解#嗨学英语coworker单词详解#嗨学英语enlarge单词详解#嗨学英语provide单词详解#嗨学英语discussing单词详解#嗨学英语serenity单词详解#嗨学英语deepen单词详解#嗨学英语cardboard单词详解#嗨学英语crystalline单词详解#嗨学英语animation单词详解#嗨学英语forlorn单词详解#嗨学英语talked单词详解#嗨学英语splendor单词详解#嗨学英语limes单词详解#嗨学英语topics单词详解#嗨学英语enigma单词详解#嗨学英语halted单词详解#嗨学英语introduction单词详解#嗨学英语fare单词详解#perform十秒单词速记#嗨学英语illicit单词详解#嗨学英语persuasive单词详解#嗨学英语athletics单词详解#嗨学英语recruiting单词详解#嗨学英语patten单词详解#嗨学英语theatrical单词详解#嗨学英语resist单词详解#嗨学英语primacy单词详解#嗨学英语storm单词详解#嗨学英语bacteria单词详解#嗨学英语lazy单词详解#嗨学英语gunpowder单词详解#嗨学英语ankylosaurus单词详解#嗨学英语latency单词详解#嗨学英语blindfold单词详解#嗨学英语verdict单词详解#嗨学英语photography单词详解#嗨学英语submission单词详解#嗨学英语atypical单词详解#嗨学英语ape单词详解#嗨学英语reinforce单词详解#嗨学英语tubes单词详解#嗨学英语male单词详解#嗨学英语tooth单词详解#嗨学英语elephant单词详解#嗨学英语calmly单词详解#嗨学英语attempts单词详解#嗨学英语infected单词详解#嗨学英语tabby单词详解#嗨学英语motion单词详解#嗨学英语they单词详解#嗨学英语amenities单词详解#嗨学英语twisting单词详解#嗨学英语pointing单词详解#嗨学英语shrew单词详解#嗨学英语celebration单词详解#嗨学英语guesthouse单词详解#嗨学英语breathing单词详解#嗨学英语gyp单词详解#嗨学英语hooray单词详解#嗨学英语definitive单词详解#嗨学英语discreet单词详解#嗨学单词apple#嗨学英语aspiring单词详解#嗨学英语gentleness单词详解#嗨学英语agora单词详解#consume十秒单词速记#嗨学英语smells单词详解#嗨学英语pursuing单词详解#嗨学英语twisting单词详解#嗨学英语diversion单词详解#嗨学英语swimmer单词详解#嗨学英语selective单词详解#嗨学英语stores单词详解#嗨学英语bone单词详解#嗨学英语twig单词详解#嗨学英语stationary单词详解#嗨学英语bridges单词详解#嗨学英语trucks单词详解#嗨学英语assault单词详解#嗨学英语Uniform单词详解#嗨学英语play a part in词组详解#嗨学英语wash单词详解#嗨学英语weakly单词详解#嗨学英语plow单词详解#嗨学英语rumors单词详解#嗨学英语trained单词详解#嗨学英语aeon单词详解#嗨学英语log单词详解#嗨学英语bag单词详解#嗨学单词always#嗨学英语distinct单词详解#嗨学英语combined单词详解#嗨学英语viewer单词详解#嗨学英语patio单词详解#嗨学英语visibly单词详解#嗨学英语dated单词详解#嗨学英语closing单词详解#嗨学英语subtitle单词详解#嗨学英语ripe单词详解#嗨学英语swings单词详解#嗨学英语solely单词详解#嗨学英语scrambled单词详解#嗨学英语blank单词详解#嗨学英语expansive单词详解#嗨学英语straw单词详解#嗨学英语worth单词详解#嗨学英语cox单词详解#嗨学英语burrow单词详解#嗨学英语native speaker词组详解#嗨学英语uniqueness单词详解#嗨学英语consequent单词详解#嗨学英语peculiarity单词详解#嗨学英语owls单词详解#嗨学英语ventilator单词详解#嗨学英语camels单词详解#adapt十秒单词速记#嗨学英语immature单词详解#嗨学英语steamed单词详解#嗨学英语lemon单词详解#嗨学单词dinner#嗨学英语emissions单词详解#嗨学英语ful单词详解#pool十秒单词速记#嗨学英语color单词详解#嗨学英语battlefield单词详解#嗨学英语unlucky单词详解#嗨学英语contributor单词详解#嗨学英语accession单词详解#嗨学英语barge单词详解#嗨学英语lights单词详解#Bilingual十秒单词速记#drive十秒单词速记#嗨学英语sparing单词详解#嗨学英语weekday单词详解#嗨学英语algae单词详解#嗨学英语aromatherapy单词详解#嗨学英语practically单词详解#嗨学英语solicit单词详解#comfort十秒单词速记#嗨学英语lifeguard单词详解#嗨学英语regret单词详解#嗨学英语favorites单词详解#嗨学英语slime单词详解#嗨学英语continuity单词详解#嗨学英语weaver单词详解#嗨学英语languish单词详解#嗨学英语polka单词详解#嗨学英语bottleneck单词详解#嗨学英语tester单词详解#嗨学英语tut单词详解#嗨学英语autocratic单词详解#嗨学英语pullover单词详解#嗨学英语frugal单词详解#嗨学英语silver单词详解#嗨学英语variant单词详解#嗨学英语touches单词详解#嗨学英语experiment单词详解#嗨学英语permission单词详解#嗨学英语recipient单词详解#嗨学英语suburban单词详解#嗨学英语forex单词详解#嗨学英语colors单词详解#嗨学英语somebody单词详解#嗨学英语ducks单词详解#嗨学英语behaving单词详解#嗨学英语cowboy单词详解#嗨学英语bass单词详解#嗨学英语scheme单词详解#嗨学英语struggling单词详解#嗨学英语commentator单词详解#嗨学英语occasion单词详解#嗨学英语reign单词详解#嗨学英语compatibility单词详解#嗨学英语renaissance单词详解#嗨学英语clip单词详解#嗨学英语squawk单词详解#嗨学英语giraffes单词详解#嗨学英语shown单词详解#嗨学英语congestion单词详解#嗨学英语spoon单词详解#嗨学英语evening单词详解#嗨学英语strikes单词详解#嗨学英语artillery单词详解#嗨学英语precedent单词详解#嗨学英语audacious单词详解#嗨学英语markup单词详解#嗨学英语excursion单词详解#opposite十秒单词速记#嗨学英语mimosa单词详解#嗨学英语device单词详解#嗨学英语listen单词详解#different十秒单词速记#嗨学英语blah单词详解#together十秒单词速记#嗨学英语clamor单词详解#嗨学英语distortion单词详解#嗨学英语snacks单词详解#嗨学英语inner单词详解#嗨学英语sniper单词详解#嗨学英语november单词详解#嗨学英语weekend单词详解#嗨学英语orb单词详解#嗨学英语radioactivity单词详解#alternative十秒单词速记#嗨学英语ponytail单词详解#嗨学英语nearest单词详解#嗨学英语finish line词组详解#嗨学英语unable单词详解#嗨学英语bland单词详解#confine十秒单词速记#嗨学英语equity单词详解#嗨学英语mother单词详解#嗨学英语prudential单词详解#嗨学英语bonsai单词详解#嗨学英语accepting单词详解#嗨学英语session单词详解#嗨学英语bub单词详解#嗨学英语vine单词详解#嗨学英语aspiration单词详解#嗨学英语bourbon单词详解#嗨学英语prejudice单词详解#嗨学英语sheep单词详解#嗨学英语gasket单词详解#嗨学英语deny单词详解#嗨学英语talent单词详解#嗨学英语amateurs单词详解#嗨学英语belligerent单词详解#嗨学单词excited#嗨学英语whereby单词详解#abundant十秒单词速记#嗨学英语pretend单词详解#嗨学英语bone单词详解#嗨学英语mode单词详解#嗨学英语protocol单词详解#嗨学英语calcium单词详解#嗨学英语alcoholic单词详解#嗨学英语scuba单词详解#嗨学英语asking单词详解#嗨学英语quant单词详解#attempt十秒单词速记#嗨学英语domestication单词详解#嗨学英语biting单词详解#嗨学英语continuum单词详解#嗨学英语decency单词详解#consist十秒单词速记#contigious十秒单词速记#嗨学英语bookshelf单词详解#嗨学英语corps单词详解#嗨学英语atone单词详解#嗨学英语microphone单词详解#嗨学英语conservation单词详解#嗨学英语sink单词详解#嗨学英语hood单词详解#嗨学英语perfect单词详解#嗨学英语revitalize单词详解#嗨学英语eaten单词详解#嗨学英语thrived单词详解#嗨学英语setbacks单词详解#嗨学英语ideal单词详解#嗨学英语calculus单词详解#嗨学英语numbers单词详解#嗨学单词Introduce#嗨学英语reservoir单词详解#嗨学英语creak单词详解#嗨学英语transitional单词详解#嗨学英语multilingual单词详解#嗨学英语teamwork单词详解#嗨学英语punishment单词详解#嗨学英语bobber单词详解#嗨学英语activist单词详解#嗨学英语maths单词详解#嗨学英语pave单词详解#嗨学英语harnessed单词详解#嗨学英语cares单词详解#嗨学英语deter单词详解#嗨学英语envision单词详解#嗨学英语municipal单词详解#嗨学英语holistic单词详解#嗨学英语political单词详解#嗨学英语imagined单词详解#嗨学英语impedance单词详解#嗨学英语today单词详解#嗨学英语iteration单词详解#嗨学英语spanish单词详解#嗨学英语flung单词详解#嗨学英语divinity单词详解#嗨学英语audacious单词详解#嗨学单词listen#嗨学英语bazaar单词详解#嗨学英语wallet单词详解#嗨学单词allow#嗨学英语slipper单词详解#嗨学英语resin单词详解#嗨学英语dawg单词详解#嗨学英语speculate单词详解#嗨学英语jacket单词详解#嗨学英语baroque单词详解#嗨学英语reinforcement单词详解#嗨学英语syrup单词详解#嗨学英语hanger单词详解#嗨学英语qualifications单词详解#嗨学英语unlike单词详解#嗨学英语violate单词详解#possible十秒单词速记#嗨学英语bullet单词详解#嗨学英语gaining单词详解#嗨学英语narrate单词详解#嗨学英语thorn单词详解#嗨学英语real time词组详解#嗨学英语habitat单词详解#嗨学英语region单词详解#嗨学英语adequately单词详解#嗨学英语proclaimed单词详解#嗨学英语inquiry单词详解#嗨学英语infer单词详解#嗨学英语somber单词详解#嗨学英语curriculwn单词详解#嗨学英语bullying单词详解#嗨学英语evade单词详解#convey十秒单词速记#嗨学单词matter#嗨学英语graffiti单词详解#嗨学英语ease单词详解#嗨学英语wildlife单词详解#嗨学英语oust单词详解#late十秒单词速记#嗨学英语altar单词详解#嗨学英语vest单词详解#嗨学英语unsigned单词详解#嗨学英语hectare单词详解#嗨学英语owl单词详解#嗨学英语happy weekend词组详解#嗨学英语brain单词详解#嗨学英语wad单词详解#嗨学英语magnum单词详解#嗨学英语perks单词详解#嗨学英语beggar单词详解#嗨学英语bane单词详解#嗨学英语battles单词详解#嗨学英语grammatical单词详解#嗨学英语tempting单词详解#effort十秒单词速记#嗨学英语detached单词详解#accept十秒单词速记#嗨学英语cuff单词详解#嗨学英语punctuation单词详解#嗨学英语assemble单词详解#嗨学英语informative单词详解#嗨学英语policies单词详解#嗨学英语canola单词详解#嗨学英语pretended单词详解#嗨学英语governor单词详解#嗨学英语correspondence单词详解#嗨学英语scruffy单词详解#嗨学英语warmer单词详解#嗨学英语gene单词详解#嗨学英语fascination单词详解#嗨学单词over#嗨学英语compilation单词详解#嗨学英语wend单词详解#嗨学英语cathedral单词详解#嗨学英语mug单词详解#嗨学英语plateau单词详解#嗨学英语aromatherapy单词详解#嗨学英语reflection单词详解#portable十秒单词速记#嗨学英语sash单词详解#嗨学英语bean单词详解#嗨学英语sound单词详解#嗨学英语filetype单词详解#嗨学英语prefer单词详解#嗨学英语potassium单词详解#嗨学英语stroke单词详解#嗨学英语kitten单词详解#嗨学英语gem单词详解#嗨学单词stick#嗨学英语fraction单词详解#嗨学英语nurture单词详解#嗨学英语want单词详解#嗨学英语scissors单词详解#嗨学英语firmly单词详解#嗨学英语daydream单词详解#嗨学英语configure单词详解#嗨学英语flatter单词详解#嗨学英语downhill单词详解#嗨学英语national单词详解#嗨学英语sterile单词详解#嗨学英语wonton单词详解#confluence十秒单词速记#嗨学英语ribbon单词详解#嗨学英语structure单词详解#嗨学英语deprived单词详解#嗨学英语can单词详解#嗨学英语mambo单词详解#嗨学英语lotion单词详解#嗨学英语smack单词详解#嗨学英语mark单词详解#嗨学英语expedite单词详解#嗨学英语solder单词详解#嗨学英语beverage单词详解#嗨学英语conception单词详解#嗨学英语harrier单词详解#嗨学英语terribly单词详解#嗨学英语apartment单词详解#嗨学英语slog单词详解#嗨学英语advocated单词详解#嗨学英语finishing单词详解#share十秒单词速记#嗨学英语concerted单词详解#嗨学英语classmate单词详解#嗨学英语talked单词详解#嗨学英语chimney单词详解#嗨学英语mambo单词详解#嗨学英语slurp单词详解#嗨学英语helpline单词详解#hall十秒单词速记#嗨学英语aspirational单词详解#嗨学英语spire单词详解#嗨学英语attest单词详解#嗨学英语amidst单词详解#嗨学英语influx单词详解#嗨学英语algae单词详解#嗨学英语afloat单词详解#嗨学英语complexity单词详解#嗨学英语cipher单词详解#嗨学英语sunflowers单词详解#嗨学英语hockey单词详解#嗨学单词letter#嗨学英语doors单词详解#嗨学英语airline单词详解#convict十秒单词速记#嗨学英语compressor单词详解#嗨学英语unzip单词详解#嗨学英语loneliness单词详解#嗨学英语interaction单词详解#嗨学英语exaggerated单词详解#嗨学英语painter单词详解#嗨学单词born#嗨学英语greatly单词详解#嗨学英语fiduciary单词详解#嗨学英语bikini单词详解#swallow十秒单词速记#嗨学英语later单词详解#front十秒单词速记#嗨学英语agora单词详解#嗨学英语buses单词详解#嗨学英语spleen单词详解#嗨学英语sadness单词详解#嗨学英语inverter单词详解#嗨学英语attorney单词详解#嗨学英语consulting单词详解#嗨学英语discreet单词详解#嗨学单词miss#嗨学英语singer单词详解#嗨学英语curry单词详解#嗨学英语persuasion单词详解#嗨学英语bewilder单词详解#嗨学英语cheeks单词详解#嗨学英语folly单词详解#嗨学英语speaker单词详解#cooperate十秒单词速记#嗨学英语calf单词详解#嗨学英语fateful单词详解#嗨学英语eat单词详解#嗨学英语pedagogy单词详解#嗨学英语yam单词详解#嗨学英语examine单词详解#嗨学英语mate单词详解#嗨学英语versatility单词详解#嗨学英语awards单词详解#嗨学英语deprived单词详解#嗨学英语jeans单词详解#嗨学英语alloy单词详解#嗨学英语workers单词详解#嗨学英语jaws单词详解#嗨学英语floss单词详解#嗨学英语baseline单词详解#嗨学单词restaurant#嗨学英语how dare you词组详解#嗨学英语wand单词详解#advance十秒单词速记#嗨学英语syndrome单词详解#comfort十秒单词速记#嗨学英语prescribe单词详解#嗨学英语operative单词详解#嗨学英语satisfactory单词详解#嗨学英语when单词详解#嗨学英语amino单词详解#嗨学英语struggling单词详解#sweep十秒单词速记#嗨学英语cobalt单词详解#嗨学英语yen单词详解#嗨学英语participation单词详解#嗨学英语benevolence单词详解#嗨学英语dermatology单词详解#嗨学英语price单词详解#嗨学英语mathematical单词详解#嗨学英语sovereignty单词详解#嗨学英语jolt单词详解#嗨学英语weep单词详解#嗨学英语Knife单词详解#嗨学英语fear单词详解#嗨学英语anorexia单词详解#嗨学英语make over词组详解#嗨学英语definitive单词详解#嗨学英语coward单词详解#嗨学英语plant单词详解#嗨学英语weaken单词详解#嗨学英语pass单词详解#嗨学英语evening单词详解#嗨学英语largest单词详解#compulsory十秒单词速记#嗨学英语circles单词详解#嗨学英语applicable单词详解#嗨学英语taste单词详解#嗨学英语challenged单词详解#嗨学英语poppies单词详解#嗨学英语desolation单词详解#嗨学英语visual单词详解#嗨学英语recourse单词详解#嗨学英语hour单词详解#嗨学英语remaining单词详解#嗨学英语geranium单词详解#嗨学英语reptile单词详解#action十秒单词速记#嗨学英语cheek单词详解#嗨学英语a handful of词组详解#嗨学英语veggie单词详解#嗨学英语sounding单词详解#嗨学英语narrowly单词详解#嗨学英语memory单词详解#嗨学英语jungle单词详解#嗨学英语dawg单词详解#嗨学单词across#嗨学英语roe单词详解#嗨学英语aims单词详解#嗨学英语loaded单词详解#嗨学英语contractor单词详解#嗨学英语astonished单词详解#嗨学英语hacker单词详解#postpone十秒单词速记#嗨学英语extinguish单词详解#嗨学英语bicycle单词详解#嗨学英语harnessed单词详解#嗨学英语duff单词详解#嗨学英语figurative单词详解#嗨学英语clove单词详解#season十秒单词速记#嗨学英语ignite单词详解#嗨学英语teen单词详解#嗨学英语bottleneck单词详解#嗨学英语experienced单词详解#nominate十秒单词速记#嗨学单词value#嗨学英语board game单词详解#嗨学英语undisturbed单词详解#嗨学英语avenge单词详解#嗨学英语basics单词详解#嗨学英语major单词详解#嗨学英语microorganism单词详解#嗨学英语safety单词详解#嗨学英语rebuild单词详解#嗨学英语first单词详解#嗨学英语hare单词详解#嗨学英语underrated单词详解#嗨学英语bony单词详解#嗨学英语significant单词详解#嗨学英语transcendentalism单词详解#嗨学英语records单词详解#嗨学英语taxes单词详解#嗨学英语sow单词详解#嗨学单词Simple#嗨学英语carer单词详解#嗨学英语drawer单词详解#嗨学英语pessimistic单词详解#嗨学英语connections单词详解#嗨学英语accelerator单词详解#嗨学英语them单词详解#嗨学英语accord单词详解#嗨学英语finish单词详解#嗨学英语tremble单词详解#嗨学英语superhero单词详解#嗨学英语september单词详解#嗨学英语balloons单词详解#嗨学英语folks单词详解#嗨学英语sauce单词详解#嗨学英语tide单词详解#嗨学单词lose#嗨学英语swimsuit单词详解#嗨学英语hailed单词详解#嗨学英语berserker单词详解#嗨学英语buys单词详解#嗨学英语battlefield单词详解#嗨学英语defiant单词详解#嗨学英语lamps单词详解#bunch十秒单词速记#嗨学英语range单词详解#嗨学英语tombs单词详解#嗨学英语cheerfully单词详解#嗨学英语surname单词详解#嗨学英语bushes单词详解#嗨学英语greek单词详解#narrow十秒单词速记#嗨学英语hooks单词详解#嗨学英语jungle单词详解#嗨学英语available单词详解#嗨学英语godlike单词详解#嗨学英语worthwhile单词详解#嗨学英语fusion单词详解#contract十秒单词速记#嗨学英语range单词详解#嗨学英语exploit单词详解#嗨学英语sprinkler单词详解#嗨学英语police单词详解#嗨学英语dexter单词详解#嗨学英语rent单词详解#嗨学英语modular单词详解#嗨学英语angular单词详解#嗨学英语continuation单词详解#嗨学英语recreational单词详解#嗨学英语adaptive单词详解#嗨学英语crybaby单词详解#嗨学英语actions单词详解#嗨学英语mind单词详解#嗨学英语hitman单词详解#嗨学英语secretary单词详解#嗨学英语stall单词详解#嗨学英语taro单词详解#嗨学英语astronaut单词详解#嗨学英语edge单词详解#嗨学英语extremely单词详解#嗨学英语democratic单词详解#advocate十秒单词速记#嗨学英语blizzard单词详解#嗨学英语adaptation单词详解#嗨学单词potato#嗨学英语literal单词详解#嗨学英语argue with词组详解#嗨学英语resentment单词详解#嗨学英语answer单词详解#嗨学英语magazine单词详解#嗨学英语survivors单词详解#嗨学英语lucky单词详解#嗨学英语checkin单词详解#嗨学英语enterprises单词详解#satisfy十秒单词速记#嗨学英语perseverance单词详解#嗨学英语decisively单词详解#嗨学英语shameless单词详解#嗨学英语charges单词详解#嗨学英语bald单词详解#嗨学英语property单词详解#嗨学英语consolation单词详解#嗨学英语mango单词详解#嗨学英语projector单词详解#嗨学英语sweating单词详解#嗨学英语cooks单词详解#嗨学英语acquainted单词详解#嗨学英语fails单词详解#嗨学英语dissolution单词详解#嗨学英语mongolian单词详解#嗨学英语basic单词详解#嗨学英语in no case词组详解#嗨学英语overweight单词详解#嗨学英语enforced单词详解#嗨学英语historic单词详解#affluent十秒单词速记#嗨学英语talkative单词详解#away十秒单词速记#嗨学英语operas单词详解#嗨学英语solids单词详解#嗨学英语atuomatic单词详解#嗨学英语exam单词详解#嗨学英语tablets单词详解#嗨学英语modified单词详解#嗨学英语crumble单词详解#嗨学英语gator单词详解#嗨学英语risky单词详解#嗨学英语gain单词详解#嗨学英语hitherto单词详解#direction十秒单词速记#嗨学英语costly单词详解#嗨学英语coke单词详解#嗨学英语devastated单词详解#嗨学英语tedious单词详解#sweep十秒单词速记#嗨学英语suitcases单词详解#嗨学英语reinstall单词详解#嗨学英语certified单词详解#嗨学英语correlation单词详解#嗨学英语daisies单词详解#嗨学英语privileged单词详解#嗨学单词down#嗨学英语invalidate单词详解#嗨学英语lash单词详解#嗨学英语stepfather单词详解#嗨学英语where单词详解#嗨学英语harmonica单词详解#嗨学英语martian单词详解#嗨学英语mandate单词详解#嗨学英语contend单词详解#嗨学英语Recognize单词详解#嗨学英语insist单词详解#嗨学英语gregarious单词详解#嗨学英语tens单词详解#嗨学英语quill单词详解#嗨学英语smoker单词详解#嗨学英语forlorn单词详解#嗨学英语learn单词详解#嗨学英语aquarium单词详解#嗨学英语another单词详解#嗨学英语cigarettes单词详解#嗨学英语growth单词详解#嗨学英语smoky单词详解#嗨学英语pic单词详解#嗨学英语voltage单词详解#嗨学英语autocratic单词详解#嗨学英语comparison单词详解#嗨学英语supports单词详解#';

            $test = preg_replace('/([\x80-\xff]*)/i','',$test);
            $temp = explode('#',$test);
            $temp = array_filter($temp);
            echo count($temp);
            echo '<pre>';
            print_r($temp);




    }

    public function api(){

        $temp['data']['gridCol'] = 4;
        $temp['data']['status'] = 0;

        //$temp = '{"data":{"gridCol" : "3", "status" : 0}}';

        $temp = json_encode($temp);
        echo $temp;
    }


    public function banner(){
        $temp['data']['banner'][0]['id']= 0;
        $temp['data']['banner'][0]['type']='image';
        $temp['data']['banner'][0]['url'] = 'https://ossweb-img.qq.com/images/lol/web201310/skin/big84000.jpg';
        $temp['data']['banner'][0]['path'] = '/page/detail/detail?aid=2';

        $temp['data']['banner'][1]['id']= 0;
        $temp['data']['banner'][1]['type']='image';
        $temp['data']['banner'][1]['url'] = 'https://ossweb-img.qq.com/images/lol/web201310/skin/big37006.jpg';
        $temp['data']['banner'][1]['path'] = '/page/detail/detail?aid=3';

        $temp['data']['banner'][2]['id']= 0;
        $temp['data']['banner'][2]['type']='image';
        $temp['data']['banner'][2]['url'] = 'https://ossweb-img.qq.com/images/lol/web201310/skin/big39000.jpg';
        $temp['data']['banner'][2]['path'] = '/page/detail/detail?aid=5';

        $temp['data']['banner'][3]['id']= 0;
        $temp['data']['banner'][3]['type']='image';
        $temp['data']['banner'][3]['url'] = 'https://ossweb-img.qq.com/images/lol/web201310/skin/big10001.jpg';
        $temp['data']['banner'][3]['path'] = '/page/detail/detail?aid=6';

        $temp['data']['banner'][4]['id']= 0;
        $temp['data']['banner'][4]['type']='image';
        $temp['data']['banner'][4]['url'] = 'https://ossweb-img.qq.com/images/lol/web201310/skin/big25011.jpg';
        $temp['data']['banner'][4]['path'] = '/page/detail/detail?aid=7';

        $temp['data']['banner'][6]['id']= 0;
        $temp['data']['banner'][6]['type']='image';
        $temp['data']['banner'][6]['url'] = 'https://ossweb-img.qq.com/images/lol/web201310/skin/big99008.jpg';
        $temp['data']['banner'][6]['path'] = '/page/detail/detail?aid=8';

        $temp['data']['status'] = 0;
        echo json_encode($temp);

    }


    public function list(){




    }


    public function nav(){



        $temp['data']['nav'][0]['cuIcon']= 'cardboardfill';
        $temp['data']['nav'][0]['color']='red';
        $temp['data']['nav'][0]['badge'] = '120';
        $temp['data']['nav'][0]['name']  = '水果蔬菜';
        $temp['data']['nav'][0]['path']  = '/pages/my/my?index=1';
        $temp['data']['nav'][0]['url'] = '/static/icon/icon1.png';

        $temp['data']['nav'][1]['cuIcon']= 'recordfill';
        $temp['data']['nav'][1]['color']='orange';
        $temp['data']['nav'][1]['badge'] = '1';
        $temp['data']['nav'][1]['name']  = '肉禽蛋类';
        $temp['data']['nav'][1]['path']  = '/pages/my/my?index=2';
        $temp['data']['nav'][1]['url'] = '/static/icon/icon2.png';

        $temp['data']['nav'][2]['cuIcon']= 'picfill';
        $temp['data']['nav'][2]['color']='yellow';
        $temp['data']['nav'][2]['badge'] = '0';
        $temp['data']['nav'][2]['name']  = '海鲜水产';
        $temp['data']['nav'][2]['path']  = '/pages/my/my?index=3';
        $temp['data']['nav'][2]['url'] = '/static/icon/icon3.png';

        $temp['data']['nav'][3]['cuIcon']= 'noticefill';
        $temp['data']['nav'][3]['color']='olive';
        $temp['data']['nav'][3]['badge'] = '0';
        $temp['data']['nav'][3]['name']  = '素食冷冻';
        $temp['data']['nav'][3]['path']  = '/pages/my/my?index=4';
        $temp['data']['nav'][3]['url'] = '/static/icon/icon4.png';

//        $temp['data']['nav'][4]['cuIcon']= 'upstagefill';
//        $temp['data']['nav'][4]['color']='cyan';
//        $temp['data']['nav'][4]['badge'] = '0';
//        $temp['data']['nav'][4]['name']  = '粮油食品';
//        $temp['data']['nav'][4]['path']  = '/pages/my/my?index=4';
//        $temp['data']['nav'][4]['url'] = '/static/icon/icon4.png';
//
//        $temp['data']['nav'][5]['cuIcon']= 'discoverfill';
//        $temp['data']['nav'][5]['color']='purple';
//        $temp['data']['nav'][5]['badge'] = '0';
//        $temp['data']['nav'][5]['name']  = '发现';
//        $temp['data']['nav'][5]['path']  = '/pages/my/my?index=5';
//        $temp['data']['nav'][5]['url'] = '/static/icon/icon4.png';
//
//        $temp['data']['nav'][6]['cuIcon']= 'questionfill';
//        $temp['data']['nav'][6]['color']='mauve';
//        $temp['data']['nav'][6]['badge'] = '0';
//        $temp['data']['nav'][6]['name']  = '帮助';
//        $temp['data']['nav'][6]['path']  = '/pages/my/my?index=6';
//        $temp['data']['nav'][6]['url'] = '/static/icon/icon4.png';
//
//        $temp['data']['nav'][7]['cuIcon']= 'commandfill';
//        $temp['data']['nav'][7]['color']='mauve';
//        $temp['data']['nav'][7]['badge'] = '120';
//        $temp['data']['nav'][7]['name']  = '社区';
//        $temp['data']['nav'][7]['path']  = '/pages/my/my?index=7';
//        $temp['data']['nav'][7]['url'] = '/static/icon/icon4.png';
//
//        $temp['data']['nav'][8]['cuIcon']= 'cardboardfill';
//        $temp['data']['nav'][8]['color']='red';
//        $temp['data']['nav'][8]['badge'] = '120';
//        $temp['data']['nav'][8]['name']  = '推荐';
//        $temp['data']['nav'][8]['path']  = '/pages/my/my?index=8';
//        $temp['data']['nav'][8]['url'] = '/static/icon/icon4.png';
//
//        $temp['data']['nav'][9]['cuIcon']= 'cardboardfill';
//        $temp['data']['nav'][9]['color']='green';
//        $temp['data']['nav'][9]['badge'] = '120';
//        $temp['data']['nav'][9]['name']  = '新鲜';
//        $temp['data']['nav'][9]['path']  = '/pages/my/my?index=9';
//        $temp['data']['nav'][9]['url'] = '/static/icon/icon4.png';
//
//        $temp['data']['nav'][10]['cuIcon']= 'discoverfill';
//        $temp['data']['nav'][10]['color']='red';
//        $temp['data']['nav'][10]['badge'] = '120';
//        $temp['data']['nav'][10]['name']  = '早餐';
//        $temp['data']['nav'][10]['path']  = '/pages/my/my?index=10';
//        $temp['data']['nav'][10]['url'] = '/static/icon/icon4.png';


        $temp['data']['status'] = 0;
        echo json_encode($temp);

    }

    public function menunav(){
        $temp['data']['menunav'][0]['name']= '全部';
        $temp['data']['menunav'][0]['subNmae']='猜你喜欢';
        $temp['data']['menunav'][0]['render'] = true;
        $temp['data']['menunav'][0]['id']  = 1;

        $temp['data']['menunav'][1]['name']= '时令';
        $temp['data']['menunav'][1]['subNmae']='当季优选';
        $temp['data']['menunav'][1]['render'] = false;
        $temp['data']['menunav'][1]['id']  = 2;

        $temp['data']['menunav'][2]['name']= '进口';
        $temp['data']['menunav'][2]['subNmae']='国际直采';
        $temp['data']['menunav'][2]['render'] = false;
        $temp['data']['menunav'][2]['id']  = 3;


        $temp['data']['menunav'][3]['name']= '爆单';
        $temp['data']['menunav'][3]['subNmae']='大家在买';
        $temp['data']['menunav'][3]['render'] = false;
        $temp['data']['menunav'][3]['id']  = 4;

        $temp['data']['status'] = 0;
        echo json_encode($temp);

    }

    public function goodsList(){

        /**
        $list = Db::name("goods")
//            ->where($where)
            ->limit(20)
            ->select()
            ->toArray();
        echo '<pre>';
        print_r($list);

        echo '</pre>';
         * */

        $temp['data']['goodsList'][0]['url'] = '/static/icon/icon6.png';
        $temp['data']['goodsList'][0]['name'] = '新疆大苹果 1.1KG';
        $temp['data']['goodsList'][0]['prices'] = '20.9';
        $temp['data']['goodsList'][0]['originalPrice'] = '30.9';
        $temp['data']['goodsList'][0]['unit'] = '箱';
        $temp['data']['goodsList'][0]['label'] = '特价';
        $temp['data']['goodsList'][0]['delivery'] = '24H发货';
        $temp['data']['goodsList'][0]['sold'] = '888';

        $temp['data']['goodsList'][1]['url'] = '/static/icon/icon7.png';
        $temp['data']['goodsList'][1]['name'] = '新疆小苹果 1.5KG';
        $temp['data']['goodsList'][1]['prices'] = '20.9';
        $temp['data']['goodsList'][1]['originalPrice'] = '30.9';
        $temp['data']['goodsList'][1]['unit'] = '箱';
        $temp['data']['goodsList'][1]['label'] = '特价';
        $temp['data']['goodsList'][1]['delivery'] = '24H发货';
        $temp['data']['goodsList'][1]['sold'] = '888';

        $temp['data']['goodsList'][2]['url'] = '/static/icon/icon8.png';
        $temp['data']['goodsList'][2]['name'] = '新疆小苹果 1.5KG';
        $temp['data']['goodsList'][2]['prices'] = '20.9';
        $temp['data']['goodsList'][2]['originalPrice'] = '30.9';
        $temp['data']['goodsList'][2]['unit'] = '箱';
        $temp['data']['goodsList'][2]['label'] = '特价';
        $temp['data']['goodsList'][2]['delivery'] = '24H发货';
        $temp['data']['goodsList'][2]['sold'] = '888';

        $temp['data']['goodsList'][3]['url'] = '/static/icon/icon9.png';
        $temp['data']['goodsList'][3]['name'] = '新疆小苹果 1.5KG';
        $temp['data']['goodsList'][3]['prices'] = '20.9';
        $temp['data']['goodsList'][3]['originalPrice'] = '30.9';
        $temp['data']['goodsList'][3]['unit'] = '箱';
        $temp['data']['goodsList'][3]['label'] = '特价';
        $temp['data']['goodsList'][3]['delivery'] = '24H发货';
        $temp['data']['goodsList'][3]['sold'] = '888';

        $temp['data']['status'] = 0;
        echo json_encode($temp);
    }

    public function goodsList2(){


        $list = Db::name("goods_fresh")
        //            ->where($where)
        ->orderRand()
        ->limit(3)
        ->select()
        ->toArray();
        $temp['data']['goodsList']= $list;
//
//
//        $temp['data']['goodsList'][0]['url'] = '/static/icon/icon6.png';
//        $temp['data']['goodsList'][0]['name'] = 'ABC大苹果 1.1KG';
//        $temp['data']['goodsList'][0]['prices'] = '20.9';
//        $temp['data']['goodsList'][0]['originalPrice'] = '30.9';
//        $temp['data']['goodsList'][0]['unit'] = '箱';
//        $temp['data']['goodsList'][0]['label'] = '特价';
//        $temp['data']['goodsList'][0]['delivery'] = '24H发货';
//        $temp['data']['goodsList'][0]['sold'] = '888';
//
//        $temp['data']['goodsList'][1]['url'] = '/static/icon/icon7.png';
//        $temp['data']['goodsList'][1]['name'] = 'ABC 1.5KG';
//        $temp['data']['goodsList'][1]['prices'] = '20.9';
//        $temp['data']['goodsList'][1]['originalPrice'] = '30.9';
//        $temp['data']['goodsList'][1]['unit'] = '箱';
//        $temp['data']['goodsList'][1]['label'] = '特价';
//        $temp['data']['goodsList'][1]['delivery'] = '24H发货';
//        $temp['data']['goodsList'][1]['sold'] = '888';
//
//        $temp['data']['goodsList'][2]['url'] = '/static/icon/icon8.png';
//        $temp['data']['goodsList'][2]['name'] = 'ABC 1.5KG';
//        $temp['data']['goodsList'][2]['prices'] = '20.9';
//        $temp['data']['goodsList'][2]['originalPrice'] = '30.9';
//        $temp['data']['goodsList'][2]['unit'] = '箱';
//        $temp['data']['goodsList'][2]['label'] = '特价';
//        $temp['data']['goodsList'][2]['delivery'] = '24H发货';
//        $temp['data']['goodsList'][2]['sold'] = '888';
//
//        $temp['data']['goodsList'][3]['url'] = '/static/icon/icon9.png';
//        $temp['data']['goodsList'][3]['name'] = 'ABC 1.5KG';
//        $temp['data']['goodsList'][3]['prices'] = '20.9';
//        $temp['data']['goodsList'][3]['originalPrice'] = '30.9';
//        $temp['data']['goodsList'][3]['unit'] = '箱';
//        $temp['data']['goodsList'][3]['label'] = '特价';
//        $temp['data']['goodsList'][3]['delivery'] = '24H发货';
//        $temp['data']['goodsList'][3]['sold'] = '888';

        $temp['data']['status'] = 0;
        echo json_encode($temp);
    }


    public function goodsFreshSearch(){
        $map = input('get.');
       $where[] = ['name', 'like', '%' . $map['keyword'] . '%'];
        $list = Db::name("goods_fresh")
         ->where($where)
//            ->orderRand()
            ->limit(4)
            ->select()
            ->toArray();
        $temp['data']['goodsList']= $list;
//
//
//        $temp['data']['goodsList'][0]['url'] = '/static/icon/icon6.png';
//        $temp['data']['goodsList'][0]['name'] = 'ABC大苹果 1.1KG';
//        $temp['data']['goodsList'][0]['prices'] = '20.9';
//        $temp['data']['goodsList'][0]['originalPrice'] = '30.9';
//        $temp['data']['goodsList'][0]['unit'] = '箱';
//        $temp['data']['goodsList'][0]['label'] = '特价';
//        $temp['data']['goodsList'][0]['delivery'] = '24H发货';
//        $temp['data']['goodsList'][0]['sold'] = '888';
//
//        $temp['data']['goodsList'][1]['url'] = '/static/icon/icon7.png';
//        $temp['data']['goodsList'][1]['name'] = 'ABC 1.5KG';
//        $temp['data']['goodsList'][1]['prices'] = '20.9';
//        $temp['data']['goodsList'][1]['originalPrice'] = '30.9';
//        $temp['data']['goodsList'][1]['unit'] = '箱';
//        $temp['data']['goodsList'][1]['label'] = '特价';
//        $temp['data']['goodsList'][1]['delivery'] = '24H发货';
//        $temp['data']['goodsList'][1]['sold'] = '888';
//
//        $temp['data']['goodsList'][2]['url'] = '/static/icon/icon8.png';
//        $temp['data']['goodsList'][2]['name'] = 'ABC 1.5KG';
//        $temp['data']['goodsList'][2]['prices'] = '20.9';
//        $temp['data']['goodsList'][2]['originalPrice'] = '30.9';
//        $temp['data']['goodsList'][2]['unit'] = '箱';
//        $temp['data']['goodsList'][2]['label'] = '特价';
//        $temp['data']['goodsList'][2]['delivery'] = '24H发货';
//        $temp['data']['goodsList'][2]['sold'] = '888';
//
//        $temp['data']['goodsList'][3]['url'] = '/static/icon/icon9.png';
//        $temp['data']['goodsList'][3]['name'] = 'ABC 1.5KG';
//        $temp['data']['goodsList'][3]['prices'] = '20.9';
//        $temp['data']['goodsList'][3]['originalPrice'] = '30.9';
//        $temp['data']['goodsList'][3]['unit'] = '箱';
//        $temp['data']['goodsList'][3]['label'] = '特价';
//        $temp['data']['goodsList'][3]['delivery'] = '24H发货';
//        $temp['data']['goodsList'][3]['sold'] = '888';

        $temp['data']['status'] = 0;
        echo json_encode($temp);
    }

    public function goodsFreshCate()
    {


        $list = Db::name("goods_fresh_cate")
            //            ->where($where)
//            ->orderRand()
//            ->limit(3)
            ->select()
            ->toArray();
        $temp['data']['goods_fresh_cate'] = $list;

        $temp['data']['status'] = 0;
        echo json_encode($temp);

    }

    public function recommend(){
        $temp['data']['recommend'][0]['url'] = '/static/icon/icon6.png';
        $temp['data']['recommend'][0]['name'] = '新疆大苹果 1.5KG';
        $temp['data']['recommend'][0]['prices'] = '20.9';
        $temp['data']['recommend'][0]['originalPrice'] = '30.9';
        $temp['data']['recommend'][0]['unit'] = '箱';
        $temp['data']['recommend'][0]['label'] = '特价';
        $temp['data']['recommend'][0]['delivery'] = '24H发货';
        $temp['data']['recommend'][0]['sold'] = '888';
        $temp['data']['recommend'][0]['orderid'] = '21';
        $temp['data']['recommend'][0]['skuid'] = '12';
        $temp['data']['recommend'][0]['storeid'] = '12';



        $temp['data']['recommend'][1]['url'] = '/static/icon/icon7.png';
        $temp['data']['recommend'][1]['name'] = '新疆小苹果 1.5KG';
        $temp['data']['recommend'][1]['prices'] = '20.9';
        $temp['data']['recommend'][1]['originalPrice'] = '30.9';
        $temp['data']['recommend'][1]['unit'] = '箱';
        $temp['data']['recommend'][1]['label'] = '特价';
        $temp['data']['recommend'][1]['delivery'] = '24H发货';
        $temp['data']['recommend'][1]['sold'] = '888';
        $temp['data']['recommend'][1]['orderid'] = '21';
        $temp['data']['recommend'][1]['skuid'] = '12';
        $temp['data']['recommend'][1]['storeid'] = '12';

        $temp['data']['recommend'][2]['url'] = '/static/icon/icon8.png';
        $temp['data']['recommend'][2]['name'] = '新疆小苹果 1.5KG';
        $temp['data']['recommend'][2]['prices'] = '20.9';
        $temp['data']['recommend'][2]['originalPrice'] = '30.9';
        $temp['data']['recommend'][2]['unit'] = '箱';
        $temp['data']['recommend'][2]['label'] = '特价';
        $temp['data']['recommend'][2]['delivery'] = '24H发货';
        $temp['data']['recommend'][2]['sold'] = '888';
        $temp['data']['recommend'][2]['orderid'] = '21';
        $temp['data']['recommend'][2]['skuid'] = '21';
        $temp['data']['recommend'][2]['storeid'] = '1';

        $temp['data']['recommend'][3]['url'] = '/static/icon/icon9.png';
        $temp['data']['recommend'][3]['name'] = '新疆小苹果 1.5KG';
        $temp['data']['recommend'][3]['prices'] = '20.9';
        $temp['data']['recommend'][3]['originalPrice'] = '30.9';
        $temp['data']['recommend'][3]['unit'] = '箱';
        $temp['data']['recommend'][3]['label'] = '特价';
        $temp['data']['recommend'][3]['delivery'] = '24H发货';
        $temp['data']['recommend'][3]['sold'] = '888';
        $temp['data']['recommend'][3]['orderid'] = '1';
        $temp['data']['recommend'][3]['skuid'] = '1';
        $temp['data']['recommend'][3]['storeid'] = '1';

        $temp['data']['status'] = 0;
        echo json_encode($temp);


    }


    public  function alist(){

        $temp['data']['alist'][0]['title'] = '第11金!中国获男子双人3米板金牌';
        $temp['data']['alist'][0]['desc'] = '7月28日，中国选手王宗源/谢思埸夺得东京奥运会跳水男子双人三米板冠军';
        $temp['data']['alist'][0]['intime'] = '22:21';
        $temp['data']['alist'][0]['thumb'] = 'https://ossweb-img.qq.com/images/lol/img/champion/Morgana.png';
        $temp['data']['alist'][0]['color'] = '#39a9dc';
        $temp['data']['alist'][0]['aid'] = 1;

        $temp['data']['alist'][1]['title'] = '杨倩妈妈去菜场被围堵';
        $temp['data']['alist'][1]['desc'] = '7月27日，杨倩为中国奥运代表团再夺一枚金牌后，28日一大早，';
        $temp['data']['alist'][1]['intime'] = '12:21';
        $temp['data']['alist'][1]['thumb'] = 'https://ossweb-img.qq.com/images/lol/web201310/skin/big81020.jpg';
        $temp['data']['alist'][1]['color'] = '#f0f03a';
        $temp['data']['alist'][1]['aid'] = 2;

        $temp['data']['alist'][2]['title'] = '河南今明天仍有强降雨';
        $temp['data']['alist'][2]['desc'] = '7月28日至29日，受台风“烟花”减弱后的热带低压影响，河南仍有强降雨';
        $temp['data']['alist'][2]['intime'] = '22:21';
        $temp['data']['alist'][2]['thumb'] = 'https://ossweb-img.qq.com/images/lol/web201310/skin/big81007.jpg';
        $temp['data']['alist'][2]['color'] = '#cdae22';
        $temp['data']['alist'][2]['aid'] = 3;
        $temp['data']['status'] = 0;
        echo json_encode($temp);

    }



    public  function article(){

        $temp['data']['article']['title'] = '第11金!中国获男子双人3米板金牌';
        $temp['data']['article']['desc'] = '7月28日，中国选手王宗源/谢思埸夺得东京奥运会跳水男子双人三米板冠军';
        $temp['data']['article']['intime'] = '22:21';
        $temp['data']['article']['thumb'] = 'https://ossweb-img.qq.com/images/lol/img/champion/Morgana.png';
        $temp['data']['article']['color'] = '#39a9dc';
        $temp['data']['article']['aid'] = 1;
        $temp['data']['article']['author'] = '50';
        $temp['data']['article']['content'] = '<div class="text-left fn16" style="line-height: 2.2; padding-top: 20px;">
                    <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;厦门海升建设有限公司，主要从事地基与基础工程施工的专业一级资质企业, 注册资金4000万元；拥有专业技术人员96名，其中高级工程师6名、工程师26名、一级建造师8名、二级建造师10名。公司在“苦中起家、稳中发展、好中取胜、快中提升”，是具有较强经济技术实力和施工管理能力的基础专业工程施工企业。1987年开始公司前身先后是“厦门市禾胜（广厦）建筑公司打桩队” 、“厦门湖里建筑总公司基础工程处”和“厦门东科工程建设有限公司基础分公司”。2002年正式成立注册现在的厦门海升基础工程建设有限公司。&nbsp;

                    </p>
                    <p><img style="max-width:100%" src="https://img.36krcdn.com/20200410/v2_fd70d32482d141b0a46f0a5772a8ede3_img_000"></p>
                    <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;公司现有各种施工机械及配套设备108台套，其中拥有自主研发（实用新型专利号：ZL . 2008 2 0145752 . 7）大型设备：ZYJ1000型抱压式静压桩机10台（同时可施工大直径沉管灌注桩），ZYJ800型静压桩机6台、ZYJ1060型静压桩机3台、YC型液压冲击锤桩机4台、柴油击锤桩机6台、旋挖桩机6台、冲（钻）孔灌注桩机58台、高压旋喷桩机4台、水泥搅拌桩机8台、长螺旋引孔钻机3台。&nbsp;&nbsp;&nbsp;
                    </p>
                </div>';

        $temp['data']['status'] = 0;
        echo json_encode($temp);

    }





    public function test(){
        $data = ['title' => 'bar', 'video_url' => 'foo','cover_images' => 'asdfasdf','tag' => 'asdfasdf', 'is_original'=> 1 ,'use_auto_cover' => 0];

        $temp = '{"data":{"article_id":"1675433394452136949","nid":"5527589735999253032"},"errno":0,"errmsg":"\u6210\u529f"}';
        $temp = json_decode($temp,true);
        echo '<pre>';
        print_r($temp);
       $article_id =  $temp['data']['article_id'];
       $errno = $temp['errno'];
       echo $errno;
       echo $article_id;
//        echo $temp['data']['error'];




      // echo  Db::name('videoinfo')->save($data);
    }

    public function upload()
    {
        $file = request()->file('file');  //获取上传文件信息
        $savename = \think\facade\Filesystem::disk('public')->putFileAs( 'topic/'.date('Ymd'), $file,$file->getOriginalName());

        $title = str_replace('.'.$file->getOriginalExtension(),'',$file->getOriginalName());

        if ($savename) {
            return (json_encode(array('status' => 1, 'msg' =>$title, 'info' => $savename)));
        }
    }


    function filter_Emoji($str)
    {
        $str = preg_replace_callback(    //执行一个正则表达式搜索并且使用一个回调进行替换
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);

        return $str;
    }


    function proStartTime() {
        global $startTime;
        $mtime1 = explode(" ", microtime());
        $startTime = $mtime1[1] + $mtime1[0];
    }

    /**
     * @End time
     */
    function proEndTime() {
        global $startTime,$set;
        $mtime2 = explode(" ", microtime());
        $endtime = $mtime2[1] + $mtime2[0];
        $totaltime = ($endtime - $startTime);
        $totaltime = number_format($totaltime, 7);
        echo "<br/>process time: ".$totaltime;
    }


    function testzip(){
        $zip=new \ZipArchive();

        $uploadPath = '/Volumes/50/idiQu/util.js.zip';
        $unzipPath = '/Volumes/50/idiQu/html';
        if ($zip->open($uploadPath, \ZipArchive::CREATE) !== TRUE) {
            die ("Could not open archive");
        } else {
            //将压缩文件解压到指定的目录下
            $zip->extractTo($unzipPath);
            //关闭zip文档
            $zip->close();
            $msg['code'] = 0;
            $msg['path'] = 'http://' . $_SERVER['SERVER_NAME'] . $unzipPath;
        }

        echo '<pre>';
        print_r($msg);
        echo '</pre>';
    }

}
