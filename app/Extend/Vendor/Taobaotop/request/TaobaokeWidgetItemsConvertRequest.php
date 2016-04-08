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
class TaobaokeWidgetItemsConvertRequest
{
	private $fields;
	private $isMobile;
	private $numIids;
	private $outerCode;
	private $trackIids;
	private $apiParas = array();
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
	public function setNumIids($numIids)
	{
		$this->numIids = $numIids;
		$this->apiParas["num_iids"] = $numIids;
	}
	public function getNumIids()
	{
		return $this->numIids;
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
	public function setTrackIids($trackIids)
	{
		$this->trackIids = $trackIids;
		$this->apiParas["track_iids"] = $trackIids;
	}
	public function getTrackIids()
	{
		return $this->trackIids;
	}
	public function getApiMethodName()
	{
		return "taobao.taobaoke.widget.items.convert";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->fields,"fields");
		RequestCheckUtil::checkMaxListSize($this->numIids,50,"numIids");
		RequestCheckUtil::checkMaxListSize($this->trackIids,50,"trackIids");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>