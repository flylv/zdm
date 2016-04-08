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
class tagcontrol extends uc_base {
	function __construct() {
		$this->tagcontrol();
	}
	function tagcontrol() {
		parent::__construct();
		$this->init_input();
		$this->load('tag');
		$this->load('misc');
	}
	function ongettag() {
		$appid = $this->input('appid');
		$tagname = $this->input('tagname');
		$nums = $this->input('nums');
		if(empty($tagname)) {
			return NULL;
		}
		$return = $apparray = $appadd = array();
		if($nums && is_array($nums)) {
			foreach($nums as $k => $num) {
				$apparray[$k] = $k;
			}
		}
		$data = $_ENV['tag']->get_tag_by_name($tagname);
		if($data) {
			$apparraynew = array();
			foreach($data as $tagdata) {
				$row = $r = array();
				$tmp = explode("\t", $tagdata['data']);
				$type = $tmp[0];
				array_shift($tmp);
				foreach($tmp as $tmp1) {
					$tmp1 != '' && $r[] = $_ENV['misc']->string2array($tmp1);
				}
				if(in_array($tagdata['appid'], $apparray)) {
					if($tagdata['expiration'] > 0 && $this->time - $tagdata['expiration'] > 3600) {
						$appadd[] = $tagdata['appid'];
						$_ENV['tag']->formatcache($tagdata['appid'], $tagname);
					} else {
						$apparraynew[] = $tagdata['appid'];
					}
					$datakey = array();
					$count = 0;
					foreach($r as $data) {
						$return[$tagdata['appid']]['data'][] = $data;
						$return[$tagdata['appid']]['type'] = $type;
						$count++;
						if($count >= $nums[$tagdata['appid']]) {
							break;
						}
					}
				}
			}
			$apparray = array_diff($apparray, $apparraynew);
		} else {
			foreach($apparray as $appid) {
				$_ENV['tag']->formatcache($appid, $tagname);
			}
		}
		if($apparray) {
			$this->load('note');
			$_ENV['note']->add('gettag', "id=$tagname", '', $appadd, -1);
		}
		return $return;
	}
}
?>