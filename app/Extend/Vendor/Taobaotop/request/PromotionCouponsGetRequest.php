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
class PromotionCouponsGetRequest
{
	private $couponId;
	private $denominations;
	private $endTime;
	private $pageNo;
	private $pageSize;
	private $apiParas = array();
	public function setCouponId($couponId)
	{
		$this->couponId = $couponId;
		$this->apiParas["coupon_id"] = $couponId;
	}
	public function getCouponId()
	{
		return $this->couponId;
	}
	public function setDenominations($denominations)
	{
		$this->denominations = $denominations;
		$this->apiParas["denominations"] = $denominations;
	}
	public function getDenominations()
	{
		return $this->denominations;
	}
	public function setEndTime($endTime)
	{
		$this->endTime = $endTime;
		$this->apiParas["end_time"] = $endTime;
	}
	public function getEndTime()
	{
		return $this->endTime;
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
	public function getApiMethodName()
	{
		return "taobao.promotion.coupons.get";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkMaxValue($this->denominations,100,"denominations");
		RequestCheckUtil::checkMinValue($this->denominations,3,"denominations");
		RequestCheckUtil::checkMinValue($this->pageNo,1,"pageNo");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>