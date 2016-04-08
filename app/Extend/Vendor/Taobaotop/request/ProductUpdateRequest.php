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
class ProductUpdateRequest
{
	private $binds;
	private $desc;
	private $image;
	private $major;
	private $name;
	private $nativeUnkeyprops;
	private $outerId;
	private $packingList;
	private $price;
	private $productId;
	private $saleProps;
	private $apiParas = array();
	public function setBinds($binds)
	{
		$this->binds = $binds;
		$this->apiParas["binds"] = $binds;
	}
	public function getBinds()
	{
		return $this->binds;
	}
	public function setDesc($desc)
	{
		$this->desc = $desc;
		$this->apiParas["desc"] = $desc;
	}
	public function getDesc()
	{
		return $this->desc;
	}
	public function setImage($image)
	{
		$this->image = $image;
		$this->apiParas["image"] = $image;
	}
	public function getImage()
	{
		return $this->image;
	}
	public function setMajor($major)
	{
		$this->major = $major;
		$this->apiParas["major"] = $major;
	}
	public function getMajor()
	{
		return $this->major;
	}
	public function setName($name)
	{
		$this->name = $name;
		$this->apiParas["name"] = $name;
	}
	public function getName()
	{
		return $this->name;
	}
	public function setNativeUnkeyprops($nativeUnkeyprops)
	{
		$this->nativeUnkeyprops = $nativeUnkeyprops;
		$this->apiParas["native_unkeyprops"] = $nativeUnkeyprops;
	}
	public function getNativeUnkeyprops()
	{
		return $this->nativeUnkeyprops;
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
	public function setPackingList($packingList)
	{
		$this->packingList = $packingList;
		$this->apiParas["packing_list"] = $packingList;
	}
	public function getPackingList()
	{
		return $this->packingList;
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
	public function setProductId($productId)
	{
		$this->productId = $productId;
		$this->apiParas["product_id"] = $productId;
	}
	public function getProductId()
	{
		return $this->productId;
	}
	public function setSaleProps($saleProps)
	{
		$this->saleProps = $saleProps;
		$this->apiParas["sale_props"] = $saleProps;
	}
	public function getSaleProps()
	{
		return $this->saleProps;
	}
	public function getApiMethodName()
	{
		return "taobao.product.update";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->productId,"productId");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>