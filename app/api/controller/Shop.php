<?php
declare (strict_types = 1);

namespace app\api\controller;

use app\BaseController;

use app\api\model\ShopAd;
use app\api\model\ShopNav;
use app\sj\controller\Article;
use think\App;
use think\exception\ValidateException;
use think\facade\Config;
use think\facade\Cache;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Shop extends \app\api\BaseController
{
    public $table;
    function __construct(App $app)
    {
        parent::__construct($app);
        $this->table= 'shop';
    }

    function test(){
        echo 'test';


        $fopen = fopen("/Volumes/50/idiQu/word.txt","rb");

        while (!feof($fopen)){
          echo  $word['title'] =  fgetss($fopen);

//             $word['title_true']  =   trim(strtolower($word['title']));
//            Db::name('word_title')->save($word);
        }

        fclose($fopen);

    }

    public function pic(){
        $path = '/Users/a50/Downloads/word/word/';
        $dir = scandir($path);
        $create_time = time();
        $domain = 'https://yy-1255875008.cos.ap-guangzhou.myqcloud.com/engilsh/word/';
        foreach ($dir as $value) {



            $title = str_replace('.jpg','',$value);
            $title = trim($title);
            $title_true = trim(strtolower($title));
            if ($value == '.' || $value == '..' || !strstr($value,'jpg')) {
                continue;
            } else {
               //echo $title.':'.$value.'<br>';

               $pictemp['title_true'] = $title_true;
               $pictemp['title'] = $title;
               $pictemp['path'] = $domain.$value;
               Db::name('word_pic')->save($pictemp);

               var_dump($pictemp);
                /**
                 *  id, title , article_id  video_url  cover_images tag is_original  use_auto_cover  status  msg create_time  bjh_status
                 */
            }
        }
    }

    public function excel_import()
    {
        ini_set('memory_limit', '1024M');
//        if ($this->request->isPost()) {
//            $file = request()->file('file');
        require "../vendor/phpexcel/PHPExcel.php";
        require "../vendor/phpexcel/PHPExcel/IOFactory.php";
        header("Content-type:text/html;charset=utf-8");
        //实例化主文件
        //接收前台传过来的execl文件
//        $file = $_FILES['file'];

        $file = '/Volumes/50/idiQu/allword.xlsx';
        //截取文件的后缀名，转化成小写
      //  $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

         $extension = 'xlsx';
        if ($extension == "xlsx") {
            //2007(相当于是打开接收的这个excel)
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        } else {
            //2003(相当于是打开接收的这个excel)
            $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        }

        $objContent = $objReader->load($file);

        if ($objContent) {
            $sheetContent = $objContent->getSheet(0)->toArray();
            //删除第一行标题

//            echo '<pre>';
//            print_r($sheetContent);
//            echo '</pre>';
            foreach($sheetContent as $k=>$v){
                $content['title'] = $v[0];
                $content['title_true'] =  trim(strtolower($content['title']));
                $content['content'] = $v[1];
                 Db::name('word_content')->save($content);
                var_dump($v[0].$v[1]);
            }
            exit();
            unset($sheetContent[0]);//
            //dump($sheetContent);die();
            //切记excel表格顺序下标跟对应字段不要弄错
//            foreach ($sheetContent as $k => $v) {
//                $arr['certificate_number'] = $v[0];
//                $arr['real_name'] = $v[1];
//                $arr['sfz'] = $v[2];
//                $arr['create_time'] = time();
//                $arr['sc_id'] = $school_info['sc_id'];
//                $arr['type'] = $school_info['type'];
//                $res[] = $arr;
//            }


//            $re = Db::table('certificate')
//                ->insertAll($res);
//            if ($re) {
//                $this->success('导入成功 !');
//            } else {
//                $this->error('导入失败 !');
//            }
        } else {
            $this->error('请导入表格 !');
        }
//    }
    }



    function shopList(){//店铺列表
//        $this->ifLogin();
//        if (Request::isAjax()) {
            $table = str_replace("List",'',__FUNCTION__);
            $common = new Common();
           echo $res = $common->getList($table);
    }

    function getIndex($key,$desckey,$table,$field='id,title,price,thumb',$where=array('status'=>1)){
        $redis = Cache::store('redis')->handler();
        $exist = $redis->EXISTS($key);
        if($exist) {//存在 就从 缓存获取
            $arrId = $redis->HGETALL($key);
            $result = array();
            foreach($arrId as $item){
                $exist = $redis->EXISTS($desckey.$item);
                if($exist){//如果存在则redis获取
                    $res = $redis->HGETALL($desckey.$item);
                    $result[$item] = $res;
                }else{//否则就mysql获取
                    //$result = array();//这里偷懒了 - -
                }
            }
        }else{//不存在就从数据库获取
            $result    = Db::name($table)->field($field)->where($where)->limit(10)->select()->toArray();
            $arrId = array();
            foreach($result as $k=>$value){
                $arrId[$k] = $value['id'];
                $redis->HMSET($desckey.$value['id'],$value);//加入首页id即可
            }
            $redis->HMSET($key,$arrId);//加入首页id即可
        }

        return $result;
    }


    function loadIndex(){//首页整合
        $scenicList = $this->getIndex('shopIndexScenicList','indexScenicDesc','scenic','id,address,addressName,thumb',array('status'=>1));
        $goodsList = $this->getIndex('shopIndexGoodsList','indexGoodsDesc','goods','id,title,price,thumb',array('status'=>1));
        $carouselList = $this->getIndex('shopIndexCarouselList','indexCarouselDesc','shopad','id,name,bg,path,pic,status',array('status'=>1));
        $navList  = $this->getIndex('shopIndexNavList','indexNavDesc','shopnav','id,name,path,thumb,status',array('status'=>1));
        $goodsGroupList = $this->getIndex('shopIndexgoodsGroupList','indexGoodsGroupDesc','goodsgroup','id,uid,title,price,thumb,descript,goodslist,likes,status',array('status'=>1));


        $temp['navList'] = array_merge($navList);
        $temp['carouselList'] = array_merge($carouselList);
        $temp['goodsList'] = array_merge($goodsList);
        $temp['scenicList'] = array_merge($scenicList);
        $temp['goodsGroupList'] = array_merge($goodsGroupList);
        $res = array();
        $res['data']['status'] = 0;
        $res['data']['res'] = $temp;
        echo json_encode($res);
        exit();
    }

    function shopnavList(){//店铺导航列表
       // $this->ifLogin();
       // if (Request::isAjax()) {
            $table = str_replace("List",'',__FUNCTION__);
            $common = new Common();
            $where['status']=1;
            echo $res = $common->getList($table,2,$where);
//            exit();
//        }
//        return view();
    }


    function shopadList(){//店铺导航列表
//        $this->ifLogin();
//        if (Request::isAjax()) {
            $table = str_replace("List",'',__FUNCTION__);
            $common = new Common();
            $where['type']=0;
            $where['status'] = 1;
            echo  $common->getList($table,2,$where);
//        }
//        return view();
    }



    function deleteOne(){
        if($this->request->isPost()) {
            $id = Request::param('id');
            $common = new \app\sj\controller\Common();
            $common->deleteOne($this->table, $id);
        }
    }

    function modifyState(){
        $comon = new  Common();
        $this->ifLogin();
        $tempdata = Request::param();
        $type = $tempdata['type'];
        $id = $tempdata['id'];
        $tempdata['att'] ?$tempdata['att']:'';
        $att = $tempdata['att'];
        $this->table = $this->table.$att;
        $comon->changeOneAttribute($this->table,$type,$id);
    }
    function modifyStateWithatt(){
        $tempdata = Request::param();
        $att= $tempdata['att'];
        $this->table = $this->table.$att;
        $this->modifyState();
    }
    function modifyStateTwo(){
        $this->table = $this->table.'grade';
        $this->modifyState();
    }
    function addGrade(){
        $usergrade = new \app\admin\model\userGrade();
        $this->ifLogin();
        $id =  Request::param('id');
        Request::param('id') ? $data = $usergrade->getOne($id) : $data = array('name'=>'','gradeValue'=>'');
        View::assign('data',$data);
        if($this->request->isPost()) {
            $common = new \app\admin\controller\Common();
            $data = Request::post();
            $id = Request::param('id') ?? '';
            $common->updateOne($this->table.'grade',$data,$id);
        }
        return view();
    }
    function upload(){
        $common = new Common();
        echo $common->upload('image');
    }
}
