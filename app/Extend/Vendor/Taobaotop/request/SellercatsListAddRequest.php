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
class SellercatsListAddRequest
{
	private $name;
	private $parentCid;
	private $pictUrl;
	private $sortOrder;
	private $apiParas = array();
	public function setName($name)
	{
		$this->name = $name;
		$this->apiParas["name"] = $name;
	}
	public function getName()
	{
		return $this->name;
	}
	public function setParentCid($parentCid)
	{
		$this->parentCid = $parentCid;
		$this->apiParas["parent_cid"] = $parentCid;
	}
	public function getParentCid()
	{
		return $this->parentCid;
	}
	public function setPictUrl($pictUrl)
	{
		$this->pictUrl = $pictUrl;
		$this->apiParas["pict_url"] = $pictUrl;
	}
	public function getPictUrl()
	{
		return $this->pictUrl;
	}
	public function setSortOrder($sortOrder)
	{
		$this->sortOrder = $sortOrder;
		$this->apiParas["sort_order"] = $sortOrder;
	}
	public function getSortOrder()
	{
		return $this->sortOrder;
	}
	public function getApiMethodName()
	{
		return "taobao.sellercats.list.add";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->name,"name");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>