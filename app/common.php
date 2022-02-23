<?php
use firebase\firebase;
use think\Db;
use think\facade\Env;

//请求返回
function callback($status = 0,$msg = '', $url = null, $data = ''){
    $data = array(
        'msg'=>$msg,
        'url'=>$url,
        'data'=>$data,
        'status'=>$status
    );
    return json_encode($data);
}



//文件单位换算
function byte_format($input, $dec=0){
    $prefix_arr = array("B", "KB", "MB", "GB", "TB");
    $value = round($input, $dec);
    $i=0;
    while ($value>1024) {
        $value /= 1024;
        $i++;
    }
    $return_str = round($value, $dec).$prefix_arr[$i];
    return $return_str;
}
//时间日期转换
function toDate($time, $format = 'Y-m-d H:i:s') {
    if (empty ( $time )) {
        return '';
    }
    $format = str_replace ( '#', ':', $format );
    return date($format, $time );
}


function dir_list($path, $exts = '', $list= array()) {
    $path = dir_path($path);
    $files = glob($path.'*');
    foreach($files as $v) {
        $fileext = fileext($v);
        if (!$exts || preg_match("/\.($exts)/i", $v)) {
            $list[] = $v;
            if (is_dir($v)) {
                $list = dir_list($v, $exts, $list);
            }
        }
    }
    return $list;
}
function dir_path($path) {
    $path = str_replace('\\', '/', $path);
    if(substr($path, -1) != '/') $path = $path.'/';
    return $path;
}
function fileext($filename) {
    return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
}
function checkField($table,$value,$field){
    $count = db($table)->where(array($field=>$value))->count();
    if($count>0){
        return true;
    }else{
        return false;
    }
}
/**
+----------------------------------------------------------
 * 产生随机字串，可用来自动生成密码 默认长度6位 字母和数字混合
+----------------------------------------------------------
 * @param string $len 长度
 * @param string $type 字串类型
 * 0 字母 1 数字 其它 混合
 * @param string $addChars 额外字符
+----------------------------------------------------------
 * @return string
+----------------------------------------------------------
 */
function rand_string($len=6,$type='',$addChars='') {
    $str ='';
    switch($type) {
        case 0:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        case 1:
            $chars= str_repeat('0123456789',3);
            break;
        case 2:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
            break;
        case 3:
            $chars='abcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        case 4:
            $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借".$addChars;
            break;
        default :
            // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
            $chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
            break;
    }
    if($len>10 ) {//位数过长重复字符串一定次数
        $chars= $type==1? str_repeat($chars,$len) : str_repeat($chars,5);
    }
    if($type!=4) {
        $chars   =   str_shuffle($chars);
        $str     =   substr($chars,0,$len);
    }else{
        // 中文随机字
        for($i=0;$i<$len;$i++){
            $str.= msubstr($chars, floor(mt_rand(0,mb_strlen($chars,'utf-8')-1)),1);
        }
    }
    return $str;
}

/**
 * 验证输入的邮件地址是否合法
 */
function is_email($user_email)
{
    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false) {
        if (preg_match($chars, $user_email)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * 验证输入的手机号码是否合法
 */
function is_mobile_phone($mobile_phone)
{
    $chars = "/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/";
    if (preg_match($chars, $mobile_phone)) {
        return true;
    }
    return false;
}
/**
 * 取得IP
 *
 * @return string 字符串类型的返回结果
 */
function getIp(){
    if (@$_SERVER['HTTP_CLIENT_IP'] && $_SERVER['HTTP_CLIENT_IP']!='unknown') {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (@$_SERVER['HTTP_X_FORWARDED_FOR'] && $_SERVER['HTTP_X_FORWARDED_FOR']!='unknown') {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return preg_match('/^\d[\d.]+\d$/', $ip) ? $ip : '';
}

//字符串截取
function str_cut($sourcestr,$cutlength,$suffix='...')
{
    $returnstr='';
    $i=0;
    $n=0;
    $str_length=strlen($sourcestr);//字符串的字节数
    while (($n<$cutlength) and ($i<=$str_length))
    {
        $temp_str=substr($sourcestr,$i,1);
        $ascnum=Ord($temp_str);//得到字符串中第$i位字符的ascii码
        if ($ascnum>=224)    //如果ASCII位高与224，
        {
            $returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符
            $i=$i+3;            //实际Byte计为3
            $n++;            //字串长度计1
        }
        elseif ($ascnum>=192) //如果ASCII位高与192，
        {
            $returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
            $i=$i+2;            //实际Byte计为2
            $n++;            //字串长度计1
        }
        elseif ($ascnum>=65 && $ascnum<=90) //如果是大写字母，
        {
            $returnstr=$returnstr.substr($sourcestr,$i,1);
            $i=$i+1;            //实际的Byte数仍计1个
            $n++;            //但考虑整体美观，大写字母计成一个高位字符
        }
        else                //其他情况下，包括小写字母和半角标点符号，
        {
            $returnstr=$returnstr.substr($sourcestr,$i,1);
            $i=$i+1;            //实际的Byte数计1个
            $n=$n+0.5;        //小写字母和半角标点等与半个高位字符宽...
        }
    }
    if ($n>$cutlength){
        $returnstr = $returnstr . $suffix;//超过长度时在尾处加上省略号
    }
    return $returnstr;
}
/**
 * 字符串截取2
 *
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)
{
    if(function_exists("mb_substr")){
        if($suffix)
            return mb_substr($str, $start, $length, $charset)."...";
        else
            return mb_substr($str, $start, $length, $charset);
    }
    elseif(function_exists('iconv_substr')) {
        if($suffix)
            return iconv_substr($str,$start,$length,$charset)."...";
        else
            return iconv_substr($str,$start,$length,$charset);
    }
    $re['utf-8'] = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
    $re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
    $re['gbk']  = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
    $re['big5']  = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    if($suffix) return $slice."…";
    return $slice;
}

//删除目录及文件
function dir_delete($dir) {
    $dir = dir_path($dir);
    if (!is_dir($dir)) return FALSE;
    $list = glob($dir.'*');
    foreach($list as $v) {
        is_dir($v) ? dir_delete($v) : @unlink($v);
    }
    return @rmdir($dir);
}
/**
 * CURL请求
 * @param $url 请求url地址
 * @param $method 请求方法 get post
 * @param null $postfields post数据数组
 * @param array $headers 请求header信息
 * @param bool|false $debug  调试开启 默认false
 * @return mixed
 */
function httpRequest($url, $method, $postfields = null, $headers = array(), $debug = false) {
    $method = strtoupper($method);
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60); /* 在发起连接前等待的时间，如果设置为0，则无限等待 */
    curl_setopt($ci, CURLOPT_TIMEOUT, 7); /* 设置cURL允许执行的最长秒数 */
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
    switch ($method) {
        case "POST":
            curl_setopt($ci, CURLOPT_POST, true);
            if (!empty($postfields)) {
                $tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;
                curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
            }
            break;
        default:
            curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method); /* //设置请求方式 */
            break;
    }
    $ssl = preg_match('/^https:\/\//i',$url) ? TRUE : FALSE;
    curl_setopt($ci, CURLOPT_URL, $url);
    if($ssl){
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE); // 不从证书中检查SSL加密算法是否存在
    }
    //curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
    //curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
    curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ci, CURLINFO_HEADER_OUT, true);
    /*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
    $response = curl_exec($ci);
    $requestinfo = curl_getinfo($ci);
    $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    if ($debug) {
        echo "=====post data======\r\n";
        var_dump($postfields);
        echo "=====info===== \r\n";
        print_r($requestinfo);
        echo "=====response=====\r\n";
        print_r($response);
    }
    curl_close($ci);
    return $response;
    //return array($http_code, $response,$requestinfo);
}
/**
 * @param $arr
 * @param $key_name
 * @return array
 * 将数据库中查出的列表以指定的 id 作为数组的键名
 */
function convert_arr_key($arr, $key_name)
{
    $arr2 = array();
    foreach($arr as $key => $val){
        $arr2[$val[$key_name]] = $val;
    }
    return $arr2;
}
//查询IP地址
function getCity($ip = ''){
    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
    if(empty($res)){ return false; }
    $jsonMatches = array();
    preg_match('#\{.+?\}#', $res, $jsonMatches);
    if(!isset($jsonMatches[0])){ return false; }
    $json = json_decode($jsonMatches[0], true);
    if(isset($json['ret']) && $json['ret'] == 1){
        $json['ip'] = $ip;
        unset($json['ret']);
    }else{
        return false;
    }
    return $json;
}
//判断图片的类型从而设置图片路径
function imgUrl($img,$defaul=''){
    if($img){
        if(substr($img,0,4)=='http'){
            $imgUrl = $img;
        }else{
            $imgUrl = $img;
        }
    }else{
        if($defaul){
            $imgUrl = $defaul;
        }else{
            $imgUrl = '/static/guanli/images/tong.png';
        }

    }
    return $imgUrl;
}
/**
 * PHP格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}
/**
 * 判断当前访问的用户是  PC端  还是 手机端  返回true 为手机端  false 为PC 端
 *  是否移动端访问访问
 * @return boolean
 */
function isMobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;

    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile');
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            return true;
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}


function is_weixin() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    } return false;
}

function is_qq() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'QQ') !== false) {
        return true;
    } return false;
}
function is_alipay() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) {
        return true;
    } return false;
}

/**
 * 过滤数组元素前后空格 (支持多维数组)
 * @param $array 要过滤的数组
 * @return array|string
 */
function trim_array_element($array){
    if(!is_array($array))
        return trim($array);
    return array_map('trim_array_element',$array);
}
/**
 * @param $arr
 * @param $key_name
 * @return array
 * 将数据库中查出的列表以指定的 值作为数组的键名，并以另一个值作为键值
 */
function convert_arr_kv($arr,$key_name,$value){
    $arr2 = array();
    foreach($arr as $key => $val){
        $arr2[$val[$key_name]] = $val[$value];
    }
    return $arr2;
}
/**
 * 邮件发送
 * @param $to    接收人
 * @param string $subject   邮件标题
 * @param string $content   邮件内容(html模板渲染后的内容)
 * @throws Exception
 * @throws phpmailerException
 */
/**
function send_email($to,$subject='',$content=''){
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $arr = db('config')->where('inc_type','smtp')->select();
    $config = convert_arr_kv($arr,'name','value');

    $mail->CharSet  = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    //调试输出格式
    //$mail->Debugoutput = 'html';
    //smtp服务器
    $mail->Host = $config['smtp_server'];
    //端口 - likely to be 25, 465 or 587
    $mail->Port = $config['smtp_port'];

    if($mail->Port == '465') {
        $mail->SMTPSecure = 'ssl';
    }// 使用安全协议
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //发送邮箱
    $mail->Username = $config['smtp_user'];
    //密码
    $mail->Password = $config['smtp_pwd'];
    //Set who the message is to be sent from
    $mail->setFrom($config['smtp_user'],$config['email_id']);
    //回复地址
    //$mail->addReplyTo('replyto@example.com', 'First Last');
    //接收邮件方
    if(is_array($to)){
        foreach ($to as $v){
            $mail->addAddress($v);
        }
    }else{
        $mail->addAddress($to);
    }

    $mail->isHTML(true);// send as HTML
    //标题
    $mail->Subject = $subject;
    //HTML内容转换
    $mail->msgHTML($content);
    return $mail->send();
}
function safe_html($html){
    $elements = [
        'html'      =>  [],
        'body'      =>  [],
        'a'         =>  ['target', 'href', 'title', 'class', 'style'],
        'abbr'      =>  ['title', 'class', 'style'],
        'address'   =>  ['class', 'style'],
        'area'      =>  ['shape', 'coords', 'href', 'alt'],
        'article'   =>  [],
        'aside'     =>  [],
        'audio'     =>  ['autoplay', 'controls', 'loop', 'preload', 'src', 'class', 'style'],
        'b'         =>  ['class', 'style'],
        'bdi'       =>  ['dir'],
        'bdo'       =>  ['dir'],
        'big'       =>  [],
        'blockquote'=>  ['cite', 'class', 'style'],
        'br'        =>  [],
        'caption'   =>  ['class', 'style'],
        'center'    =>  [],
        'cite'      =>  [],
        'code'      =>  ['class', 'style'],
        'col'       =>  ['align', 'valign', 'span', 'width', 'class', 'style'],
        'colgroup'  =>  ['align', 'valign', 'span', 'width', 'class', 'style'],
        'dd'        =>  ['class', 'style'],
        'del'       =>  ['datetime'],
        'details'   =>  ['open'],
        'div'       =>  ['class', 'style'],
        'dl'        =>  ['class', 'style'],
        'dt'        =>  ['class', 'style'],
        'em'        =>  ['class', 'style'],
        'font'      =>  ['color', 'size', 'face'],
        'footer'    =>  [],
        'h1'        =>  ['class', 'style'],
        'h2'        =>  ['class', 'style'],
        'h3'        =>  ['class', 'style'],
        'h4'        =>  ['class', 'style'],
        'h5'        =>  ['class', 'style'],
        'h6'        =>  ['class', 'style'],
        'header'    =>  [],
        'hr'        =>  [],
        'i'         =>  ['class', 'style'],
        'img'       =>  ['src', 'alt', 'title', 'width', 'height', 'id', 'class'],
        'ins'       =>  ['datetime'],
        'li'        =>  ['class', 'style'],
        'mark'      =>  [],
        'nav'       =>  [],
        'ol'        =>  ['class', 'style'],
        'p'         =>  ['class', 'style'],
        'pre'       =>  ['class', 'style'],
        's'         =>  [],
        'section'   =>  [],
        'small'     =>  [],
        'span'      =>  ['class', 'style'],
        'sub'       =>  ['class', 'style'],
        'sup'       =>  ['class', 'style'],
        'strong'    =>  ['class', 'style'],
        'table'     =>  ['width', 'border', 'align', 'valign', 'class', 'style'],
        'tbody'     =>  ['align', 'valign', 'class', 'style'],
        'td'        =>  ['width', 'rowspan', 'colspan', 'align', 'valign', 'class', 'style'],
        'tfoot'     =>  ['align', 'valign', 'class', 'style'],
        'th'        =>  ['width', 'rowspan', 'colspan', 'align', 'valign', 'class', 'style'],
        'thead'     =>  ['align', 'valign', 'class', 'style'],
        'tr'        =>  ['rowspan', 'align', 'valign', 'class', 'style'],
        'tt'        =>  [],
        'u'         =>  [],
        'ul'        =>  ['class', 'style'],
        'video'     =>  ['autoplay', 'controls', 'loop', 'preload', 'src', 'height', 'width', 'class', 'style'],
        'embed'     =>  ['src', 'height','align', 'width', 'class', 'style','type','pluginspage','wmode','play','loop','menu','allowscriptaccess','allowfullscreen'],
        'source'    =>  ['src', 'type']
    ];
    $html = strip_tags($html,'<'.implode('><', array_keys($elements)).'>');
    $xml = new \DOMDocument();
    libxml_use_internal_errors(true);
    if (!strlen($html)){
        return '';
    }
    if ($xml->loadHTML('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . $html)){
        foreach ($xml->getElementsByTagName("*") as $element){
            if (!isset($elements[$element->tagName])){
                $element->parentNode->removeChild($element);
            }else{
                for ($k = $element->attributes->length - 1; $k >= 0; --$k) {
                    if (!in_array($element->attributes->item($k) -> nodeName, $elements[$element->tagName])){
                        $element->removeAttributeNode($element->attributes->item($k));
                    }elseif (in_array($element->attributes->item($k) -> nodeName, ['href','src','style','background','size'])) {
                        $_keywords = ['javascript:','javascript.:','vbscript:','vbscript.:',':expression'];
                        $find = false;
                        foreach ($_keywords as $a => $b) {
                            if (false !== strpos(strtolower($element->attributes->item($k)->nodeValue),$b)) {
                                $find = true;
                            }
                        }
                        if ($find) {
                            $element->removeAttributeNode($element->attributes->item($k));
                        }
                    }
                }
            }
        }
    }
    $html = substr($xml->saveHTML($xml->documentElement), 12, -14);
    $html = strip_tags($html,'<'.implode('><', array_keys($elements)).'>');
    return $html;
}


/**
 * redis链接
 *
 */
function redis(){
    $redis = new \Redis();
    $redis->connect('127.0.0.1', 6379);
    $redis->select(7);
    //echo $redis->get('a');
    return $redis;
}

/**
 * [生成唯一字符串]
 * @ 0-存数字字符串；1-小写字母字符串；2-大写字母字符串；3-大小写数字字符串；4-字符；
 *   5-数字，小写，大写，字符混合
 * @param  integer $type   [字符串的类型]
 * @param  integer $length [字符串的长度]
 * @param  integer $time   [是否带时间1-带，0-不带]
 * @return [string]  $str    [返回唯一字符串]
 */
function randSole($type = 0,$length = 10,$time=0){
    $str = $time == 0 ? '':date('YmdHis',time());
    switch ($type) {
        case 0:
            for((int)$i = 0;$i <= $length;$i++){
                if(mb_strlen($str) == $length){
                    $str = $str;
                }else{
                    $str .= rand(0,9);
                }
            }
            break;
        case 1:
            for((int)$i = 0;$i <= $length;$i++){
                if(mb_strlen($str) == $length){
                    $str = $str;
                }else{
                    $rand = "qwertyuioplkjhgfdsazxcvbnm";
                    $str .= $rand{mt_rand(0,26)};
                }
            }
            break;
        case 2:
            for((int)$i = 0;$i <= $length;$i++){
                if(mb_strlen($str) == $length){
                    $str = $str;
                }else{
                    $rand = "QWERTYUIOPLKJHGFDSAZXCVBNM";
                    $str .= $rand{mt_rand(0,26)};
                }
            }
            break;
        case 3:
            for((int)$i = 0;$i <= $length;$i++){
                if(mb_strlen($str) == $length){
                    $str = $str;
                }else{
                    $rand = "123456789qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM";
                    $str .= $rand{mt_rand(0,35)};
                }
            }
            break;
        case 4:
            for((int)$i = 0;$i <= $length;$i++){
                if(mb_strlen($str) == $length){
                    $str = $str;
                }else{
                    $rand = "!@#$%^&*()_+=-~`";
                    $str .= $rand{mt_rand(0,17)};
                }
            }
            break;
        case 5:
            for((int)$i = 0;$i <= $length;$i++){
                if(mb_strlen($str) == $length){
                    $str = $str;
                }else{
                    $rand = "123456789qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM!@#$%^&*()_+=-~`";
                    $str .= $rand{mt_rand(0,52)};
                }
            }
            break;
    }
    return $str;
}

/**
 * des-cbc加密
 * @param string  $data 要被加密的数据
 * @param string  $key 加密使用的key
 */
function des_cbc_encrypt($data, $key){
    $ivArray=array(0x12, 0x34, 0x56, 0x78, 0x90, 0xAB, 0xCD, 0xEF);
    $iv=null;
    foreach ($ivArray as $element){
        $iv.=CHR($element);
    }
    return openssl_encrypt ($data, 'des-cbc', $key, 0, $iv);
}

/**
 * des-cbc解密
 * @param string  $data 加密数据
 * @param string  $key 加密使用的key
 */
function des_cbc_decrypt($data, $key){
    $ivArray=array(0x12, 0x34, 0x56, 0x78, 0x90, 0xAB, 0xCD, 0xEF);
    $iv=null;
    foreach ($ivArray as $element){
        $iv.=CHR($element);
    }
    return openssl_decrypt ($data, 'des-cbc', $key, 0, $iv);
}

/**
 * 生成token
 * param $token
 */
function create_token($user_id){
    //.token
    $firebase = new firebase(config('app.jwt_setting.key'));
    $token = $firebase->createToken(['id'=>$user_id]);
    $redis = redis();
    $redis->hSet('token', $user_id, $token);
    return $token;
}

/**
 * 生成公众号openid的token
 * param $token
 */
function create_openid_token($wx_authorizer_id){
    //.token
    $firebase = new firebase(config('app.jwt_openid_setting.key'));
    $token = $firebase->createToken(['id'=>$wx_authorizer_id]);
    $redis = redis();
    $redis->hSet('open_token', $wx_authorizer_id, $token);
    return $token;
}

/**
 * 校验token,存在用户返uid,否则接口直接返回错误码
 * param $token
 * return ['code'=>1001,'uid'=>无效token];
 *        ['code'=>1002, 'msg'=>'登录过期'];
 */
function check_token(){
    $firebase = new firebase(config('app.jwt_setting.key'));
    $res = $firebase->validateTokens(config('app.jwt_setting.timeout'));
    //exit(json_encode($res));
    if ($res['code']==0) {
        //redis 储存的 token
        $redis = redis();
        $token_redis = $redis->hGet('token', $res['id']);
        if($res['token'] == $token_redis){
            $user = get_user($redis,$res['id']);
            $channel_ids = explode(',',$user['channel_ids']);
            if (empty($user['channel_ids'])||count($channel_ids)<3){
                common_json('请先选择频道',1009);
            }
            return ['uid'=>$res['id'],'userinfo'=>$user];
        }
        common_json('token无效',1001);

    }else{
        exit(json_encode($res));
    }
}

/**
 * 校验token，存在用户返uid,否则返回错误码
 * param $token
 * return ['uid'=>1];
 *        ['code'=>1001, 'msg'=>'token无效'];
 */
function return_check_token(){
    $firebase = new firebase(config('app.jwt_setting.key'));
    $res = $firebase->validateToken(config('app.jwt_setting.timeout'));
    //exit(json_encode($res));
    if ($res['code']==0) {
        //redis 储存的 token
        $redis = redis();
        $token_redis = $redis->hGet('token', $res['id']);
        if($res['token'] == $token_redis){
            return $res['id'];
        }
        return ['code'=>1001, 'msg'=>'token无效'];

    }else{
        return $res;
    }

}

/**
 * 获取用户信息
 * @param $redis redis链接
 * @param $user_id 用户ID
 * @param $field 字段
 * @return $user 用户信息
 */
function get_user($redis, $user_id, $field = array())
{
    //$redis->del('user_info:'.$user_id);
    $user_id = intval($user_id);
    if ($redis->hExists('user_info:' . $user_id, 'id')) {
        if (!empty($field)) {
            $user = $redis->hMget('user_info:' . $user_id, $field);
        } else {
            $user = $redis->hGetall('user_info:' . $user_id);
        }
    } else {
        $user = db('user')->where('id','=',$user_id)->find();
        if (!empty($user)) {
            $redis->hmset('user_info:'.$user_id, $user);
        }
        if (!empty($field)) {
            $user = $redis->hMget('user_info:' . $user_id, $field);
        }
    }
    return $user;
}


/*
 * @param $redis redis链接
 * @param $user_id 用户ID
 * @param $field 字段
 * @return $usermoney 用户钱包信息
 */
function get_user_money($redis,$user_id,$field = array())
{

    if ($redis->hExists('user_money:' . $user_id, 'user_id')) {
        if (!empty($field)) {
            $usermoney = $redis->hMget('user_money:' . $user_id, $field);
        } else {
            $usermoney = $redis->hGetall('user_money:' . $user_id);
        }
    } else {
        $usermoney = db('user_money')->where(array('user_id'=>$user_id))->find();
        //$usermoney = json_decode($usermoney,true);
        if (!empty($usermoney)) {
            $redis->hmset('user_money:' . $user_id, $usermoney);
        }
        if (!empty($field)) {
            $usermoney = $redis->hMget('user_money:' . $user_id, $field);
        }
    }
    return $usermoney;

}

/**
 * 接口json输出
 * @param  string  $msg  [msg返回的提示信息]
 * @param  integer $code  [code状态吗,0为成功,其余状态根据业务需求来返回]
 * @param  array   $data  [data为返回数据]
 * @param  string  $other [other其他说明]
 * @return [type]         [description]
 */
function common_json($msg = 'error',$code = 0,$data = '',$other = ''){
    $output = array();
    $output['msg'] = $msg;
    $output['code'] = $code;
    $output['data'] = $data;
    $output['other'] = $other;
    exit(json_encode($output));
}

/**
 * 生成流水号
 * @param string $sub;  HB:红包;            CZ:充值秀币;             VIP:vip充值;
 *                      LHB:领红包;         ZX:发布公开文章奖励;      AD:发布频道广告;         XT:系统调整秀币; MT发布会议;
 *                      YQ:邀请下级奖励;     PR:发布营销游戏口令红包;  GR:领取营销游戏口令红包；  ZD：推广置顶(发布采购或者合作);
 *                      RB;口令红包过期返还; TH:退还（视频违法）;   AC:二级代理商（服务商）激活码；   VC;vip激活码
 */
function serial_number($sub) {
    return $sub.date('YmdHis').substr(strval(microtime()),2,3);
}


/**
 * Notes：不同角色用户配置
 * User: zoe
 * Date: 2019/2/27
 * Time: 14:04
 * @param $redis
 * @param int $id 1-未认证用户；2-已认证用户；3-vip用户；4-一级代理；5-二级代理
 * @param string $field
 */
function user_setting($redis,$id = 1,$field=''){
    $key = 'user_setting:'.$id;
    //$redis->del($key);
    if (!$redis->exists($key))  {
        $data = Db::name('user_setting')->where('type','=', $id)->find();
        if (!empty($data)) {
            $redis->hMset($key, $data);
        }
        if (!empty($field)) {
            if (is_array($field)) {
                return $redis->hMget($key, $field);
            }else{
                return $redis->hGet($key, $field);
            }
        }
        return $data;
    }else{
        if (!empty($field)) {
            if (is_array($field)) {
                return $redis->hMget($key, $field);
            }else{
                return $redis->hGet($key, $field);
            }
        }else{
            return $redis->hGetall( $key );
        }
    }

}

/**
 * Notes：系统配置
 * User: zoe
 * Date: 2019/2/27
 * Time: 13:51
 * @param $redis
 * @param string $field
 */
function system_setting($redis,$field=''){
    $key = 'system_setting';
    //$redis->del($key);
    if (!$redis->exists($key))  {
        $data = Db::name('system_setting')->where('id', 1)->find();
        if (!empty($data)) {
            $redis->hMset($key, $data);
        }
        if (!empty($field)) {
            if (is_array($field)) {
                return $redis->hMget($key, $field);
            }else{
                return $redis->hGet($key, $field);
            }
        }
        return $data;
    }else{
        if (!empty($field)) {
            if (is_array($field)) {
                return $redis->hMget($key, $field);
            }else{
                return $redis->hGet($key, $field);
            }
        }else{
            return $redis->hGetall( $key );
        }
    }

}

/**
 * Notes：检查手机号
 * User: zoe
 * Date: 2019/2/27
 * Time: 16:05
 * @param $mobile
 * @return bool
 */
function check_mobile($mobile){
    if(preg_match('/1[345678]\d{9}$/',$mobile))
        return true;
    return false;
}

/**
 * 获取access_token
 *
 */
function getAccessToken($type=1){
    switch ($type){
        case '1': //会员端小程序
            $wxConf = config('miniprogram.1');
            break;
        case '2': //代理商小程序
            $wxConf = config('miniprogram.2');
            break;
        case '3': //企来秀微信公众号（服务号）
            $wxConf = config('wechat.1');
            break;
        case '4': //企来秀秀微信订阅号
            //$wxConf = Config::pull('subwechat');;
            break;
    }
    $wxApp = new Application($wxConf);
    $token = $wxApp->access_token;
    return $token->getToken();
}


/**
 * 日志
 * @param unknown $str
 *
 */
function logger($str,$name='',$new=0){
    if(empty($name)){
        $name = date('ymd');
    }else{
        $name = $name.date('ymd');
    }
    $pre = $new ? "\r\n" : '';
    $log = str_replace("\n","",$str)."\n";
    error_log($pre.'['.date('Y-m-d H:i:s',time()).']'.$log,3,Env::get('root_path').'logger'.DIRECTORY_SEPARATOR.$name.'.log');
}


/**
 * 获取配置，系统字典
 * @param int $pid ,一级id
 *
 */
function getDictionary($pid, $redis=''){
    $redis = $redis?:redis();
    if($redis->exists('dictionary:'.$pid)){
        return json_decode($redis->get('dictionary:'.$pid), true);
    }else{
        $data = db('system_dictionary')->field('id,name,icon')->where('pid',$pid)->order('sort asc')->select();
        if (empty($data)) exit(json(['code'=>1020, 'msg'=>'字典不存在']));

        $redis->set('dictionary:'.$pid, json_encode($data));
        return $data;
    }
}

/**
 * Notes：昵称去除emoji
 * User: zoe
 * Date: 2019/3/19
 * Time: 8:51
 * @param $str
 * @return mixed|string
 */
function filter_emoji($str)
{
    $str = preg_replace_callback( '/./u',
        function (array $match) {
            return strlen($match[0]) >= 4 ? '*' : $match[0];
        },
        $str);

    return $str;
}

/**
 * 添加访客记录
 * @param int $interviewee 被访问者， 文章广告等的拥有者
 * @param int $visitor 访问者, 一般是指当前用户
 * @param int $from 来源, 1植入广告文章 3找采购 4招聘 5找合作  7营销游戏  8名片 10资讯新闻 11频道广告 12战队 13植入广告
 *
 * @return int $affect, 影响的数据，-1被访问者已被删除
 */
function add_visitor_log($interviewee, $visitor, $from){
    if($interviewee == $visitor) return 0;//排除自己访问自己

    $redis = redis();
    $intervieweeinfo = get_user($redis, $interviewee, ['id','vip','wx_openid']);
    if(!$intervieweeinfo || !$intervieweeinfo['id']) return -1;


    $data = array(
        //'id' int(10) NOT NULL AUTO_INCREMENT,
        'user_id' => $interviewee,// int(10) NOT NULL COMMENT '用户id',
        'visitor_uid' => $visitor,  //int(10) NOT NULL DEFAULT '0' COMMENT '访客uid',
        'create_time' => time(),//int(11) NOT NULL COMMENT '访客时间',
        'ymd' => date('Ymd'),//int(11) DEFAULT NULL COMMENT '年月日，eg:20190415',
        'from' => $from,
    );
    //插入数据库
    $affect = db('user_visitor')->insert($data);
    //修改统计
    if(db('user_visitor_sta')->where('user_id', $interviewee)->count())
        db('user_visitor_sta')->where('user_id', $interviewee)->setInc("from{$from}");
    else
        db('user_visitor_sta')->insert(['user_id'=>$interviewee, "from{$from}"=>1]);

    //通知，小红点
    user_new_notice(3,$interviewee ,1);

    //是否模板消息通知
    $isTemplate = 0;
    //判断是否vip
    if($intervieweeinfo['vip'] == 1) $isTemplate = 1;

    //判断后台设置的全局， 访客追踪
    if($isTemplate == 1){
        $user_setting_is_trace = user_setting($redis, 3, 'is_trace');
        if($user_setting_is_trace != 1) $isTemplate = 0;
    }

    if($isTemplate == 1){
        //通知，消息模板，访客信息
        $visitorinfo = get_user($redis, $visitor, ['nickname']);
        if($intervieweeinfo['wx_openid']){
            $action = array(
                1 =>'对方查看了您植入广告的文章',     2=>'???找到???',           3=>'对方查看了您发布的找采购信息', 4=>'对方查看了您发布的招聘信息',
                5 =>'对方查看了您发布的找合作信息',   6=>'???访客追踪???',        7=>'对方查看了您发布的营销游戏',   8=>'对方查看了您的个人名片',
                9 =>'???推荐关系???',              10=>'对方查看了您发布的文章', 11=>'对方查看了您发布的频道广告',  12=>'对方查看了您创建的战队',
                13=>'对方查看了您植入的文章顶部广告',
            );
            $wx = new \app\home\controller\Wx();//\chooseTemplate();
            $wx_data = ['wx_openid'=>$intervieweeinfo['wx_openid'], 'nickname'=> $visitorinfo['nickname'], 'from_name' =>$action[$from], 'user_id'=>$visitor];
            $wx->chooseTemplate(1, $wx_data);
        }
    }

    return $affect;
}

/**
 * Notes：获取用户是否有未读内容
 * User: zoe
 * Date: 2019/4/18
 * Time: 17:59
 * @param int $type 1-系统消息；2-好友申请；3-访客追踪
 * @param $user_id 用户id
 * @param int $is_inc 0-查看是否增加；1-增加消息；-1-减少消息
 * @return string
 */
function user_new_notice($type=1,$user_id ,$is_inc=0){
    $redis = redis();
    $key = 'user_new_notice:'.$type;
    $new = 1;
    if (!$redis->hExists($key,$user_id)){
        $new = 0;
        switch ($type) {
            case '1':
                $count = db('user_message')->where([['user_id','=',$user_id],['is_read','=',0]])->count('id');
                break;
            case '2':
                $count = db('user_friend')->where([['friend_id','=',$user_id],['status','=',0]])->count('id');
                break;
            case '3':
                $count = 0;
                $new = 1;
                break;
        }
        $redis->hMset($key,[$user_id=>$count]);
    }
    $num = $redis->hGet($key,$user_id);
    if ($is_inc>0 && $new==1){
        $num = $redis->hIncrBy($key,$user_id,1);
    }elseif ($is_inc<0 && $num>0 && $new==1){
        if ($type==3){
            $num = 0;
            $redis->hMset($key,[$user_id=>$num]);
        }else{
            $num = $redis->hIncrBy($key,$user_id,-1);
        }
    }
    return $num;
}

/**
 * Notes：判断用户身份获取配置;1-未认证用户；2-已认证用户；3-vip用户；4-一级代理；5-二级代理
 * User: zoe
 * Date: 2019/5/17
 * Time: 11:24
 * @param int $role 用户信息里的role字段
 * @param int $vip 用户信息里的vip字段
 * @param int $is_auth 用户信息里的is_auth字段
 * @return array
 */
function user_role($redis,$role=0,$vip=0,$is_auth=0){
    if($role==1){
        $user_role = 4;
    }elseif ($role==2){
        $user_role = 5;
    }elseif($vip==1){
        $user_role = 3;
    }elseif ($is_auth==1){
        $user_role = 2;
    }else{
        $user_role = 1;
    }
    $set = user_setting($redis,$user_role);
    return ['user_role'=>$user_role,'setting'=>$set];
}

/**
 * Notes：获取激活码
 * User: zoe
 * Date: 2019/5/22
 * Time: 19:25
 * @param $type 1-代理商激活码；2-VIP激活码
 * @param $agent_id 代理商id
 * @return string
 */
function set_cdkey($type,$agent_id){
    $first = $type==1?'A':'V';
    $second = str_pad($agent_id,4,'0',STR_PAD_LEFT);
    $third = str_pad(rand(1,99999),5,'0',STR_PAD_LEFT);
    $cdkey = $first.$second.$third;
    return $cdkey;
}

/**
 * 生成代理商token
 * param $token
 */
function create_agent_token($agent_id){
    //5.token
    $firebase = new firebase(config('app.jwt_agent_setting.key'));
    $token = $firebase->createToken(['id'=>$agent_id]);
    $redis = redis();
    $redis->hSet('agent_token', $agent_id, $token);
    return $token;
}

/**
 * 校验token,存在代理商返agent_id,否则接口直接返回错误码
 * param $token
 * return ['code'=>1001,'msg'=>无效token];
 *        ['code'=>1002, 'msg'=>'登录过期'];
 */
function check_agent_token(){
    $firebase = new firebase(config('app.jwt_agent_setting.key'));
    $res = $firebase->validateToken(config('app.jwt_agent_setting.timeout'));
    if ($res['code']==0) {
        //redis 储存的 token
        $redis = redis();
        $token_redis = $redis->hGet('agent_token', $res['id']);
        if($res['token'] == $token_redis){
            return $res['id'];
        }
        common_json('token无效',1001);

    }else{
        exit(json_encode($res));
    }
}