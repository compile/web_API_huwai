<?php
declare (strict_types = 1);

namespace app\api\controller;

use think\facade\Db;

class Nav
{


    public function getnav()
    {
        $where[]= ['type','=','0'];

        $list = Db::name('ok_article_cate')
            ->order('ord desc')
            //thumb,id,post_id,title,author_name,cover,published_at,comments_count
            ->where($where)
            ->select()
            ->toArray();

        foreach($list as $key=>$item){
            $list[$key]['id'] = 'tab'.$item['id'];
            $list[$key]['newsid'] = $item['pinyin'];
            $list[$key]['name']   =  $item['ctypename'];
        }

        $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list, 'count' => 1, 'rel' => 1];

        echo json_encode($result);
    }




}
