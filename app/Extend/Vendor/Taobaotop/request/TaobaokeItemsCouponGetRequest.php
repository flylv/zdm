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
class TaobaokeItemsCouponGetRequest
{
	private $area;
	private $cid;
	private $couponType;
	private $endCommissionNum;
	private $endCommissionRate;
	private $endCommissionVolume;
	private $endCouponRate;
	private $endCredit;
	private $endVolume;
	private $fields;
	private $isMobile;
	private $keyword;
	private $nick;
	private $outerCode;
	private $pageNo;
	private $pageSize;
	private $pid;
	private $shopType;
	private $sort;
	private $startCommissionNum;
	private $startCommissionRate;
	private $startCommissionVolume;
	private $startCouponRate;
	private $startCredit;
	private $startVolume;
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
	public function setCid($cid)
	{
		$this->cid = $cid;
		$this->apiParas["cid"] = $cid;
	}
	public function getCid()
	{
		return $this->cid;
	}
	public function setCouponType($couponType)
	{
		$this->couponType = $couponType;
		$this->apiParas["coupon_type"] = $couponType;
	}
	public function getCouponType()
	{
		return $this->couponType;
	}
	public function setEndCommissionNum($endCommissionNum)
	{
		$this->endCommissionNum = $endCommissionNum;
		$this->apiParas["end_commission_num"] = $endCommissionNum;
	}
	public function getEndCommissionNum()
	{
		return $this->endCommissionNum;
	}
	public function setEndCommissionRate($endCommissionRate)
	{
		$this->endCommissionRate = $endCommissionRate;
		$this->apiParas["end_commission_rate"] = $endCommissionRate;
	}
	public function getEndCommissionRate()
	{
		return $this->endCommissionRate;
	}
	public function setEndCommissionVolume($endCommissionVolume)
	{
		$this->endCommissionVolume = $endCommissionVolume;
		$this->apiParas["end_commission_volume"] = $endCommissionVolume;
	}
	public function getEndCommissionVolume()
	{
		return $this->endCommissionVolume;
	}
	public function setEndCouponRate($endCouponRate)
	{
		$this->endCouponRate = $endCouponRate;
		$this->apiParas["end_coupon_rate"] = $endCouponRate;
	}
	public function getEndCouponRate()
	{
		return $this->endCouponRate;
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
	public function setEndVolume($endVolume)
	{
		$this->endVolume = $endVolume;
		$this->apiParas["end_volume"] = $endVolume;
	}
	public function getEndVolume()
	{
		return $this->endVolume;
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
	public function setShopType($shopType)
	{
		$this->shopType = $shopType;
		$this->apiParas["shop_type"] = $shopType;
	}
	public function getShopType()
	{
		return $this->shopType;
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
		$this->apiParas["start_commission_num"] = $startCommissionNum;
	}
	public function getStartCommissionNum()
	{
		return $this->startCommissionNum;
	}
	public function setStartCommissionRate($startCommissionRate)
	{
		$this->startCommissionRate = $startCommissionRate;
		$this->apiParas["start_commission_rate"] = $startCommissionRate;
	}
	public function getStartCommissionRate()
	{
		return $this->startCommissionRate;
	}
	public function setStartCommissionVolume($startCommissionVolume)
	{
		$this->startCommissionVolume = $startCommissionVolume;
		$this->apiParas["start_commission_volume"] = $startCommissionVolume;
	}
	public function getStartCommissionVolume()
	{
		return $this->startCommissionVolume;
	}
	public function setStartCouponRate($startCouponRate)
	{
		$this->startCouponRate = $startCouponRate;
		$this->apiParas["start_coupon_rate"] = $startCouponRate;
	}
	public function getStartCouponRate()
	{
		return $this->startCouponRate;
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
	public function setStartVolume($startVolume)
	{
		$this->startVolume = $startVolume;
		$this->apiParas["start_volume"] = $startVolume;
	}
	public function getStartVolume()
	{
		return $this->startVolume;
	}
	public function getApiMethodName()
	{
		return "taobao.taobaoke.items.coupon.get";
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