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
class mailcontrol extends uc_base {
	function __construct() {
		$this->mailcontrol();
	}
	function mailcontrol() {
		parent::__construct();
		$this->init_input();
	}
	function onadd() {
		$this->load('mail');
		$mail = array();
		$mail['appid']		= UC_APPID;
		$mail['uids']		= explode(',', $this->input('uids'));
		$mail['emails']		= explode(',', $this->input('emails'));
		$mail['subject']	= $this->input('subject');
		$mail['message']	= $this->input('message');
		$mail['charset']	= $this->input('charset');
		$mail['htmlon']		= intval($this->input('htmlon'));
		$mail['level']		= abs(intval($this->input('level')));
		$mail['frommail']	= $this->input('frommail');
		$mail['dateline']	= $this->time;
		return $_ENV['mail']->add($mail);
	}
}
?>