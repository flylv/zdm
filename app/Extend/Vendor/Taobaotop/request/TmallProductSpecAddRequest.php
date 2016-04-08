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
class TmallProductSpecAddRequest
{
	private $barcode;
	private $certifiedPicStr;
	private $image;
	private $productId;
	private $specProps;
	private $specPropsAlias;
	private $apiParas = array();
	public function setBarcode($barcode)
	{
		$this->barcode = $barcode;
		$this->apiParas["barcode"] = $barcode;
	}
	public function getBarcode()
	{
		return $this->barcode;
	}
	public function setCertifiedPicStr($certifiedPicStr)
	{
		$this->certifiedPicStr = $certifiedPicStr;
		$this->apiParas["certified_pic_str"] = $certifiedPicStr;
	}
	public function getCertifiedPicStr()
	{
		return $this->certifiedPicStr;
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
	public function setProductId($productId)
	{
		$this->productId = $productId;
		$this->apiParas["product_id"] = $productId;
	}
	public function getProductId()
	{
		return $this->productId;
	}
	public function setSpecProps($specProps)
	{
		$this->specProps = $specProps;
		$this->apiParas["spec_props"] = $specProps;
	}
	public function getSpecProps()
	{
		return $this->specProps;
	}
	public function setSpecPropsAlias($specPropsAlias)
	{
		$this->specPropsAlias = $specPropsAlias;
		$this->apiParas["spec_props_alias"] = $specPropsAlias;
	}
	public function getSpecPropsAlias()
	{
		return $this->specPropsAlias;
	}
	public function getApiMethodName()
	{
		return "tmall.product.spec.add";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->barcode,"barcode");
		RequestCheckUtil::checkNotNull($this->image,"image");
		RequestCheckUtil::checkNotNull($this->productId,"productId");
		RequestCheckUtil::checkNotNull($this->specProps,"specProps");
		RequestCheckUtil::checkMaxLength($this->specPropsAlias,60,"specPropsAlias");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>