<?php
/**
 * Created by PhpStorm.
 * User: a50
 * Date: 2018/11/6
 * Time: 5:10 PM
 */

namespace collection_50;
use PHPZxing\PHPZxingDecoder;//识别二维码

class core
{

    public function __construct()
    {
        include_once("common.inc.php");
    }





    /**
     * 缩放裁剪 直接用 scalePic即可，
     * @param $picname
     * @param int $maxX
     * @param int $maxY
     * @param string $pre
     * @param $newwidth
     * @param $newheight
     * @return 返回新的图片名
     */


    function scalePic($picname,$maxX=150,$maxY=100,$pre='',$newwidth,$newheight)
    {

        $info = getimagesize($picname); //获取图片的基本信息
        $width = $info[0];//获取宽度
        $height = $info[1];//获取高度
        //判断图片资源类型并创建对应图片资源
        echo '<pre>';
        print_r($info);
        echo $picname;
        echo '</pre>';
        if(!empty($info) && in_array($info['2'],array('1','2','3','4'))){
            echo count($info);
            print_r($info[2]);
            echo '在正常范围内，可以处理生成缩略图';
            $im = getPicType($info[2],$picname);
            //计算缩放比例
            $scale = ($maxX/$width)>($maxY/$height)?$maxY/$height:$maxX/$width;
            //计算缩放后的尺寸
            $sWidth = floor($width*$scale);
            $sHeight = floor($height*$scale);
            //创建目标图像资源
            $nim = imagecreatetruecolor($sWidth,$sHeight);
            //等比缩放
            imagecopyresampled($nim,$im,0,0,0,0,$sWidth,$sHeight,$width,$height);
            //输出图像
            $newPicName = outputImage($picname,$pre,$nim);
            //释放图片资源
            imagedestroy($im);
            imagedestroy($nim);
            //return $newPicName;
            imagecropper($newPicName,$newwidth,$newheight);//裁剪
        }else{
            echo '图片资源不正常，返回空';
            $newPicName = '';
        }
        return $newPicName;
    }

    /**
     * function 判断并返回图片的类型(以资源方式返回)
     * @param int $type 图片类型
     * @param string $picname 图片名字
     * @return 返回对应图片资源
     */
    function getPicType($type,$picname)
    {


        $im=null;
        switch($type)
        {
            case 1:  //GIF
                $im = imagecreatefromgif($picname);
                break;
            case 2:  //JPG
                $im = imagecreatefromjpeg($picname);
                break;
            case 3:  //PNG
                $im = imagecreatefrompng($picname);
                break;
            case 4:  //BMP
                $im = imagecreatefromwbmp($picname);
                break;
            default:
                die("不认识图片类型");
                break;
        }
        return $im;
    }

    /**
     * function 输出图像
     * @param string $picname 图片名字
     * @param string $pre 新图片名前缀
     * @param resourse $nim 要输出的图像资源
     * @return 返回新的图片名
     */
    function outputImage($picname,$pre,$nim)
    {
        $info = getimagesize($picname);
        $picInfo = pathInfo($picname);
        $newPicName = $picInfo['dirname'].'/'.$pre.$picInfo['basename'];//输出文件的路径
        switch($info[2])
        {
            case 1:
                imagegif($nim,$newPicName);
                break;
            case 2:
                imagejpeg($nim,$newPicName);
                break;
            case 3:
                imagepng($nim,$newPicName);
                break;
            case 4:
                imagewbmp($nim,$newPicName);
                break;
        }
        return $newPicName;
    }


    /**
     * 裁剪
     * @param $source_path
     * @param $target_width
     * @param $target_height
     * @return bool
     */

    function imagecropper($source_path, $target_width, $target_height){
        $source_info = getimagesize($source_path);
        $source_width = $source_info[0];
        $source_height = $source_info[1];
        $source_mime = $source_info['mime'];
        $source_ratio = $source_height / $source_width;
        $target_ratio = $target_height / $target_width;

        // 源图过高
        if ($source_ratio > $target_ratio){
            $cropped_width = $source_width;
            $cropped_height = $source_width * $target_ratio;
            $source_x = 0;
            $source_y = ($source_height - $cropped_height) / 2;
        }elseif ($source_ratio < $target_ratio){ // 源图过宽
            $cropped_width = $source_height / $target_ratio;
            $cropped_height = $source_height;
            $source_x = ($source_width - $cropped_width) / 2;
            $source_y = 0;
        }else{ // 源图适中
            $cropped_width = $source_width;
            $cropped_height = $source_height;
            $source_x = 0;
            $source_y = 0;
        }

        switch ($source_mime){
            case 'image/gif':
                $source_image = imagecreatefromgif($source_path);
                break;

            case 'image/jpeg':
                $source_image = imagecreatefromjpeg($source_path);
                break;

            case 'image/png':
                $source_image = imagecreatefrompng($source_path);
                break;

            default:
                return false;
                break;
        }

        $target_image = imagecreatetruecolor($target_width, $target_height);
        $cropped_image = imagecreatetruecolor($cropped_width, $cropped_height);

        // 裁剪
        imagecopy($cropped_image, $source_image, 0, 0, $source_x, $source_y, $cropped_width, $cropped_height);
        // 缩放
        imagecopyresampled($target_image, $cropped_image, 0, 0, 0, 0, $target_width, $target_height, $cropped_width, $cropped_height);
        $dotpos = strrpos($source_path, '.');
        $imgName = substr($source_path, 0, $dotpos);
        $suffix = substr($source_path, $dotpos);
        $imgNew = $imgName . $suffix;
        imagejpeg($target_image, $imgNew, 75);
        imagedestroy($source_image);
        imagedestroy($target_image);
        imagedestroy($cropped_image);
    }

    /**
     * @param $l
     * @param int $type
     * @return mixed
     *
     * 根据type判断通过给的值返回给定的具体类名或者公众号名称
     */

    function getTrue($l,$type=1){//id转化分类或者公众号名称
        $db = new MySQLi(DBHOST,DBUSER,DBPASSWD,DBNAME);
        !mysqli_connect_error() or die("连接失败");
        $db->query('set names utf8');
        if($type == 2){//公众号名称
            $sql = "select profile_nickname from lib_account where lib_id = {$l}";
            $do = $db->query($sql);
            $tem = $do->fetch_assoc();
            $re =  $tem['profile_nickname'];
        }else{//分类
            $sql = "select typename from lib_type where id = {$l}";
            $do = $db->query($sql);
            $tem = $do->fetch_assoc();
            $re =  $tem['typename'];
        }
        return $re;
    }

    /**
     * @param $type
     * 判断是否合法类别
     *  如果存在，返回true，否则返回false false
     */

    function TypeLegal($type){
        $tem = false;
        $typeArray = array("娱乐","时尚","旅游","星座","情感","亲子","搞笑","美食","健康","动漫","游戏","历史","文化","科技","军事","数码","体育","汽车","家居","财经","时事","宠物","猎奇");

        if(in_array($type,$typeArray)){
            $tem = true;
        }
        return $tem;
    }

    /**
     * @param $ArticleData
     * 给予批量数据，传输目标服务器
     */
    function postCurl($ArticleData){
        $data = array(
            'secret' => "YYGJiaYou2018MRTTW.Com",
            'Data' => $ArticleData
        );
        # Create a connection
        $url = 'https://www.idiqu.com/AddNewData.php';
        $ch = curl_init($url);
        # Form data string
        $postString = http_build_query($data, '', '&');
        //echo $postString;exit;
        # Setting our options
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Get the response
        $response = curl_exec($ch);
        curl_close($ch);
    }

    /**
     * 过滤已经采集过的文章id
     */
    function screeningMd5($siteid){
        $db = new MySQLi(DBHOST,DBUSER,DBPASSWD,DBNAME);
        !mysqli_connect_error() or die("连接失败");
        $db->query('set names utf8');
        $sql = "SELECT `md5` FROM `lib_post_control` WHERE `site` = {$siteid}";
        $result = $db->query($sql);
        $smd5=$result->fetch_all(MYSQLI_ASSOC);//原数据
        $emd5 = "";
        if(count($smd5)==0){
            $emd5 = "'0'";
        }else {
            foreach ($smd5 as $l) {
                $emd5 .= "'" . $l['md5'] . "',";
            }
        }
        return $emd5;
    }


    /**
     * 删除文件
     * @param $html
     */
    function deleteimg($html){
        //匹配图片的src
        preg_match_all('#<img.*?src="([^"]*)"[^>]*>#i', $html, $match);
        #$match[1] = array_unique($match[1]);//去重复mmm
        foreach($match[1] as $imgurl){
            unlink($imgurl); //unlink方法删除文件

        }
    }

    /**
     * @return mysqli
     */
    function db(){

        $conn = mysqli_connect(DBHOST, DBUSER, DBPASSWD,DBNAME);
        mysqli_query($conn,"set names utf8");
        if(! $conn )
        {
            die('Could not connect: ' . mysqli_error());
        }

        return $conn;

    }

    /** 返回图片数量 */
    function getImgNum($content){
        $pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
        preg_match_all($pattern,$content,$matchContent);
        return count($matchContent[1]);
    }
    /**
     * @param $content
     * @return mixed
     * 返回图片
     */
    function getFirstImg($content){
        $pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
        preg_match_all($pattern,$content,$matchContent);
        if(empty($matchContent[1][0])){//如果为空
            // $matchContent[1][0]="article/picture/".rand(1,5).".jpg";
        }
        return $matchContent[1][0];
    }
    function getSecondImg($content){
        $pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
        preg_match_all($pattern,$content,$matchContent);
        if(empty($matchContent[1][1])){//如果为空
            // $matchContent[1][0]="article/picture/".rand(1,5).".jpg";
        }
        return $matchContent[1][1];
    }

    function getEndImg($content){
        $pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
        preg_match_all($pattern,$content,$matchContent);
        echo $num = count($matchContent[1]);
        return $matchContent[1][$num - 1];
    }


    function getEndTwoImg($content){
        $pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
        preg_match_all($pattern,$content,$matchContent);
        echo $num = count($matchContent[1]);
        return $matchContent[1][$num - 2];
    }

    /**
     * @param $content
     * @return null|string|string[]
     * 返回处理后的文章内容。
     */

    function filterContent($content){



        $content = strtolower($content);//统一小写

        $content = preg_replace('/<a[^>]*>/', '', $content);// 去除所有的超链接,保留内容
        $content = preg_replace('/<\/a[^>]*>/', '', $content);//移除残留</a>
        $content = preg_replace("#data-croporisrc#","src",$content);//让图片正常显示
        $content = preg_replace("#<iframe[\s\S]+</iframe *>#","",$content);//清除所有的视频嵌入广告


        /** 去除无用标签 **/
        //  $content = preg_replace( '/(<section.*?)(style=.+?[\'|"])/i', '$1' , $content);
        $content = preg_replace( '/(<br.*?)(style=.+?[\'|"])/i', '$1' , $content);

        $content = preg_replace( '/(<a.*?)(style=.+?[\'|"])/i', '$1' , $content);

        $content = preg_replace( '/(<(img|strong|h2|h1|h3|h4|em|h5||center|legend|tbody|tr|td).*?)(style=.+?[\'|"])/i', '$1' , $content);
        $content = preg_replace('/<blockquote[^>]*>/', '<blockquote>', $content);
        $content = preg_replace('/(height="([^\"]*)")||(width="([^\"]*)")||(class="([^\"]*)")||(powered-by="([^\"]*)")||(label="([^\"]*)")||(data-([^\"]*)="([^\"]*)")||(data_ue_src="([^\"]*)")||(data-width="([^\"]*)")||(data-copyright="([^\"]*)")||(data-ratio="([^\"]*)")||(alt="([^\"]*)")||(title="([^\"]*)")||(data-w="([^\"]*)")||(data-type="([^\"]*)")||(data-height="([^\"]*)")/','',$content);
        $content = preg_replace('/<span[^>]*>/','<span>',$content);


        $content = preg_replace('/<p[^>]*>/', '<p>', $content);



        $content = preg_replace('/<strong[^>]*>/', '<b>', $content);//strong 换成b 标签保留内容
        $content = preg_replace('/<\/strong[^>]*>/', '</b>', $content);

        // $content = preg_replace('/\s*<p>\s*</p>/is',"",$content);//清除空白p

        // $content = preg_replace('<(\/?br.*?\/)>','',$content);//br清除

        $content = preg_replace('/<p[^>]*><\/p>/', '', $content);//清除空p
        $content =  preg_replace("/<(\w+)><\/\\1>/", "", $content);//无用嵌套
        //$content = preg_replace('/s(?=s)/','',$content);//错误
        $content = preg_replace('/\s+>/','>',$content);

        //$content = preg_replace('/\s+/',' ',$content);//不可用
        $content = preg_replace('/<(script.*?)>(.*?)<(\/script.*?)>/si',"",$content);// 清除script
        $content = preg_replace('/<(qqmusic.*?)>(.*?)<(\/qqmusic.*?)>/si',"",$content);// 清除qq音乐
        $content = preg_replace('/<(svg.*?)>(.*?)<(\/svg.*?)>/si',"",$content);// 清除svg



        $content = preg_replace('/<(mpcpc.*?)>(.*?)<(\/mpcpc.*?)>/si',"",$content);//清除mpcpc
        $content = preg_replace('/<(fieldset.*?)>(.*?)<(\/fieldset.*?)>/si',"",$content);// 清除fieldset标签及内容

        //  $content = preg_replace('/<(section.*?)>(.*?)<(\/section.*?)>/si',"",$content);// 清除section标签及内容 暂不使用
        $content = preg_replace('/<section[^>]*>/', '', $content);//清除section保留内容


        $content = preg_replace('/<\/section[^>]*>/', '', $content);//遗留section清除



        $content = preg_replace('/<span.*>.*(阅读原文|查看更多精彩内容)+.*<\/span>/i','',$content);




        $content = preg_replace('{(<(\w+)>)\1+}','$1',$content); //多重重复嵌套整理为一个
        $content = preg_replace('{(<(\/\w+)>)\1+}','$1',$content);//多重重复嵌套整理为一个

        $content = preg_replace('/<(\w+)><\/\\1>/', '', $content);//空内容标签过滤
        $content = preg_replace('/<(\w+)><\/\\1>/', '', $content);//空内容标签过滤




        return $content;
    }

    function filterContentKejilie($content){
        $content = str_replace(array("\r","\n"), "", $content);//整理为一行
        $content = preg_replace('/\\t|\r|\n|\s+/',' ',$content);//tab 换行 空白 替换成 单空白
        $content = preg_replace('{(<(\w+)>)\1+}','$1',$content); //多重重复嵌套整理为一个
        $content = preg_replace('{(<(\/\w+)>)\1+}','$1',$content);//多重重复嵌套整理为一个
        return $content;
    }
    function filterContentAgain($content){

        $content = str_replace(array("\r","\n"), "", $content);//整理为一行
        $content = preg_replace('/\\t|\r|\n|\s+/',' ',$content);//tab 换行 空白 替换成 单空白
        $content = preg_replace('{(<(\w+)>)\1+}','$1',$content); //多重重复嵌套整理为一个
        $content = preg_replace('{(<(\/\w+)>)\1+}','$1',$content);//多重重复嵌套整理为一个





        $content = str_replace("<span><br></span>","",$content);//发现未正确闭合的标签，此处清理


        $content = str_replace("<p><span></p>","",$content);//发现未正确闭合的标签，此处清理

        $content = str_replace("<p><br></p>","",$content);//发现未正确闭合的标签，此处清理
        $content = str_replace("<p></p>","",$content);//发现未正确闭合的标签，此处清理
        $content = preg_replace('/src="(?!https:\/\/i1.idiqu.com)([^"]+)"/','',$content);//清除多余的图片地址

        $content = str_replace("<span>返回搜狐，查看更多</span>","",$content);//发现未正确闭合的标签，此处清理
        $content = str_replace("<p>责任编辑：</p>","",$content);

        return $content;
    }

    function filterContentQQ($content){

        $content = str_replace('aria-hidden="true"',"",$content);//发现未正确闭合的标签，此处清理
        $content = preg_replace('/<source[^>]*>/', '<img>', $content);//strong 换成b 标签保留内容
        $content = preg_replace('/<\/source[^>]*>/', '', $content);
        $content = preg_replace('/<\/picture[^>]*>/', '', $content);
        $content = str_replace("<img>","",$content);//删除空img

        return $content;
    }
    function filterCustom($aid,$content){
        $db= db();
        $fitterSql = "select  * from lib_filter_custom where aid = {$aid}";
        $result = $db->query($fitterSql);
        $fitterTem = $result->fetch_all(MYSQLI_ASSOC);
        $num = count($fitterTem);
        if($num == 0){

            // return;
        }else{//替换文章内容。并这里输出最新的过滤规则列表。 可以删除。。
            foreach($fitterTem as $item){
                if($item['status'] == 1){
                    $content = preg_replace($item['rule'],$item['repword'],$content);
                }
            }
        }

        return $content;

    }
    /**
     * @param $img
     * @param $content
     * @return null|string|string[]
     * 这里处理二维码是否存在
     */
    function scalecode($img,$content){
        $decoder = zx();

        $data = $decoder->decode($img);// 通过src确定位置

        if($data){
            if($data->isFound()) {//发现二维码还需要判断是否需要清除，如果图片尺寸很大，例如1000*1000，那么不清除该图片，因为二维码可能是必须的。
                echo '哈哈发现二维码'.$img;

                list($width, $height) = getimagesize($img);
                if($width <= 1000 || $height <= 1000){

                    $one= $data->getImageValue();
                    // $two = $data->getFormat();
                    // $three = $data->getType();
                    if($one!==''){
                        $delsrc= explode("/",$img);
                        $count=count($delsrc);
                        $del =  $delsrc[$count-1];
                        $content = preg_replace('/<img[^>]*.+src="*.+'.$del.'"?.+>/i','',$content);
                    }
                }

            }else{

                $src = $img;
                list($width, $height) = getimagesize($src);
                if(($width/$height)>= 4 || ($width/$height)==1 ||$width <= 250 || $height <= 250){//图片宽高比大于6 或者 等于1，或者宽度小于250或者高度小于250 就清理掉
                    echo $src.'宽高比超过了5,或者1：1清理掉';
                    $delsrc= explode("/",$src);
                    $count=count($delsrc);
                    $del =  $delsrc[$count-1];
                    $content = preg_replace('/<img[^>]*.+src="*.+'.$del.'"?.+>/i','',$content);
                }


            }
        }

        return $content;
    }

    /**
     * @param $src
     * @param $content
     * @return null|string|string[] //  废弃  这里判断图片长宽比。一般广告应该是高小于宽4倍。即如果width/height <= 5 清除掉
     */
    function scalecodeimg($src,$content){


        list($width, $height) = getimagesize($src);
        if(($width/$height)>= 4 || ($width/$height)==1 ||$width <= 250 || $height <= 250){//图片宽高比大于6 或者 等于1，或者宽度小于250或者高度小于250 就清理掉
            echo $src.'宽高比超过了5,或者1：1清理掉';
            $delsrc= explode("/",$src);
            $count=count($delsrc);
            $del =  $delsrc[$count-1];
            $content = preg_replace('/<img[^>]*.+src="*.+'.$del.'"?.+>/i','',$content);
        }
        return $content;
    }

    function zx(){
        $decoder        = new PHPZxingDecoder();
        //$decoder->setJavaPath('/usr/bin/java');
        //  $decoder->setJavaPath('/usr/java/jdk-10.0.2/bin/java');
//	$decoder->setJavaPath('/etc/alternatives/java');
//	$decoder->setJavaPath('/usr/java/default/bin/java');
        return $decoder;
    }


    function trimall($str)//删除空格
    {
        $oldchar=array(" ","　","\t","\n","\r");
        $newchar=array("","","","","");
        return str_replace($oldchar,$newchar,$str);
    }


    /**
     *@通过curl方式获取指定的图片到本地
     *@ 完整的图片地址
     *@ 要存储的文件名 微信有效
     **/
    function getImg($url = "", $filename = "")
    {
        //去除URL连接上面可能的引号
        //$url = preg_replace( '/(?:^['"]+|['"/]+$)/', '', $url );
        $hander = curl_init();
        $fp = fopen($filename,'wb');
        curl_setopt($hander,CURLOPT_URL,$url);
        curl_setopt($hander,CURLOPT_FILE,$fp);
        curl_setopt($hander,CURLOPT_HEADER,0);
        curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
        //curl_setopt($hander,CURLOPT_RETURNTRANSFER,false);//以数据流的方式返回数据,当为false是直接显示出来
        curl_setopt($hander,CURLOPT_TIMEOUT,60);
        curl_exec($hander);
        curl_close($hander);
        fclose($fp);
        Return true;
    }


    /**
     * @param $str
     * @return mixed
     * 字数统计
     */

    function countWords($str){

        $str = preg_replace('/[\x80-\xff]{1,3}/', ' ', $str,-1,$n);
        $n += str_word_count($str);
        return $n;

    }


    function tipm($str){

        include "class/class.phpmailer.php";
        include "class/class.smtp.php";
        $mail = new PHPMailer(true); //建立邮件发送类
        $mail->CharSet = "UTF-8";//设置信息的编码类型
        $address = "3920699@qq.com";//收件人地址
        $mail->IsSMTP(); // 使用SMTP方式发送
        $mail->Host = "smtp.qq.com"; //使用163邮箱服务器
        $mail->SMTPAuth = true; // 启用SMTP验证功能
        $mail->Username = "3920699@qq.com"; //你的163服务器邮箱账号
        $mail->Password = "hlxecrfjwhtscaif"; // 163邮箱密码
        $mail->Port = 25;//邮箱服务器端口号
        $mail->From = "3920699@qq.com"; //邮件发送者email地址
        $mail->FromName = "测试邮件";//发件人名称
        $mail->AddAddress("$address", "张三"); //收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
        $mail->IsHTML(true);//是否使用HTML格式
        $mail->Subject = $str; //邮件标题
        $mail->Body = "如题～，". date('Y-m-d H:i:s', time()); //邮件内容，上面设置HTML，则可以是HTML
        if (!$mail->Send()) {
            echo "邮件发送失败. <p>";
            echo "错误原因: " . $mail->ErrorInfo;
            exit;
        }else{
            echo "发送成功";
        }

    }

    function say(){
        return date("Y-m-d H:i:s");
    }

}




