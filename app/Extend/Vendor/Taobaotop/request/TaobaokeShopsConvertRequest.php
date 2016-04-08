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
class TaobaokeShopsConvertRequest
{
	private $fields;
	private $isMobile;
	private $nick;
	private $outerCode;
	private $pid;
	private $sellerNicks;
	private $sids;
	private $apiParas = array();
	public function setFields($fields)
	{
		$this->fields = $fields;
		$this->apiParas["fields"] = $fields;
	}
	public function getFields()
	{
		return $this->fields;
	}
	public function setIsMobile($isMobile)
	{
		$this->isMobile = $isMobile;
		$this->apiParas["is_mobile"] = $isMobile;
	}
	public function getIsMobile()
	{
		return $this->isMobile;
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
	public function setOuterCode($outerCode)
	{
		$this->outerCode = $outerCode;
		$this->apiParas["outer_code"] = $outerCode;
	}
	public function getOuterCode()
	{
		return $this->outerCode;
	}
	public function setPid($pid)
	{
		$this->pid = $pid;
		$this->apiParas["pid"] = $pid;
	}
	public function getPid()
	{
		return $this->pid;
	}
	public function setSellerNicks($sellerNicks)
	{
		$this->sellerNicks = $sellerNicks;
		$this->apiParas["seller_nicks"] = $sellerNicks;
	}
	public function getSellerNicks()
	{
		return $this->sellerNicks;
	}
	public function setSids($sids)
	{
		$this->sids = $sids;
		$this->apiParas["sids"] = $sids;
	}
	public function getSids()
	{
		return $this->sids;
	}
	public function getApiMethodName()
	{
		return "taobao.taobaoke.shops.convert";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->fields,"fields");
		RequestCheckUtil::checkMaxListSize($this->sellerNicks,10,"sellerNicks");
		RequestCheckUtil::checkMaxListSize($this->sids,10,"sids");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>