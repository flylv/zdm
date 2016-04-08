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
class TaobaokeItemsRelateGetRequest
{
	private $cid;
	private $fields;
	private $isMobile;
	private $maxCount;
	private $nick;
	private $numIid;
	private $outerCode;
	private $pid;
	private $relateType;
	private $sellerId;
	private $shopType;
	private $sort;
	private $trackIid;
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
	public function setFields($fields)
	{
		$this->fields = $fields;
		$this->apiParas["fields"] = $fields;
	}
	public function getFields()
	{
		return $this->fields;
	}
	public function setIsMobile($isMobile)
	{
		$this->isMobile = $isMobile;
		$this->apiParas["is_mobile"] = $isMobile;
	}
	public function getIsMobile()
	{
		return $this->isMobile;
	}
	public function setMaxCount($maxCount)
	{
		$this->maxCount = $maxCount;
		$this->apiParas["max_count"] = $maxCount;
	}
	public function getMaxCount()
	{
		return $this->maxCount;
	}
	public function setNick($nick)
	{
		$this->nick = $nick;
		$this->apiParas["nick"] = $nick;
	}
	public function getNick()
	{
		return $this->nick;
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
	public function setOuterCode($outerCode)
	{
		$this->outerCode = $outerCode;
		$this->apiParas["outer_code"] = $outerCode;
	}
	public function getOuterCode()
	{
		return $this->outerCode;
	}
	public function setPid($pid)
	{
		$this->pid = $pid;
		$this->apiParas["pid"] = $pid;
	}
	public function getPid()
	{
		return $this->pid;
	}
	public function setRelateType($relateType)
	{
		$this->relateType = $relateType;
		$this->apiParas["relate_type"] = $relateType;
	}
	public function getRelateType()
	{
		return $this->relateType;
	}
	public function setSellerId($sellerId)
	{
		$this->sellerId = $sellerId;
		$this->apiParas["seller_id"] = $sellerId;
	}
	public function getSellerId()
	{
		return $this->sellerId;
	}
	public function setShopType($shopType)
	{
		$this->shopType = $shopType;
		$this->apiParas["shop_type"] = $shopType;
	}
	public function getShopType()
	{
		return $this->shopType;
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
	public function setTrackIid($trackIid)
	{
		$this->trackIid = $trackIid;
		$this->apiParas["track_iid"] = $trackIid;
	}
	public function getTrackIid()
	{
		return $this->trackIid;
	}
	public function getApiMethodName()
	{
		return "taobao.taobaoke.items.relate.get";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->fields,"fields");
		RequestCheckUtil::checkNotNull($this->relateType,"relateType");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>