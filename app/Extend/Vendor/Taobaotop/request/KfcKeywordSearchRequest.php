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
class KfcKeywordSearchRequest
{
	private $apply;
	private $content;
	private $nick;
	private $apiParas = array();
	public function setApply($apply)
	{
		$this->apply = $apply;
		$this->apiParas["apply"] = $apply;
	}
	public function getApply()
	{
		return $this->apply;
	}
	public function setContent($content)
	{
		$this->content = $content;
		$this->apiParas["content"] = $content;
	}
	public function getContent()
	{
		return $this->content;
	}
	public function setNick($nick)
	{
		$this->nick = $nick;
		$this->apiParas["nick"] = $nick;
	}
	public function getNick()
	{
		return $this->nick;
	}
	public function getApiMethodName()
	{
		return "taobao.kfc.keyword.search";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->content,"content");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>