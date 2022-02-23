<?php
/**
 * Created by PhpStorm.
 * User: zoe
 * Date: 2020/2/24
 * Time: 14:22
 */

namespace app\common\controller;

use app\common\model\File;


class Upload
{
    /**
     * Notes：图片上传
     * User: zoe
     * Date: 2020/2/24
     * Time: 14:49
     * @param int $type
     * @return array
     * @throws \OSS\Http\RequestCore_Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function uploadImg($type=1){
        $keys = array_keys($_FILES);
        $key = $keys[0];
        // 获取表单上传文件
        $file = request()->file($key);
        //上传验证
        $rule = [
            'size'=>20480000,
            'mime'=>'image/gif,image/jpeg,image/tiff,image/bmp',
            'ext'=>'jpg,png,jpeg,gif,tif,bmp,mp4,MP4'
        ];
        $info = $file->check($rule);
        //判断验证是否成功
        if(!$info){
            // 上传失败获取错误信息
            return ['code'=>1,'msg'=>$file->getError()];
        }
        $md5 = $file->md5();
        // 上传图片检索
        //$search = File::where('md5',$md5)->field('id img_id,md5,url')->find();
        //如果已经存在直接返回路径
        //if (isset($search) && $search['img_id']) {
        //    return ['code'=>0,'msg'=>'文件已经存在','data'=>$search];
        //}
        //文件信息
        $fileinfo = $file->getInfo();

            // 移动到框架应用根目录/uploads/ 目录下
            $path = 'uploads';
            $infos = $file->rule('md5')->move( $path );
            if(!$infos) return ['code'=>1,'msg'=>$file->getError()];
            $save_name = $infos->getSaveName();
            $path = preg_replace('/[\\,\/]/',DIRECTORY_SEPARATOR,$path.DIRECTORY_SEPARATOR.$save_name);
            $url = config('app.server').$path;

        //数据插入上传日志

        $data = [
            'name'        => $fileinfo['name'],
            'type'        => $fileinfo['type'],
            'size'        => $fileinfo['size'],
            'md5'         => $md5,
            'url'       => $url,
        ];

//        File::addData($data);

        return ['code'=>0,'msg'=>'上传成功','data'=>$data];
    }


    /**
     * @param int $type
     * @return array
     * @throws \OSS\Http\RequestCore_Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException 音乐上传
     */

    public function uploadMp3($type=1){
        $keys = array_keys($_FILES);
        $key = $keys[0];
        // 获取表单上传文件
        $file = request()->file($key);
        //上传验证
        $rule = [
            'size'=>20480000,
            'mime'=>'audio/mpeg3,audio/x-mpeg-3,video/mpeg,video/x-mpeg',
            'ext'=>'mp3'
        ];
        $info = $file->check($rule);
        //判断验证是否成功
        if(!$info){
            // 上传失败获取错误信息
            return ['code'=>1,'msg'=>$file->getError()];
        }
        $md5 = $file->md5();
        // 上传图片检索
        $search = File::where('md5',$md5)->field('id img_id,md5,url')->find();
        //如果已经存在直接返回路径
        if (isset($search) && $search['img_id']) {
            return ['code'=>0,'msg'=>'文件已经存在','data'=>$search];
        }
        //文件信息
        $fileinfo = $file->getInfo();
        if ($type == 2){ //OSS上传
            $oss = new OssUpload();
            $res = $oss->save_to_oss($md5,$fileinfo['tmp_name']);
            //return_json(1,'上传失败',$res);
            if ($res['code']>0){
                return ['code'=>1,'msg'=>$res['msg']];
            }
            $url = $res['data']['url'];
        }else{
            // 移动到框架应用根目录/uploads/ 目录下
            $path = 'uploads';
            $infos = $file->rule('md5')->move( $path );
            if(!$infos) return ['code'=>1,'msg'=>$file->getError()];
            $save_name = $infos->getSaveName();
            $path = preg_replace('/[\\,\/]/',DIRECTORY_SEPARATOR,$path.DIRECTORY_SEPARATOR.$save_name);
            $url = config('app.server').$path;
        }
        //数据插入上传日志
        $data = [
            'name'        => $fileinfo['name'],
            'type'        => $fileinfo['type'],
            'size'        => $fileinfo['size'],
            'md5'         => $md5,
            'url'       => $url,
        ];
        File::addData($data);
        return ['code'=>0,'msg'=>'上传成功','data'=>$data];
    }

    /**
     * Notes：视频上传
     * User: zoe
     * Date: 2020/2/24
     * Time: 15:20
     * @param int $type
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function uploadVideo($type=1){
        $keys = array_keys($_FILES);
        $key = $keys[0];
        // 获取表单上传文件
        $file = request()->file($key);
        //获取文件信息
        $fileinfo = $file->getInfo();
        //上传验证
        $rule = [
            'size'=>51200000,
            'mime'=>'video/mp4, video/rmvb, video/avi, video/mkv',
            'ext'=>'mp4,rmvb,avi,mkv'
        ];
        $info = $file->check($rule);
        //判断验证是否成功
        if(!$info){
            // 上传失败获取错误信息
            return ['code'=>1,'msg'=>$file->getError()];
        }
        $md5 = $file->md5();
        // 上传视频检索
        $search =File::where('md5',$md5)->field('id img_id,md5,url')->find();
        //如果已经存在直接返回路径信息
        if ($search) {
            return ['code'=>0,'msg'=>'文件已经存在','data'=>$search];
        }
        if ($type==2){//oss分片上传
            $oss = new OssUpload();
            $res = $oss->multipartUpload($md5,$fileinfo['tmp_name']);
            if ($res['code']>0){
                return ['code'=>1,'msg'=>$res['msg']];
            }
            //访问地址
            $url = explode('?',$res['data']['url'])[0];
        }else{
            // 移动到框架应用根目录/uploads/ 目录下
            $path = 'uploads/video';
            $infos = $file->rule('md5')->move( $path );
            if(!$infos) return ['code'=>1,'msg'=>$file->getError()];
            $save_name = $infos->getSaveName();
            $path = preg_replace('/[\\,\/]/',DIRECTORY_SEPARATOR,$path.DIRECTORY_SEPARATOR.$save_name);
            $url = config('app.server').$path;
        }

        //数据插入上传日志
        $data = [
            'name'        => $fileinfo['name'],
            'type'        => $fileinfo['type'],
            'size'        => $fileinfo['size'],
            'md5'         => $md5,
            'url'       => $url,
        ];
        File::addData($data);
        return ['code'=>0,'msg'=>'上传成功','data'=>$data];
    }



}