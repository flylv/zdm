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
class oauth {
    private $_type = '';
    private $_setting = array();
    public function __construct($type) {
        $this->_type = $type;
        $setting = D('oauth')->where(array('code' => $type))->getField('config');
        $this->_setting = unserialize($setting);
        include_once LIB_PATH . 'Inslib/oauth/' . $type . '/' . $type . '.php';
        $om_class = $type . '_oauth';
        $this->_om = new $om_class($this->_setting);
    }
    public function authorize() {
        redirect($this->_om->getAuthorizeURL());
    }
    public function callbackLogin($request_args) {
		try{
            $user = $this->_om->getUserInfo($request_args);    
        }catch(Exception $e){
            header("Content-Type: text/html; charset=utf-8");
            exit("<script>alert('第三方登录权限有问题');window.location.href='" . u('user/login') . "';</script>");
        }     
        $bind_user = $this->_checkBind($this->_type, $user['keyid']);
        if ($bind_user) {
            $this->_updateBindInfo($user);
            $user_info = D('user')->field('id,username')->where(array('id' => $bind_user['uid']))->find();
            $this->_oauth_visitor()->assign_info($user_info);
            return U('user/index');
        } else {
            if (D('user')->where(array('username' => $user['keyname']))->count()) {
                $user['pin_user_name'] = $user['keyname'] . '_' . mt_rand(99, 9999);
            } else {
                $user['pin_user_name'] = $user['keyname'];
            }
            $user['pin_user_name'] = urlencode($user['pin_user_name']);
            $user['keyname'] = urlencode($user['keyname']);
            if ($user['keyavatar_big']) {
                $user['temp_avatar'] = '';
                $avatar_temp_root = C('pin_attach_path') . 'avatar/temp/';
                $temp_dir = date('ymd', time()) . '/';
                $file_name = date('ymdhis' . mt_rand(1000, 9999)) . '.jpg';
                mkdir($avatar_temp_root . $temp_dir);
                $image_content = Http::curlDownload($user['keyavatar_big'], $avatar_temp_root . $temp_dir . $file_name);
                $user['temp_avatar'] = $temp_dir . $file_name;
            }
            $user['type'] = $this->_type;
            cookie('user_bind_info', $user);
            return U('user/binding'); 
        }
    }
    public function callbackBind($request_args) {
        if (!session('user_info')) {
            return U('user/login');
        }
        $pin_user = session('user_info');
        $user = $this->_om->getUserInfo($request_args);
        $bind_user = $this->_checkBind($this->_type, $user['keyid']);
        if ($bind_user['uid'] && $bind_user['uid'] != $pin_user['id']) {
            die('此帐号已经绑定过本站');
        }
        $user['pin_uid'] = $pin_user['id'];
        $this->bindUser($user);
        return U('user/bind');
    }
    private function _updateBindInfo($user) {
        $info = serialize($user['bind_info']);
        D('user_bind')->where(array('keyid' => $user['keyid']))->save(array('info' => $info));
    }
    public function bindUser($user) {
        $bind_info = serialize($user['bind_info']);
        $bind_user = array(
            'uid' => $user['pin_uid'],
            'type' => $this->_type,
            'keyid' => $user['keyid'],
            'info' => $bind_info
        );
        D('user_bind')->add($bind_user);
    }
    public function bindByData($user) {
        $this->bindUser($user);
    }
    private function _checkBind($type, $key_id) {
        return D('user_bind')->where(array('type' => $type, 'keyid' => $key_id))->find();
    }
    private function _oauth_visitor() {
        include_once (ZhiPHP_PATH . 'app/Lib/Inslib/user_visitor.class.php');
        return new user_visitor();
    }
    public function NeedRequest() {
        return $this->_om->NeedRequest();
    }
}