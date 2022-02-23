<?php
namespace app\admin\validate;
use think\exception\ValidateException;
use think\facade\Request;
use think\Validate;
class BaseValidate extends Validate
{
   public function gocheck()
   {
       $request = Request::instance();
       $params = $request->param();

     try {
         $result=$this->batch()->check($params);
     } catch (ValidateException $e) {
         echo callback("100", $e->getError(), "", "000");
     }
   }
}
