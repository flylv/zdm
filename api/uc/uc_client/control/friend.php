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
class friendcontrol extends uc_base {
	function __construct() {
		$this->friendcontrol();
	}
	function friendcontrol() {
		parent::__construct();
		$this->init_input();
		$this->load('friend');
	}
	function ondelete() {
		$uid = intval($this->input('uid'));
		$friendids = $this->input('friendids');
		$id = $_ENV['friend']->delete($uid, $friendids);
		return $id;
	}
	function onadd() {
		$uid = intval($this->input('uid'));
		$friendid = $this->input('friendid');
		$comment = $this->input('comment');
		$id = $_ENV['friend']->add($uid, $friendid, $comment);
		return $id;
	}
	function ontotalnum() {
		$uid = intval($this->input('uid'));
		$direction = intval($this->input('direction'));
		$totalnum = $_ENV['friend']->get_totalnum_by_uid($uid, $direction);
		return $totalnum;
	}
	function onls() {
		$uid = intval($this->input('uid'));
		$page = intval($this->input('page'));
		$pagesize = intval($this->input('pagesize'));
		$totalnum = intval($this->input('totalnum'));
		$direction = intval($this->input('direction'));
		$pagesize = $pagesize ? $pagesize : UC_PPP;
		$totalnum = $totalnum ? $totalnum : $_ENV['friend']->get_totalnum_by_uid($uid);
		$data = $_ENV['friend']->get_list($uid, $page, $pagesize, $totalnum, $direction);
		return $data;
	}
}
?>