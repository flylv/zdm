<?php 
/**
* ZhePHP 值得买模式的海淘网站程序
* ====================================================================
* 版权所有 杭州言商网络有限公司，并保留所有权利。
* 网站地址: http://www.zhiphp.com
* 交流论坛: http://bbs.pinphp.com
* --------------------------------------------------------------------
* 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
* 使用；不允许对程序代码以任何形式任何目的的再发布。
* ====================================================================
* Author: brivio <brivio@qq.com>
* 授权技术支持: 1142503300@qq.com
*/
class RequestCheckUtil
{
	public static function checkNotNull($value,$fieldName) {
		if(self::checkEmpty($value)){
			throw new Exception("client-check-error:Missing Required Arguments: " .$fieldName , 40);
		}
	}
	public static function checkMaxLength($value,$maxLength,$fieldName){		
		if(!self::checkEmpty($value) && mb_strlen($value , "UTF-8") > $maxLength){
			throw new Exception("client-check-error:Invalid Arguments:the length of " .$fieldName . " can not be larger than " . $maxLength . "." , 41);
		}
	}
	public static function checkMaxListSize($value,$maxSize,$fieldName) {	
		if(self::checkEmpty($value))
			return ;
		$list=preg_split("/,/",$value);
		if(count($list) > $maxSize){
				throw new Exception("client-check-error:Invalid Arguments:the listsize(the string split by \",\") of ". $fieldName . " must be less than " . $maxSize . " ." , 41);
		}
	}
	public static function checkMaxValue($value,$maxValue,$fieldName){	
		if(self::checkEmpty($value))
			return ;
		self::checkNumeric($value,$fieldName);
		if($value > $maxValue){
				throw new Exception("client-check-error:Invalid Arguments:the value of " . $fieldName . " can not be larger than " . $maxValue ." ." , 41);
		}
	}
	public static function checkMinValue($value,$minValue,$fieldName) {
		if(self::checkEmpty($value))
			return ;
		self::checkNumeric($value,$fieldName);
		if($value < $minValue){
				throw new Exception("client-check-error:Invalid Arguments:the value of " . $fieldName . " can not be less than " . $minValue . " ." , 41);
		}
	}
	protected static function checkNumeric($value,$fieldName) {
		if(!is_numeric($value))
			throw new Exception("client-check-error:Invalid Arguments:the value of " . $fieldName . " is not number : " . $value . " ." , 41);
	}
	public static function checkEmpty($value) {
		if(!isset($value))
			return true ;
		if($value === null )
			return true;
		if(trim($value) === "")
			return true;
		return false;
	}
}
?>