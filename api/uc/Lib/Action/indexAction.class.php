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
define('UC_CLIENT_VERSION', '1.6.0');
define('UC_CLIENT_RELEASE', '20110501');
define('API_DELETEUSER', 1);
define('API_RENAMEUSER', 1);
define('API_GETTAG', 1);
define('API_SYNLOGIN', 1);
define('API_SYNLOGOUT', 1);
define('API_UPDATEPW', 1);
define('API_UPDATEBADWORDS', 1);
define('API_UPDATEHOSTS', 1);
define('API_UPDATEAPPS', 1);
define('API_UPDATECLIENT', 1);
define('API_UPDATECREDIT', 1);
define('API_GETCREDIT', 1);
define('API_GETCREDITSETTINGS', 1);
define('API_UPDATECREDITSETTINGS', 1);
define('API_ADDFEED', 1);
define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '1');
define('IN_API', true);
define('CURSCRIPT', 'api');
class indexAction extends Action {
    public function _initialize() {
        $integrate_config = D('setting')->where(array('name'=>'integrate_config'))->getField('data');
        $conf =unserialize($integrate_config);        
        eval($conf["uc_config"]);
        include_once APP_PATH . 'uc_client/client.php';
		include_once PINPHP_PATH . 'app/Lib/Model/baseModel.class.php';
        include_once PINPHP_PATH . 'app/Lib/Model/userModel.class.php';
        $this->_user_mod = D('user');
    }
    public function index() {
        $get = $post = array();                
        $code =@$_GET['code'];
        parse_str(uc_authcode($code, 'DECODE', UC_KEY), $get);
        $timestamp = time();
        if($timestamp - $get['time'] > 3600) {
            exit('Authentication has expiried');
        }
        if(empty($get)) {
            exit('Invalid Request');
        }
        $action = $get['action'];
        include_once APP_PATH . 'uc_client/lib/xml.class.php';
        $post = xml_unserialize(file_get_contents('php://input'));
        if(in_array($get['action'], array('test', 'deleteuser', 'renameuser', 'gettag', 'synlogin', 'synlogout', 'updatepw', 'updatebadwords', 'updatehosts', 'updateapps', 'updateclient', 'updatecredit', 'getcreditsettings', 'updatecreditsettings'))) {
            exit($this->$get['action']($get, $post));
        } else {
            exit(API_RETURN_FAILED);
        }
    }
    public function test($get, $post) {
        return API_RETURN_SUCCEED;
    }
    public function deleteuser($get, $post) {
        if (!API_DELETEUSER) {
            return API_RETURN_FORBIDDEN;
        }
        $this->_user_mod->delete($get['ids']);
        return API_RETURN_SUCCEED;
    }
    public function renameuser() {
        if(!API_RENAMEUSER) {
            return API_RETURN_FORBIDDEN;
        }
        $uc_uid = $get['uid'];
        $usernameold = $get['oldusername'];
        $usernamenew = $get['newusername'];
        if (!$this->_user_mod->rename(array('uc_uid'=>$uc_uid, 'username'=>$usernameold), $usernamenew)) {
            return API_RETURN_FAILED;
        }
        return API_RETURN_SUCCEED;
    }
    public function updatepw() {
        return API_RETURN_SUCCEED;
    }
    public function synlogin($get, $post) {
        if(!API_SYNLOGIN) {
            return API_RETURN_FORBIDDEN;
        }
        header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
        $username = trim($get['username']);
        $login_time = $get['time'];
        $user_info = $this->_user_mod->field('id,username')->where(array('username'=>$username))->find();
        if (!$user_info) {
            $uc_user = uc_get_user($username);
            $user_id = $this->_user_mod->add(array(
                'uc_uid' => $uc_user['uid'],
                'username' => $uc_user['username'],
                'password' => md5(time() . rand(100000, 999999)),
                'email' => $uc_user['email'],
            ));
            $user_info = array('id' => $user_id, 'username' => $username);
        }
        $this->_api_visitor()->assign_info($user_info);
        $this->_user_mod->where(array('id'=>$user_info['id']))->save(array(
            'last_time' => $login_time,
            'last_ip' => get_client_ip(),
        ));
        return API_RETURN_SUCCEED;
    }
    public function synlogout($get, $post) {
        header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
        $this->_api_visitor()->logout();
        return API_RETURN_SUCCEED;
    }
    public function updateapps($get, $post) {
        if (!API_UPDATEAPPS) {
            return API_RETURN_FORBIDDEN;
        }
        $UC_API = $post['UC_API'];
        $cachefile = APP_PATH.'uc_client/data/cache/apps.php';
        $fp = fopen($cachefile, 'w');
        $s = "<?php\r\n";
        $s .= '$_CACHE[\'apps\'] = '.var_export($post, TRUE).";\r\n";
        fwrite($fp, $s);
        fclose($fp);
        return API_RETURN_SUCCEED;
    }
    function updateclient($get, $post) {
        if (!API_UPDATECLIENT) {
            return API_RETURN_FORBIDDEN;
        }
        $cachefile = APP_PATH.'uc_client/data/cache/settings.php';
        $fp = fopen($cachefile, 'w');
        $s = "<?php\r\n";
        $s .= '$_CACHE[\'settings\'] = '.var_export($post, TRUE).";\r\n";
        fwrite($fp, $s);
        fclose($fp);
        return API_RETURN_SUCCEED;
    }
    private function _api_visitor() {
        include_once (PINPHP_PATH . 'app/Lib/Inslib/user_visitor.class.php');
        return new user_visitor();
    }
}