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
class SkusQuantityUpdateRequest
{
	private $numIid;
	private $outeridQuantities;
	private $skuidQuantities;
	private $type;
	private $apiParas = array();
	public function setNumIid($numIid)
	{
		$this->numIid = $numIid;
		$this->apiParas["num_iid"] = $numIid;
	}
	public function getNumIid()
	{
		return $this->numIid;
	}
	public function setOuteridQuantities($outeridQuantities)
	{
		$this->outeridQuantities = $outeridQuantities;
		$this->apiParas["outerid_quantities"] = $outeridQuantities;
	}
	public function getOuteridQuantities()
	{
		return $this->outeridQuantities;
	}
	public function setSkuidQuantities($skuidQuantities)
	{
		$this->skuidQuantities = $skuidQuantities;
		$this->apiParas["skuid_quantities"] = $skuidQuantities;
	}
	public function getSkuidQuantities()
	{
		return $this->skuidQuantities;
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
		return "taobao.skus.quantity.update";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->numIid,"numIid");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>