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
class default_passport
{
    private $_error = 0;
    public function __construct() {
        $this->_user_mod = D('user');
    }
    public function get_info() {
        return array(
            'code' => 'default', 
            'name' => 'ZhiPHP', 
            'desc' => 'ZhiPHP 默认会员系统',
            'version' => '1.0', 
            'author' => 'ZhiPHP TEAM', 
        );
    }
    public function register($username, $password, $email, $gender) {
        if (!$this->check_username($username)) {
            $this->_error = L('username_exists');
            return false;
        }
        if (!$this->check_email($email)) {
            $this->_error = L('email_exists');
            return false;
        }
        return array(
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'gender' => $gender
        );
    }
    public function edit($uid, $old_password, $data, $force = false) {        
        if (!$force) {
            $info = $this->get($uid);
            if ($info['password'] != md5($old_password)) {
                $this->_error = L('auth_failed');
                return false;
            }
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
        if ($is_name) {
            $map = array('username' => $flag);
        } else {
            $map = array('id' => intval($flag));
        }
        return D('user')->where($map)->find();
    }
    public function auth($username, $password) {
        $uid = D('user')->where(array('username'=>$username, 'password'=>md5($password)))->getField('id');
        if ($uid) {
            return $uid;
        } else {
            $this->_error = L('auth_failed');
            return false;
        }
    }
    public function synlogin() {}
    public function synlogout() {}
    public function check_email() {
        if ($this->_user_mod->where(array('email'=>$email))->count('id')) {
            return false;
        }
        return true;
    }
    public function check_username() {
        if ($this->_user_mod->where(array('username'=>$username))->count('id')) {
            return false;
        }
        return true;
    }
    public function get_error() {
        return $this->_error;
    }
}