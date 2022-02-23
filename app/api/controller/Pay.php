<?php
declare (strict_types = 1);

namespace app\api\controller;

use app\api\model\Address;
use think\facade\Cache;
use think\facade\Db;
use think\facade\Request;

require_once "../extend/wxPay/WxPay.Api.php";
require_once "../extend/wxPay/WxPay.Data.php";
class Pay
{
    public function checkpay(){
        //这里检测数据是否对。
        //然后准备付款了。准备付款需要的数据返回.
        $post =  Request::param();
        $id = $post['id'];
//        $res = new \app\api\model\pay();
        $res = Db::name('pay')->where('oid','=',$id)->find();//根据oid 查找到 支付信息。后续给支付接口。
        $pay = $res;//其实应该加密给的。
        $result['data']['status'] = 0;
        $result['data']['pay'] = $pay;
        $result['data']['res'] = json_encode($post);
        echo json_encode($result);
        exit();

    }

    public function wxPay(){
// 获取支付金额
        $amount='';
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $amount=$_POST['total'];
        }else{
            $amount=$_GET['total'];
        }
        $total = floatval($amount);
        $total = round($total*100); // 将元转成分
        if(empty($total)){
            $total = 100;
        }

// 商品名称
        $subject = 'DCloud项目捐赠';
// 订单号，示例代码使用时间值作为唯一的订单ID号
        $out_trade_no = date('YmdHis', time());

        $unifiedOrder = new WxPayUnifiedOrder();
        $unifiedOrder->SetBody($subject);//商品或支付单简要描述
        $unifiedOrder->SetOut_trade_no($out_trade_no);
        $unifiedOrder->SetTotal_fee($total);
        $unifiedOrder->SetTrade_type("APP");


        echo '<pre>';

            print_r($unifiedOrder);

        echo '</pre>';
        $result = WxPayApi::unifiedOrder($unifiedOrder);
        if (is_array($result)) {
            echo json_encode($result);
        }

    }

    public function wxpayv3Notify(){
        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/plain');
        echo 'SUCCESS';
    }

    public function okpay(){
        $post =  Request::param();
        /**
        1. 支付信息添加  pay。 确定支付的。pay_log[后面添加]
         *    2. pay 支付状态需要修改
         *    3. order 状态修改。
         *    4. user 的使用状态 has_order  = 0
         *    5. 通知[暂无]
         * */


        Db::startTrans();
        try {
        $payinfo = $post['payinfo'];//支付表信息


        $paytemp['status'] = 1;// 支付了为1  没有支付 为0;
        $paytemp['update_time'] = time();//更新时间。
        $paytemp['content'] = '支付的信息。 这里先这样';


        $usertemp['has_order'] = 0;// 解除 用户有订单状态.后面应该加累计订单数。


        $ordertemp['status'] = 3;//完成订单了
        $ordertemp['modified_time'] = time();


        Db::name('order')->where('id','=',$payinfo['oid'])->save($ordertemp);
        Db::name('pay')->where('id','=',$payinfo['id'])->save($paytemp);
        Db::name('user')->where('id','=',$payinfo['uid'])->save($usertemp);

            $result['data']['error'] = 0;
            Db::commit();
        } catch (\Exception $e) {
            $result['data']['error'] = $e;
            // 回滚事务
            Db::rollback();
        }



        $result['data']['status'] = 0;
        $result['data']['pay'] = $post;
        $result['data']['res'] = json_encode($post);

        echo json_encode($result);
        exit();

    }



    public function buildGroupOrder(){//
        $post =  Request::param();
        $userInfo = $post['userInfo'];//用户信息
        $user = new \app\api\model\user();
        $usertemp = $user->getOne($userInfo['id']);//这里检测是否已经有订单了。
        if($usertemp['has_order']==1){//这里需要返回已经有订单了。约定返回的参数。
            $result['data']['status'] = 0;
            $result['data']['res'] = json_encode($post);
            $result['data']['error'] = 1;
            $result['data']['msg'] = '已经有订单在进行中了。 ';
            echo json_encode($result);
            exit();
        }




        //这里应该不是计算库存。 是分开的。 写入被预定的日期。 每个选单每一天只能有一个预定。 因为需要消毒或者晒。
        /**
         *
         * 需要设定是否需要有押金 。 如果需要押金 则判断有无 有直接下单 无去充钱。   如果不需要押金则         判断是否有被下单 没有的话则 成功 。当前时间不能再被预定。
         *
         */

//        echo '<pre>';
//        print_r($post);
//
//        exit();
        // 启动事务
        Db::startTrans();
        try {
        $order = $post['order'];//订单信息
        $startTime = $post['startTime'];//预期时间
        $address = $post['address'];//地址
        $mobile = $post['mobile'];//电话信息
        $total =  $post['total'];//价格
        $userInfo = $post['userInfo'];//用户信息
        $desc = $post['desc'];//备注
        //假设账户有钱。


        //直接保存预定


        //预定信息。
        $reserve['uid'] = $userInfo['id'];
        $reserve['gg_id'] = $order['id'];
        $reserve['res_time'] = $startTime;
        $reserve['start_time'] = $startTime;
        $reserve['create_time'] = time();


        //订单信息
        $ordertemp['order_sn'] = $this->getOrderSn();
        $ordertemp['customer_id'] = $userInfo['id'];
        $ordertemp['shipping_user'] = $userInfo['username'];
        $ordertemp['address'] =   $address['address'];
        $ordertemp['shipping_comp_name'] = '商家配送';//快递公司名称
        $ordertemp['shipping_sn'] = '12345678';//快递单号
        $ordertemp['create_time'] = 'CURRENT_TIMESTAMP';//下单时间
        $ordertemp['shipping_time'] = '' ;//发货时间
        $ordertemp['order_money'] = $total;
        $ordertemp['goodslist'] = $order['goodslist'];
        $ordertemp['pay_time'] = '';//支付时间
        $ordertemp['receive_time'] = '';//收货时间
        $ordertemp['order_status'] = 1;//订单状态 0 创建订单  1 待付款   2 待收货 3 待评价 4收货 5完成订单。
        $ordertemp['invoice_time'] = '';//发票抬头
        $ordertemp['modified_time'] = 'CURRENT_TIMESTAMP';//最后修改时间
        $ordertemp['descript'] = $desc;


        $usertemp['has_order'] = 1;
        $usertemp['id'] = $userInfo['id'];

//
//        echo '<pre>';
//
////        print_r($post);
//        print_r($reserve);

       $re =  Db::name('goodsgroup_reserve')->save($reserve);
       $u =  Db::name('user')->save($usertemp);
       $or =  Db::name('order')->save($ordertemp);
//        print_r($usertemp);
//
//        print_r($ordertemp);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            $result['data']['error'] = $e;
            // 回滚事务
            Db::rollback();
        }


        $result['data']['status'] = 0;
        $result['data']['res'] = json_encode($post);

        echo json_encode($result);
        exit();

    }

    public function getUserInfo(){
        return 1;
    }

    public function getOrderSn(){
        $uid = 1;
        $time= date("mdhis");
        $result = str_pad($time.$uid,20,"0",STR_PAD_RIGHT);
        return $result;
    }



    public function changeOrder(){
        /***
         *  订单状态修改。
         *  0 订单创建默认状态      1 : 待付款    2: 待收货   3:待评价    4: 售后        *
         *  1   待付款         初始 0 订单创建后默认到 付款阶段 如果没有付款 就是待付款 1
         *  2   待收货      待付款阶段后 发货就是 待收货阶段
         *  3   等待评价    收到货后 就进入待评价阶段。
         *  4   售后    货品有问题 。 会员进入 售后阶段。
         *   售后阶段 又有售后表。 如果没有问题了。 便 结束售后订单。 否则循环
         */

        // 人工操作的有 取消订单。 删除订单。     投诉进入售后。 剩下的是程序自动推进
        $post =  Request::param();

        $type =  $post['dotype'];
        if($type == 'del'){//删除订单
            //




        }else if($type == 'cancel'){//取消订单
            //
            $goods = new  Goods();
            $orderid = $post['item']['order_id'];// 根据orderid 去取消订单 把状态改为 9 。 归还stocck_lock 的库存  需要状态为1 才可以取消。(如果付款取消的话 则需要归还付款金额和其他 暂不考虑)


            $save['id'] = $orderid;
            $save['order_status'] = 9;//取消的订单状态







            // 启动事务
            Db::startTrans();
            try {

                $save['id'] = $orderid;
                $save['order_status'] = 9;//取消的订单状态


                Db::name('order')->save($save);//1 取消订单。


                $where['order_id'] = $orderid;
                $temporder = Db::name('order_detail')->where($where)->select()->toArray();//查找订单下所有的商品


                $goodstemp = array();
                foreach($temporder as $i=>$item){
                    $goodswhere['id'] = $item['product_id'];
                    Db::name('goods')->where($goodswhere) ->dec('stock_locked',$item['product_cnt'])->update();//修改库存。 其实应该更严谨一些
                }
                //以上可以。 但是如果有优惠券 也要恢复未使用的状态才对。







                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                $result['data']['error'] = $e;
                // 回滚事务
                Db::rollback();
            }




            //取消库存锁定 stock_locked;




//            $goods = new \app\admin\model\goods();
//            $g=   $goods->getOne($item['id']);




           //  Db::name('order')->save($save);



        }

        $result['data']['status'] = 0;
        $result['data']['res'] = $post['item'];
        $result['data']['temporder'] = $temporder;
        $result['data']['where'] = $where;
        $result['data']['goods'] = $goodstemp;
        echo json_encode($result);
        exit();
    }


    public function orderDesc(){
        $post =  Request::param();
        $id = $post;
        $res = new \app\api\model\order();
        $orderDesc =  $res->getOne($id);


        $scenic = Db::name('scenic')->where('id','=',$orderDesc['scenic'])->find();
        $result['data']['status'] = 0;
        $result['data']['res'] = $orderDesc;
        $result['data']['scenic'] = $scenic;

        echo json_encode($result);
        exit();
    }


    public function getOrder(){//获得用户的所有订单     总价格。  订单时间 。 商品数量。 商品具体图片。 总价 用户默认1
        $post =  Request::param();
        $userInfo = $post['userInfo'];
//        $page = input('page', 1);
        $page = $post['navItem']['page']?$post['navItem']['page']:1;//分类订单页面
        $pageSize = input('limit', 9);
        $where = array();
        $where['customer_id'] = $userInfo['id'];//所属id
        $where['order_status'] =  @$post['state']?@$post['state'] : '';
        if($where['order_status'] == ''){
            unset($where['order_status']);
        }
//        $temp = Db::name('order')->where($where)->select()->toArray();
        $list = \think\facade\Db::name('order')->order('id desc')->where($where)->paginate(array('list_rows' => $pageSize, 'page' => $page))->toArray();
        $resulttemp = $list['data'];

//        $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
//        echo json_encode($result);

        foreach($list['data'] as $k=>$item){
            $resulttemp[$k]['order_id'] =$item['id'];
            $resulttemp[$k]['total_price'] = $item['payment_money'];
            $resulttemp[$k]['order_status'] = $item['order_status'];
            $resulttemp[$k]['goods_num'] = $item['goods_num'];
            $resulttemp[$k]['goodsList'] = $this->getGoodsImages($item['id']);
            $resulttemp[$k]['time'] = date("Y-m-d H:i:s");
//            $resulttemp[$k]['time'] = '2021-11-07 09:30:57';
        }
        $result['data']['status'] = 0;
        $result['data']['res'] = $resulttemp;
        $result['data']['test'] = $post;
        $result['data']['sql'] = $page;
        echo json_encode($result);
        exit();
    }




    public function getGoodsImages($orderid){
        if($orderid){

            $res = Db::name('order_detail')->where("order_id",'=',$orderid)->select()->toArray();
            $result = array();
            foreach($res as $k=>$item){
                $result[$k]['image'] = $item['product_thumb'];
                $result[$k]['number'] = $item['product_cnt'];
                $result[$k]['price'] = $item['product_price'];
                $result[$k]['attr'] = $item['product_name'];
            }
            return $result;
        }else {
            exit();
        }
    }


    public function createGroupOrder(){
        $post =  Request::param();
        $temp = json_encode($post['goodsData']);//只有 id 和 number
        $userInfo = $post['userInfo'];
        $from = $post['from'];
        $start_time = $post['startTime'];
        $temp2 = json_decode($temp,true);


        $id = $temp2['id'];
        $goodsgroup = new goodsgroup();
        $goodslist = $goodsgroup->goodsGroupOnefromid($id);
        $result['data']['status'] = 0;
        $result['data']['res'] =$goodslist;
        $result['data']['startTime'] = $start_time;
        echo json_encode($result);
        exit();
    }



    public function createOrder(){//这里检测 订单商品是否正常 数据    // 商品有不同的属性。 如果有就去 goods_attr 找。 如果没有就默认 goods找即可？//这里应该还要得到 用户购物车里面所选择的id.成单后要通知删除
        $post =  Request::param();
        $temp = json_encode($post['goodsData']);
        $userInfo = $post['userInfo'];
        $from = $post['from'];
        $start_time = $post['startTime'];
        $temp2 = json_decode($temp,true);
        $goodsResult = array();
        $sale = array();
        $cartindex = array();
        foreach($temp2 as $k=>$item){//这里检查是否足够库存
            $goods = new \app\admin\model\goods();
//            echo $item['id'];
                $g=  $goods->getOne($item['id']);
                if($item['attr_val']){//如果有 属性 就去找属性值
                    $where['attr'] = $item['attr_val'];
                    $skutemp = Db::name("goodsattr")->where($where)->find();
                }
//            if($g['stock']>=$item['number']){//库存 比现在的多或者等于才可以卖
                $goodsResult[$k]['image'] = $g['thumb'];
                $goodsResult[$k]['number'] = $item['number'];
                $goodsResult[$k]['title'] = $g['title'];
                $goodsResult[$k]['attr_val'] =  $skutemp['attr'];
                $goodsResult[$k]['price'] = (float)$g['price'];
                $goodsResult[$k]['id'] = $g['id'];
                //价格计算
                $sale[$k]['id'] = $g['id'];
                $sale[$k]['num'] = $item['number'];
                $sale[$k]['price'] = $g['price'];
                $sale[$k]['total'] = $item['number']* $g['price'];
                $sale['total'][$k] = $item['number']* $g['price'];

                if($post['from'] == 1){
                    $cartindex[$k] = @$item['cartid'];
                }


                //计算总价格

//            }else{//如果异常 这里应该返回错误信息
//                echo 'false';
//                echo '&nbsp;stock:'.$g['stock'].'&nbsp;';
//            }
            // echo $item['id'].':'.$item['number'].'<br>';
        }

//        $info = new \app\api\model\address();
        $id = $userInfo['id'];
//        print_r($userInfo);
//        $address = $info->getOne($id);
        $address  = Db::name("scenic")->where('id','=',1)->find();
        //如果有优惠券 还需要加入 。 并且都要记录
        $result['data']['status'] = 0;
        $result['data']['res'] = $goodsResult;
        $result['data']['sale'] = $sale;
        $result['data']['total'] = array_sum($sale['total']);
        $result['data']['address'] = $address;
        $result['data']['from'] = $from;
        $result['data']['startTime'] = $start_time;
        $result['data']['cartindex'] = $cartindex;// 返回生成订单的购物车数据。
        echo json_encode($result);
        exit();
    }

    public function goodsOne(){
        $res = new \app\admin\model\goods();
        $id =  Request::param('id');
         $goodsRes = $res->getOne($id) ;
        $result['data']['status'] = 0;
        $result['data']['res'] = $goodsRes;
        echo json_encode($result);
        exit();
    }

    public function index(){
        echo __FUNCTION__;
    }

    public function chenggfa(){

        $A = 100112;
        $B = 2234;

        echo ($A * $B );

    }
}
