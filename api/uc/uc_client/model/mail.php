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
define('UC_MAIL_REPEAT', 5);
class uc_mailmodel {
	var $db;
	var $base;
	var $apps;
	function __construct(&$base) {
		$this->mailmodel($base);
	}
	function mailmodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
		$this->apps = &$this->base->cache['apps'];
	}
	function get_total_num() {
		$data = $this->db->result_first("SELECT COUNT(*) FROM ".UC_DBTABLEPRE."mailqueue");
		return $data;
	}
	function get_list($page, $ppp, $totalnum) {
		$start = $this->base->page_get_start($page, $ppp, $totalnum);
		$data = $this->db->fetch_all("SELECT m.*, u.username, u.email FROM ".UC_DBTABLEPRE."mailqueue m LEFT JOIN ".UC_DBTABLEPRE."members u ON m.touid=u.uid ORDER BY dateline DESC LIMIT $start, $ppp");
		foreach((array)$data as $k => $v) {
			$data[$k]['subject'] = htmlspecialchars($v['subject']);
			$data[$k]['tomail'] = empty($v['tomail']) ? $v['email'] : $v['tomail'];
			$data[$k]['dateline'] = $v['dateline'] ? $this->base->date($data[$k]['dateline']) : '';
			$data[$k]['appname'] = $this->base->cache['apps'][$v['appid']]['name'];
		}
		return $data;
	}
	function delete_mail($ids) {
		$ids = $this->base->implode($ids);
		$this->db->query("DELETE FROM ".UC_DBTABLEPRE."mailqueue WHERE mailid IN ($ids)");
		return $this->db->affected_rows();
	}
	function add($mail) {
		if($mail['level']) {
			$sql = "INSERT INTO ".UC_DBTABLEPRE."mailqueue (touid, tomail, subject, message, frommail, charset, htmlon, level, dateline, failures, appid) VALUES ";
			$values_arr = array();
			foreach($mail['uids'] as $uid) {
				if(empty($uid)) continue;
				$values_arr[] = "('$uid', '', '$mail[subject]', '$mail[message]', '$mail[frommail]', '$mail[charset]', '$mail[htmlon]', '$mail[level]', '$mail[dateline]', '0', '$mail[appid]')";
			}
			foreach($mail['emails'] as $email) {
				if(empty($email)) continue;
				$values_arr[] = "('', '$email', '$mail[subject]', '$mail[message]', '$mail[frommail]', '$mail[charset]', '$mail[htmlon]', '$mail[level]', '$mail[dateline]', '0', '$mail[appid]')";
			}
			$sql .= implode(',', $values_arr);
			$this->db->query($sql);
			$insert_id = $this->db->insert_id();
			$insert_id && $this->db->query("REPLACE INTO ".UC_DBTABLEPRE."vars SET name='mailexists', value='1'");
			return $insert_id;
		} else {
			$mail['email_to'] = array();
			$uids = 0;
			foreach($mail['uids'] as $uid) {
				if(empty($uid)) continue;
				$uids .= ','.$uid;
			}
			$users = $this->db->fetch_all("SELECT uid, username, email FROM ".UC_DBTABLEPRE."members WHERE uid IN ($uids)");
			foreach($users as $v) {
				$mail['email_to'][] = $v['username'].'<'.$v['email'].'>';
			}
			foreach($mail['emails'] as $email) {
				if(empty($email)) continue;
				$mail['email_to'][] = $email;
			}
			$mail['message'] = str_replace('\"', '"', $mail['message']);
			$mail['email_to'] = implode(',', $mail['email_to']);
			return $this->send_one_mail($mail);
		}
	}
	function send() {
		register_shutdown_function(array($this, '_send'));
	}
	function _send() {
		$mail = $this->_get_mail();
		if(empty($mail)) {
			$this->db->query("REPLACE INTO ".UC_DBTABLEPRE."vars SET name='mailexists', value='0'");
			return NULL;
		} else {
			$mail['email_to'] = $mail['tomail'] ? $mail['tomail'] : $mail['username'].'<'.$mail['email'].'>';
			if($this->send_one_mail($mail)) {
				$this->_delete_one_mail($mail['mailid']);
				return true;
			} else {
				$this->_update_failures($mail['mailid']);
				return false;
			}
		}
	}
	function send_by_id($mailid) {
		if ($this->send_one_mail($this->_get_mail_by_id($mailid))) {
			$this->_delete_one_mail($mailid);
			return true;
		}
	}
	function send_one_mail($mail) {
		if(empty($mail)) return;
		$mail['email_to'] = $mail['email_to'] ? $mail['email_to'] : $mail['username'].'<'.$mail['email'].'>';
		$mail_setting = $this->base->settings;
		return include UC_ROOT.'lib/sendmail.inc.php';
	}
	function _get_mail() {
		$data = $this->db->fetch_first("SELECT m.*, u.username, u.email FROM ".UC_DBTABLEPRE."mailqueue m LEFT JOIN ".UC_DBTABLEPRE."members u ON m.touid=u.uid WHERE failures<'".UC_MAIL_REPEAT."' ORDER BY level DESC, mailid ASC LIMIT 1");
		return $data;
	}
	function _get_mail_by_id($mailid) {
		$data = $this->db->fetch_first("SELECT m.*, u.username, u.email FROM ".UC_DBTABLEPRE."mailqueue m LEFT JOIN ".UC_DBTABLEPRE."members u ON m.touid=u.uid WHERE mailid='$mailid'");
		return $data;
	}
	function _delete_one_mail($mailid) {
		$mailid = intval($mailid);
		return $this->db->query("DELETE FROM ".UC_DBTABLEPRE."mailqueue WHERE mailid='$mailid'");
	}
	function _update_failures($mailid) {
		$mailid = intval($mailid);
		return $this->db->query("UPDATE ".UC_DBTABLEPRE."mailqueue SET failures=failures+1 WHERE mailid='$mailid'");
	}
}
?>