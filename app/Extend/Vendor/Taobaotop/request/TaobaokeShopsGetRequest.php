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
class TaobaokeShopsGetRequest
{
	private $cid;
	private $endAuctioncount;
	private $endCommissionrate;
	private $endCredit;
	private $endTotalaction;
	private $fields;
	private $isMobile;
	private $keyword;
	private $nick;
	private $onlyMall;
	private $outerCode;
	private $pageNo;
	private $pageSize;
	private $pid;
	private $sortField;
	private $sortType;
	private $startAuctioncount;
	private $startCommissionrate;
	private $startCredit;
	private $startTotalaction;
	private $apiParas = array();
	public function setCid($cid)
	{
		$this->cid = $cid;
		$this->apiParas["cid"] = $cid;
	}
	public function getCid()
	{
		return $this->cid;
	}
	public function setEndAuctioncount($endAuctioncount)
	{
		$this->endAuctioncount = $endAuctioncount;
		$this->apiParas["end_auctioncount"] = $endAuctioncount;
	}
	public function getEndAuctioncount()
	{
		return $this->endAuctioncount;
	}
	public function setEndCommissionrate($endCommissionrate)
	{
		$this->endCommissionrate = $endCommissionrate;
		$this->apiParas["end_commissionrate"] = $endCommissionrate;
	}
	public function getEndCommissionrate()
	{
		return $this->endCommissionrate;
	}
	public function setEndCredit($endCredit)
	{
		$this->endCredit = $endCredit;
		$this->apiParas["end_credit"] = $endCredit;
	}
	public function getEndCredit()
	{
		return $this->endCredit;
	}
	public function setEndTotalaction($endTotalaction)
	{
		$this->endTotalaction = $endTotalaction;
		$this->apiParas["end_totalaction"] = $endTotalaction;
	}
	public function getEndTotalaction()
	{
		return $this->endTotalaction;
	}
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
	public function setKeyword($keyword)
	{
		$this->keyword = $keyword;
		$this->apiParas["keyword"] = $keyword;
	}
	public function getKeyword()
	{
		return $this->keyword;
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
	public function setOnlyMall($onlyMall)
	{
		$this->onlyMall = $onlyMall;
		$this->apiParas["only_mall"] = $onlyMall;
	}
	public function getOnlyMall()
	{
		return $this->onlyMall;
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
	public function setPageNo($pageNo)
	{
		$this->pageNo = $pageNo;
		$this->apiParas["page_no"] = $pageNo;
	}
	public function getPageNo()
	{
		return $this->pageNo;
	}
	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
		$this->apiParas["page_size"] = $pageSize;
	}
	public function getPageSize()
	{
		return $this->pageSize;
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
	public function setSortField($sortField)
	{
		$this->sortField = $sortField;
		$this->apiParas["sort_field"] = $sortField;
	}
	public function getSortField()
	{
		return $this->sortField;
	}
	public function setSortType($sortType)
	{
		$this->sortType = $sortType;
		$this->apiParas["sort_type"] = $sortType;
	}
	public function getSortType()
	{
		return $this->sortType;
	}
	public function setStartAuctioncount($startAuctioncount)
	{
		$this->startAuctioncount = $startAuctioncount;
		$this->apiParas["start_auctioncount"] = $startAuctioncount;
	}
	public function getStartAuctioncount()
	{
		return $this->startAuctioncount;
	}
	public function setStartCommissionrate($startCommissionrate)
	{
		$this->startCommissionrate = $startCommissionrate;
		$this->apiParas["start_commissionrate"] = $startCommissionrate;
	}
	public function getStartCommissionrate()
	{
		return $this->startCommissionrate;
	}
	public function setStartCredit($startCredit)
	{
		$this->startCredit = $startCredit;
		$this->apiParas["start_credit"] = $startCredit;
	}
	public function getStartCredit()
	{
		return $this->startCredit;
	}
	public function setStartTotalaction($startTotalaction)
	{
		$this->startTotalaction = $startTotalaction;
		$this->apiParas["start_totalaction"] = $startTotalaction;
	}
	public function getStartTotalaction()
	{
		return $this->startTotalaction;
	}
	public function getApiMethodName()
	{
		return "taobao.taobaoke.shops.get";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->fields,"fields");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>