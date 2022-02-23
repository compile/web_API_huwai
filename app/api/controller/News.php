<?php
declare (strict_types = 1);

namespace app\api\controller;

use think\facade\Db;

class News
{


    public function articlelist()
    {

        $minId = input('minId', 0);//如果为0 则就是默认。 否则就按这个id 去搜索接下来的篇数。
        $columnId = input('columnId',0);//分类。 如果为0 就表示全部。
        $pageSize = input('pageSize',10);//一次多少数据，默认10
            $where = [];
        if(!$columnId){
                //不处理

        }else{
            //得到piniyin 。 去bb_ok_article_cate 得到搜索词即可
            $tempwhere[] = ['pinyin','=',$columnId];
             $temp = Db::table('ok_article_cate')
                //thumb,id,post_id,title,author_name,cover,published_at,comments_count
                ->where($tempwhere)
                ->find();
             $where[] = ['pid','=',$temp['ctypename']];
        }

        if(!$minId){

        }else{

            $where[] = ['id', '>', $minId];

        }


        $list = Db::table('ok_article_all')
            ->order('ord desc')
            //thumb,id,post_id,title,author_name,cover,published_at,comments_count
            ->where($where)
            ->field('id,title,thumb')
            ->limit(10)
            ->select()
            ->toArray();


        echo json_encode($list);
    }
    public function singlearticle(){//根据id 得到文章

        $id = input('id', 9);
            $where[] = ['id', '=',$id];
        $article = Db::table('ok_article_all')
            ->order('ord desc')
            //thumb,id,post_id,title,author_name,cover,published_at,comments_count
            ->where($where)
            ->find();

        $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $article, 'count' => 1, 'rel' => 1];

        echo json_encode($result);
    }

    public function getrecommendarticle(){//根据id 得到文章

        $where[] = ['thumb', '<>',''];
        $article = Db::table('ok_article_all')
            ->order('ord desc')
            //thumb,id,post_id,title,author_name,cover,published_at,comments_count
            ->field('thumb,id,title')
            ->limit(4)
            ->where($where)
            ->select()
            ->toarray();
        $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $article, 'count' => 1, 'rel' => 1];
        echo json_encode($result);
    }


}
