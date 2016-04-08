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
class PromotionLimitdiscountGetRequest
{
	private $endTime;
	private $limitDiscountId;
	private $pageNumber;
	private $startTime;
	private $status;
	private $apiParas = array();
	public function setEndTime($endTime)
	{
		$this->endTime = $endTime;
		$this->apiParas["end_time"] = $endTime;
	}
	public function getEndTime()
	{
		return $this->endTime;
	}
	public function setLimitDiscountId($limitDiscountId)
	{
		$this->limitDiscountId = $limitDiscountId;
		$this->apiParas["limit_discount_id"] = $limitDiscountId;
	}
	public function getLimitDiscountId()
	{
		return $this->limitDiscountId;
	}
	public function setPageNumber($pageNumber)
	{
		$this->pageNumber = $pageNumber;
		$this->apiParas["page_number"] = $pageNumber;
	}
	public function getPageNumber()
	{
		return $this->pageNumber;
	}
	public function setStartTime($startTime)
	{
		$this->startTime = $startTime;
		$this->apiParas["start_time"] = $startTime;
	}
	public function getStartTime()
	{
		return $this->startTime;
	}
	public function setStatus($status)
	{
		$this->status = $status;
		$this->apiParas["status"] = $status;
	}
	public function getStatus()
	{
		return $this->status;
	}
	public function getApiMethodName()
	{
		return "taobao.promotion.limitdiscount.get";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>