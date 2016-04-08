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
class ItemsOnsaleGetRequest
{
	private $cid;
	private $endModified;
	private $fields;
	private $hasDiscount;
	private $hasShowcase;
	private $isEx;
	private $isTaobao;
	private $orderBy;
	private $pageNo;
	private $pageSize;
	private $q;
	private $sellerCids;
	private $startModified;
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
	public function setEndModified($endModified)
	{
		$this->endModified = $endModified;
		$this->apiParas["end_modified"] = $endModified;
	}
	public function getEndModified()
	{
		return $this->endModified;
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
	public function setHasDiscount($hasDiscount)
	{
		$this->hasDiscount = $hasDiscount;
		$this->apiParas["has_discount"] = $hasDiscount;
	}
	public function getHasDiscount()
	{
		return $this->hasDiscount;
	}
	public function setHasShowcase($hasShowcase)
	{
		$this->hasShowcase = $hasShowcase;
		$this->apiParas["has_showcase"] = $hasShowcase;
	}
	public function getHasShowcase()
	{
		return $this->hasShowcase;
	}
	public function setIsEx($isEx)
	{
		$this->isEx = $isEx;
		$this->apiParas["is_ex"] = $isEx;
	}
	public function getIsEx()
	{
		return $this->isEx;
	}
	public function setIsTaobao($isTaobao)
	{
		$this->isTaobao = $isTaobao;
		$this->apiParas["is_taobao"] = $isTaobao;
	}
	public function getIsTaobao()
	{
		return $this->isTaobao;
	}
	public function setOrderBy($orderBy)
	{
		$this->orderBy = $orderBy;
		$this->apiParas["order_by"] = $orderBy;
	}
	public function getOrderBy()
	{
		return $this->orderBy;
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
	public function setQ($q)
	{
		$this->q = $q;
		$this->apiParas["q"] = $q;
	}
	public function getQ()
	{
		return $this->q;
	}
	public function setSellerCids($sellerCids)
	{
		$this->sellerCids = $sellerCids;
		$this->apiParas["seller_cids"] = $sellerCids;
	}
	public function getSellerCids()
	{
		return $this->sellerCids;
	}
	public function setStartModified($startModified)
	{
		$this->startModified = $startModified;
		$this->apiParas["start_modified"] = $startModified;
	}
	public function getStartModified()
	{
		return $this->startModified;
	}
	public function getApiMethodName()
	{
		return "taobao.items.onsale.get";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkMinValue($this->cid,0,"cid");
		RequestCheckUtil::checkNotNull($this->fields,"fields");
		RequestCheckUtil::checkMaxListSize($this->sellerCids,32,"sellerCids");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>