<?php 
/**
* ZhePHP 值得买模式的海淘网站程序
* ====================================================================
* ====================================================================
*/
if (is_file('./data/install.lock')) {
    header('Location: ./');
    exit;
}
define('APP_NAME', 'install');
define('APP_PATH', './install/');
define('APP_DEBUG', true);
require("./core/setup.php");