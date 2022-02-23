<?php
declare (strict_types = 1);

namespace app\admin\controller;
use app\admin\BaseController;
use think\facade\Db;
use think\exception\ValidateException;
use think\facade\Config;
use think\facade\Cache;
use think\facade\View;
use think\facade\Request;

class Admin extends BaseController
{
    public function index()
    {
//      //  Cache::store('redis')->set('name','test',3600);
//        if(request()->isPost()) {// 需要是post
//            try {
//                $this->validate([
//                    'name' => '',
//                    'email' => 'thinkphp@qq.com'
//                ],
//                    'app\guanli\validate\User');
//            } catch (ValidateException $e) {
//                //halt($e->getError());
//                echo callback("100", $e->getError(), "", "000");
//            }
//        }

//        $user = new \app\guanli\model\Guanli();
//        $data = [
//            'username' => 'compile',
//            'password' => 'dl545129041'
//        ];
//        $user->login($data,'');

        return View();
    }
    public function main(){
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

    public function difftest(){
        $list = Db::name("videoinfo")
            ->where('pass','=',2)
            ->field('id,title,video_url,cover_images,msg,article_id')
            ->select()
            ->toArray();


        foreach($list as $key=>$item){


            $title =trim(preg_replace('/([\x80-\xff]*)/i','',$item['title']));
            //echo $title.'<br>';


            //	echo $item['video_url']."<br>";

            if(strstr($item['video_url'], $title)){
                //	echo $item['video_url'].'存在<br>';
            }else{
                echo '<span style="color:#f22ada">'.$item['title'].'</span> &nbsp;&nbsp; 文章id '.$item['article_id'].' 状态:'.$item['msg'].' 检测到:'.$item['video_url'].'不存在'.$title.'<br>';

                //	Db::name("videoinfo")->where("id",$item['id'])
                // ->delete();
            }

        }

    }


    public function diffdirsql(){
        $list = Db::name("videoinfo")
            ->where('pass','=',2)
            ->field('id,title,video_url,cover_images,msg,article_id')
            ->select()
            ->toArray();


        foreach($list as $key=>$item){

            $title1[] =trim(preg_replace('/([\x80-\xff]*)/i','',$item['title'])) . '.mp4';
            /**
            //echo $title.'<br>';


            //	echo $item['video_url']."<br>";

            if(strstr($item['video_url'], $title)){
            //	echo $item['video_url'].'存在<br>';
            }else{
            echo '<span style="color:#f22ada">'.$item['title'].'</span> &nbsp;&nbsp; 文章id '.$item['article_id'].' 状态:'.$item['msg'].' 检测到:'.$item['video_url'].'不存在'.$title.'<br>';

            //	Db::name("videoinfo")->where("id",$item['id'])
            ->delete();
            }
             **/
        }


        echo '<pre>';
        echo 'num:'.count($title1);
        echo '<br>';
        //	print_r($title);


        $path = '/bjh/bjh.qilaixiu.com/englishword/';
        $dir = scandir($path);
        $create_time = time();
        // $domain = 'http://res1.qilaixiu.com/';
        foreach ($dir as $value) {
            /**
            $sub_path = $path . '/' . $value;
            $subpath = ltrim($path,'/file').'/';
            $subpath = ltrim($subpath,'/');
             * */
            if ($value == '.' || $value == '..' || !strstr($value,'mp4')) {
                continue;
            } else {
                $title2[] =  $value;
            }
        }


        $diff = array_values(array_diff($title2,$title1));


        print_r($diff);



    }


    public function bjhlist(){//获得视频列表

        $app_id =       '1672969461062585';
        $app_token =   '4908c6a12702b8797dcdfdc663e426a9';

        /**
         * app_token	string	是	授权密钥
        app_id	string	是	作者帐号ID
        start_time	string	否	支持按照年月日格式（2019-06-01）进行查询，仅支持查询到日维度的数据
        end_time	string	否	支持按照年月日格式（2019-07-01）进行查询，仅支持查询到日维度的数据
        page_no	int	否	查询页码，不传默认为1
        page_size	int	否	查询条数，不能超过20，不传默认为20
        article_type	string	否	文章类型，news-图文、gallery-图集、video-视频，不传默认查询所有支持的文章类型
        collection	string	否	文章状态集，不传默认查询所有支持的文章状态集 draft-草稿、publish-已发布、pre_publish-待发布、withdraw-已撤回、rejected-未通过
         **/
        /**
        $url = 'https://baijiahao.baidu.com/builderinner/open/resource/query/articleListall';
        for($i=1;$i<=220;$i++){
        // echo '<hr>'.$i.'<hr>';
        $tem['app_id'] = $app_id;
        $tem['app_token'] = $app_token;
        $tem['page_no'] = $i;
        $tem['page_size'] = 20;
        // $tem['article_type'] = 'video';
        $temps =  $this->curl2($tem, $url);
        $temps = json_decode($temps,true);
        foreach($temps['data']['items'] as $key => $item){
        $bjh['nid'] = $item['nid'];
        // $bjh['article_id'] = $item['article_id'];
        // $bjh['article_url'] = $item['article_url'];
        $bjh['status'] = $item['status'];
        $result = preg_replace('/([\x80-\xff]*)/i','',$item['title']);
        $bjh['word'] = $result;
        $bjh['create_time'] = time();
        echo '<pre>';
        print_r($bjh);
        echo '</pre>';
        Db::name("words_test2")->save($bjh);
        }
        }
         **/
        $test = ''; // test : "3234234#fasdfj#fdafs#dfasdfdf";
        $test = preg_replace('/([\x80-\xff]*)/i','',$test);
        $temp = explode('#',$test);
        $temp = array_filter($temp);
        $temp = array_unique($temp);
        echo count($temp);
        foreach($temp as $item){
            $bjh['word'] = trim($item);
            $bjh['create_time'] = time();
            Db::name("words_back")->save($bjh);
        }
    }


    public function diff_nid(){

        $list = Db::name("words_test2")
            ->select()
            ->toArray();

        foreach($list as $item){
            $nid[] = $item['nid'];
        }

        $test = '';

        $temp = explode('#',$test);
        $temp = array_filter($temp);

        $nid = array_unique($nid);
        echo '<pre>';

        echo '数据库里去掉重复的 数据 '.count($nid);
        echo '百家号给的数据数'. count($temp);


        $repeat_arr = array_diff( $temp,$nid);
        echo '<hr>';
        echo '得到差集合';

        echo count($repeat_arr);
        print_r($repeat_arr);



        //         echo '<hr>';

        //         	echo '<pre>';
        // echo '数据库里面的';
        // echo print_r($nid);

        // echo '百家号给的';
        // print_r($temp);
        // echo '<hr>';


    }

    public function login()//登陆
    {
        if($this->request->isPost()){// 如果是post 就验证是否登陆。 如果错则提示错误。 如果正确则登陆
            //验证数据。
        }
        return View();
    }



    public function video_batch(){

        if($this->request->isPost()){// 如果是post 就验证是否登陆。 如果错则提示错误。 如果正确则登陆
            //验证数据。

            $app_id =       '1706608657050305';

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
                $logs['create_time'] = $create_time;
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



    function file_list(){
        $path = 'file';
        $this->getDir($path);
    }

    function check_word(){
        //录入words 库
        // $txt = file_get_contents("/bjh/bjh.qilaixiu.com/public/bjh.txt");
        // $temp = explode('##',$txt);
        //$temp = Db::name('words_test')
        //->select()
        //->toArray();

        $test = Db::query("select `word` FROM `words_test` GROUP BY `word`");

        //echo count($test);


        //exit();
        //  foreach($temp as $item){
        //  	$words[] = $item['word'];
        //  }

        for($i=0;$i<= count($test) -1;$i++){
            $words[] = $test[$i]['word'];
        }


        // $words_unique = array_unique($test);//去重复
        $words_unique =$words;
        echo '<pre>';

        print_r($words_unique);

        echo '</pre>';

        //$temp = array_unique($temp);//去重复

        foreach($words_unique as $item){
            echo 	$t['word'] = $item;
            echo '<br>';
            $t['create_time'] = time();
            $do = $this->add_two($t);
        }
    }
    function write_word(){
        $temp = Db::name('videoinfo')
            ->select()
            ->toArray();
        foreach($temp as $key=>$item){

            // echo $item['id'].$item['title'].'<br>';

            $img =  $item['cover_images'];
            $temp = explode('/',$img);
            // echo trim(trim($temp[count($temp) - 1],'.png'),'.jpg');
            $tem =  explode('.',$temp[count($temp) - 1]);
            echo $tem['0'].'<br>'	;

            Db::name('videoinfo')
                ->where('id', $item['id'])
                ->update(['word' => trim($tem['0'])]);
        }
    }
    function del_from_words(){//把 words没有的删除
        $temp = Db::name('videoinfo')
            ->select()
            ->toArray();
        foreach($temp as $key=>$item){

            $word =  trim(preg_replace('/([\x80-\xff]*)/i','',$item['title']));

            $check = Db::name('words_back')
                ->where('word','=',$word)
                ->find();

            if($check){
                echo  $item['word'].'存在<br>';

                Db::name('videoinfo')
                    ->delete($item['id']);


            }else{
                //echo  $item['word'].'不存在<br>';
            }



            // echo 	$t['word'] = $tem[0];
            // echo '<br>';
            // 	$t['create_time'] = time();

            // 	 $do = $this->add_two($t);


        }
    }

    function batch_save(){
        $where[] = ['status', '=', 0];
        $temp = Db::name('videoinfo')
            ->where($where)
            ->select()
            ->toArray();
        //  echo '<pre>';


        //  foreach($temp as $item){
        //      echo $item['word'].'.mp4<br>';
        //  }

        // exit();

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
    function file_get_mp4(){
        /**
         *
         * 1.逻辑。 先检测一遍有没有错。
         * 2.再提交到数据库。
         * 3.再批量添加标题和 其他内容。    并更改状态。
         * 4.确认无误后提交到百家号。
         *
         **/
        // $path = '/bjh/bjh.qilaixiu.com/englishword/';
        $path = '/vdb1/linshi/20210615/';
        $dir = scandir($path);
        $create_time = time();
        $domain = 'http://res1.qilaixiu.com/';
        foreach ($dir as $value) {
            /**
            $sub_path = $path . '/' . $value;
            $subpath = ltrim($path,'/file').'/';
            $subpath = ltrim($subpath,'/');
             * */
            if ($value == '.' || $value == '..' || !strstr($value,'mp4')) {
                continue;
            } else {
                //.$path 可以省略，直接输出文件名
                $filename = str_replace(strrchr($value, "."),"",$value);
                $filename = strtolower($filename);
                echo  $imgstatus = $this->checkFileExists($path.$filename.'.png');
                echo $path.$filename.'.png';
                echo '<hr>';
                echo '$imgstatus2:';
                echo  $imgstatus2 = $this->checkFileExists($path.$filename.'.jpg');
                echo '<br>';
                $video_url = $filename.'.mp4';
                $noimgorerror = array();
                if($imgstatus){
                    $img = $filename.'.png';
//                    echo $filename.'.mp4&nbsp;&nbsp;&nbsp;'.$img.'<br>';
                    if($this->checkIfExists($domain.$img)){//存在
                        echo '存在,过滤'.$filename.'<br>';
                    }else{


//                        echo '不存在,添加入库<br>';
                        $temp['title']     = $filename;
                        $temp['video_url'] = $domain.$video_url;
                        $temp['cover_images'] = $domain.$img;
                        $temp['create_time'] = $create_time;
                        $temp['tag'] = $filename;
                        $temp['is_original'] = 1;
                        $temp['status'] = 0;
                        $temp['word']     = trim($filename);
                        $temp['msg'] = '成功';
                        $result = $this->add_one($temp);
                        if($result){
                            echo $filename .' is ok in sql111111111<br>';
                        }else{
                            echo $filename .' is ok in sql is error,please call wushi<br>';
                        }
                    }


                }elseif($imgstatus2){
                    if($imgstatus2){
                        $img = $filename.'.jpg';
//                       echo $filename.'.mp4&nbsp;&nbsp;&nbsp;'.$img.'<br>';
                        if($this->checkIfExists($domain.$img)){//存在
                            echo '存在,过滤'.$filename.'<br>';
                        }else{

//                           echo '不存在,添加入库<hr>';
                            $temp['title']     = $filename;
                            $temp['video_url'] = $domain.$video_url;
                            $temp['cover_images'] = $domain.$img;
                            $temp['create_time'] = $create_time;
                            $temp['tag'] = $filename;
                            $temp['is_original'] = 1;
                            $temp['status'] = 0;
                            $temp['word']     = trim($filename);
                            $temp['msg'] = '成功';
                            $result =   $this->add_one($temp);
                            if($result){
                                echo $filename .' is ok in sql111111111<br>';
                            }else{
                                echo $filename .' is ok in sql is error,please call wushi<br>';
                            }
                        }
                    }else{

                        $noimgorerror[] =  $filename.' is no img';
                    }
                }else{
                    echo 'acc';
                    $noimgorerror[]  =  $filename. ' is no img';
                }

                /**
                 *  id, title , article_id  video_url  cover_images tag is_original  use_auto_cover  status  msg create_time  bjh_status
                 */
            }
        }

        echo '<hr>这里显示异常信息,为空表示正常<br>';
        print_r($noimgorerror);

    }



    function file_get_shipin(){
        /**
         *
         * 1.逻辑。 先检测一遍有没有错。
         * 2.再提交到数据库。
         * 3.再批量添加标题和 其他内容。    并更改状态。
         * 4.确认无误后提交到百家号。
         *
         **/
        // $path = '/bjh/bjh.qilaixiu.com/englishword/';
        $path = '/vdb1/bjh.qilaixiu.com/english';
        $dir = scandir($path);
        $create_time = time();
        $domain = 'http://res1.qilaixiu.com/';
        foreach ($dir as $value) {
            /**
            $sub_path = $path . '/' . $value;
            $subpath = ltrim($path,'/file').'/';
            $subpath = ltrim($subpath,'/');
             * */
            if ($value == '.' || $value == '..' || !strstr($value,'mp4')) {
                continue;
            } else {
                //.$path 可以省略，直接输出文件名
                $filename = str_replace(strrchr($value, "."),"",$value);
                $filename = strtolower($filename);
                //   echo  $imgstatus = $this->checkFileExists($path.$filename.'.png');
                //   echo $path.$filename.'.png';
                $imgstatus2 = $this->checkFileExists($path.$filename.'.jpg');
                echo $video_url = $filename.'.mp4';
                echo '<br>';
                $noimgorerror = array();



                if($imgstatus2){
                    $img = $filename.'.jpg';
//                       echo $filename.'.mp4&nbsp;&nbsp;&nbsp;'.$img.'<br>';
                    //   if($this->checkIfExists($domain.$img)){//存在
                    //       echo '存在,过滤'.$filename.'<br>';
                    //   }else{

//                           echo '不存在,添加入库<hr>';
                    $temp['title']     = $filename;
                    $temp['video_url'] = $domain.$video_url;
                    $temp['cover_images'] = $domain.$img;
                    $temp['create_time'] = $create_time;
                    $temp['tag'] = $filename;
                    $temp['is_original'] = 1;
                    $temp['status'] = 0;
                    $temp['word']     = trim($filename);
                    $temp['msg'] = '成功';

                    echo $filename.'<br>';

                    //$result =   $this->add_one($temp);
                    //   if($result){
                    //       echo $filename .' is ok in sql111111111<br>';
                    //   }else{
                    //       echo $filename .' is ok in sql is error,please call wushi<br>';
                    //   }
                    //   }
                }else{

                    $noimgorerror[] =  $filename.' is no img';
                }


                /**
                 *  id, title , article_id  video_url  cover_images tag is_original  use_auto_cover  status  msg create_time  bjh_status
                 */
            }
        }

        echo '<hr>这里显示异常信息,为空表示正常<br>';
        print_r($noimgorerror);

    }

    public function no_no_print(){
        $path = '/vdb1/linshi/20210615/';
        $dir = scandir($path);
        $create_time = time();
        $domain = 'http://res1.qilaixiu.com/';
        foreach ($dir as $value) {
            if ($value == '.' || $value == '..' || !strstr($value, 'mp4')) {
                continue;
            } else {
                //.$path 可以省略，直接输出文件名
                $filename = str_replace(strrchr($value, "."), "", $value);
                $filename = strtolower($filename);

                echo $filename .'.mp4<br>';
            }
        }

    }


    public  function no_check_in_word()
    {

        //	exit();// 临时使用不过滤的。 使用把把 文件移到/bjh/bjh.qilaixiu.com/englishword
        // $path = '/bjh/bjh.qilaixiu.com/public/file/word/';
        $path = '/vdb1/linshi/20210803/';
        $dir = scandir($path);
        $create_time = time();
        $domain = 'http://8.136.197.186:3918/';
        foreach ($dir as $value) {
            if ($value == '.' || $value == '..' || !strstr($value, 'mp4')) {
                continue;
            } else {
                //.$path 可以省略，直接输出文件名
                $filename = str_replace(strrchr($value, "."), "", $value);
                $filename = strtolower($filename);
                $imgstatus = $this->checkFileExists($path . $filename . '.png');
                $imgstatus2 = $this->checkFileExists($path . $filename . '.jpg');

                $video_url = $filename . '.mp4';
                $noimgorerror = array();
                /**
                if ($imgstatus) {
                //判断图片格式是png 还是jpg
                $img = $filename . '.png';
                } else if ($imgstatus2) {
                $img = $filename . '.jpg';
                } else {
                echo 'no img';
                break;
                }
                 **/


                if ($imgstatus) {
                    //判断图片格式是png 还是jpg
                    $img = $filename . '.png';
                } else {
                    $img = $filename . '.jpg';
                }
                //                       echo $filename.'.mp4&nbsp;&nbsp;&nbsp;'.$img.'<br>';
                $temp = Db::name('videoinfo')
                    ->where('word', (string)$filename)
                    ->find();
                if ($temp) {
                    //存在
                    echo '存在,就改掉';
                    /**
                     * // $where[] = ['msg', '<>', 'publish'];
                     * $where[] = ['pass', '=', '1'];
                     **/


                    $change['msg']= '成功';
                    $change['pass'] = 0;
                    $change['status'] = 0;
                    $change['title'] = $temp['word'];
                    $change['tag'] = $temp['word'];




                    $do = Db::name('videoinfo')
                        ->where('id', $temp['id'])
                        ->update($change);

                    if($do){
                        echo $temp['id'].'修改成功<br>';
                    }else{
                        echo $temp['id'].'修改失败<br>';
                    }

                } else {
                    echo $img . '不存在,添加入库<hr>';

                    //                           echo '不存在,添加入库<hr>';
                    $temp['title']     = $filename;
                    $temp['video_url'] = $domain.$video_url;
                    $temp['cover_images'] = $domain.$img;
                    $temp['create_time'] = $create_time;
                    $temp['tag'] = $filename;
                    $temp['is_original'] = 1;
                    $temp['status'] = 0;
                    $temp['word']     = trim($filename);
                    $temp['msg'] = '成功';


                    $result =   $this->add_one($temp);

                    if($result){
                        echo $filename .' is ok in sql111111111<br>';
                    }else{
                        echo $filename .' is ok in sql is error,please call wushi<br>';
                    }

                }
                /**
                 *  id, title , article_id  video_url  cover_images tag is_original  use_auto_cover  status  msg create_time  bjh_status
                 */
            }
            echo '<hr>这里显示异常信息,为空表示正常<br>';
            print_r($noimgorerror);
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
    function add_two($temp){
        $do = Db::name('words')
            ->save($temp);
        return $do;
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


    function getDir($path){

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

            $app_id =       '1706608657050305';
            $app_token =   'ef540d3c9a144dffbeaeb813b96b76ba';
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


    public function auto_in_bjhao(){//自动上传。每次一个。 msg 状态不能为publish。 并且 pass 必须等于1 。
        /**
         *  重置pass = 1  即可重新上传。
         *
         *
         * */



        $where[] = ['msg', '<>', 'publish'];
        $where[] = ['pass', '=', '1'];
        $where[] = ['title','like','%一分钟%'];
        $item = Db::name("videoinfo")
            ->where($where)
            ->find();


        if(!$item){
            echo 'no data , exit()';
            exit();
        }
        echo $item['id'];

        $app_id =       '1706608657050305';
        $app_token =   'ef540d3c9a144dffbeaeb813b96b76ba';
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
        // $tem['mapp_procedure'] = $mapp_procedure;
        $url2 = "https://baijiahao.baidu.com/builderinner/open/resource/video/publish";
        echo $temps =  $this->curl2($tem, $url2);
        $temps = json_decode($temps,true);


        echo '<pre>';
        print_r($item);
        print_r($temps);
        echo 'asdfasdf';
        if(@$temps['data']['params'] == 'tag'){
            $msg = "tag长度超过限制";
            $data['id'] = $item['id'];
            $data['pass'] = 3;
            $data['msg'] =  $msg;
            $do =  Db::name('videoinfo')->save($data);
            exit();
        }else{
            $msg = "没事";

            echo '这里';
            $article_id =  $temps['data']['article_id'];
            echo $article_id;
        }

        echo $msg;



        // exit();
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
        $where[] = ['pass', '=', '2'];

        $list = Db::name("videoinfo")
            ->where($where)
            ->limit(19)
            ->select()
            ->toArray();

        if(!$list){
            echo 'no data ';

            $do =  Db::name('videoinfo')
                ->where('here', 1)
                ->update(['here' => 0]);


            if($do){
                echo 'start ';
            }
            exit();
        }
        $article_id = '';
        foreach ($list as $k => $v) {
            $article_id .= $v['article_id'].',';
        }
        $article_id = trim($article_id,',');
        $url = 'https://baijiahao.baidu.com/builderinner/open/resource/query/status';
        $app_id =       '1706608657050305';
        $app_token =   'ef540d3c9a144dffbeaeb813b96b76ba';
        $tem['app_id'] = $app_id;
        $tem['app_token'] = $app_token;
        $tem['article_id'] = $article_id;
        $temps =  $this->curl2($tem,$url);

        $temps = json_decode($temps,true);

        if($temps['errno'] == 0){//查询成功则对应
            $tempinfo = $temps['data'];
            foreach($list as $k=>$v){
                $status =  @$tempinfo[$v['article_id']]['status'];

                if($status){
                    $article_id = $v['article_id'];
                    if($tempinfo[$article_id]['status'] == 'publish'){
//                       $path = $tempinfo[$article_id]['url'];//公开地址, 这里不需要了。
                    }
                    echo          $video['id'] = $v['id'];
                    $video['msg'] = $tempinfo[$article_id]['status'];
                    $video['here'] =1;//寻址

                    echo json_encode($video);

                    $do =  Db::name('videoinfo')->save($video);
                }else{

                    //echo          $video['id'] = $v['id'];
                    echo  $v['article_id'];
                    echo 'null<br>';
                    $video['id'] = $v['id'];
                    $video['here'] =1;//寻址
                    $do =  Db::name('videoinfo')->save($video);
                }


            }


        }

    }




    public function video_in_one(){
        if($this->request->isPost()){// 如果是post 就验证是否登陆。 如果错则提示错误。 如果正确则登陆
            //验证数据。
            $map = input('post.');
            $app_id =       '1706608657050305';
            $app_token =   'ef540d3c9a144dffbeaeb813b96b76ba';
            $mapp_procedure = "[{\"mapp_id\":\"16553734\",\"material_id\":\"651006204411710953\",\"cover_type\":\"big\"}]";
            //小程序
            $url = 'http://8.136.197.186:3918/';

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
                #  $tem['mapp_procedure'] = $mapp_procedure;
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
        //if ($this->request->isAjax()) {
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

        $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        echo json_encode($result);
        //   }
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

    public function test(){
        // $data = ['title' => 'bar', 'video_url' => 'foo','cover_images' => 'asdfasdf','tag' => 'asdfasdf', 'is_original'=> 1 ,'use_auto_cover' => 0];
        //echo  Db::table('videoinfo')->save($data);

        $temp['test'] = 1;
        $temp['test2'] = 2;
        echo json_encode($temp);
    }

    public function test3(){

        $page = input('page', 1);
        $pageSize = input('limit', 10);
        $list = Db::table('videoinfo')
            ->order('create_time desc')
            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
            ->toArray();

        $article_id = '';
        foreach ($list['data'] as $k => $v) {
            $article_id .= $v['article_id'].',';
        }

        $article_id = trim($article_id,',');
        $url = 'https://baijiahao.baidu.com/builderinner/open/resource/query/status';
        $app_id =       '1706608657050305';
        $app_token =   'ef540d3c9a144dffbeaeb813b96b76ba';
        $tem['app_id'] = $app_id;
        $tem['app_token'] = $app_token;
        $tem['article_id'] = $article_id;
        echo $temp = $this->curl2($tem,$url);
        $temp = json_decode($temp,true);


        if($temp['errno'] == 0){//查询成功则对应

            $tempinfo = $temp['data'];

            foreach($list['data'] as $k => $item){

                $articleid = $list['data'][$k]['article_id'];



                $list['data'][$k]['info'] = $tempinfo[$articleid]['status'];
                if($tempinfo[$articleid]['status'] == 'publish'){
                    $list['data'][$k]['path'] = $tempinfo[$articleid]['url'];
                }

            }










        }





        echo '<pre>';

        print_r($list);

        echo '</pre>';

    }


    public function sucai(){
        $url = 'https://baijiahao.baidu.com/builderinner/open/resource/query/searchMappSource';
        $app_id =       '1706608657050305';
        $app_token =   'ef540d3c9a144dffbeaeb813b96b76ba';

        $tem['app_id'] = $app_id;
        $tem['app_token'] = $app_token;
        $tem['mapp_id'] = '99477910549665';
        $temp = $this->curl2($tem,$url);
        $temp = json_decode($temp,true);

        echo '<pre>';

        print_r($temp);

        echo '</pre>';


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
    public function out(){

    }

}
