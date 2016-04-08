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
class ItemsSearchRequest
{
	private $auctionFlag;
	private $autoPost;
	private $cid;
	private $endPrice;
	private $endScore;
	private $endVolume;
	private $fields;
	private $genuineSecurity;
	private $hasDiscount;
	private $is3D;
	private $isCod;
	private $isMall;
	private $isPrepay;
	private $locationCity;
	private $locationState;
	private $nicks;
	private $oneStation;
	private $orderBy;
	private $pageNo;
	private $pageSize;
	private $postFree;
	private $productId;
	private $promotedService;
	private $props;
	private $q;
	private $startPrice;
	private $startScore;
	private $startVolume;
	private $stuffStatus;
	private $wwStatus;
	private $apiParas = array();
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
	}
	public function setAuctionFlag($auctionFlag)
	{
		$this->auctionFlag = $auctionFlag;
		$this->apiParas["auction_flag"] = $auctionFlag;
	}
	public function getAuctionFlag()
	{
		return $this->auctionFlag;
	}
	public function setAutoPost($autoPost)
	{
		$this->autoPost = $autoPost;
		$this->apiParas["auto_post"] = $autoPost;
	}
	public function getAutoPost()
	{
		return $this->autoPost;
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
	public function setEndPrice($endPrice)
	{
		$this->endPrice = $endPrice;
		$this->apiParas["end_price"] = $endPrice;
	}
	public function getEndPrice()
	{
		return $this->endPrice;
	}
	public function setEndScore($endScore)
	{
		$this->endScore = $endScore;
		$this->apiParas["end_score"] = $endScore;
	}
	public function getEndScore()
	{
		return $this->endScore;
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
	public function setGenuineSecurity($genuineSecurity)
	{
		$this->genuineSecurity = $genuineSecurity;
		$this->apiParas["genuine_security"] = $genuineSecurity;
	}
	public function getGenuineSecurity()
	{
		return $this->genuineSecurity;
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
	public function setIs3D($is3D)
	{
		$this->is3D = $is3D;
		$this->apiParas["is_3D"] = $is3D;
	}
	public function getIs3D()
	{
		return $this->is3D;
	}
	public function setIsCod($isCod)
	{
		$this->isCod = $isCod;
		$this->apiParas["is_cod"] = $isCod;
	}
	public function getIsCod()
	{
		return $this->isCod;
	}
	public function setIsMall($isMall)
	{
		$this->isMall = $isMall;
		$this->apiParas["is_mall"] = $isMall;
	}
	public function getIsMall()
	{
		return $this->isMall;
	}
	public function setIsPrepay($isPrepay)
	{
		$this->isPrepay = $isPrepay;
		$this->apiParas["is_prepay"] = $isPrepay;
	}
	public function getIsPrepay()
	{
		return $this->isPrepay;
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
	public function setNicks($nicks)
	{
		$this->nicks = $nicks;
		$this->apiParas["nicks"] = $nicks;
	}
	public function getNicks()
	{
		return $this->nicks;
	}
	public function setOneStation($oneStation)
	{
		$this->oneStation = $oneStation;
		$this->apiParas["one_station"] = $oneStation;
	}
	public function getOneStation()
	{
		return $this->oneStation;
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
	public function setPostFree($postFree)
	{
		$this->postFree = $postFree;
		$this->apiParas["post_free"] = $postFree;
	}
	public function getPostFree()
	{
		return $this->postFree;
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
	public function setPromotedService($promotedService)
	{
		$this->promotedService = $promotedService;
		$this->apiParas["promoted_service"] = $promotedService;
	}
	public function getPromotedService()
	{
		return $this->promotedService;
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
	public function setQ($q)
	{
		$this->q = $q;
		$this->apiParas["q"] = $q;
	}
	public function getQ()
	{
		return $this->q;
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
	public function setStartScore($startScore)
	{
		$this->startScore = $startScore;
		$this->apiParas["start_score"] = $startScore;
	}
	public function getStartScore()
	{
		return $this->startScore;
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
	public function setStuffStatus($stuffStatus)
	{
		$this->stuffStatus = $stuffStatus;
		$this->apiParas["stuff_status"] = $stuffStatus;
	}
	public function getStuffStatus()
	{
		return $this->stuffStatus;
	}
	public function setWwStatus($wwStatus)
	{
		$this->wwStatus = $wwStatus;
		$this->apiParas["ww_status"] = $wwStatus;
	}
	public function getWwStatus()
	{
		return $this->wwStatus;
	}
	public function getApiMethodName()
	{
		return "taobao.items.search";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
}
?>