<?php
declare (strict_types = 1);

namespace app\sj\controller;
use app\sj\BaseController;
use think\facade\Db;
use think\facade\Config;
use think\facade\View;
use think\facade\Request;
use think\facade\Session;
use think\Facade\Cache;
use app\sj\model\Test;
use think\cache\driver\Redis;
use think\Model;

class Guanli extends BaseController
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
    public function index()
    {
        $this->ifLogin();
//        var_dump(Config::get('wushi.say'));
        $menu = $this->menujson();
        $menu = $this->unicode2Chinese($menu);
        View::assign('menu', $menu);
//        $data = [
//            'name' => '2222222222222',
//            'email' => '3920699@qq.com'
//        ];
//
//        $validate = new \app\admin\validate\User;
//        if(!$validate->check($data)){
//            dump($validate->getError());
//        }
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
        $bool = Session::has('shop_admin_info');
        if ($bool) {
            redirect('/sj/Guanli/index')->send();
        }
        if ($this->request->isPost()) {
            $data = Request::post();
            $user = Db::name('shop_admin')->where('username', $data['user'])->find();
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
                    $landing_record['userid'] = $user['shop_id'];
                    $landing_record['create_time'] = time();
                    $do = Db::name('landing_record')->save($landing_record);
                    Session::set('shop_admin_info', $user);
                    $userinfo = Session::get('shop_admin_info');
                    $bool = Session::has('shop_admin_info');
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
        session('shop_admin_info', null);
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
        $list = Db::name('menu_sj')
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
        $list = Db::name('menu_sj')
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

    public function ifLogin()
    {
        $bool = Session::has('shop_admin_info');
        if (!$bool) {
            redirect('/sj/Guanli/login')->send();
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


    function md5(){
        echo md5('211/sbin/accessdb
');
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

    function pin($p){
        echo '<br>';

        is_array($p) ? var_dump($p) :  static::read($p);

        echo '<br>';
    }

    function merge_spaces($string){
        return preg_replace("/\s(?=\s)/","\\1",$string);
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

    public function api(){

        $temp['data']['gridCol'] = 4;
        $temp['data']['status'] = 0;

        //$temp = '{"data":{"gridCol" : "3", "status" : 0}}';

        $temp = json_encode($temp);
        echo $temp;
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


}
