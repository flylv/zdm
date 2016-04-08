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
class FavoriteAddRequest
{
	private $collectType;
	private $itemNumid;
	private $shared;
	private $apiParas = array();
	public function setCollectType($collectType)
	{
		$this->collectType = $collectType;
		$this->apiParas["collect_type"] = $collectType;
	}
	public function getCollectType()
	{
		return $this->collectType;
	}
	public function setItemNumid($itemNumid)
	{
		$this->itemNumid = $itemNumid;
		$this->apiParas["item_numid"] = $itemNumid;
	}
	public function getItemNumid()
	{
		return $this->itemNumid;
	}
	public function setShared($shared)
	{
		$this->shared = $shared;
		$this->apiParas["shared"] = $shared;
	}
	public function getShared()
	{
		return $this->shared;
	}
	public function getApiMethodName()
	{
		return "taobao.favorite.add";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->collectType,"collectType");
		RequestCheckUtil::checkNotNull($this->itemNumid,"itemNumid");
		RequestCheckUtil::checkMinValue($this->itemNumid,1,"itemNumid");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>