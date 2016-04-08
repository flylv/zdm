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
class ipCheck {
	public $ipRangeStr = '10.0.0.1/8';
	public $msg = '';
	function __construct($ipRangeStr){
		!empty($ipRangeStr) ? $this->ipRangeStr = $ipRangeStr : '';
	}
	function check($ip = '') {
		empty($ip) && $ip = $this->getClientIp();
		if (FALSE !== strpos($this->ipRangeStr,'-')){
			$type = 'size'; 
		}else if(FALSE !== strpos($this->ipRangeStr,'/')){
			$type = 'mask'; 
		}else{
			$this->msg = '错误的IP范围值';
			return FALSE;
		}
		if ('size' === $type){
			$ipRangeStr = explode('-',$this->ipRangeStr);
			$ipAllowStart = $ipRangeStr[0];
			$ipAllowEnd = $ipRangeStr[1];
			if (FALSE === strpos($ipAllowEnd,'.')){ 
				$ipAllowElmArray = explode('.',$ipAllowStart);
				$ipAllowEnd = $ipAllowElmArray[0] . '.' . 
									$ipAllowElmArray[1] . '.' . 
									$ipAllowElmArray[2] . '.' . 
									$ipAllowEnd;
			}
		}else if ('mask' === $type){
			$ipRangeStr = explode('/',$this->ipRangeStr);
			$ipRangeIP = $ipRangeStr[0];
			$ipRangeMask = (int)$ipRangeStr[1];
			$maskElmNumber = floor($ipRangeMask/8); 
			$maskElmLastLen = $ipRangeMask % 8; 
			$maskElmLast = str_repeat(1,8-$maskElmLastLen);
			$maskElmLast = bindec($maskElmLast); 
			$ipRangeIPElmArray = explode('.',$ipRangeIP);
			if (0 == $maskElmNumber){
				$ipAllowStart = '0.0.0.0';
				$ipAllowEnd = $maskElmLast . '.254.254.254';
			}else if (1 == $maskElmNumber){
				$ipAllowStart = $ipRangeIPElmArray[0] . '.' . '0.0.0';
				$ipAllowEnd = $ipRangeIPElmArray[0] . '.' . $maskElmLast . '.254.254';
			}else if (2 == $maskElmNumber){
				$ipAllowStart = $ipRangeIPElmArray[0] . '.' . $ipRangeIPElmArray[1] . '.' . '0.0';
				$ipAllowEnd = $ipRangeIPElmArray[0] . '.' . $ipRangeIPElmArray[1] . '.' . $maskElmLast . '.254';
			}else if (3 == $maskElmNumber){
				$ipAllowStart = $ipRangeIPElmArray[0] . '.' . $ipRangeIPElmArray[1] . '.' . $ipRangeIPElmArray[2] . '.' . '0';
				$ipAllowEnd = $ipRangeIPElmArray[0] . '.' . $ipRangeIPElmArray[1] . '.' . $ipRangeIPElmArray[2] . '.' . $maskElmLast;
			}else if (4 == $maskElmNumber){
				$ipAllowEnd = $ipAllowStart = $ipRangeIP;
			}else{
				$this->msg = '错误的IP段数据';
				return $this->msg;
			}
		}else{
			$this->msg = '错误的IP段类型';
			return $this->msg;
		}
		$ipAllowStart = $this->getDecIp($ipAllowStart);
		$ipAllowEnd = $this->getDecIp($ipAllowEnd);
		$ip = $this->getDecIp($ip);
		if (!empty($ip)){
			if ($ip <= $ipAllowEnd && $ip >= $ipAllowStart){
				$this->msg = 'IP检测通过';
				return TRUE;
			}else{
				$this->msg = '此为被限制IP';
				return FALSE;
			}
		}else{
			FALSE === ($this->msg) && $this->msg == '没有提供待检测IP'; 
			return $this->msg; 
		}
	}
	function getDecIp($ip){
		$ip = explode(".", $ip); 
		return $ip[0]*255*255*255+$ip[1]*255*255+$ip[2]*255+$ip[3];
	}
	function getClientIp(){
		if(isset($_SERVER['REMOTE_ADDR'])){
			return $_SERVER['REMOTE_ADDR'];
		}else{
			$this->msg = '不能获取客户端IP';
			return FALSE;
		}
	}
}
?>