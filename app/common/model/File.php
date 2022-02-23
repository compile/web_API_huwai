<?php
/**
 * Created by PhpStorm.
 * User: zoe
 * Date: 2020/2/24
 * Time: 14:31
 */

namespace app\common\model;
use think\Model;

class File extends Model
{

    /**
     * Notes：文件上传插入日志
     * User: zoe
     * Date: 2020/2/24
     * Time: 14:43
     * @param $param
     * @return File
     */
    public static function addData($param){
        $data = [
            //'id'=>$param[''], // int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件ID',
            'md5'=>$param['md5'], // varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '文件md5',
            'url'=>$param['url'], // varchar(500) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '远程地址',
            'create_time'=>time(), // int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
            'name'=>$param['name'], // varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '文件原名称',
            'type'=>$param['type'], // varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '文件类型',
            'size'=>$param['size'], // int(20) DEFAULT NULL COMMENT '文件大小',
        ];
        return self::create($data);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}