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
!defined('IN_UC') && exit('Access Denied');
class uc_appmodel {
	var $db;
	var $base;
	function __construct(&$base) {
		$this->appmodel($base);
	}
	function appmodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
	}
	function get_apps($col = '*', $where = '') {
		$arr = $this->db->fetch_all("SELECT $col FROM ".UC_DBTABLEPRE."applications".($where ? ' WHERE '.$where : ''), 'appid');
		foreach($arr as $k => $v) {
			isset($v['extra']) && !empty($v['extra']) && $v['extra'] = unserialize($v['extra']);
			unset($v['authkey']);
			$arr[$k] = $v;
		}
		return $arr;
	}
}
?>