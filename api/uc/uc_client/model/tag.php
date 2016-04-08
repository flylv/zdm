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
class uc_tagmodel {
	var $db;
	var $base;
	function __construct(&$base) {
		$this->tagmodel($base);
	}
	function tagmodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
	}
	function get_tag_by_name($tagname) {
		$arr = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."tags WHERE tagname='$tagname'");
		return $arr;
	}
	function get_template($appid) {
		$result = $this->db->result_first("SELECT tagtemplates FROM ".UC_DBTABLEPRE."applications WHERE appid='$appid'");
		return $result;
	}
	function updatedata($appid, $data) {
		$appid = intval($appid);
		include_once UC_ROOT.'lib/xml.class.php';
		$data = xml_unserialize($data);
		$this->base->load('app');
		$data[0] = addslashes($data[0]);
		$datanew = array();
		if(is_array($data[1])) {
			foreach($data[1] as $r) {
				$datanew[] = $_ENV['misc']->array2string($r);
			}
		}
		$tmp = $_ENV['app']->get_apps('type', "appid='$appid'");
		$datanew = addslashes($tmp[0]['type']."\t".implode("\t", $datanew));
		if(!empty($data[0])) {
			$return = $this->db->result_first("SELECT count(*) FROM ".UC_DBTABLEPRE."tags WHERE tagname='$data[0]' AND appid='$appid'");
			if($return) {
				$this->db->query("UPDATE ".UC_DBTABLEPRE."tags SET data='$datanew', expiration='".$this->base->time."' WHERE tagname='$data[0]' AND appid='$appid'");
			} else {
				$this->db->query("INSERT INTO ".UC_DBTABLEPRE."tags (tagname, appid, data, expiration) VALUES ('$data[0]', '$appid', '$datanew', '".$this->base->time."')");
			}
		}
	}
	function formatcache($appid, $tagname) {
		$return = $this->db->result_first("SELECT count(*) FROM ".UC_DBTABLEPRE."tags WHERE tagname='$tagname' AND appid='$appid'");
		if($return) {
			$this->db->query("UPDATE ".UC_DBTABLEPRE."tags SET expiration='0' WHERE tagname='$tagname' AND appid='$appid'");
		} else {
			$this->db->query("INSERT INTO ".UC_DBTABLEPRE."tags (tagname, appid, expiration) VALUES ('$tagname', '$appid', '0')");
		}
	}
}
?>