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
class TopClient
{
	public $appkey;
	public $secretKey;
	public $gatewayUrl = "http://gw.api.taobao.com/router/rest";
	public $format = "xml";
	public $checkRequest = true;
	protected $signMethod = "md5";
	protected $apiVersion = "2.0";
	protected $sdkVersion = "top-sdk-php-20131118";
	protected function generateSign($params)
	{
		ksort($params);
		$stringToBeSigned = $this->secretKey;
		foreach ($params as $k => $v)
		{
			if("@" != substr($v, 0, 1))
			{
				$stringToBeSigned .= "$k$v";
			}
		}
		unset($k, $v);
		$stringToBeSigned .= $this->secretKey;
		return strtoupper(md5($stringToBeSigned));
	}
	public function curl($url, $postFields = null)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}
		if (is_array($postFields) && 0 < count($postFields))
		{
			$postBodyString = "";
			$postMultipart = false;
			foreach ($postFields as $k => $v)
			{
				if("@" != substr($v, 0, 1))
				{
					$postBodyString .= "$k=" . urlencode($v) . "&"; 
				}
				else
				{
					$postMultipart = true;
				}
			}
			unset($k, $v);
			curl_setopt($ch, CURLOPT_POST, true);
			if ($postMultipart)
			{
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
			}
			else
			{
				curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
			}
		}
		$reponse = curl_exec($ch);
		if (curl_errno($ch))
		{
			throw new Exception(curl_error($ch),0);
		}
		else
		{
			$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if (200 !== $httpStatusCode)
			{
				throw new Exception($reponse,$httpStatusCode);
			}
		}
		curl_close($ch);
		return $reponse;
	}
	protected function logCommunicationError($apiName, $requestUrl, $errorCode, $responseTxt)
	{
		$localIp = isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : "CLI";
		$logger = new LtLogger;
		$logger->conf["log_file"] = LOG_PATH . "taobao/top_comm_err_" . $this->appkey . "_" . date("Y-m-d") . ".log";
		$logger->conf["separator"] = "^_^";
		$logData = array(
    		date("Y-m-d H:i:s"),
    		$apiName,
    		$this->appkey,
    		$localIp,
    		PHP_OS,
    		$this->sdkVersion,
    		$requestUrl,
    		$errorCode,
    		str_replace("\n","",$responseTxt)
		);
		$logger->log($logData);
	}
	public function execute($request, $session = null)
	{
		if($this->checkRequest) {
			try {
				$request->check();
			} catch (Exception $e) {
				$result->code = $e->getCode();
				$result->msg = $e->getMessage();
				return $result;
			}
		}
		$sysParams["app_key"] = $this->appkey;
		$sysParams["v"] = $this->apiVersion;
		$sysParams["format"] = $this->format;
		$sysParams["sign_method"] = $this->signMethod;
		$sysParams["method"] = $request->getApiMethodName();
		$sysParams["timestamp"] = date("Y-m-d H:i:s");
		$sysParams["partner_id"] = $this->sdkVersion;
		if (null != $session)
		{
			$sysParams["session"] = $session;
		}
		$apiParams = $request->getApiParas();
		$sysParams["sign"] = $this->generateSign(array_merge($apiParams, $sysParams));
		$requestUrl = $this->gatewayUrl . "?";
		foreach ($sysParams as $sysParamKey => $sysParamValue)
		{
			$requestUrl .= "$sysParamKey=" . urlencode($sysParamValue) . "&";
		}
		$requestUrl = substr($requestUrl, 0, -1);
		try
		{
			$resp = $this->curl($requestUrl, $apiParams);
		}
		catch (Exception $e)
		{
			$this->logCommunicationError($sysParams["method"],$requestUrl,"HTTP_ERROR_" . $e->getCode(),$e->getMessage());
			$result->code = $e->getCode();
			$result->msg = $e->getMessage();            
			return $result;
		}
		$respWellFormed = false;
		if ("json" == $this->format)
		{
			$respObject = json_decode($resp);
			if (null !== $respObject)
			{
				$respWellFormed = true;
				foreach ($respObject as $propKey => $propValue)
				{
					$respObject = $propValue;
				}
			}
		}
		else if("xml" == $this->format)
		{
			$respObject = @simplexml_load_string($resp);
			if (false !== $respObject)
			{
				$respWellFormed = true;
			}
		}
		if (false === $respWellFormed)
		{
			$this->logCommunicationError($sysParams["method"],$requestUrl,"HTTP_RESPONSE_NOT_WELL_FORMED",$resp);
			$result->code = 0;
			$result->msg = "HTTP_RESPONSE_NOT_WELL_FORMED";
			return $result;
		}
		if (isset($respObject->code))
		{
			$logger = new LtLogger;
			$logger->conf["log_file"] = LOG_PATH . "taobao/top_biz_err_" . $this->appkey . "_" . date("Y-m-d") . ".log";
			$logger->log(array(
				date("Y-m-d H:i:s"),
				$resp
			));
		}
		return $respObject;
	}
	public function exec($paramsArray)
	{
		if (!isset($paramsArray["method"]))
		{
			trigger_error("No api name passed");
		}
		$inflector = new Inflector;
		$inflector->conf["separator"] = ".";
		$requestClassName = ucfirst($inflector->camelize(substr($paramsArray["method"], 7))) . "Request";
		if (!class_exists($requestClassName))
		{
			trigger_error("No such api: " . $paramsArray["method"]);
		}
		$session = isset($paramsArray["session"]) ? $paramsArray["session"] : null;
		$req = new $requestClassName;
		foreach($paramsArray as $paraKey => $paraValue)
		{
			$inflector->conf["separator"] = "_";
			$setterMethodName = $inflector->camelize($paraKey);
			$inflector->conf["separator"] = ".";
			$setterMethodName = "set" . $inflector->camelize($setterMethodName);
			if (method_exists($req, $setterMethodName))
			{
				$req->$setterMethodName($paraValue);
			}
		}
		return $this->execute($req, $session);
	}
	public function load_api($api_name)
	{
		Vendor('Taobaotop.request.'.$api_name);
		return new $api_name;
	}
}