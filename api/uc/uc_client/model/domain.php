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
class uc_domainmodel {
	var $db;
	var $base;
	function __construct(&$base) {
		$this->domainmodel($base);
	}
	function domainmodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
	}
	function add_domain($domain, $ip) {
		if($domain) {
			$this->db->query("INSERT INTO ".UC_DBTABLEPRE."domains SET domain='$domain', ip='$ip'");
		}
		return $this->db->insert_id();
	}
	function get_total_num() {
		$data = $this->db->result_first("SELECT COUNT(*) FROM ".UC_DBTABLEPRE."domains");
		return $data;
	}
	function get_list($page, $ppp, $totalnum) {
		$start = $this->base->page_get_start($page, $ppp, $totalnum);
		$data = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."domains LIMIT $start, $ppp");
		return $data;
	}
	function delete_domain($arr) {
		$domainids = $this->base->implode($arr);
		$this->db->query("DELETE FROM ".UC_DBTABLEPRE."domains WHERE id IN ($domainids)");
		return $this->db->affected_rows();
	}
	function update_domain($domain, $ip, $id) {
		$this->db->query("UPDATE ".UC_DBTABLEPRE."domains SET domain='$domain', ip='$ip' WHERE id='$id'");
		return $this->db->affected_rows();
	}
}
?>