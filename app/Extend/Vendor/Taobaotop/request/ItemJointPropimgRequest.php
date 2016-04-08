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
class ItemJointPropimgRequest
{
	private $id;
	private $numIid;
	private $picPath;
	private $position;
	private $properties;
	private $apiParas = array();
	public function setId($id)
	{
		$this->id = $id;
		$this->apiParas["id"] = $id;
	}
	public function getId()
	{
		return $this->id;
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
	public function setPicPath($picPath)
	{
		$this->picPath = $picPath;
		$this->apiParas["pic_path"] = $picPath;
	}
	public function getPicPath()
	{
		return $this->picPath;
	}
	public function setPosition($position)
	{
		$this->position = $position;
		$this->apiParas["position"] = $position;
	}
	public function getPosition()
	{
		return $this->position;
	}
	public function setProperties($properties)
	{
		$this->properties = $properties;
		$this->apiParas["properties"] = $properties;
	}
	public function getProperties()
	{
		return $this->properties;
	}
	public function getApiMethodName()
	{
		return "taobao.item.joint.propimg";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->numIid,"numIid");
		RequestCheckUtil::checkMinValue($this->numIid,0,"numIid");
		RequestCheckUtil::checkNotNull($this->picPath,"picPath");
		RequestCheckUtil::checkNotNull($this->properties,"properties");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>