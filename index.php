<?php 
/**
* ZhePHP 值得买模式的海淘网站程序
* ====================================================================
* www.admin.cn  QQ:677123
* ====================================================================
*/
if (!is_file('./data/install.lock')) {
    header('Location: ./install.php');
    exit;
}
define('ZHI_VERSION','1.4');
define('ZHI_RELEASE','20140115133143');
define('APP_NAME', 'app');
define('APP_PATH', './app/'); 
define('ZHI_DATA_PATH', './data/');
define('EXTEND_PATH', APP_PATH . 'Extend/');
define('CONF_PATH', ZHI_DATA_PATH . 'config/');
define('RUNTIME_PATH', ZHI_DATA_PATH . 'runtime/');
define('HTML_PATH', RUNTIME_PATH . 'html/');
require("./core/setup.php");