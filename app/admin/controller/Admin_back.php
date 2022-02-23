<?php
declare (strict_types = 1);

namespace app\admin\controller;
use app\admin\BaseController;
use app\admin\validate\BaseValidate;
use think\facade\Db;
use think\exception\ValidateException;
use think\facade\Config;
use think\facade\Cache;
use think\facade\View;
use think\facade\Request;
use think\facade\Session;

class Admin extends BaseController
{
    public function index()
    {
       $this->ifLogin();
       return View();
    }
    public function main(){
        $test =  Config::get('config');

        print_r($test);
        $userinfo = Session::get('admininfo');
        echo '<pre>';
        print_r($userinfo);
        echo '</pre>';

        $request = Request::instance();
        echo $request->ip();

        $version = Db::query('SELECT VERSION() AS ver');
        $config  = [
            'url'             => $_SERVER['HTTP_HOST'],
            'document_root'   => $_SERVER['DOCUMENT_ROOT'],
            'server_os'       => PHP_OS,
            'server_port'     => $_SERVER['SERVER_PORT'],
            'server_ip'       => $_SERVER['SERVER_ADDR'],
            'server_soft'     => $_SERVER['SERVER_SOFTWARE'],
            'php_version'     => PHP_VERSION,
            'mysql_version'   => $version[0]['ver'],
            'max_upload_size' => ini_get('upload_max_filesize')
        ];
        View::assign('config', $config);
        return View();
    }

    public function login()//登陆
    {
        $bool = Session::has('admininfo');
        if($bool) {
            redirect('/guanli/Guanli/index')->send();
        }
        if($this->request->isPost()){
            $data = Request::post();
            $user =  Db::name('guanli')->where('username', $data['user'])->find();
            if($user){
                $pwd = $data['pwd'];
                $mdemail = $user['mdemail'];
                $pwd =  md5($mdemail.$pwd.$mdemail);
                if($pwd == $user['pwd']){
                    $request = Request::instance();
                    $ip =  $request->ip();
                    //登记
                    $landing_record['ip'] = $ip;
                    $landing_record['username'] = $user['username'];
                    $landing_record['userid']   = $user['admin_id'];
                    $landing_record['create_time'] = time();
                    $do =  Db::name('landing_record')->save($landing_record);
                    Session::set('admininfo', $user);
                    $userinfo = Session::get('admininfo');
                    $bool = Session::has('admininfo');
                    if($bool) {
                        $this->json_back('0', 'ok', $userinfo);
                    }else{
                        $this->json_back('205', 'false', '异常');
                    }
                }else{
                    $this->json_back('204','密码错误,请重试','');
                }
            }else{
                $this->json_back('203','用户名错误，是否被禁用','');
            }
        }else{
            return View();
        }
    }

    public function landing_record(){
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



    public function opera_log(){
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




    public function web_cache(){
        //$this->ifLogin();
        Session::delete('admininfo');
        redirect('/guanli/Guanli/login')->send();

        return View();
    }
    protected  function okin(){
        Session::set('admininfo', 'okkk');
        return true;
    }

    public function out(){
        session('admininfo', null);
        echo '<script>window.location.href="login.html";</script>';
    }
    public function user_index(){

        return View();
    }

    public function user_add(){
        return View();
    }

    public function type_index(){

        return View();
    }

    public function article_index(){

        return View();
    }

    public function article_add(){

        return View();
    }

    public function type_add(){

        return View();
    }

    public function web_index(){

        return View();
    }

    public function flink_index(){

        return View();
    }

    public function nav_index(){

        return View();
    }

    public function web_pwd(){

        return View();
    }

    public function db_backup(){

        return View();
    }

    public function db_reduction(){

        return View();
    }


    public function pages_component(){

        return View();
    }

    public function pages_model(){

        return View();
    }

    public function pages_msg(){

        return View();
    }

    public function video_index(){

        return View();
    }






    public function adminlist(){
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

    public function testadmin(){

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

    public function addAdmin(){
        $this->ifLogin();
        $if_edit = Request::has('id','get');
        if($if_edit){
            $id =  Request::param('id');
            $tempadmin =  Db::name('guanli')->where('admin_id', $id)->find();
        }else{
            $tempadmin = array('username'=>'','pwd'=>'','group_id'=>'1','email'=>'','realname'=>'','tel'=>'','is_open'=>'','avatar'=>'','status'=>'1','wx_openid'=>'','username'=>'');
        }
        $create_time = time();
        if($this->request->isPost()){
            $data = Request::post();
            $if_edit = Request::has('id','get');
            if($if_edit){
                $data['update_time'] = $create_time;
                $data['admin_id'] = $id;//修改模式
                $mdemail = $tempadmin['mdemail'];

                $typename =  '编辑用户';
            }else{
                $data['mdemail'] = bin2hex(random_bytes(3));//添加模式
                $data['create_time'] = $create_time;
                $mdemail = bin2hex(random_bytes(16));
                $typename =  '添加用户';
            }

            $pwd = trim(Request::param('pwd'));//是否设置
            if($_POST['pwd'] !==''){//如果不为空则更改
                $pwd =  md5($mdemail.$pwd.$mdemail);
                $data['pwd'] = $pwd;
            }else{
                unset($data['pwd']);
            }

            $this->inlog(__FUNCTION__,$typename);
            $do =  Db::name('guanli')->save($data);
            if($do){
                $this->json_back(1,$pwd,'');
            }else{
                $this->json_back(0,$pwd,'');
            }
            exit();
        }
        View::assign('data',$tempadmin);
        return View("addAdmin");
    }
    public function inlog($funtion, $typename){
        //行为记录
        $request = Request::instance();
        $ip =  $request->ip();
        $user = Session::get('admininfo');
        $operalog['ip'] = $ip;
        $operalog['username'] = $user['username'];
        $operalog['userid']   = $user['admin_id'];
        $operalog['create_time'] = time();
        $operalog['typename'] = $typename;
        $operalog['opera'] = strtoupper($funtion);
        $do =  Db::name('operalog')->save($operalog);
    }
    public function weblog(){
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $map = input('post.');
            $where= array();
//            $where[] = ['status', '=', 1];
            if (@$map['testing'] != '') $where[] = ['testpage', '=', $map['testing']];
            if (@$map['status'] != ''){

                if($map['status'] == '200'){
                    $where[] = ['remark', '=', '200'];
                }else{
                    $where[] = ['remark', '<>', '200'];
                }
            }
            if (@$map['start_time'] != '' ) {
                $start_time = $map['start_time'];
                $today_start = strtotime(date($start_time));
                $where[] = ['create_time', '>=', $today_start];
            }

            if ( @$map['end_time'] != ''){
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

    public function serset(){//设置配置文件。生成
        $this->ifLogin();
        return View();
    }


    public function statuslist(){
        $this->ifLogin();
        echo __FUNCTION__;
    }
    public function setlist(){//配置文件查看
        $this->ifLogin();
//        echo "<pre>";
//        var_dump($this->my_dir("set"));
//        echo "</pre>";

       $temp = file_get_contents("./set/.setall");
        $temp = json_decode($temp,true);
        echo '<pre>';
            print_r($temp);
        echo '</pre>';

    }

    public function setchatalert(){
        $this->ifLogin();
        $list = Db::name('guanli')
            ->where('wx_openid', '<>', '')
            ->where('wx_openid', '<>', '')
            ->column('wx_openid');
        $str = implode($list,',');
        $str = trim($str,',');

        $do = file_put_contents('./set/.wechat',$str);
        echo $str;
    }


    public function defaultlist(){
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $map = input('post.');
            $where= array();
//            $where[] = ['status', '=', 1];
            if (@$map['ip'] != '') $where[] = ['ip', '=', $map['ip']];
            if (@$map['typename'] != '') $where[] = ['typename', '=', $map['typename']];
            if (@$map['start_time'] != '' ) {
                $start_time = $map['start_time'];
                $today_start = strtotime(date($start_time));
                $where[] = ['create_time', '>=', $today_start];
            }

            if ( @$map['end_time'] != ''){
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

    public function setDefault(){
        $this->ifLogin();

        $where[] = ['status', '=', '1'];
        $temp = Db::name('web')
            ->where($where)
            ->select();
        $testing = '';
        foreach ($temp as $k => $item) {
            if ($item['testing'] !== '') {
                $testing .= $item['testing'].',';
            }
        }
        $test['testing'] = trim($testing,',');
        $temp = Db::name('guanli')
            ->where($where)
            ->select();
        $wxopenid = '';
        foreach ($temp as $k => $item) {
            if ($item['wx_openid'] !== '') {
                $wxopenid .= $item['wx_openid'].',';
            }
        }
        $test['wxopenid'] = trim($wxopenid,',');

        $temp = Db::name('server')
            ->where($where)
            ->select();
        $ip = '';
        $ip_remark = '';
        $monitor = '';
        foreach ($temp as $k => $item) {
            if ($item['ip'] !== '') {
                $ip .= $item['ip'].',';
                $monitor .= $item['ip_remark']. ' ' .$item['monitor'].'#';
            }
            if ($item['ip_remark'] !== '') {
                $ip_remark .= $item['ip_remark'].',';
            }
        }
        $test['monitor'] = trim($monitor,'#');
        $test['ip'] = trim($ip,',');
        $test['ip_remark'] = trim($ip_remark,',');
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
            $this->json_back('0','ok',$test);
        } else {
            $this->json_back('200','error','写入失败');
        }
        exit();
        //}
    }
    public function addDefault(){
        $this->ifLogin();
        $if_edit = Request::has('id','get');
        if($if_edit){
            $id =  Request::param('id');
            $data =  Db::name('default')->where('id', $id)->find();
            View::assign('data',$data);
        }else{
            $data = array('type'=>'','defaultname'=>'','defaultvalue'=>'','remark'=>'','status'=>'');
        }
        $create_time = time();
        if($this->request->isPost()){
            $data = Request::post();
            $data['create_time'] = $create_time;

            $if_edit = Request::has('id','get');
            if($if_edit){
                $data['id'] = $id;
                $typename = '编辑定义值';
            }else{
                $typename = '添加定义值';
            }
            $this->inlog(__FUNCTION__,$typename);
            $do =  Db::name('default')->save($data);
            if($do){
                $this->json_back(1,'创建成功','');
            }else{
                $this->json_back(0,'创建失败','');
            }
            exit();
        }
        View::assign('data',$data);
        return View();
    }

    public function serlog(){
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $map = input('post.');
            $where= array();
            if (@$map['ip'] != '') $where[] = ['ip', '=', $map['ip']];
            if (@$map['typename'] != '') $where[] = ['typename', '=', $map['typename']];
            if (@$map['start_time'] != '' ) {
                $start_time = $map['start_time'];
                $today_start = strtotime(date($start_time));
                $where[] = ['create_time', '>=', $today_start];
            }
            if ( @$map['end_time'] != ''){
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

    public function serlist(){
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
                $file = "/etc/linuxsh/logs/".$v['ip_remark']."_disk.txt";
                if(file_exists($file)){
                    $harddisk= file_get_contents($file);
                    $list['data'][$k]['harddisk'] =  $harddisk;
                }else{
                    $list['data'][$k]['harddisk'] = 'null';
                }

                $monitorItem =  explode(',',$v['monitor']);

                $list['data'][$k]['monitor'] = '';
                foreach($monitorItem as $item){
                    if($item == '1'){
                        $list['data'][$k]['monitor'] .= 'harddisk &nbsp;';
                    }
                    if($item == '2'){
                        $list['data'][$k]['monitor'] .= 'nginx &nbsp;';
                    }
                    if($item == '3'){
                        $list['data'][$k]['monitor'] .= 'php-fpm &nbsp;';
                    }
                    if($item == '4'){
                        $list['data'][$k]['monitor'] .= 'mysql &nbsp;';
                    }
                    if($item == '5'){
                        $list['data'][$k]['monitor'] .= 'redis &nbsp;';
                    }
                    if($item == '6'){
                        $list['data'][$k]['monitor'] .= 'ssh &nbsp;';
                    }
                    if($item == '7'){
                        $list['data'][$k]['monitor'] .= 'load &nbsp;';
                    }
                }


                $file = "/etc/linuxsh/logs/".$v['ip_remark']."_net.txt";
                if(file_exists($file)){
                    $net= file_get_contents($file);
                    $list['data'][$k]['net'] =  $net;
                }else{
                    $list['data'][$k]['net'] = 'null';
                }



            }


            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();
    }

    public function diffloglist(){
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 20);
            $map = input('post.');
            $where = array();
            if (@$map['ip_remark'] != '') $where[] = ['ip_remark', '=',  $map['ip_remark'] ];
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

    public function seedifflog(){
        $this->ifLogin();
        $if_edit = Request::has('id','get');
        if($if_edit){
            $id =  Request::param('id');
            $data =  Db::name('difflog')->where('id', $id)->find();
            $content = $data['content'];
            $content = str_replace("__","/\r",$content);
            $content = str_replace("_","&nbsp;",$content);
            echo $content;
        }else{
            $this->json_back(203,'error','');
        }
    }




    public function addSer(){
        $this->ifLogin();
        $if_edit = Request::has('id','get');
        if($if_edit){
            $id =  Request::param('id');
           $data =  Db::name('server')->where('id', $id)->find();
            View::assign('data',$data);
            $typename = '编辑服务器'.$id;
        }else{
            $data = array('ip'=>'','ip_remark'=>'','status'=>'1','remark'=>'','ipname'=>'','monitor'=>'');
            $typename = '添加服务器';
        }
            $create_time = time();
            if($this->request->isPost()){
            $data = Request::post();
            $data['create_time'] = $create_time;
            $if_edit = Request::has('id','get');
            if($if_edit){
                    $data['id'] = $id;
                }
                //unset($data['monitor']);
                $monitor =  Db::name('default')->where('type', 1)->select();//这里是全部的项目
                foreach($monitor as $key=>$value){
                    $monitorItemName[] = $value['defaultvalue'];
                }
                $tor = '';
                $tempmonitor = $data['monitor'];
                foreach($tempmonitor as $key=>$item){
                    if(in_array($key,$monitorItemName)){
                        if($key == 'harddisk'){
                            $tor .= '1,';
                        }
                        if($key == 'nginx'){
                            $tor .= '2,';
                        }
                        if($key == 'php-fpm'){
                            $tor .= '3,';
                        }
                        if($key == 'mysql'){
                            $tor .= '4,';
                        }
                        if($key == 'redis'){
                            $tor .= '5,';
                        }
                        if($key == 'ssh'){
                            $tor .= '6,';
                        }
                        if($key == 'load'){
                            $tor .= '7,';
                        }
                    }
                }
                $data['monitor'] = trim($tor,',');


                $this->inlog(__FUNCTION__,$typename);
                $do =  Db::name('server')->save($data);
                if($do){
                    $this->json_back(1,'创建成功','');
                }else{
                    $this->json_back(0,'创建失败','');
                }
                exit();
            }
        $monitorItem  =$data['monitor'];//选中的
        $monitorItemName = array();
        if($monitorItem !== ''){
            $monitorItem = explode(',',$monitorItem);
            foreach($monitorItem as $item){
                if($item == '1'){
                    $monitorItemName[] = 'harddisk';
                }
                if($item == '2'){
                    $monitorItemName[] = 'nginx';
                }
                if($item == '3'){
                    $monitorItemName[] = 'php-fpm';
                }
                if($item == '4'){
                    $monitorItemName[] = 'mysql';
                }
                if($item == '5'){
                    $monitorItemName[] = 'redis';
                }
                if($item == '6'){
                    $monitorItemName[] = 'ssh';
                }
                if($item == '7'){
                    $monitorItemName[] = 'load';
                }
            }
        }else{
            $monitorItemName = array();
        }
        $monitorstatus = array();
        $monitor =  Db::name('default')->where('type', 1)->select();//这里是全部的项目
            foreach($monitor as $k=>$item){//如果有选中。 则  值为1  。 如果没有选择。 则值为0
                if(in_array($item['defaultvalue'],$monitorItemName)){//如果在数组里面。 说明选中
                    $monitorstatus[$item['defaultvalue']]= 1;
                }else{
                    $monitorstatus[$item['defaultvalue']]= 0;
                }
            }
        View::assign('monitorstatus',$monitorstatus);
        View::assign('monitoritem',$monitor);
        View::assign('data',$data);
        return View('addSer');
    }


    public function getDefault($id){
        $temp  =   Db::name('default')->where('id',$id)->find();
        return $temp['defaultname'];
    }



    public function weblist(){
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

            foreach($list['data'] as $k=>$v){
                $temp  =   Db::name('server')->where('id', $list['data'][$k]['ip'])->find();
                $list['data'][$k]['ip'] = $temp['ipname'];
            }
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();
    }

    public function getSerlist(){
        $this->ifLogin();
        $serlist = Db::name('server')
            ->where('status',1)
            ->order('create_time desc')
            ->column('*','id');
        return $this->json_back(1,'ok',$serlist);
    }

    public function getWeblist(){
        $this->ifLogin();
        $serlist = Db::name('web')
            ->where('status',1)
            ->order('create_time desc')
            ->column('*','id');
        return $this->json_back(1,'ok',$serlist);
    }



    public function getTypeName(){
        $this->ifLogin();
        $serlist = Db::name('default')
            ->where('status',1)
            ->where('type',1)
            ->order('id desc')
            ->column('*','id');
        return $this->json_back(1,'ok',$serlist);
    }


    public function changestatus(){
        $this->ifLogin();
        $temp = Request::post();
        $if_id = Request::has('id','post');
        if($if_id){
            $checked = $temp['checked'];
            if($checked == 'true'){
                $data['status'] = 1;
                $msg = '开启';
            }else{
                $data['status'] = 0;
                $msg = '关闭';
            }
            $data['id'] = $temp['id'];

            if(Request::has('type','post') && $temp['type']=='ser'){
                $this->inlog(__FUNCTION__,'修改服务器监控状态');
                $do =  Db::name('server')->save($data);
            }else{
                $this->inlog(__FUNCTION__,'修改网站监控状态');
                $do =  Db::name('web')->save($data);
            }
            if($do !==   false){
                $this->json_back('0',$msg,'');
            }else{
                $this->json_back('2','操作失败','');
            }
        }else{
            $this->json_back('203','错误参数','');
        }


    }

    function httpcode(){
        $this->ifLogin();
        $if_url = Request::has('testing','post');
        if($if_url) {
            $url = Request::post('testing');
            $url = explode(',',$url);
            $temp = array();
            if(is_array($url)){
                foreach($url as $k => $item){
                  $temp[$k]['code'] =   $this->getcode($item);
                  $temp[$k]['url'] =   $item;
                }
                $this->json_back('0','ok',$temp);
            }else{
                $this->json_back('2','false','2');
            }
        }
    }

    function getcode($url){
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

    function goping(){
        $this->ifLogin();
        $if_ip = Request::has('ip','post');
        if($if_ip) {
            $ip = Request::post('ip');
            $ip = explode(',',$ip);
            $temp = array();
            if(is_array($ip)){
                foreach($ip as $k => $item){
                    $temp[$k]['info'] =   $this->ping($item,30);
                    $temp[$k]['ip'] =   $item;
                }
                $this->json_back('0','ok',$this->ping($item,30));
            }else{
                $this->json_back('2','false','2');
            }
        }
    }

    function ping($ip,$times=90)
    {
        $server = 'ls -al';
        $last_line = exec($server, $arr);


        $arr['test']= 'test';
        $arr['last_line'] = $last_line;


        return $arr;
    }


    function testping(){
        $server = 'ls -al';
        $last_line = exec($server, $arr);
        echo "$last_line"; //最后总结结果
        echo '<pre>';
        print_r($arr); //PING命令详细数据数组
    }

    function getnet(){
                $ip_remark = Request::has('ip','get');
                if(!$ip_remark){
                         $this->json_back(202,'错误','');
                         exit();
                }
                 $ip = Request::get('ip');
        $file = "/etc/linuxsh/logs/{$ip}_net.txt";
        if(file_exists($file)){
            $net= file_get_contents($file);
            View::assign('data',$net);
        }else{
                        $net = 'null';
                         View::assign('data',$net);
                }
                return View('testnet');
    }

    function getdisk(){
        $ip_remark = Request::has('ip','get');
        if(!$ip_remark){
            $this->json_back(202,'错误','');
            exit();
        }
        $ip = Request::get('ip');
        $file = "/etc/linuxsh/logs/{$ip}_disk.txt";
        if(file_exists($file)){
            $net= file_get_contents($file);
            View::assign('data',$net);
        }else{
            $net = 'null';
            View::assign('data',$net);
        }

        View::assign('ip',$ip);
        return View();
    }

    function testnet(){
        $file = "/etc/linuxsh/logs/176_net.txt";
        if(file_exists($file)){
            $net= file_get_contents($file);
            View::assign('data',$net);

        }
                return View();
    }

    public function addWeb(){
        $this->ifLogin();
        $if_edit = Request::has('id','get');
        if($if_edit){
            $id =  Request::param('id');
            $data =  Db::name('web')->where('id', $id)->find();
            View::assign('data',$data);
        }else{
            $data = array('ip'=>'','status'=>'1','remark'=>'','webname'=>'','domainname'=>'','testing'=>'');
        }
        $create_time = time();
        if($this->request->isPost()){
            $data = Request::post();
            $data['create_time'] = $create_time;
            $if_edit = Request::has('id','get');
            if($if_edit){
                $data['id'] = $id;
                $typename = '编辑网站';
            }else{
                $typename = '添加网站';
            }
            $this->inlog(__FUNCTION__,$typename);
            $do =  Db::name('web')->save($data);
            if($do){
                $this->json_back(1,'创建成功','');
            }else{
                $this->json_back(0,'创建失败','');
            }
            exit();
        }
        View::assign('data',$data);
        return View('addWeb');
    }

    public function ifLogin(){
        $bool = Session::has('admininfo');
        if(!$bool) {
            redirect('/guanli/Guanli/login')->send();
        }
    }

    public function testadmins(){
        echo __FUNCTION__;

        echo '<br>';
//        Session::delete('admininfo');
//        Session::clear();
        session('admininfo', null);
//        Session::set('admininfo', 'asdfasdfasdf');
        $userinfo = Session::get('admininfo');




        print_r($userinfo);
    }


    public function video_batch(){

        if($this->request->isPost()){// 如果是post 就验证是否登陆。 如果错则提示错误。 如果正确则登陆
            //验证数据。

            $app_id =       '1672969461062585';
            $app_token =   '4908c6a12702b8797dcdfdc663e426a9';

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
            for($i=0;$i<$num;$i++) {

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
                echo $temps =  $this->curl2($tem, $url2);
                $logs['log']=$temps;
                $logs['json'] = json_encode($tem);
                $create_time = time();
                $log =  Db::name('log')->save($logs);
                if($log !==''){
                    $temps = json_decode($temps,true);
                    echo  $article_id =  $temps['data']['article_id'];
                    echo '<br>';
                    $errno = $temps['errno'];
                    $msg = $temps['errmsg'];
                    $data = ['create_time'=> $create_time , 'msg' => $msg , 'status' => $errno,'article_id'=> $article_id , 'title' => $tem['title'], 'video_url' => $tem['video_url'],'cover_images' => $tem['cover_images'],'tag' => $tem['tag'], 'is_original'=> $tem['is_original'] ,'use_auto_cover' => $tem['use_auto_cover']];
                    $do =  Db::name('videoinfo')->save($data);
                    if($do){
                        echo 'ok,记录了'.$tem['title'].'<br>';
                    }else{
                        echo 'false.记录失败'.$tem['title'].'请告诉管理员<br>';
                    }
                }else{
                    echo '返回空';
                }
            }
            //接口地址:https://baijiahao.baidu.com/builderinner/open/resource/video/publish
        }
        return View();
    }

    public function video_list(){

        if ($this->request->isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 20);
            $list = Db::name('videoinfo')
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
                    $do =  Db::name('videoinfo')->save($data);
                    $dos['msg'][$k]= '成功';
                    $dos['title'][$k]= $item['title'];
                }else{
                    $dos['msg'][$k]= '失败';
                    $dos['title'][$k]= $item['title'];
                }
            }


            $this->json_back('1',$dos,$temps);

            exit();

            //接口地址:https://baijiahao.baidu.com/builderinner/open/resource/video/publish
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
                    $do =  Db::name('videoinfo')->save($data);
                    $dos['msg'][$k]= '成功';
                    $dos['title'][$k]= $item['title'];
                }else{
                    $dos['msg'][$k]= '失败';
                    $dos['title'][$k]= $item['title'];
                }
            }
            $this->json_back('1',$dos,$temps);
            exit();
            //接口地址:https://baijiahao.baidu.com/builderinner/open/resource/video/publish
        }
    }
    public function video_list_api(){
        if ($this->request->isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $map = input('post.');
            $where[] = ['status', '=', 0];
            if (@$map['title'] != '') $where[] = ['title', 'like', '%' . $map['title'] . '%'];
            if (@$map['msg'] != '') $where[] = ['msg', '=',  $map['msg'] ];
            if (@$map['article_id'] != '') $where[] = ['article_id', '=',  $map['article_id'] ];
            $list = Db::name('videoinfo')
                ->where($where)
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            $article_id = '';
            foreach ($list['data'] as $k => $v) {//这边应该加判定。 如果状态不是public  rejected forbidden withdraw deleted videofail audiofail 再查询
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
        $mapp_procedure = array();
        $mapp_procedure['mapp_id'] = '16553734';
        $mapp_procedure['material_id'] = '651006204411710953';
        $mapp_procedure['cover_type'] = 'big';

        $mapp_procedure = json_encode($mapp_procedure);

        echo $mapp_procedure;
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

}
