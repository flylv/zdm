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
class LtLogger
{
	public $conf = array(
		"separator" => "\t",
		"log_file" => ""
		);
		private $fileHandle;
		protected function getFileHandle()
		{
			if (null === $this->fileHandle)
			{
				if (empty($this->conf["log_file"]))
				{
					trigger_error("no log file spcified.");
				}
				$logDir = dirname($this->conf["log_file"]);
				if (!is_dir($logDir))
				{
					mkdir($logDir, 0777, true);
				}
				$this->fileHandle = fopen($this->conf["log_file"], "a");
			}
			return $this->fileHandle;
		}
		public function log($logData)
		{
			if ("" == $logData || array() == $logData)
			{
				return false;
			}
			if (is_array($logData))
			{
				$logData = implode($this->conf["separator"], $logData);
			}
			$logData = $logData. "\n";
			fwrite($this->getFileHandle(), $logData);
		}
}