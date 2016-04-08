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
class ucenter_passport
{
    private $_error = 0;
    public function get_info() {
        return array(
            'code' => 'ucenter', 
            'name' => 'UCenter', 
            'desc' => 'UCenter',
            'version' => '2.0', 
            'author' => 'ZhiPHP TEAM', 
            'config' => array(
                'uc_config' => array(
                    'text' => '应用的 UCenter 配置信息',
                    'type' => 'textarea',
                    'width' => '400',
                    'height' => '250',
                )
            )
        );
    }
    public function install_check() {
        if (!is_dir('./api/uc/uc_client/data')) {
            $this->_error = L('uc_client_not_exists');
            return false;
        }
        if (!is_writeable('./api/uc/uc_client/data')) {
            $this->_error = L('uc_client_not_write');
            return false;
        }
        return true;
    }
    private function _ucenter_init() {
        $conf = C('pin_integrate_config');
        eval($conf['uc_config']);
        include_once ('./api/uc/uc_client/client.php');
    }
    public function register($username, $password, $email, $gender) {
        $this->_ucenter_init();
        $uc_uid = uc_user_register($username, $password, $email);
        if ($uc_uid < 0) {
            switch ($uc_uid) {
                case -1:
                    $this->_error = L('invalid_user_name');
                    break;
                case -2:
                    $this->_error = L('blocked_user_name');
                    break;
                case -3:
                    $this->_error = L('username_exists');
                    break;
                case -4:
                    $this->_error = L('email_error');
                    break;
                case -5:
                    $this->_error = L('blocked_email');
                    break;
                case -6:
                    $this->_error = L('email_exists');
                    break;
            }
            return false;
        }
        return array(
            'uc_uid' => $uc_uid,
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'gender' => $gender
        );
    }
    public function edit($uid, $old_password, $data, $force = false) {
        $this->_ucenter_init();
        $new_pwd = $new_email = '';
        if (isset($data['password'])) {
            $new_pwd  = $data['password'];
        }
        if (isset($data['email'])) {
            $new_email = $data['email'];
        }
        $uc_uid = D('user')->where(array('id'=>$uid))->getField('uc_uid');
        $info = $this->get($uc_uid);
        if (empty($info)) {
            $this->_error('no_such_user');
            return false;
        }
        $result = uc_user_edit($info['username'], $old_password, $new_pwd, $new_email, $force);
        if ($result != 1) {
            switch ($result) {
                case 0:
                case -7:
                    break;
                case -1:
                    $this->_error = L('auth_failed');
                    break;
                case -4:
                    $this->_error = L('email_error');
                    break;
                case -5:
                    $this->_error = L('blocked_email');
                    break;
                case -6:
                    $this->_error = L('email_exists');
                    break;
                case -8:
                    $this->_error = L('user_protected');
                    break;
                default:
                    $this->_error = L('unknow_error');
                    break;
            }
            return false;
        }
        if (isset($data['password'])) {
            $data['password'] = md5($data['password']);
        }
        return $data;
    }
    public function delete() {
        return true;
    }
    public function get($flag, $is_name = false) {
        $this->_ucenter_init();
        $user_info = uc_get_user($flag, !$is_name);
        if (empty($user_info)) {
            $this->_error('no_such_user');
            return false;
        }
        list($uc_uid, $username, $email) = $user_info;
        $uid = D('user')->where(array('uc_uid'))->getField('id');
        return array(
            'id' => $uid,
            'username' =>  $username,
            'email'     =>  $email
        );
    }
    public function auth($username, $password) {
        $this->_ucenter_init();
        $result = uc_user_login($username, $password);
        if ($result[0] < 0) {
            switch ($result[0]) {
                case -1:
                    $this->_error = L('no_such_user');
                    break;
                case -2:
                    $this->_error = L('password_error');
                    break;
                case -3:
                    $this->_error = L('answer_error');
                    break;
                default:
                    $this->_error = L('unknow_error');
                    break;
            }
            return false;
        }
        return array('uc_uid'=>$result[0], 'username'=>$result[1], 'password'=>$result[2], 'email'=>$result[3]);
    }
    public function synlogin($uid) {
        $uc_uid = D('user')->where(array('id'=>$uid))->getField('uc_uid');
        return uc_user_synlogin($uc_uid);
    }
    public function synlogout() {
        $this->_ucenter_init();
        return uc_user_synlogout();
    }
    public function get_error() {
        return $this->_error;
    }
}