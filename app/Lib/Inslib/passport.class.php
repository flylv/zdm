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
class passport
{
    private $_error = 0;
    private $_us = null;
    public function __construct($name) {
        $file = LIB_PATH . 'Inslib/passport/' . $name . '.php';
        include $file;
        $class = $name . '_passport';
        $this->_us  = new $class();
    }
    static function uc($name) {
        include LIB_PATH . 'Inslib/passport/' . $name . '.php';
        $class = $name . '_passport';
        return new $class();
    }
    public function register($username, $password, $email, $gender) {
        if (!$add_data = $this->_us->register($username, $password, $email, $gender)) {
            $this->_error = $this->_us->get_error();
            return false;
        }
        return $this->_local_add($add_data);
    }
    public function edit($uid, $old_password, $data, $force = false) {
        if (!$edit_data = $this->_us->edit($uid, $old_password, $data, $force)) {
            $this->_error = $this->_us->get_error();
            return false;
        }
        return $this->_local_edit($uid, $edit_data);
    }
    public function delete($uid) {
        if ($this->_us->delete($uid)) {
            $this->_error = $this->_us->get_error();
            return false;
        }
        return $this->_local_delete($uid);
    }
    public function get($flag, $is_name = false) {
        return $this->_us->get($flag, $is_name = false);
    }
    public function auth($username, $password) {
        $uid = $this->_us->auth($username, $password);                
        if (!$uid) {
            $this->_error = $this->_us->get_error();
            return false;
        }
        if (is_array($uid)) {
            $uid = $this->_local_sync($uid);
        }
        return $uid;
    }
    public function synlogin($uid) {
        return $this->_us->synlogin($uid);
    }
    public function synlogout() {
        return $this->_us->synlogout();
    }
    private function _local_add($add_data) {
        $user_mod = D('user');
        if (false !== $user_mod->create($add_data)) {
            $uid = $user_mod->add();
            if (!$uid) {
                $this->_error = $user_mod->getError();
                return false;
            } else {
                return $uid;
            }
        } else {
            $this->_error = $user_mod->getError();
            return false;
        }
    }
    private function _local_edit($uid, $data) {
        isset($data['password']) && $data['password'] =$data['password'];        
        D('user')->where(array('id'=>$uid))->save($data);
        return true;
    }
    private function _local_delete($uid) {
        $user_mod = D('user');
        return $user_mod->delete($uid);
    }
    private function _local_get($flag, $is_name = false) {
        if ($is_name) {
            $map = array('username' => $flag);
        } else {
            $map = array('id' => intval($flag));
        }
        $user= D('user')->where($map)->find();
        return $user;
    }
    private function _local_sync($user_info) {
        $local_info = $this->_local_get($user_info['username'], true);
        if (empty($local_info)) {
            $local_info['id'] = $this->_local_add($user_info); 
        } else {
            $this->_local_edit($local_info['id'], $user_info); 
        }
        return $local_info['id'];
    }
    public function get_error() {
        return $this->_error;
    }
}