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
class ProductPropimgUploadRequest
{
	private $id;
	private $image;
	private $position;
	private $productId;
	private $props;
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
	public function setImage($image)
	{
		$this->image = $image;
		$this->apiParas["image"] = $image;
	}
	public function getImage()
	{
		return $this->image;
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
	public function setProductId($productId)
	{
		$this->productId = $productId;
		$this->apiParas["product_id"] = $productId;
	}
	public function getProductId()
	{
		return $this->productId;
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
	public function getApiMethodName()
	{
		return "taobao.product.propimg.upload";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->image,"image");
		RequestCheckUtil::checkNotNull($this->productId,"productId");
		RequestCheckUtil::checkNotNull($this->props,"props");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>