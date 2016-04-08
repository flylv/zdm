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
class TmallItemsDiscountSearchRequest
{
	private $auctionTag;
	private $brand;
	private $cat;
	private $endPrice;
	private $postFee;
	private $q;
	private $sort;
	private $start;
	private $startPrice;
	private $apiParas = array();
	public function setAuctionTag($auctionTag)
	{
		$this->auctionTag = $auctionTag;
		$this->apiParas["auction_tag"] = $auctionTag;
	}
	public function getAuctionTag()
	{
		return $this->auctionTag;
	}
	public function setBrand($brand)
	{
		$this->brand = $brand;
		$this->apiParas["brand"] = $brand;
	}
	public function getBrand()
	{
		return $this->brand;
	}
	public function setCat($cat)
	{
		$this->cat = $cat;
		$this->apiParas["cat"] = $cat;
	}
	public function getCat()
	{
		return $this->cat;
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
	public function setPostFee($postFee)
	{
		$this->postFee = $postFee;
		$this->apiParas["post_fee"] = $postFee;
	}
	public function getPostFee()
	{
		return $this->postFee;
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
	public function setSort($sort)
	{
		$this->sort = $sort;
		$this->apiParas["sort"] = $sort;
	}
	public function getSort()
	{
		return $this->sort;
	}
	public function setStart($start)
	{
		$this->start = $start;
		$this->apiParas["start"] = $start;
	}
	public function getStart()
	{
		return $this->start;
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
	public function getApiMethodName()
	{
		return "tmall.items.discount.search";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkMaxValue($this->start,1000,"start");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>