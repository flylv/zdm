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
class TaobaokeItemsGetRequest
{
	private $area;
	private $autoSend;
	private $cashCoupon;
	private $cashOndelivery;
	private $cid;
	private $endCommissionNum;
	private $endCommissionRate;
	private $endCredit;
	private $endPrice;
	private $endTotalnum;
	private $fields;
	private $guarantee;
	private $isMobile;
	private $keyword;
	private $mallItem;
	private $nick;
	private $onemonthRepair;
	private $outerCode;
	private $overseasItem;
	private $pageNo;
	private $pageSize;
	private $pid;
	private $realDescribe;
	private $sevendaysReturn;
	private $sort;
	private $startCommissionNum;
	private $startCommissionRate;
	private $startCredit;
	private $startPrice;
	private $startTotalnum;
	private $vipCard;
	private $apiParas = array();
	public function setArea($area)
	{
		$this->area = $area;
		$this->apiParas["area"] = $area;
	}
	public function getArea()
	{
		return $this->area;
	}
	public function setAutoSend($autoSend)
	{
		$this->autoSend = $autoSend;
		$this->apiParas["auto_send"] = $autoSend;
	}
	public function getAutoSend()
	{
		return $this->autoSend;
	}
	public function setCashCoupon($cashCoupon)
	{
		$this->cashCoupon = $cashCoupon;
		$this->apiParas["cash_coupon"] = $cashCoupon;
	}
	public function getCashCoupon()
	{
		return $this->cashCoupon;
	}
	public function setCashOndelivery($cashOndelivery)
	{
		$this->cashOndelivery = $cashOndelivery;
		$this->apiParas["cash_ondelivery"] = $cashOndelivery;
	}
	public function getCashOndelivery()
	{
		return $this->cashOndelivery;
	}
	public function setCid($cid)
	{
		$this->cid = $cid;
		$this->apiParas["cid"] = $cid;
	}
	public function getCid()
	{
		return $this->cid;
	}
	public function setEndCommissionNum($endCommissionNum)
	{
		$this->endCommissionNum = $endCommissionNum;
		$this->apiParas["end_commissionNum"] = $endCommissionNum;
	}
	public function getEndCommissionNum()
	{
		return $this->endCommissionNum;
	}
	public function setEndCommissionRate($endCommissionRate)
	{
		$this->endCommissionRate = $endCommissionRate;
		$this->apiParas["end_commissionRate"] = $endCommissionRate;
	}
	public function getEndCommissionRate()
	{
		return $this->endCommissionRate;
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
	public function setEndPrice($endPrice)
	{
		$this->endPrice = $endPrice;
		$this->apiParas["end_price"] = $endPrice;
	}
	public function getEndPrice()
	{
		return $this->endPrice;
	}
	public function setEndTotalnum($endTotalnum)
	{
		$this->endTotalnum = $endTotalnum;
		$this->apiParas["end_totalnum"] = $endTotalnum;
	}
	public function getEndTotalnum()
	{
		return $this->endTotalnum;
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
	public function setGuarantee($guarantee)
	{
		$this->guarantee = $guarantee;
		$this->apiParas["guarantee"] = $guarantee;
	}
	public function getGuarantee()
	{
		return $this->guarantee;
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
	public function setMallItem($mallItem)
	{
		$this->mallItem = $mallItem;
		$this->apiParas["mall_item"] = $mallItem;
	}
	public function getMallItem()
	{
		return $this->mallItem;
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
	public function setOnemonthRepair($onemonthRepair)
	{
		$this->onemonthRepair = $onemonthRepair;
		$this->apiParas["onemonth_repair"] = $onemonthRepair;
	}
	public function getOnemonthRepair()
	{
		return $this->onemonthRepair;
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
	public function setOverseasItem($overseasItem)
	{
		$this->overseasItem = $overseasItem;
		$this->apiParas["overseas_item"] = $overseasItem;
	}
	public function getOverseasItem()
	{
		return $this->overseasItem;
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
	public function setRealDescribe($realDescribe)
	{
		$this->realDescribe = $realDescribe;
		$this->apiParas["real_describe"] = $realDescribe;
	}
	public function getRealDescribe()
	{
		return $this->realDescribe;
	}
	public function setSevendaysReturn($sevendaysReturn)
	{
		$this->sevendaysReturn = $sevendaysReturn;
		$this->apiParas["sevendays_return"] = $sevendaysReturn;
	}
	public function getSevendaysReturn()
	{
		return $this->sevendaysReturn;
	}
	public function setSort($sort)
	{
		$this->sort = $sort;
		$this->apiParas["sort"] = $sort;
	}
	public function getSort()
	{
		return $this->sort;
	}
	public function setStartCommissionNum($startCommissionNum)
	{
		$this->startCommissionNum = $startCommissionNum;
		$this->apiParas["start_commissionNum"] = $startCommissionNum;
	}
	public function getStartCommissionNum()
	{
		return $this->startCommissionNum;
	}
	public function setStartCommissionRate($startCommissionRate)
	{
		$this->startCommissionRate = $startCommissionRate;
		$this->apiParas["start_commissionRate"] = $startCommissionRate;
	}
	public function getStartCommissionRate()
	{
		return $this->startCommissionRate;
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
	public function setStartPrice($startPrice)
	{
		$this->startPrice = $startPrice;
		$this->apiParas["start_price"] = $startPrice;
	}
	public function getStartPrice()
	{
		return $this->startPrice;
	}
	public function setStartTotalnum($startTotalnum)
	{
		$this->startTotalnum = $startTotalnum;
		$this->apiParas["start_totalnum"] = $startTotalnum;
	}
	public function getStartTotalnum()
	{
		return $this->startTotalnum;
	}
	public function setVipCard($vipCard)
	{
		$this->vipCard = $vipCard;
		$this->apiParas["vip_card"] = $vipCard;
	}
	public function getVipCard()
	{
		return $this->vipCard;
	}
	public function getApiMethodName()
	{
		return "taobao.taobaoke.items.get";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkMaxValue($this->cid,2147483647,"cid");
		RequestCheckUtil::checkNotNull($this->fields,"fields");
		RequestCheckUtil::checkMaxValue($this->pageNo,10,"pageNo");
		RequestCheckUtil::checkMaxValue($this->pageSize,400,"pageSize");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>