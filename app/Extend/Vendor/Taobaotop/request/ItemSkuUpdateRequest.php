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
class ItemSkuUpdateRequest
{
	private $itemPrice;
	private $lang;
	private $numIid;
	private $outerId;
	private $price;
	private $properties;
	private $quantity;
	private $specId;
	private $apiParas = array();
	public function setItemPrice($itemPrice)
	{
		$this->itemPrice = $itemPrice;
		$this->apiParas["item_price"] = $itemPrice;
	}
	public function getItemPrice()
	{
		return $this->itemPrice;
	}
	public function setLang($lang)
	{
		$this->lang = $lang;
		$this->apiParas["lang"] = $lang;
	}
	public function getLang()
	{
		return $this->lang;
	}
	public function setNumIid($numIid)
	{
		$this->numIid = $numIid;
		$this->apiParas["num_iid"] = $numIid;
	}
	public function getNumIid()
	{
		return $this->numIid;
	}
	public function setOuterId($outerId)
	{
		$this->outerId = $outerId;
		$this->apiParas["outer_id"] = $outerId;
	}
	public function getOuterId()
	{
		return $this->outerId;
	}
	public function setPrice($price)
	{
		$this->price = $price;
		$this->apiParas["price"] = $price;
	}
	public function getPrice()
	{
		return $this->price;
	}
	public function setProperties($properties)
	{
		$this->properties = $properties;
		$this->apiParas["properties"] = $properties;
	}
	public function getProperties()
	{
		return $this->properties;
	}
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
		$this->apiParas["quantity"] = $quantity;
	}
	public function getQuantity()
	{
		return $this->quantity;
	}
	public function setSpecId($specId)
	{
		$this->specId = $specId;
		$this->apiParas["spec_id"] = $specId;
	}
	public function getSpecId()
	{
		return $this->specId;
	}
	public function getApiMethodName()
	{
		return "taobao.item.sku.update";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->numIid,"numIid");
		RequestCheckUtil::checkMinValue($this->numIid,0,"numIid");
		RequestCheckUtil::checkNotNull($this->properties,"properties");
		RequestCheckUtil::checkMinValue($this->quantity,0,"quantity");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>