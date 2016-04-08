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
class TopatsSimbaCampkeywordeffectGetRequest
{
	private $campaignId;
	private $nick;
	private $searchType;
	private $source;
	private $timeSlot;
	private $apiParas = array();
	public function setCampaignId($campaignId)
	{
		$this->campaignId = $campaignId;
		$this->apiParas["campaign_id"] = $campaignId;
	}
	public function getCampaignId()
	{
		return $this->campaignId;
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
	public function setSearchType($searchType)
	{
		$this->searchType = $searchType;
		$this->apiParas["search_type"] = $searchType;
	}
	public function getSearchType()
	{
		return $this->searchType;
	}
	public function setSource($source)
	{
		$this->source = $source;
		$this->apiParas["source"] = $source;
	}
	public function getSource()
	{
		return $this->source;
	}
	public function setTimeSlot($timeSlot)
	{
		$this->timeSlot = $timeSlot;
		$this->apiParas["time_slot"] = $timeSlot;
	}
	public function getTimeSlot()
	{
		return $this->timeSlot;
	}
	public function getApiMethodName()
	{
		return "taobao.topats.simba.campkeywordeffect.get";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->campaignId,"campaignId");
		RequestCheckUtil::checkNotNull($this->searchType,"searchType");
		RequestCheckUtil::checkNotNull($this->source,"source");
		RequestCheckUtil::checkNotNull($this->timeSlot,"timeSlot");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>