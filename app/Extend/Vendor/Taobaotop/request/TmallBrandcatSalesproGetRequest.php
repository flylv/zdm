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
class TmallBrandcatSalesproGetRequest
{
	private $brandId;
	private $catId;
	private $apiParas = array();
	public function setBrandId($brandId)
	{
		$this->brandId = $brandId;
		$this->apiParas["brand_id"] = $brandId;
	}
	public function getBrandId()
	{
		return $this->brandId;
	}
	public function setCatId($catId)
	{
		$this->catId = $catId;
		$this->apiParas["cat_id"] = $catId;
	}
	public function getCatId()
	{
		return $this->catId;
	}
	public function getApiMethodName()
	{
		return "tmall.brandcat.salespro.get";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->brandId,"brandId");
		RequestCheckUtil::checkNotNull($this->catId,"catId");
	}
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
?>