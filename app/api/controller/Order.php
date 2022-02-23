<?php
declare (strict_types = 1);

namespace app\api\controller;

use app\api\model\Address;
use think\facade\Cache;
use think\facade\Db;
use think\facade\Request;

class Order
{
    public function goodsList()
    {
//        if (Request::isAjax()) {
            $table = str_replace("List", '', __FUNCTION__);
            $common = new Common();
            echo $res = $common->getList($table, 2);
        exit();
//        }
    }

    public function test(){
        $post =  Request::param();
        echo '<pre>';

         echo $post['data'];
        $temp = json_decode($post['data'],true);
        $goodsResult = array();
        foreach($temp['goodsData'] as $k=>$item){//这里检查是否足够库存
                        $goods = new \app\admin\model\goods();
                      $g=   $goods->getOne($item['id']);
                      if($g['stock']>=$item['number']){
                          $goodsResult['number'] = $item['number'];
                          $goodsResult['title'] = $g['title'];
                          $goodsResult['test'] =  '春装 L';
                          $goodsResult['price'] = (float)$g['price'];
                      }else{
                          echo 'false';
                          echo '&nbsp;stock:'.$g['stock'].'&nbsp;';
                      }
            echo $item['id'].':'.$item['number'].'<br>';
        }










        echo '<pre>';

    }

    public function buildOrder(){
        $post =  Request::param();
        $userInfo = $post['userInfo'];//用户信息


        //订单信息 价格  地址      还缺一个优惠券信息。
        //提交给api 处理 生成订单 + 支付单 + 锁定库存
        /**
         *  buildOrder 需要再一次确认
         *  1.商品库存是否足够。
         *  2.足够则扣库存。
         *  3. 生成订单信息。 等待支付。
         *  4. 支付数据
         */
        $sale = array();
        $kucun = array();
        foreach($post['order'] as $k=>$item){//这里检查是否足够库存
            $goods = new \app\admin\model\goods();
            $g=   $goods->getOne($item['id']);
            if(($g['stock'] - $g['stock_locked'])>=$item['number']){//库存 比现在的多或者等于才可以卖

                //具体商品信息
                $goodsResult[$k]['image'] = "http://images.jaadee.com/images/201702/goods_img/30150_d85aed83521.jpg";
                $goodsResult[$k]['number'] = $item['number'];
                $goodsResult[$k]['title'] = $g['title'];
                $goodsResult[$k]['price'] = (float)$g['price'];


                //价格计算
                $sale[$k]['id'] = $g['id'];
                $sale[$k]['num'] = $item['number'];
                $sale[$k]['price'] = $g['price'];
                $sale[$k]['total'] = $item['number']* $g['price'];
                $total[] = $item['number']* $g['price'];
                /** 商品表 还有一个仓库表  先不管？？ */
                /** bb_order_detail 信息 */
                //是按单个的 一个订单多少商品 就多少个数据。 后面需要的时候再提取 扣库存。
                $ordertemp_detail[$k]['id'] = '';//固定。 后面赋值即可。
                $ordertemp_detail[$k]['product_id'] = $g['id'];//商品id
                $ordertemp_detail[$k]['product_name'] = $g['title'];//商品名
                $ordertemp_detail[$k]['product_thumb'] = $g['thumb'];
                $ordertemp_detail[$k]['product_cnt'] = $item['number'];//购买数量
                $ordertemp_detail[$k]['average_cost'] =  0;//平均成本价格
                $ordertemp_detail[$k]['fee_money'] = 0;//优惠分摊金额
                $ordertemp_detail[$k]['w_id'] = 1;//仓库id ？ 不知道用途
                $ordertemp_detail[$k]['modified_time'] = 'CURRENT_TIMESTAMP';//CURRENT_TIMESTAMP 修改时间


                $kucun[$k]['id'] = $g['id'];
                $kucun[$k]['stock_locked'] = $item['number'];//锁定多少库存
                //计算总价格

            }else{//如果异常 这里应该返回错误信息
//                echo 'false';
//                echo '&nbsp;stock:'.$g['stock'].'&nbsp;';
                $result['data']['status'] = 0;
                $result['data']['res'] = '库存不够了，请等待最新上架，我们已经通知商家补充库存';
                echo json_encode($result);
                exit();//
            }
            // echo $item['id'].':'.$item['number'].'<br>';
        }
        $total = array_sum($total);
        /** order 表入库信息  如果超时没有支付 则必须 库存返回*/
        $ordertemp['order_sn'] = $this->getOrderSn();
        $ordertemp['customer_id'] = $userInfo['id'];
        $ordertemp['shipping_user'] = $post['address']['name'];
        $ordertemp['address'] = $post['address']['address'];
        $ordertemp['payment_method'] = 5 ;//微信支付
        $ordertemp['order_money'] =  $total;
        $ordertemp['district_money'] = 0;//优惠金额
        $ordertemp['shipping_money'] = 0;//运费
        $ordertemp['payment_money'] =  $ordertemp['order_money'] - $ordertemp['district_money'] - $ordertemp['shipping_money'];//支付金额
        $ordertemp['shipping_comp_name'] = '商家配送';//快递公司名称
        $ordertemp['shipping_sn'] = '12345678';//快递单号
        $ordertemp['create_time'] = 'CURRENT_TIMESTAMP';//下单时间
        $ordertemp['shipping_time'] = '' ;//发货时间
        $ordertemp['goods_num'] = count($ordertemp_detail);


        $ordertemp['pay_time'] = '';//支付时间
        $ordertemp['receive_time'] = '';//收货时间
        $ordertemp['order_status'] = 1;//订单状态 0 创建订单  1 待付款   2 待收货 3 待评价 4收货 5完成订单。
        $ordertemp['invoice_time'] = '';//发票抬头
        $ordertemp['modified_time'] = 'CURRENT_TIMESTAMP';//最后修改时间
        // 启动事务
        Db::startTrans();
        try {
            $orderid = Db::name('order')->insertGetId($ordertemp);//生成 初始订单 扣库存 等待支付
            foreach($ordertemp_detail as $i=>$item){
                $ordertemp_detail[$i]['order_id'] = $orderid;//赋值 订单号
            }
            Db::name('order_detail')->insertAll($ordertemp_detail); //插入订单详情。 并且扣库存 (数量); 仓库应该就是避免直接操作上架的数据。 所以另外存储的 数据。 不然会乱掉。
            // 比如仓库有20件。 但是只上架10份。
            $ku = new \app\sj\model\goods();
            $ku->saveAll($kucun);//增加锁定的库存// 这样如果要解锁 只需要修改 locked 。 不过 计算数量的时候需要连这个一起计算？
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            $result['data']['error'] = $e;
            // 回滚事务
            Db::rollback();
        }

        $result['data']['status'] = 0;
        $result['data']['res'] = json_encode($post);
        $result['data']['res'] = $ordertemp_detail;
        $result['data']['res2'] = $ordertemp;
        $result['data']['stock'] = $kucun;
        echo json_encode($result);
        exit();

    }



    public function getbill(){//结算。 后续可以加入优惠券。
        //goodsgroup账单。计算时间

        $post =  Request::param();
        $order = $post['orderDesc'];
        $userInfo = $post['userInfo'];//用户信息
        //结束时间。 然后计算时间差。


        $ordertemp['id'] = $order['id'];

        $enddate = date("Y-m-d h:i:s",time());
        $ordertemp['receive_time_end'] = $enddate;
        $startdate = $order['receive_time'];
        //生成价格
        //计算时间差
        $hour=floor((strtotime($enddate)-strtotime($startdate))%86400/3600);
        if($hour<=1){
            $hour = 1;//起步为1小时
        }

        //支付价格

        $payment_money = $hour * $order['order_money'];
//        $orderinfo['payment_money'] = $payment_money;
        $orderinfo['payment_money'] = $payment_money;

        //生成支付信息。提供过去
       // $ordertemp['id'] =   $order['id'];
        //$orderinfo['order_money'] = $payment_money;



        $orderinfo['status'] =9;// 9 等待支付。 0 。 预定 1正常  2使用中 3完成 9 等待支付。
        $orderinfo['id'] = $order['id'];
        $orderinfo['receive_time_end'] = $enddate;
        $orderinfo['order_money'] = $payment_money;
        $orderinfo['duration'] = (strtotime($enddate)-strtotime($startdate))%86400/3600;






        Db::startTrans();
        try {
            $change  = Db::name('order')->save($orderinfo);

            $uid = $userInfo['id'];
            $paytemp['uid'] = $uid;
            $paytemp['type'] = 1;
            $paytemp['gid'] = $order['gid'];//goodGroup id
            $paytemp['oid'] = $order['id'];//order
            $paytemp['sid'] = 1; // 商家id
            $paytemp['status'] = 0;
            $paytemp['price'] = $payment_money;
            $paytemp['create_time'] = time();
            $payid = Db::name('pay')->insertGetId($paytemp);
            Db::commit();
            $orderinfo['receive_time'] = $order['receive_time'];
            $result['data']['status'] = 0;
            $result['data']['res'] = json_encode($post);
            $result['data']['orderinfo'] = $orderinfo;
            $result['data']['error'] = 0;//正常
            $result['data']['hour'] = $hour ;
            $result['data']['qian'] =  $order['order_money'];
        } catch (\Exception $e) {
            $result['data']['error'] = $e;
            // 回滚事务
            Db::rollback();
        }
        echo  json_encode($result);
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
        $ordertemp['shipping_time'] = $startTime ;//发货时间
        $ordertemp['create_time'] = date('Y-m-d h:i:s');

        $ordertemp['order_money'] = $total;
        $ordertemp['goodslist'] = $order['goodslist'];
        $ordertemp['pay_time'] = '';//支付时间
        $ordertemp['receive_time'] = '';//收货时间
        $ordertemp['order_status'] = 1;//订单状态 0 创建订单  1 待付款   2 待收货 3 待评价 4收货 5完成订单。
        $ordertemp['invoice_time'] = '';//发票抬头
        $ordertemp['modified_time'] = 'CURRENT_TIMESTAMP';//最后修改时间
        $ordertemp['descript'] = $desc;
        $ordertemp['status'] = 0;

        $ordertemp['gid']   = $order['id'];
        $ordertemp['scenic'] = $address['id'];//景点地址

        $usertemp['has_order'] = 1;
        $usertemp['id'] = $userInfo['id'];

//
//        echo '<pre>';
//
////        print_r($post);
//        print_r($reserve);

      $re =  Db::name('goodsgroup_reserve')->save($reserve);
      $u =  Db::name('user')->save($usertemp);
      $orderid =  Db::name('order')->insertGetId($ordertemp);//入库获得id
//        print_r($usertemp);
      $result['data']['error'] = 0;
      $result['data']['url'] = $orderid;
//        print_r($ordertemp);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            $result['data']['error'] = $e;
            // 回滚事务
            Db::rollback();
        }

        $ordertemp['id'] = $orderid;
        $result['data']['status'] = 0;
        $result['data']['res'] = $ordertemp;

        echo json_encode($result);
        exit();

    }


    public function checkarrive(){
        $post =  Request::param();
        $res = new \app\api\model\order();
        $one= $res->getOne($post['id']);

        if($one['arrivenum']== $post['arrivenum']){//没有错的话 则确认到达。 更新状态和时间。并开始计费。
                $change['status'] = 2;
                $change['receive_time'] = date('Y-m-d H:i:s');
                $change['id'] = $post['id'];
                $ok = Db::name('order')->save($change);
                if($ok){

                }else{

                }
        }
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

    public function orderStatus(){
        $post =  Request::param();
        $id = $post;
        $res = new \app\api\model\order();
        $orderDesc =  $res->getOne($id);
        $result['data']['status'] = 0;
        $result['data']['res'] = $orderDesc;


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
        $where['status'] =  @$post['state']?@$post['state'] : '';
        if($where['status'] == ''){
            unset($where['status']);
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
            $resulttemp[$k]['scenicinfo'] =  $res = Db::name('scenic')->where('id','=',$item['scenic'])->find();
            $resulttemp[$k]['time'] = date("Y-m-d H:i:s");
//            $resulttemp[$k]['time'] = '2021-11-07 09:30:57';
        }
        $result['data']['status'] = 0;
        $result['data']['res'] = $resulttemp;
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
