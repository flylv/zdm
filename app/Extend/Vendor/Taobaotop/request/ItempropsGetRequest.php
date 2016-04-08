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
class ItempropsGetRequest
{
	private $childPath;
	private $cid;
	private $fields;
	private $isColorProp;
	private $isEnumProp;
	private $isInputProp;
	private $isItemProp;
	private $isKeyProp;
	private $isSaleProp;
	private $parentPid;
	private $pid;
	private $type;
	private $apiParas = array();
	public function setChildPath($childPath)
	{
		$this->childPath = $childPath;
		$this->apiParas["child_path"] = $childPath;
	}
	public function getChildPath()
	{
		return $this->childPath;
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
	public function setFields($fields)
	{
		$this->fields = $fields;
		$this->apiParas["fields"] = $fields;
	}
	public function getFields()
	{
		return $this->fields;
	}
	public function setIsColorProp($isColorProp)
	{
		$this->isColorProp = $isColorProp;
		$this->apiParas["is_color_prop"] = $isColorProp;
	}
	public function getIsColorProp()
	{
		return $this->isColorProp;
	}
	public function setIsEnumProp($isEnumProp)
	{
		$this->isEnumProp = $isEnumProp;
		$this->apiParas["is_enum_prop"] = $isEnumProp;
	}
	public function getIsEnumProp()
	{
		return $this->isEnumProp;
	}
	public function setIsInputProp($isInputProp)
	{
		$this->isInputProp = $isInputProp;
		$this->apiParas["is_input_prop"] = $isInputProp;
	}
	public function getIsInputProp()
	{
		return $this->isInputProp;
	}
	public function setIsItemProp($isItemProp)
	{
		$this->isItemProp = $isItemProp;
		$this->apiParas["is_item_prop"] = $isItemProp;
	}
	public function getIsItemProp()
	{
		return $this->isItemProp;
	}
	public function setIsKeyProp($isKeyProp)
	{
		$this->isKeyProp = $isKeyProp;
		$this->apiParas["is_key_prop"] = $isKeyProp;
	}
	public function getIsKeyProp()
	{
		return $this->isKeyProp;
	}
	public function setIsSaleProp($isSaleProp)
	{
		$this->isSaleProp = $isSaleProp;
		$this->apiParas["is_sale_prop"] = $isSaleProp;
	}
	public function getIsSaleProp()
	{
		return $this->isSaleProp;
	}
	public function setParentPid($parentPid)
	{
		$this->parentPid = $parentPid;
		$this->apiParas["parent_pid"] = $parentPid;
	}
	public function getParentPid()
	{
		return $this->parentPid;
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
		return "taobao.itemprops.get";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->cid,"cid");
		RequestCheckUtil::checkMaxValue($this->type,2,"type");
		RequestCheckUtil::checkMinValue($this->type,1,"type");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>