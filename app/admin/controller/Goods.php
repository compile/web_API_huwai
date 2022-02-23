<?php

namespace app\admin\controller;
use app\admin\BaseController;
use app\admin\model\goodsGrade;
use app\admin\model\Test;
use think\facade\Db;
use think\facade\Request;

class Goods extends BaseController
{
    public function goodsList()//商品列表
    {
        $this->ifLogin();
        if (Request::isAjax()) {
            $table = str_replace("List",'',__FUNCTION__);
            $common = new \app\admin\controller\Common();
            $common->getList($table);
            exit();
        }
        return View();
    }


    public function goodsCate()//商品分类
    {
        $this->ifLogin();
        if (Request::isAjax()) {
            $table = str_replace("List",'',__FUNCTION__);
            $common = new \app\admin\controller\Common();
            $common->getList($table);
            exit();
        }
        return View();
    }

    public function get_goodsCate(){//取得商品分类json
        $this->ifLogin();
//        if (Request::isAjax()) {
            $list = Db::name('goods_cate')
                ->where('pid','=','0')
                ->field('id,name')
                ->order('create_time desc')
                ->select()
                ->toArray();

            foreach($list as $key => $value){
                $list2 = Db::name('goods_cate')
                    ->where('pid','=',$value['id'])
                    ->order('create_time desc')
                    ->select()
                    ->toArray();

                $cate[$key]['id']=$value['id'];
                $cate[$key]['name'] = $value['name'];
                if($list2){
                    foreach($list2 as $k=>$item){
                        $cate[$key]['children'][$k]['id'] = $item['id'];
                        $cate[$key]['children'][$k]['name'] = $item['name'];
                    }
                }
            }
            return json_encode($cate);
//        }
    }

    public function get_goodsBrand(){//取得商品品牌
        $this->ifLogin();
//        if (Request::isAjax()) {
        $list = Db::name('goods_brand')
          //  ->where('pid','=','0')
            ->field('id,name')
            ->order('create_time desc')
            ->select()
            ->toArray();
        return json_encode($list);
//        }
    }


    public function goodsBrand(){//品牌管理
        $this->ifLogin();
        if (Request::isAjax()) {
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $list = Db::name('goods_brand')
                ->order('create_time desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
            echo json_encode($result);
            exit();
        }
        return View();
    }

    public function seetest(){
        echo '{
    "msg": "",
    "code": 0,
    "data": [
        {"id":"1", "pId":"0", "name":"水果"},
        {"id":"2", "pId":"0", "name":"蔬菜"},
        {"id":"3", "pId":"2", "name":"土豆"},
        {"id":"4", "pId":"2", "name":"时蔬"},
        {"id":"101", "pId":"1", "name":"苹果"},
        {"id":"102", "pId":"1", "name":"香蕉"},
        {"id":"103", "pId":"1", "name":"梨"},
        {"id":"1021", "pId":"101", "name":"嘎拉"},
        {"id":"12", "pId":"101", "name":"桑萨"},
        {"id":"9", "pId":"102", "name":"千层蕉"},
        {"id":"12", "pId":"102", "name":"仙人蕉"},
        {"id":"41", "pId":"102", "name":"吕宋蕉"},
        {"id":"15", "pId":"101", "name":"红富士苹果"},
        {"id":"41", "pId":"101", "name":"红星苹果"}
    ],
    "count": 924,
    "is": true,
    "tip": "操作成功！"
}';
    }

    public function goodsgrade(){


        $result = new GoodsGrade();
        //$result->getList();
        $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $result->getList(), 'count' => count($result->getList()), 'rel' => 1];
        echo json_encode($result);


    }

    public function saveGradeValue(){//修改grade
        if($this->request->isPost()) {
            $common = new \app\admin\controller\Common();
            $data = Request::post();
            $id = Request::param('id') ?? '';
            $common->updateOne('goodsgrade',$data['data'],$id);//更新或者新增单个
        }
    }

    public function delGrade(){//修改grade
        //if($this->request->isPost()) {
        $data = Request::post();
        echo '<pre>';
        print_r($data);
        echo '</pre>';

    }



    public function addGoods(){
        return View();
    }

    public function addGoodsApi(){
        $result = input();
    /**
        {
            "name": "可乐鸡翅",
	"attach_title": "11",
	"keyword": "",
	"cat_ids1": "2",
	"goods_brand": "0",
	"imgurls": {
            "0": "https:\/\/laikeds.oss-cn-shenzhen.aliyuncs.com\/1\/1\/1604036181803.png",
		"center": ""
	},
	"cbj": ["7", "7"],
	"yj": ["9", "9"],
	"sj": ["29", "29"],
	"goods_unit": ["盒", "盒"],
	"stocks": ["90", "90"],
	"goods_attr": ["颜色", "属性"],
	"submit": "提交",
	"title": ["蓝色 安卓版", "黑色 安卓版"],
	"img": [" ", " "],
	"min_inventory": "144"
    }
     *  验证后就入库。 bb_goods      多属性则进   bb_goods_attrgoods
     * */




        Db::startTrans();
        try {
//            // 马云账户 -50
//            Db::name('user')
//                -> where('name', '马云')
//                -> save(['money' => Db::raw('money - 50')]);
            $goods['name'] = $result['name'];
            $goods['attached_name'] = $result['attach_title'];
            $goods['brand_id'] = $result['goods_brand'];
            $goods['yj'] = $result['yj']['0'];
            $goods['sj'] = $result['sj']['0'];
            $goods['cbj'] = $result['cbj']['0'];
            $goods['images'] = $result['img']['1'];
            $goods['create_time'] = time();
//            Db::name('goods')->insert($goods);
            $goodsId = Db::name('goods')->insertGetId($goods);
//
//            // 李嘉诚账户 +50
//            Db::name('user')
//                -> where('name', '李嘉诚')
//                -> save(['money' => Db::raw('money + 50')]);
            $num =  count($result['img']);

            for($i=0;$i<$num;$i++){
                $attrgoods[$i]['gid'] = $goodsId;
                $attrgoods[$i]['title'] = $result['title'][$i];
                $attrgoods[$i]['cbj'] = $result['cbj'][$i];
                $attrgoods[$i]['yj'] = $result['yj'][$i];
                $attrgoods[$i]['sj'] = $result['sj'][$i];
                $attrgoods[$i]['img'] = $result['img'][$i];
                $attrgoods[$i]['stocks'] = $result['stocks'][$i];
                $attrgoods[$i]['goods_unit'] = $result['goods_unit'][$i];
            }



            Db::name('goods_attrgoods')->insertAll($attrgoods);

            // 提交事务
            Db::commit();

            $result = ['code' => 0, 'msg' => '操作成功!', 'data' => $goods, 'count' => 0, 'rel' => 1];
            echo json_encode($result);
        }
            /*
            **
             * 执行不正常(执行失败)
             **/
        catch (\Exception $e) {##这里参数不能删除($e：错误信息)

            // 做一些业务逻辑(包括反馈提示等)
            // ...



            echo json_encode($e);
            // 回滚事务
            Db::rollback();
        }
    }
    public function goodsAttr(){//商品属性列表
        $this->ifLogin();
        if (Request::isAjax()) {
            $where['id'] = 0;
            $page = input('page', 1);
            $pageSize = input('limit', 10);
            $list = Db::name('goods_attribute')
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
    public function getGoodsUnit(){//商品单位
//        if (Request::isAjax()) {
            $list = Db::name('goods_unit')
                ->order('create_time desc')
                ->select()
                ->toArray();
            $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list, 'count' => count($list), 'rel' => 1];
            echo json_encode($result);
            exit();
//        }
    }


    public function fupload(){
            $test = '{"code":0,"msg":"success","data":{"list":[{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1604311091544.png","id":"6730","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/a5250580420223.jpg","id":"6727","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/a5250580420224.jpg","id":"6728","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/a5250580420220.png","id":"6724","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/a5250580420221.jpg","id":"6725","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/a5250580420222.jpg","id":"6726","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1604197239928.gif","id":"6723","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1604197217632.jpeg","id":"6722","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/1/1604036181803.png","id":"6721","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/2/1603950398379.jpeg","id":"6720","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1603850043725.jpeg","id":"6719","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1603781478145.png","id":"6717","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1603758718525.jpeg","id":"6716","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/160375871086.jpeg","id":"6715","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1603703705527.png","id":"6711","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/7/160369849594.jpeg","id":"6709","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1603170498397.png","id":"6701","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1602581132461.png","id":"6700","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1602581120718.png","id":"6699","selected":0},{"file_url":"https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1602560384170.jpeg","id":"6698","selected":0}],"count":"874"}}';
        echo $test;
    }

    public function list_group()
    {


       $test = '{ "code": 0, "data": [ { "id": "-1", "name": "全部", "is_default": 1 }, { "id": "2", "name": "icon", "is_default": "0" }, { "id": "42", "name": "未命名", "is_default": "0" }, { "id": "41", "name": "未命名", "is_default": "0" }, { "id": "40", "name": "未命名", "is_default": "0" }, { "id": "39", "name": "未命名", "is_default": "0" }, { "id": "38", "name": "未命名", "is_default": "0" }, { "id": "37", "name": "未命名", "is_default": "0" }, { "id": "36", "name": "未命名", "is_default": "0" }, { "id": "35", "name": "未命名", "is_default": "0" }, { "id": "34", "name": "未命名", "is_default": "0" }, { "id": "33", "name": "未命名", "is_default": "0" }, { "id": "32", "name": "未命名", "is_default": "0" }, { "id": "10", "name": "商品图片", "is_default": "0" }, { "id": "43", "name": "未命名", "is_default": "0" } ] }';
        echo $test;
    }


    public function getAttribute(){
        $test = '{ "attribute": [ { "id": "1", "name": "颜色", "status": false, "children": [ { "id": "2", "name": "蓝色", "status": false }, { "id": "3", "name": "黑色", "status": false }, { "id": "4", "name": "红色", "status": false }, { "id": "5", "name": "黄色", "status": false }, { "id": "6", "name": "粉色", "status": false }, { "id": "7", "name": "天蓝", "status": false }, { "id": "119", "name": "天蓝色", "status": false }, { "id": "120", "name": "棕色", "status": false }, { "id": "121", "name": "灰色", "status": false }, { "id": "124", "name": "白色", "status": false }, { "id": "129", "name": "珊瑚色玫瑰豆沙506", "status": false }, { "id": "160", "name": "深蓝色", "status": false }, { "id": "241", "name": "50", "status": false }, { "id": "291", "name": "青灰色", "status": false }, { "id": "295", "name": "银灰色", "status": false }, { "id": "317", "name": "【新品】16英寸 九代i7 16 1T灰", "status": false }, { "id": "318", "name": "【新品】16英寸 九代i7 16 256灰", "status": false } ] }, { "id": "8", "name": "尺码", "status": true, "children": [ { "id": "9", "name": "M", "status": false }, { "id": "10", "name": "L", "status": true }, { "id": "11", "name": "XL", "status": false }, { "id": "12", "name": "XXL", "status": false }, { "id": "118", "name": "S", "status": false }, { "id": "122", "name": "36", "status": false }, { "id": "123", "name": "37", "status": false }, { "id": "146", "name": "XS", "status": false }, { "id": "147", "name": "均码", "status": false }, { "id": "168", "name": "DF ", "status": false }, { "id": "169", "name": "DF ", "status": false }, { "id": "246", "name": "1", "status": false }, { "id": "247", "name": "1", "status": false }, { "id": "452", "name": "3XL", "status": false }, { "id": "455", "name": "2XL", "status": false }, { "id": "457", "name": "4XL", "status": false }, { "id": "479", "name": "S【90斤以下】", "status": false }, { "id": "481", "name": "XL【100-120斤】", "status": false }, { "id": "482", "name": "L【100-110斤】", "status": false }, { "id": "483", "name": "M【90-100斤】", "status": false }, { "id": "507", "name": "34", "status": false }, { "id": "509", "name": "38", "status": false }, { "id": "510", "name": "35", "status": false }, { "id": "511", "name": "39", "status": false }, { "id": "512", "name": "33", "status": false }, { "id": "514", "name": "42", "status": false }, { "id": "516", "name": "原板材质，穿不发黄", "status": false }, { "id": "518", "name": "40男款", "status": false }, { "id": "520", "name": "39男款", "status": false }, { "id": "522", "name": "标准码平时穿多大就拍多大", "status": false }, { "id": "523", "name": "升级版本，秀气版型显脚小", "status": false }, { "id": "525", "name": "40", "status": false }, { "id": "527", "name": "里外纯皮材质保真假一赔十", "status": false }, { "id": "528", "name": "香港买版原Y开模", "status": false }, { "id": "530", "name": "秋季新升级版更舒适柔软", "status": false }, { "id": "531", "name": "43", "status": false }, { "id": "532", "name": "41", "status": false }, { "id": "590", "name": "大码L", "status": false }, { "id": "592", "name": "大码XXXL", "status": false }, { "id": "593", "name": "大码XL", "status": false }, { "id": "594", "name": "大码XXL", "status": false } ] }, { "id": "16", "name": "默认1", "status": false, "children": [] }, { "id": "19", "name": "默认", "status": false, "children": [ { "id": "20", "name": "默认", "status": false }, { "id": "538", "name": "大小", "status": false } ] }, { "id": "126", "name": "数量", "status": false, "children": [ { "id": "127", "name": "2000张", "status": false }, { "id": "128", "name": "3000张", "status": false }, { "id": "300", "name": "1", "status": false }, { "id": "303", "name": "2", "status": false } ] }, { "id": "131", "name": "种类", "status": false, "children": [] }, { "id": "141", "name": "属性", "status": false, "children": [ { "id": "142", "name": "安卓版", "status": false }, { "id": "143", "name": "苹果版", "status": false } ] }, { "id": "144", "name": "颜色分类", "status": false, "children": [ { "id": "145", "name": "花色", "status": false }, { "id": "148", "name": "图片色", "status": false }, { "id": "162", "name": "湖蓝色", "status": false }, { "id": "170", "name": "红色", "status": false }, { "id": "171", "name": "紫色预定", "status": false }, { "id": "172", "name": "深灰色预定", "status": false }, { "id": "173", "name": "浅紫色预订", "status": false }, { "id": "174", "name": "薄荷绿", "status": false }, { "id": "175", "name": "墨绿色", "status": false }, { "id": "176", "name": "紫色", "status": false }, { "id": "177", "name": "深咖啡", "status": false }, { "id": "178", "name": "米白色预定", "status": false }, { "id": "179", "name": "驼色预定", "status": false }, { "id": "180", "name": "浅灰色预定", "status": false }, { "id": "181", "name": "宝蓝色预定", "status": false }, { "id": "182", "name": "粉红色", "status": false }, { "id": "183", "name": "藏青色", "status": false }, { "id": "184", "name": "黑色预定", "status": false }, { "id": "185", "name": "黑色", "status": false }, { "id": "186", "name": "深灰色", "status": false }, { "id": "187", "name": "薄荷绿预定", "status": false }, { "id": "188", "name": "墨绿色预定", "status": false }, { "id": "189", "name": "驼色", "status": false }, { "id": "190", "name": "米白色", "status": false }, { "id": "191", "name": "焦糖色", "status": false }, { "id": "192", "name": "浅紫色", "status": false }, { "id": "193", "name": "焦糖色预定", "status": false }, { "id": "194", "name": "宝蓝色", "status": false }, { "id": "195", "name": "浅灰色", "status": false }, { "id": "196", "name": "灰蓝色预定", "status": false }, { "id": "197", "name": "灰蓝色", "status": false }, { "id": "202", "name": "JB012 Emerson埃墨森", "status": false }, { "id": "205", "name": "JB007 Elena 埃琳娜", "status": false }, { "id": "207", "name": "JB008 Lowell 罗威尔", "status": false }, { "id": "208", "name": "JB004 Riddle 里德尔", "status": false }, { "id": "210", "name": "JB013 橙", "status": false }, { "id": "211", "name": "JB001 Sassoon 沙逊", "status": false }, { "id": "212", "name": "JB006 Britney 布兰妮", "status": false }, { "id": "213", "name": "JB009 Victor 维克多", "status": false }, { "id": "214", "name": "JB003 Milton 米尔顿", "status": false }, { "id": "215", "name": "JB005 Wendy 温蒂", "status": false }, { "id": "249", "name": "高档 霸气豪华手提皮盒10支装", "status": false }, { "id": "250", "name": "限量 任选一只口红＋爆款气垫", "status": false }, { "id": "251", "name": "YSL4支＋TF2支＋迪2支＋香2支", "status": false }, { "id": "252", "name": "藕荷色", "status": false }, { "id": "253", "name": "紫罗兰", "status": false }, { "id": "254", "name": "粉色", "status": false }, { "id": "255", "name": "深紫色", "status": false }, { "id": "256", "name": "姜黄色", "status": false }, { "id": "257", "name": "新品大气一朵独秀（夜光花）1支", "status": false }, { "id": "258", "name": "高贵黑丝绒银丝永生花＋纯银项链", "status": false }, { "id": "259", "name": "新品 高档炫酷金属皮盒 4支装", "status": false }, { "id": "260", "name": "柠檬黄", "status": false }, { "id": "261", "name": "明黄色", "status": false }, { "id": "262", "name": "栗色", "status": false }, { "id": "263", "name": "透明", "status": false }, { "id": "264", "name": "高档 限量65朵玫瑰 四大品牌", "status": false }, { "id": "265", "name": "限量升级版双重惊喜高档手提皮盒", "status": false }, { "id": "266", "name": "荧光黄", "status": false }, { "id": "267", "name": "金色", "status": false }, { "id": "268", "name": "16玫瑰最深的爱送最爱的你1支装", "status": false }, { "id": "269", "name": "高档限量升级版双重惊喜65朵玫瑰", "status": false }, { "id": "270", "name": "翠绿色", "status": false }, { "id": "271", "name": "新品 9朵玫瑰双重惊喜音乐盒1支", "status": false }, { "id": "272", "name": "YSL12阿玛尼口红 迪奥999羊皮307", "status": false }, { "id": "273", "name": "限量爆款12色眼影+口红2支＋气垫", "status": false }, { "id": "274", "name": "高档 霸气豪华手提皮盒 6支装", "status": false }, { "id": "275", "name": "36朵玫瑰 我的爱只留给你 4支装", "status": false }, { "id": "276", "name": "YSL 12＋阿玛尼口红＋纪梵希305", "status": false }, { "id": "277", "name": "高档 霸气豪华手提皮盒8支装", "status": false }, { "id": "278", "name": "卡其色", "status": false }, { "id": "279", "name": "深卡其布色", "status": false }, { "id": "280", "name": "桔色", "status": false }, { "id": "281", "name": "16玫瑰最深的爱送最爱的你3支装", "status": false }, { "id": "282", "name": "西瓜红", "status": false }, { "id": "283", "name": "一心一意只爱你勿忘我真干花 1支", "status": false }, { "id": "284", "name": "36朵玫瑰 我的爱只留给你 6支装", "status": false }, { "id": "285", "name": "新品大气一朵独秀（只有你）1支", "status": false }, { "id": "286", "name": "酒红色", "status": false }, { "id": "287", "name": "高档 霸气豪华手提皮盒12支装", "status": false }, { "id": "288", "name": "限量升级版双重惊喜65朵玫瑰高档", "status": false }, { "id": "289", "name": "大红色", "status": false }, { "id": "290", "name": "高档限量升级版双重惊喜手提皮盒", "status": false }, { "id": "298", "name": "黄色", "status": false }, { "id": "299", "name": "蓝色", "status": false }, { "id": "326", "name": "保湿款-护发素400ml", "status": false }, { "id": "329", "name": "3分钟奇迹发膜236ml", "status": false }, { "id": "330", "name": "蓬松款-护发素", "status": false }, { "id": "332", "name": "保湿款-洗发水360ml", "status": false }, { "id": "333", "name": "新款蓬松-洗发水360ML", "status": false }, { "id": "384", "name": "蜜糖色四门鞋柜", "status": false }, { "id": "385", "name": "浅胡桃换鞋凳", "status": false }, { "id": "386", "name": "板栗色两门鞋柜", "status": false }, { "id": "387", "name": "绿色", "status": false }, { "id": "388", "name": "军绿色", "status": false }, { "id": "389", "name": "浅胡桃四门鞋柜", "status": false }, { "id": "390", "name": "板栗色换鞋凳", "status": false }, { "id": "391", "name": "板栗色四门鞋柜+换鞋凳", "status": false }, { "id": "392", "name": "原木色四门鞋柜", "status": false }, { "id": "393", "name": "白色三门鞋柜", "status": false }, { "id": "394", "name": "浅绿色", "status": false }, { "id": "395", "name": "白色两门鞋柜", "status": false }, { "id": "396", "name": "原木色四门鞋柜+换鞋凳", "status": false }, { "id": "397", "name": "原木色三门鞋柜", "status": false }, { "id": "398", "name": "浅胡桃四门鞋柜+换鞋凳", "status": false }, { "id": "399", "name": "白色三门鞋柜+换鞋凳", "status": false }, { "id": "400", "name": "板栗色四门鞋柜", "status": false }, { "id": "401", "name": "板栗色三门鞋柜", "status": false }, { "id": "402", "name": "白色四门鞋柜", "status": false }, { "id": "403", "name": "浅胡桃三门鞋柜", "status": false }, { "id": "404", "name": "原木色两门鞋柜", "status": false }, { "id": "405", "name": "板栗色三门鞋柜+换鞋凳", "status": false }, { "id": "406", "name": "浅胡桃三门鞋柜+换鞋凳", "status": false }, { "id": "407", "name": "浅胡桃两门鞋柜", "status": false }, { "id": "408", "name": "原木色换鞋凳", "status": false }, { "id": "409", "name": "原木色三门鞋柜+换鞋凳", "status": false }, { "id": "435", "name": "米黄色【直径12cm实木底座】彩装", "status": false }, { "id": "436", "name": "米黄色【直径12cm实木底座】普装", "status": false }, { "id": "437", "name": "紫蓝粉【直径20cm实木底座】", "status": false }, { "id": "438", "name": "蓝橘黄【直径20cm实木底座】", "status": false }, { "id": "439", "name": "高贵紫【直径20cm实木底座】", "status": false }, { "id": "440", "name": "麻本色【直径20cm实木底座】", "status": false }, { "id": "441", "name": "浪漫粉【直径20cm实木底座】", "status": false }, { "id": "442", "name": "典雅白【直径20cm实木底座】", "status": false }, { "id": "443", "name": "麻本色【直径12cm实木底座】彩装", "status": false }, { "id": "444", "name": "天空蓝【直径20cm实木底座】", "status": false }, { "id": "445", "name": "天蓝色【直径12cm实木底座】彩装", "status": false }, { "id": "446", "name": "米黄色【直径20cm实木底座】", "status": false }, { "id": "447", "name": "麻本色【直径12cm实木底座】普装", "status": false }, { "id": "448", "name": "天蓝色【直径12cm实木底座】普装", "status": false }, { "id": "453", "name": "9328 蓝色", "status": false }, { "id": "454", "name": "9534 香杏", "status": false }, { "id": "456", "name": "9326 红色", "status": false }, { "id": "458", "name": "9536 蓝色", "status": false }, { "id": "459", "name": "9096 红凤", "status": false }, { "id": "460", "name": "9535 蓝桔", "status": false }, { "id": "461", "name": "9326 元宝蓝", "status": false }, { "id": "462", "name": "9539 黑色", "status": false }, { "id": "463", "name": "9328 绿色", "status": false }, { "id": "464", "name": "9328 黑色", "status": false }, { "id": "465", "name": "9328 紫红色", "status": false }, { "id": "466", "name": "9328 卡其色", "status": false }, { "id": "467", "name": "9328 亮灰", "status": false }, { "id": "468", "name": "8096 蓝色", "status": false }, { "id": "469", "name": "9096 金丝兰", "status": false }, { "id": "470", "name": "9326 白色", "status": false }, { "id": "471", "name": "9536 灰色", "status": false }, { "id": "472", "name": "9539 杏色", "status": false }, { "id": "473", "name": "9534 蓝桔", "status": false }, { "id": "474", "name": "9328 杏色", "status": false }, { "id": "475", "name": "9326 蓝色", "status": false }, { "id": "476", "name": "9328 荧光粉", "status": false }, { "id": "477", "name": "9535 杏黄", "status": false }, { "id": "478", "name": "9328 酒红色", "status": false }, { "id": "480", "name": "杏色", "status": false }, { "id": "484", "name": "all black娃娃版【48H】", "status": false }, { "id": "485", "name": "巴洛克收腰版（短款）【现】", "status": false }, { "id": "486", "name": "巴洛克收腰版（长款）【现】", "status": false }, { "id": "487", "name": "巴洛克吊带裙【48H】", "status": false }, { "id": "488", "name": "人鱼姬粉金吊带裙【48H】", "status": false }, { "id": "489", "name": "all black收腰版（短款）【48H】", "status": false }, { "id": "490", "name": "巴洛克娃娃版【48H】", "status": false }, { "id": "491", "name": "蓝风铃吊带裙【48H】", "status": false }, { "id": "492", "name": "人鱼姬粉金收腰版（短款）【48H", "status": false }, { "id": "493", "name": "人鱼姬粉金娃娃版【48H】", "status": false }, { "id": "494", "name": "人鱼姬粉金收腰版（长款）【48H", "status": false }, { "id": "495", "name": "all black吊带裙【48H】", "status": false }, { "id": "506", "name": "Energy Noir 浆果色唇膏笔 现货", "status": false }, { "id": "508", "name": "橘色", "status": false }, { "id": "513", "name": "牛皮黑尾", "status": false }, { "id": "515", "name": "银色尾", "status": false }, { "id": "517", "name": "粉色尾", "status": false }, { "id": "519", "name": "全白色", "status": false }, { "id": "521", "name": "金色尾", "status": false }, { "id": "524", "name": "反光款", "status": false }, { "id": "526", "name": "彩虹尾", "status": false }, { "id": "529", "name": "磨砂黑尾", "status": false }, { "id": "591", "name": "乳白色", "status": false }, { "id": "595", "name": "乳白色预售", "status": false }, { "id": "638", "name": "双门119L金色 冷藏+冷冻", "status": false }, { "id": "639", "name": "三门136L银色 冷藏+冷冻+软冷冻", "status": false }, { "id": "640", "name": "三门156L银色 冷藏+冷冻+软冷冻", "status": false }, { "id": "641", "name": "双门119L银色 （抗菌款）", "status": false }, { "id": "642", "name": "单门65L 白色 单冷藏", "status": false }, { "id": "643", "name": "双门119L银色 冷藏+冷冻", "status": false }, { "id": "644", "name": "单门65L 橙色 单冷藏", "status": false }, { "id": "645", "name": "双门119L橙色 冷藏+冷冻", "status": false }, { "id": "646", "name": "单门65L 蓝色 单冷藏", "status": false }, { "id": "647", "name": "双门119L蓝色 冷藏+冷冻", "status": false }, { "id": "648", "name": "双门126L银色（抗菌款）", "status": false }, { "id": "649", "name": "双门126L银色 冷藏+冷冻", "status": false }, { "id": "650", "name": "双门126L蓝色 冷藏+冷冻", "status": false }, { "id": "651", "name": "双门126L金色 冷藏+冷冻", "status": false }, { "id": "652", "name": "100只装店长推荐爆款", "status": false }, { "id": "653", "name": "50只装", "status": false }, { "id": "654", "name": "500只装", "status": false }, { "id": "655", "name": "200只装店长推荐爆款", "status": false }, { "id": "657", "name": "原木色（40cm高加厚床+床垫）", "status": false }, { "id": "661", "name": "新款原木床+抽屉(加厚)", "status": false }, { "id": "663", "name": "原木色（40cm加厚床+双抽+床垫）", "status": false }, { "id": "665", "name": "新款环保清漆床+抽屉(加厚)", "status": false }, { "id": "666", "name": "原木色（40cm高加厚床+双抽）", "status": false }, { "id": "667", "name": "新款原木床+抽屉+床垫(加厚)", "status": false }, { "id": "668", "name": "原木色（30cm高加厚床）", "status": false }, { "id": "670", "name": "新款环保清漆裸床(加厚)", "status": false }, { "id": "671", "name": "原木色（30cm高加厚床+床垫）", "status": false }, { "id": "672", "name": "原木色（40cm高加厚床）", "status": false }, { "id": "673", "name": "新款环保清漆床+抽屉+床垫(加厚)", "status": false }, { "id": "674", "name": "新款环保清漆床+床垫(加厚)", "status": false }, { "id": "675", "name": "新款原木裸床（加厚）", "status": false }, { "id": "676", "name": "新款环保白漆床+抽屉+床垫(加厚)", "status": false }, { "id": "677", "name": "原木色（30cm加厚床+双抽+床垫）", "status": false }, { "id": "678", "name": "新款环保白漆裸床(加厚)", "status": false }, { "id": "679", "name": "新款原木床+床垫(加厚)", "status": false }, { "id": "680", "name": "新款环保白漆床+床垫(加厚)", "status": false }, { "id": "681", "name": "新款环保白漆床+抽屉(加厚)", "status": false }, { "id": "682", "name": "原木色（30cm高加厚床+双抽）", "status": false } ] }, { "id": "151", "name": "鞋码", "status": false, "children": [ { "id": "152", "name": "42", "status": false }, { "id": "154", "name": "43", "status": false }, { "id": "155", "name": "44", "status": false }, { "id": "156", "name": "45", "status": false }, { "id": "157", "name": "46", "status": false }, { "id": "158", "name": "47", "status": false }, { "id": "159", "name": "41", "status": false } ] }, { "id": "163", "name": "计价单位", "status": false, "children": [ { "id": "243", "name": "件", "status": false } ] }, { "id": "165", "name": "DFD ", "status": false, "children": [ { "id": "166", "name": "D", "status": false }, { "id": "167", "name": "D", "status": false } ] }, { "id": "200", "name": "款式", "status": false, "children": [ { "id": "201", "name": "床笠款", "status": false }, { "id": "209", "name": "床单款", "status": false }, { "id": "216", "name": "2020", "status": false } ] }, { "id": "203", "name": "适用床尺寸", "status": false, "children": [ { "id": "204", "name": "M:四件套（适合被芯是200x230）", "status": false }, { "id": "206", "name": "L:四件套（适合被芯是220x240）", "status": false } ] }, { "id": "217", "name": "硬盘大小", "status": false, "children": [ { "id": "218", "name": "256G", "status": false }, { "id": "225", "name": "500G", "status": false }, { "id": "226", "name": "1T", "status": false }, { "id": "238", "name": "1024", "status": false } ] }, { "id": "219", "name": "内存大小", "status": false, "children": [ { "id": "220", "name": "8G@####", "status": false }, { "id": "223", "name": "16G", "status": false }, { "id": "224", "name": "32G", "status": false }, { "id": "237", "name": "256", "status": false } ] }, { "id": "231", "name": "12", "status": false, "children": [ { "id": "232", "name": "12", "status": false }, { "id": "233", "name": "11", "status": false } ] }, { "id": "293", "name": "LKT_KW_1", "status": false, "children": [] }, { "id": "294", "name": "口味", "status": false, "children": [ { "id": "338", "name": "麻辣", "status": false }, { "id": "339", "name": "香辣", "status": false }, { "id": "496", "name": "大刀肉250g*5袋【约175个大份】", "status": false }, { "id": "497", "name": "大刀肉250g*6袋【约210个囤货】", "status": false }, { "id": "498", "name": "大刀肉250g*3袋【约105个划算】", "status": false }, { "id": "499", "name": "大刀肉132g*1袋【新品尝鲜】", "status": false }, { "id": "500", "name": "大刀肉250g*4袋【约140个推荐】", "status": false }, { "id": "501", "name": "大刀肉250g*1袋【约35个尝鲜】", "status": false }, { "id": "502", "name": "大刀肉250g*2袋【约70个人气】", "status": false } ] }, { "id": "296", "name": "规格", "status": false, "children": [ { "id": "297", "name": "木质", "status": false }, { "id": "301", "name": "1", "status": false }, { "id": "302", "name": "2", "status": false }, { "id": "503", "name": "50ml", "status": false }, { "id": "624", "name": "5片", "status": false } ] }, { "id": "304", "name": "机身颜色", "status": false, "children": [ { "id": "305", "name": "黑色", "status": false }, { "id": "312", "name": "白色", "status": false }, { "id": "596", "name": "iphone8 红色 4.7寸", "status": false }, { "id": "597", "name": "iphone8 白色 4.7寸", "status": false }, { "id": "599", "name": "iphone8 金色 4.7寸", "status": false }, { "id": "600", "name": "iphone8 黑色 4.7寸", "status": false }, { "id": "602", "name": "苹果 5.8寸【白色】", "status": false }, { "id": "603", "name": "苹果 6.1寸【红色】", "status": false }, { "id": "604", "name": "苹果 6.1寸【珊瑚色】", "status": false }, { "id": "605", "name": "苹果 6.1寸【黄色】", "status": false }, { "id": "607", "name": "苹果xs max【有锁预定 】", "status": false }, { "id": "608", "name": "苹果 5.8寸【金色】", "status": false }, { "id": "609", "name": "苹果 6.1寸【黑色】", "status": false }, { "id": "610", "name": "苹果 6.1寸【白色】", "status": false }, { "id": "611", "name": "苹果xs max 6.5寸【黑色】", "status": false }, { "id": "612", "name": "苹果xs max 6.5寸【金色】", "status": false }, { "id": "613", "name": "苹果 6.1寸【蓝色】", "status": false }, { "id": "614", "name": "苹果xs max 6.5寸【白色】", "status": false }, { "id": "615", "name": "苹果 5.8寸【黑色】", "status": false }, { "id": "616", "name": "iPhone 11 黄色 6.1英寸", "status": false }, { "id": "618", "name": "iPhone 11 红色 6.1英寸", "status": false }, { "id": "619", "name": "iPhone 11 绿色 6.1英寸", "status": false }, { "id": "620", "name": "iPhone 11 黑色 6.1英寸", "status": false }, { "id": "621", "name": "iPhone 11 紫色 6.1英寸", "status": false }, { "id": "622", "name": "iPhone 11 红色（有锁单机）", "status": false }, { "id": "623", "name": "iPhone 11 白色 6.1英寸", "status": false } ] }, { "id": "306", "name": "套餐类型", "status": false, "children": [ { "id": "307", "name": "官方标配", "status": false }, { "id": "598", "name": "套餐一", "status": false }, { "id": "617", "name": "套餐二", "status": false } ] }, { "id": "308", "name": "存储容量", "status": false, "children": [ { "id": "309", "name": "128GB", "status": false }, { "id": "313", "name": "64GB", "status": false }, { "id": "601", "name": "256GB", "status": false }, { "id": "606", "name": "512GB", "status": false } ] }, { "id": "310", "name": "版本类型", "status": false, "children": [ { "id": "311", "name": "中国大陆", "status": false } ] }, { "id": "321", "name": "看看这", "status": false, "children": [ { "id": "322", "name": "可可", "status": false } ] }, { "id": "323", "name": "主要颜色", "status": false, "children": [ { "id": "324", "name": "玉米奶杏", "status": false }, { "id": "325", "name": "玉米奶杏下批预售", "status": false } ] }, { "id": "327", "name": "化妆品净含量", "status": false, "children": [ { "id": "328", "name": "400mL", "status": false }, { "id": "331", "name": "其他/other", "status": false } ] }, { "id": "368", "name": "34", "status": false, "children": [] }, { "id": "372", "name": "秒杀", "status": false, "children": [ { "id": "373", "name": "秒杀", "status": false } ] }, { "id": "374", "name": "2", "status": false, "children": [ { "id": "375", "name": "2", "status": false }, { "id": "378", "name": "1", "status": false } ] }, { "id": "376", "name": "32", "status": false, "children": [ { "id": "377", "name": "2", "status": false } ] }, { "id": "379", "name": "222", "status": false, "children": [ { "id": "380", "name": "33", "status": false }, { "id": "381", "name": "222", "status": false } ] }, { "id": "382", "name": "安装方式", "status": false, "children": [ { "id": "383", "name": "整装", "status": false } ] }, { "id": "420", "name": "55", "status": false, "children": [] }, { "id": "424", "name": "尺寸", "status": false, "children": [ { "id": "425", "name": "大尺寸", "status": false }, { "id": "656", "name": "1500mm*2000mm", "status": false }, { "id": "660", "name": "1200mm*2000mm", "status": false }, { "id": "662", "name": "1000mm*2000mm", "status": false }, { "id": "664", "name": "1350mm*2000mm", "status": false }, { "id": "669", "name": "1800mm*2000mm", "status": false } ] }, { "id": "426", "name": "标题长度标题长度标题长度", "status": false, "children": [ { "id": "427", "name": "标题长度标题长度", "status": false }, { "id": "431", "name": "标题长度", "status": false }, { "id": "432", "name": "标题", "status": false } ] }, { "id": "428", "name": "属性属性属性属性", "status": false, "children": [ { "id": "429", "name": "属性属性属性属性", "status": false }, { "id": "430", "name": "属性属性", "status": false } ] }, { "id": "449", "name": "健身课程", "status": false, "children": [ { "id": "450", "name": "60分钟", "status": false }, { "id": "451", "name": "90分钟", "status": false } ] }, { "id": "504", "name": "土豪", "status": false, "children": [ { "id": "505", "name": "非常土豪", "status": false } ] }, { "id": "533", "name": "测试", "status": false, "children": [ { "id": "534", "name": "csa", "status": false }, { "id": "535", "name": "csb", "status": false } ] }, { "id": "536", "name": "cs", "status": false, "children": [ { "id": "537", "name": "u", "status": false } ] }, { "id": "539", "name": "油耗大小", "status": false, "children": [ { "id": "540", "name": "油耗低", "status": false }, { "id": "541", "name": "油耗高", "status": false }, { "id": "542", "name": "大", "status": false }, { "id": "543", "name": "小", "status": false } ] }, { "id": "544", "name": "油耗值", "status": false, "children": [ { "id": "545", "name": "大", "status": false }, { "id": "546", "name": "中", "status": false }, { "id": "547", "name": "小", "status": false } ] }, { "id": "548", "name": "版本1", "status": false, "children": [ { "id": "549", "name": "高", "status": false }, { "id": "550", "name": "中", "status": false }, { "id": "551", "name": "底", "status": false } ] }, { "id": "552", "name": "编码", "status": false, "children": [ { "id": "553", "name": "1112", "status": false }, { "id": "564", "name": "长效防冻液（马石油）35/2KG轻负荷", "status": false }, { "id": "565", "name": "长效防冻液（马石油）35/4KG轻负荷", "status": false } ] }, { "id": "554", "name": "图号", "status": false, "children": [ { "id": "555", "name": "222", "status": false } ] }, { "id": "556", "name": "刹车片", "status": false, "children": [ { "id": "557", "name": "222222", "status": false } ] }, { "id": "558", "name": "刹车片型号", "status": false, "children": [ { "id": "559", "name": "后刹车片(孚斯特)", "status": false }, { "id": "563", "name": "3501.6B-105*", "status": false } ] }, { "id": "560", "name": "马石油", "status": false, "children": [ { "id": "561", "name": "润滑油", "status": false }, { "id": "562", "name": "机油", "status": false } ] }, { "id": "566", "name": "适用车型", "status": false, "children": [ { "id": "567", "name": "重卡", "status": false }, { "id": "568", "name": "小汽车", "status": false } ] }, { "id": "569", "name": "大小", "status": false, "children": [ { "id": "570", "name": "1", "status": false }, { "id": "571", "name": "2", "status": false }, { "id": "572", "name": "3", "status": false }, { "id": "573", "name": "4", "status": false }, { "id": "574", "name": "5", "status": false }, { "id": "575", "name": "6", "status": false }, { "id": "576", "name": "7", "status": false }, { "id": "577", "name": "8", "status": false }, { "id": "578", "name": "9", "status": false } ] }, { "id": "579", "name": "测试1", "status": false, "children": [ { "id": "580", "name": "11", "status": false }, { "id": "581", "name": "111", "status": false }, { "id": "582", "name": "333", "status": false } ] }, { "id": "583", "name": "排量", "status": false, "children": [ { "id": "584", "name": "6.0", "status": false }, { "id": "585", "name": "5.0", "status": false }, { "id": "586", "name": "4.0", "status": false } ] }, { "id": "587", "name": "卖报卖报", "status": false, "children": [ { "id": "588", "name": "222", "status": false }, { "id": "589", "name": "222", "status": false } ] }, { "id": "625", "name": "食品口味", "status": false, "children": [ { "id": "626", "name": "越南玉娇芒果干108g*3袋【超值】", "status": false }, { "id": "627", "name": "芒果干+黄桃干+凤梨干【108g*3】", "status": false }, { "id": "628", "name": "越南玉娇芒果干108g*1袋【体验】", "status": false }, { "id": "629", "name": "越南玉娇芒果干256g*1袋【家庭】", "status": false }, { "id": "630", "name": "越南玉娇芒果干108g*2袋【性价】", "status": false }, { "id": "631", "name": "越南玉娇芒果干256g*2袋【聚会】", "status": false } ] }, { "id": "658", "name": "家具结构", "status": false, "children": [ { "id": "659", "name": "框架结构", "status": false } ] } ] }';
        echo $test;
    }


    public function testtest(){
        $test['颜色'][] = '白色';
        $test['颜色'][]  = '白色';
        $test['颜色'][]  = '黑色';
        $test['颜色'][]  = '黄色';
        $test['颜色'][]  = '蓝色';


        echo json_encode($test);

    }

}
