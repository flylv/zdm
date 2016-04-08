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
class ItemPriceUpdateRequest
{
	private $afterSaleId;
	private $approveStatus;
	private $auctionPoint;
	private $autoFill;
	private $cid;
	private $codPostageId;
	private $desc;
	private $emsFee;
	private $expressFee;
	private $freightPayer;
	private $hasDiscount;
	private $hasInvoice;
	private $hasShowcase;
	private $hasWarranty;
	private $image;
	private $increment;
	private $inputPids;
	private $inputStr;
	private $is3D;
	private $isEx;
	private $isLightningConsignment;
	private $isReplaceSku;
	private $isTaobao;
	private $isXinpin;
	private $lang;
	private $listTime;
	private $locationCity;
	private $locationState;
	private $num;
	private $numIid;
	private $outerId;
	private $picPath;
	private $postFee;
	private $postageId;
	private $price;
	private $productId;
	private $propertyAlias;
	private $props;
	private $sellPromise;
	private $sellerCids;
	private $skuOuterIds;
	private $skuPrices;
	private $skuProperties;
	private $skuQuantities;
	private $stuffStatus;
	private $subStock;
	private $title;
	private $validThru;
	private $weight;
	private $apiParas = array();
	public function setAfterSaleId($afterSaleId)
	{
		$this->afterSaleId = $afterSaleId;
		$this->apiParas["after_sale_id"] = $afterSaleId;
	}
	public function getAfterSaleId()
	{
		return $this->afterSaleId;
	}
	public function setApproveStatus($approveStatus)
	{
		$this->approveStatus = $approveStatus;
		$this->apiParas["approve_status"] = $approveStatus;
	}
	public function getApproveStatus()
	{
		return $this->approveStatus;
	}
	public function setAuctionPoint($auctionPoint)
	{
		$this->auctionPoint = $auctionPoint;
		$this->apiParas["auction_point"] = $auctionPoint;
	}
	public function getAuctionPoint()
	{
		return $this->auctionPoint;
	}
	public function setAutoFill($autoFill)
	{
		$this->autoFill = $autoFill;
		$this->apiParas["auto_fill"] = $autoFill;
	}
	public function getAutoFill()
	{
		return $this->autoFill;
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
	public function setCodPostageId($codPostageId)
	{
		$this->codPostageId = $codPostageId;
		$this->apiParas["cod_postage_id"] = $codPostageId;
	}
	public function getCodPostageId()
	{
		return $this->codPostageId;
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
	public function setEmsFee($emsFee)
	{
		$this->emsFee = $emsFee;
		$this->apiParas["ems_fee"] = $emsFee;
	}
	public function getEmsFee()
	{
		return $this->emsFee;
	}
	public function setExpressFee($expressFee)
	{
		$this->expressFee = $expressFee;
		$this->apiParas["express_fee"] = $expressFee;
	}
	public function getExpressFee()
	{
		return $this->expressFee;
	}
	public function setFreightPayer($freightPayer)
	{
		$this->freightPayer = $freightPayer;
		$this->apiParas["freight_payer"] = $freightPayer;
	}
	public function getFreightPayer()
	{
		return $this->freightPayer;
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
	public function setHasInvoice($hasInvoice)
	{
		$this->hasInvoice = $hasInvoice;
		$this->apiParas["has_invoice"] = $hasInvoice;
	}
	public function getHasInvoice()
	{
		return $this->hasInvoice;
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
	public function setHasWarranty($hasWarranty)
	{
		$this->hasWarranty = $hasWarranty;
		$this->apiParas["has_warranty"] = $hasWarranty;
	}
	public function getHasWarranty()
	{
		return $this->hasWarranty;
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
	public function setIncrement($increment)
	{
		$this->increment = $increment;
		$this->apiParas["increment"] = $increment;
	}
	public function getIncrement()
	{
		return $this->increment;
	}
	public function setInputPids($inputPids)
	{
		$this->inputPids = $inputPids;
		$this->apiParas["input_pids"] = $inputPids;
	}
	public function getInputPids()
	{
		return $this->inputPids;
	}
	public function setInputStr($inputStr)
	{
		$this->inputStr = $inputStr;
		$this->apiParas["input_str"] = $inputStr;
	}
	public function getInputStr()
	{
		return $this->inputStr;
	}
	public function setIs3D($is3D)
	{
		$this->is3D = $is3D;
		$this->apiParas["is_3D"] = $is3D;
	}
	public function getIs3D()
	{
		return $this->is3D;
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
	public function setIsLightningConsignment($isLightningConsignment)
	{
		$this->isLightningConsignment = $isLightningConsignment;
		$this->apiParas["is_lightning_consignment"] = $isLightningConsignment;
	}
	public function getIsLightningConsignment()
	{
		return $this->isLightningConsignment;
	}
	public function setIsReplaceSku($isReplaceSku)
	{
		$this->isReplaceSku = $isReplaceSku;
		$this->apiParas["is_replace_sku"] = $isReplaceSku;
	}
	public function getIsReplaceSku()
	{
		return $this->isReplaceSku;
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
	public function setIsXinpin($isXinpin)
	{
		$this->isXinpin = $isXinpin;
		$this->apiParas["is_xinpin"] = $isXinpin;
	}
	public function getIsXinpin()
	{
		return $this->isXinpin;
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
	public function setListTime($listTime)
	{
		$this->listTime = $listTime;
		$this->apiParas["list_time"] = $listTime;
	}
	public function getListTime()
	{
		return $this->listTime;
	}
	public function setLocationCity($locationCity)
	{
		$this->locationCity = $locationCity;
		$this->apiParas["location.city"] = $locationCity;
	}
	public function getLocationCity()
	{
		return $this->locationCity;
	}
	public function setLocationState($locationState)
	{
		$this->locationState = $locationState;
		$this->apiParas["location.state"] = $locationState;
	}
	public function getLocationState()
	{
		return $this->locationState;
	}
	public function setNum($num)
	{
		$this->num = $num;
		$this->apiParas["num"] = $num;
	}
	public function getNum()
	{
		return $this->num;
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
	public function setPicPath($picPath)
	{
		$this->picPath = $picPath;
		$this->apiParas["pic_path"] = $picPath;
	}
	public function getPicPath()
	{
		return $this->picPath;
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
	public function setPostageId($postageId)
	{
		$this->postageId = $postageId;
		$this->apiParas["postage_id"] = $postageId;
	}
	public function getPostageId()
	{
		return $this->postageId;
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
	public function setPropertyAlias($propertyAlias)
	{
		$this->propertyAlias = $propertyAlias;
		$this->apiParas["property_alias"] = $propertyAlias;
	}
	public function getPropertyAlias()
	{
		return $this->propertyAlias;
	}
	public function setProps($props)
	{
		$this->props = $props;
		$this->apiParas["props"] = $props;
	}
	public function getProps()
	{
		return $this->props;
	}
	public function setSellPromise($sellPromise)
	{
		$this->sellPromise = $sellPromise;
		$this->apiParas["sell_promise"] = $sellPromise;
	}
	public function getSellPromise()
	{
		return $this->sellPromise;
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
	public function setSkuOuterIds($skuOuterIds)
	{
		$this->skuOuterIds = $skuOuterIds;
		$this->apiParas["sku_outer_ids"] = $skuOuterIds;
	}
	public function getSkuOuterIds()
	{
		return $this->skuOuterIds;
	}
	public function setSkuPrices($skuPrices)
	{
		$this->skuPrices = $skuPrices;
		$this->apiParas["sku_prices"] = $skuPrices;
	}
	public function getSkuPrices()
	{
		return $this->skuPrices;
	}
	public function setSkuProperties($skuProperties)
	{
		$this->skuProperties = $skuProperties;
		$this->apiParas["sku_properties"] = $skuProperties;
	}
	public function getSkuProperties()
	{
		return $this->skuProperties;
	}
	public function setSkuQuantities($skuQuantities)
	{
		$this->skuQuantities = $skuQuantities;
		$this->apiParas["sku_quantities"] = $skuQuantities;
	}
	public function getSkuQuantities()
	{
		return $this->skuQuantities;
	}
	public function setStuffStatus($stuffStatus)
	{
		$this->stuffStatus = $stuffStatus;
		$this->apiParas["stuff_status"] = $stuffStatus;
	}
	public function getStuffStatus()
	{
		return $this->stuffStatus;
	}
	public function setSubStock($subStock)
	{
		$this->subStock = $subStock;
		$this->apiParas["sub_stock"] = $subStock;
	}
	public function getSubStock()
	{
		return $this->subStock;
	}
	public function setTitle($title)
	{
		$this->title = $title;
		$this->apiParas["title"] = $title;
	}
	public function getTitle()
	{
		return $this->title;
	}
	public function setValidThru($validThru)
	{
		$this->validThru = $validThru;
		$this->apiParas["valid_thru"] = $validThru;
	}
	public function getValidThru()
	{
		return $this->validThru;
	}
	public function setWeight($weight)
	{
		$this->weight = $weight;
		$this->apiParas["weight"] = $weight;
	}
	public function getWeight()
	{
		return $this->weight;
	}
	public function getApiMethodName()
	{
		return "taobao.item.price.update";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkMinValue($this->cid,0,"cid");
		RequestCheckUtil::checkMaxLength($this->desc,200000,"desc");
		RequestCheckUtil::checkMaxValue($this->num,999999,"num");
		RequestCheckUtil::checkMinValue($this->num,0,"num");
		RequestCheckUtil::checkNotNull($this->numIid,"numIid");
		RequestCheckUtil::checkMinValue($this->numIid,1,"numIid");
		RequestCheckUtil::checkMaxListSize($this->sellerCids,10,"sellerCids");
		RequestCheckUtil::checkMaxLength($this->title,60,"title");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>