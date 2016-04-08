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
class ItemcatsIncrementGetRequest
{
	private $cids;
	private $days;
	private $type;
	private $apiParas = array();
	public function setCids($cids)
	{
		$this->cids = $cids;
		$this->apiParas["cids"] = $cids;
	}
	public function getCids()
	{
		return $this->cids;
	}
	public function setDays($days)
	{
		$this->days = $days;
		$this->apiParas["days"] = $days;
	}
	public function getDays()
	{
		return $this->days;
	}
	public function setType($type)
	{
		$this->type = $type;
		$this->apiParas["type"] = $type;
	}
	public function getType()
	{
		return $this->type;
	}
	public function getApiMethodName()
	{
		return "taobao.itemcats.increment.get";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->cids,"cids");
		RequestCheckUtil::checkMaxListSize($this->cids,1000,"cids");
		RequestCheckUtil::checkMaxValue($this->days,7,"days");
		RequestCheckUtil::checkMinValue($this->days,1,"days");
		RequestCheckUtil::checkMaxValue($this->type,2,"type");
		RequestCheckUtil::checkMinValue($this->type,1,"type");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>