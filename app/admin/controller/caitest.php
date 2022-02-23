<?php
/**
 * Created by PhpStorm.
 * User: a50
 * Date: 2018/9/7
 * Time: 上午11:00
 */


require_once 'mmmmm/autoload.php';
require_once 'collectionControlApi.php';
use QL\QueryList;
use QL\Ext\PhantomJs;

$A['link'] = 'https://www.sohu.com/a/514825750_121286289';
$A['hot'] = 0;
getPage($A);


function getPage($A){

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
        $html = getContents($url);
        $html = replaceimg($html,'img',$url);
        $this->setHtml($html);
        return $this;
    });
    $rules = [
        'title' => ['h1','text'],
        'post_time'  => ['#news-time','text'],
        'content' =>['#mp-editor','html'],
        'name'    =>['h4>a','text'],
        'typename'    =>['.location>a','text']

    ];
    $temp = $ql->myHttp($url)->rules($rules)->query()->getData();
    echo '<pre>';
    print_r($temp);
    //   print_r($temp[0]);
    //   echo '图片数量';
    echo $imgnum =getImgNum($temp['0']['content']);
    if($imgnum <=0){
        $firstimg = '';
    }else{
        $firstimg = getFirstImg($temp['0']['content']);
        echo '<br>缩略图';
        $thumbimg = str_replace("img","thumb",$firstimg);
        echo $thumbimg;
        file2dir($firstimg,$thumbimg);
        $firstimg = $thumbimg;
    }
    echo '第一张图片';
    echo $firstimg;
    echo '</pre>';
    $db = db();
    $content =  $temp['0']['content'];
    $content = str_replace("'", "/'", $content);
    $post_name =  $temp['0']['name'];
    $post_title=  $temp['0']['title'];
    $post_time =  $temp['0']['post_time'];//原来时间。暂时不需要。用current
    $post_thumb = $firstimg;
    //$type = $A['type'];
    //$type = $temp['0']['typename'];
    // $type =getTypeName($A['type']);
    $type = $A['type'];
    $lib_id = $A['pid'];
    $md5  = short_md5(trimall($post_title));//防止重复添加,应增加判断是否存在，不存在再插入操作
    echo $sql = "SELECT * FROM `lib_link_article_Sm` WHERE `md5` = '{$md5}'";
    $result = $db->query($sql);
    $num = $result->num_rows;
    echo $num;
    if($result->num_rows<=0) {//不存在的话则添加
        if($if_hot == 1){
            $status = 'hot';
        }else{
            $status = 'publish';
        }
        echo  $sql = "INSERT INTO `lib_link_article_Sm` (`ID`, `post_author`, `type`, `post_thumb`,`post_date`, `post_content`, `post_title`,`post_status`, `md5`, `post_name`, `post_parent`, `status`) VALUES (NULL, '1', '{$type}','{$post_thumb}',CURRENT_TIMESTAMP , '{$content}', '{$post_title}','{$status}', '{$md5}','{$post_name}','{$lib_id}','0')";
#$sql = "INSERT INTO `article` (`id`, `author`, `title`, `content`) VALUES (NULL, 'cash','ccc','{$content}')";
        $do = $db->query($sql);
        if ($do) {
            echo '文章详情 add ok<br>';//成功的话。把文章设置为成功


        } else {
            echo $sql . '文章详情 add false<br>';


        }

    }else{
        echo '不能重复添加<br>';
        //deleteimg($content);
        //unlink($post_thumb);
    }
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

/**
 * 清除标题空格/换行/原创标记
 * @param $str
 * @return mixed
 */
function titleTrim($str)
{
    $search = array(" ","　","\n","\r","\t","原创");
    $replace = array("","","","","","");
    return str_replace($search, $replace, $str);
}

/**
 * 返回16位md5
 * @param $str
 * @return bool|string
 */



function random_string($len = 12)
{
    $pool = 'abcdefghijk0123456789lmnopqrstuvwxyz';
    $str = '';
    for ($i=0; $i < $len; $i++){
        $str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
    }
    return $str;
}

/**
 * 批量替换本地图片 伪造来路。
 * @param $xstr
 * @param $keyword
 * @param $from
 * @return mixed
 */
function replaceimg($xstr,$keyword,$from){

    //保存路径
    $d = date('Ymd', time());
    echo $dirslsitss = $keyword.'/'.$d;//分类是否存在
    if(!is_dir($dirslsitss)) {
        @mkdir($dirslsitss, 0777,true);
    }
    echo  $thumbsitss = 'thumb/'.$d;//thumb 缩略图文件夹同步生成
    if(!is_dir($thumbsitss)) {
        @mkdir($thumbsitss, 0777,true);
    }
    //匹配图片的src
    preg_match_all('#<img.*?src="([^"]*)"[^>]*>#i', $xstr, $match);
    //$match[1] = array_unique($match[1]);//去重复mmm
    foreach($match[1] as  $item => $imgurl){

        $imgurl = $imgurl;

        if(is_int(strpos($imgurl, 'http'))){
            $arcurl = $imgurl;
        } else {
            //$arcurl = $oriweb.$imgurl;
            $arcurl = $imgurl;
        }

        $arcurl = str_replace('https:','http:',$arcurl);

        echo '下载地址:';
        echo '$arcurl:'.$arcurl;
        $result = explode(".",$arcurl);
        $imgtype = $result[count($result)-1];
        echo $imgtype;
        if($imgtype == 'gif'){
            $imgtype = '.gif';
        }else{
            $imgtype = '.jpg';
        }
        /**
        $img=file_get_contents($arcurl);
        if(!empty($img)) {
         **/
        //保存图片到服务器
        //$fileimgname = random_string(10).".jpg";
        $fileimgname = short_md5($from).$item.$imgtype;
        $filecachs=$dirslsitss."/".$fileimgname;
        echo "filecaches:";
        echo $filecachs;
        echo '<br>';
        echo '$arcurl:'.$arcurl.'<br>';
        // $fanhuistr = file_put_contents( $filecachs, $img );
        getImg($arcurl,$filecachs);
        $saveimgfile = $keyword."/".$d."/".$fileimgname;
        echo "saveimgfile:".$saveimgfile;
        echo "imgurl:".$imgurl;
        $xstr=str_replace($imgurl,$saveimgfile,$xstr);
        /**}**/
    }
    return $xstr;
}

/**
 * @param $url
 * @param $from  伪造来路
 * @return mixed
 */


function curl_file_get_contents($url,$from){
    //初始化curl会话
    $ch = curl_init();
    //设置一个cURL传输选项。
    curl_setopt($ch, CURLOPT_URL, $url);					//目标
    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
    //curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);
    curl_setopt($ch, CURLOPT_REFERER,$from);			//伪造来路
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function short_md5($str) {
    return substr(md5($str), 8, 16);
}

function file2dir($sourcefile, $thumbfile){
    if( ! file_exists($sourcefile)){
        return false;
    }
    //$filename = basename($sourcefile);
    return copy($sourcefile, $thumbfile);
}


