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
class TopatsDeliverySendRequest
{
	private $companyCodes;
	private $memos;
	private $orderTypes;
	private $outSids;
	private $sellerAddress;
	private $sellerAreaId;
	private $sellerMobile;
	private $sellerName;
	private $sellerPhone;
	private $sellerZip;
	private $tids;
	private $apiParas = array();
	public function setCompanyCodes($companyCodes)
	{
		$this->companyCodes = $companyCodes;
		$this->apiParas["company_codes"] = $companyCodes;
	}
	public function getCompanyCodes()
	{
		return $this->companyCodes;
	}
	public function setMemos($memos)
	{
		$this->memos = $memos;
		$this->apiParas["memos"] = $memos;
	}
	public function getMemos()
	{
		return $this->memos;
	}
	public function setOrderTypes($orderTypes)
	{
		$this->orderTypes = $orderTypes;
		$this->apiParas["order_types"] = $orderTypes;
	}
	public function getOrderTypes()
	{
		return $this->orderTypes;
	}
	public function setOutSids($outSids)
	{
		$this->outSids = $outSids;
		$this->apiParas["out_sids"] = $outSids;
	}
	public function getOutSids()
	{
		return $this->outSids;
	}
	public function setSellerAddress($sellerAddress)
	{
		$this->sellerAddress = $sellerAddress;
		$this->apiParas["seller_address"] = $sellerAddress;
	}
	public function getSellerAddress()
	{
		return $this->sellerAddress;
	}
	public function setSellerAreaId($sellerAreaId)
	{
		$this->sellerAreaId = $sellerAreaId;
		$this->apiParas["seller_area_id"] = $sellerAreaId;
	}
	public function getSellerAreaId()
	{
		return $this->sellerAreaId;
	}
	public function setSellerMobile($sellerMobile)
	{
		$this->sellerMobile = $sellerMobile;
		$this->apiParas["seller_mobile"] = $sellerMobile;
	}
	public function getSellerMobile()
	{
		return $this->sellerMobile;
	}
	public function setSellerName($sellerName)
	{
		$this->sellerName = $sellerName;
		$this->apiParas["seller_name"] = $sellerName;
	}
	public function getSellerName()
	{
		return $this->sellerName;
	}
	public function setSellerPhone($sellerPhone)
	{
		$this->sellerPhone = $sellerPhone;
		$this->apiParas["seller_phone"] = $sellerPhone;
	}
	public function getSellerPhone()
	{
		return $this->sellerPhone;
	}
	public function setSellerZip($sellerZip)
	{
		$this->sellerZip = $sellerZip;
		$this->apiParas["seller_zip"] = $sellerZip;
	}
	public function getSellerZip()
	{
		return $this->sellerZip;
	}
	public function setTids($tids)
	{
		$this->tids = $tids;
		$this->apiParas["tids"] = $tids;
	}
	public function getTids()
	{
		return $this->tids;
	}
	public function getApiMethodName()
	{
		return "taobao.topats.delivery.send";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->tids,"tids");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>