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
class ucclient_db {
	var $querynum = 0;
	var $link;
	var $histories;
	var $dbhost;
	var $dbuser;
	var $dbpw;
	var $dbcharset;
	var $pconnect;
	var $tablepre;
	var $time;
	var $goneaway = 5;
	function connect($dbhost, $dbuser, $dbpw, $dbname = '', $dbcharset = '', $pconnect = 0, $tablepre='', $time = 0) {
		$this->dbhost = $dbhost;
		$this->dbuser = $dbuser;
		$this->dbpw = $dbpw;
		$this->dbname = $dbname;
		$this->dbcharset = $dbcharset;
		$this->pconnect = $pconnect;
		$this->tablepre = $tablepre;
		$this->time = $time;
		if($pconnect) {
			if(!$this->link = mysql_pconnect($dbhost, $dbuser, $dbpw)) {
				$this->halt('Can not connect to MySQL server');
			}
		} else {
			if(!$this->link = mysql_connect($dbhost, $dbuser, $dbpw)) {
				$this->halt('Can not connect to MySQL server');
			}
		}
		if($this->version() > '4.1') {
			if($dbcharset) {
				mysql_query("SET character_set_connection=".$dbcharset.", character_set_results=".$dbcharset.", character_set_client=binary", $this->link);
			}
			if($this->version() > '5.0.1') {
				mysql_query("SET sql_mode=''", $this->link);
			}
		}
		if($dbname) {
			mysql_select_db($dbname, $this->link);
		}
	}
	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}
	function result_first($sql) {
		$query = $this->query($sql);
		return $this->result($query, 0);
	}
	function fetch_first($sql) {
		$query = $this->query($sql);
		return $this->fetch_array($query);
	}
	function fetch_all($sql, $id = '') {
		$arr = array();
		$query = $this->query($sql);
		while($data = $this->fetch_array($query)) {
			$id ? $arr[$data[$id]] = $data : $arr[] = $data;
		}
		return $arr;
	}
	function cache_gc() {
		$this->query("DELETE FROM {$this->tablepre}sqlcaches WHERE expiry<$this->time");
	}
	function query($sql, $type = '', $cachetime = FALSE) {
		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ? 'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql, $this->link)) && $type != 'SILENT') {
			$this->halt('MySQL Query Error', $sql);
		}
		$this->querynum++;
		$this->histories[] = $sql;
		return $query;
	}
	function affected_rows() {
		return mysql_affected_rows($this->link);
	}
	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}
	function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
	}
	function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}
	function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}
	function num_fields($query) {
		return mysql_num_fields($query);
	}
	function free_result($query) {
		return mysql_free_result($query);
	}
	function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}
	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}
	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}
	function version() {
		return mysql_get_server_info($this->link);
	}
	function close() {
		return mysql_close($this->link);
	}
	function halt($message = '', $sql = '') {
		$error = mysql_error();
		$errorno = mysql_errno();
		if($errorno == 2006 && $this->goneaway-- > 0) {
			$this->connect($this->dbhost, $this->dbuser, $this->dbpw, $this->dbname, $this->dbcharset, $this->pconnect, $this->tablepre, $this->time);
			$this->query($sql);
		} else {
			$s = '';
			if($message) {
				$s = "<b>UCenter info:</b> $message<br />";
			}
			if($sql) {
				$s .= '<b>SQL:</b>'.htmlspecialchars($sql).'<br />';
			}
			$s .= '<b>Error:</b>'.$error.'<br />';
			$s .= '<b>Errno:</b>'.$errorno.'<br />';
			$s = str_replace(UC_DBTABLEPRE, '[Table]', $s);
			exit($s);
		}
	}
}
?>