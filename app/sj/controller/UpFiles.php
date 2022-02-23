<?php
namespace app\admin\controller;
use app\common\controller\Upload;
use think\Db;
use think\Request;

use think\facade\Env;
class UpFiles extends Common
{
    /**
     * Notes：本地图片上传
     * User: zoe
     * Date: 2020/3/23
     * Time: 14:06
     * @return array
     * @throws \OSS\Http\RequestCore_Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function upload(){
        /*// 获取上传文件表单字段名
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下

        $info = $file->validate(['ext' => 'jpg,png,gif,jpeg'])->move('uploads');
        if($info){
            $result['code'] = 1;
            $result['info'] = '图片上传成功!';
            $path=str_replace('\\','/',$info->getSaveName());
            $result['url'] = '/uploads/'. $path;
            return $result;
        }else{
            // 上传失败获取错误信息

            $result['code'] =0;
            $result['info'] =  $file->getError();
            $result['url'] = '';
            return $result;
        }*/
        $upload = new Upload();
        $res = $upload->uploadImg(2);
        return ['code'=>$res['code'],'info'=>$res['msg'],'data'=>$res['data']];
    }
    public function upload2(){
        $upload = new Upload();
        $res = $upload->uploadImg(1);
        return ['code'=>$res['code'],'info'=>$res['msg'],'data'=>$res['data']];
    }

    public function uploadEdit(){
        $upload = new Upload();
        $res = $upload->uploadImg(1);
        $data = [
                            "code"=> $res['code'] //0表示成功，其它失败
                 ,"msg"=> "" //提示信息 //一般上传失败后返回
                 ,"data"=> [
                      "src"=> $res['data']['url']
                     ,"title"=>'' //可选
                 ]
             ];
      //  return ['code'=>0,'info'=>$res['msg'],'data'=>$res['data']];
        return json_encode($data);
    }

    public function uploadVideo(){
        $upload = new Upload();
        $res = $upload->uploadImg(1);
        return ['code'=>$res['code'],'info'=>$res['msg'],'data'=>$res['data']];
    }

    public function uploadMusic(){
        $upload = new Upload();
        $res = $upload->uploadMp3(1);
        return ['code'=>$res['code'],'info'=>$res['msg'],'data'=>$res['data']];
    }

    public function uploadVideo2(){
        //$this->check_user();
        //$type = input('type',1);//1-图片；2-视频
        $upload = new Upload();
        $res = $upload->uploadVideo(2);
        $data = isset($res['data'])?$res['data']:[];
        common_json($res['msg'],$res['code'],$data);
    }
    /*
        *功能：php完美实现下载远程图片保存到本地
        *参数：文件url,保存文件目录,保存文件名称，使用的下载方式
        *当保存文件名称为空时则使用远程文件原来的名称
    */
    function getImage($url,$type=0){
        if(trim($url)==''){
            return array('file_name'=>'','save_path'=>'','error'=>1);
        }
            $path=date("Ymd"); //获取当前时间
            $save_dir='uploads'.'/'.$path;
            $ext = '.jpg';
            $filename=md5($url).$ext;
        if(0!==strrpos($save_dir,'/')){
            $save_dir.='/';
        }
        //创建保存目录
        if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
            return array('file_name'=>'','save_path'=>'','error'=>5);
        }
        //获取远程文件所采用的方法
        if($type){
            $ch=curl_init();
            $timeout=5;
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
            $img=curl_exec($ch);
            curl_close($ch);
        }else{
            ob_start();
            readfile($url);
            $img=ob_get_contents();
            ob_end_clean();
        }
        //$size=strlen($img);
        //文件大小
        $fp2=@fopen($save_dir.$filename,'a');
        fwrite($fp2,$img);
        fclose($fp2);
        unset($img,$url);
        return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0);
    }


    public function file(){
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['ext' => 'zip,rar,pdf,swf,ppt,psd,ttf,txt,xls,doc,docx'])->move('uploads');
        if($info){
            $result['code'] = 0;
            $result['info'] = '文件上传成功!';
            $path=str_replace('\\','/',$info->getSaveName());

            $result['url'] = '/uploads/'. $path;
            $result['ext'] = $info->getExtension();
            $result['size'] = byte_format($info->getSize(),2);
            return $result;
        }else{
            // 上传失败获取错误信息
            $result['code'] =1;
            $result['info'] = '文件上传失败!';
            $result['url'] = '';
            return $result;
        }
    }
    public function pic(){
        // 获取上传文件表单字段名
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['ext' => 'jpg,png,gif,jpeg'])->move(Env::get('root_path') . 'public/uploads');
        if($info){
            $result['code'] = 1;
            $result['info'] = '图片上传成功!';
            $path=str_replace('\\','/',$info->getSaveName());
            $result['url'] = '/uploads/'. $path;
            return json_encode($result,true);
        }else{
            // 上传失败获取错误信息
            $result['code'] =0;
            $result['info'] = '图片上传失败!';
            $result['url'] = '';
            return json_encode($result,true);
        }
    }
    /**
     * 后台：wangEditor
     * @return \think\response\Json
     */
    public function editUpload(){
        // 获取上传文件表单字段名
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['ext' => 'jpg,png,gif,jpeg'])->move('uploads');
        if($info){
            $path=str_replace('\\','/',$info->getSaveName());
            return '/uploads/'. $path;
        }else{
            // 上传失败获取错误信息
            $result['code'] =1;
            $result['msg'] = '图片上传失败!';
            $result['data'] = '';
            return json_encode($result,true);
        }
    }
    //多图上传
    public function upImages(){
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['ext' => 'jpg,png,gif,jpeg'])->move(Env::get('root_path') . 'public/uploads');
        if($info){
            $result['code'] = 0;
            $result['msg'] = '图片上传成功!';
            $path=str_replace('\\','/',$info->getSaveName());
            $result["src"] = '/uploads/'. $path;
            return $result;
        }else{
            // 上传失败获取错误信息
            $result['code'] =1;
            $result['msg'] = '图片上传失败!';
            return $result;
        }
    }
    /**
     * 后台：NKeditor
     * @return \think\response\Json
     */
    public function editimg(){
        $allowExtesions = array(
            'image' => 'gif,jpg,jpeg,png,bmp',
            'flash' => 'swf,flv',
            'media' => 'swf,flv,mp3,wav,wma,wmv,mid,avi,mpg,asf,rm,rmvb',
            'file' => 'doc,docx,xls,xlsx,ppt,htm,html,txt,zip,rar,gz,bz2',
        );
        // 获取上传文件表单字段名
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['ext'=>$allowExtesions[input('fileType')]])->move('./uploads');
        if($info){
            $path=str_replace('\\','/',$info->getSaveName());
            $url = '/uploads/'. $path;
            $result['code'] = '000';
            $result['message'] = '图片上传成功!';
            $result['item'] = ['url'=>$url];
            return json($result);
        }else{
            // 上传失败获取错误信息
            $result['code'] =001;
            $result['message'] = $file->getError();
            $result['url'] = '';
            return json($result);
        }
    }
}