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
class appcontrol extends uc_base {
	function __construct() {
		$this->appcontrol();
	}
	function appcontrol() {
		parent::__construct();
		$this->load('app');
	}
	function onls() {
		$this->init_input();
		$applist = $_ENV['app']->get_apps('appid, type, name, url, tagtemplates, viewprourl, synlogin');
		$applist2 = array();
		foreach($applist as $key => $app) {
			$app['tagtemplates'] = $this->unserialize($app['tagtemplates']);
			$applist2[$app['appid']] = $app;
		}
		return $applist2;
	}
	function onadd() {
	}
	function onucinfo() {
	}
	function _random($length, $numeric = 0) {
	}
	function _generate_key() {
	}
	function _format_notedata($notedata) {
	}
}
?>