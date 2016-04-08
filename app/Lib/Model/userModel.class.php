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
class userModel extends baseModel
{
    protected $_validate = array(
        array('username', 'require', '{%username_require}'), 
        array('repassword', 'password', '{%inconsistent_password}', 0, 'confirm'), 
        array('email', 'email', '{%email_error}'), 
        array('username', '1,20', '{%username_length_error}', 0, 'length', 1), 
        array('password', '6,20', '{%password_length_error}', 0, 'length', 1), 
    );
    protected $_auto = array(
        array('password','md5',1,'function'), 
        array('reg_time','time',1,'function'), 
        array('reg_ip','get_client_ip',1,'function'), 
    );
    public function rename($map, $newname) {
        if ($this->where(array('username'=>$newname))->count('id')) {
            return false;
        }
        $this->where($map)->save(array('username'=>$newname));
        $uid = $this->where(array('username'=>$newname))->getField('id');
        D('item')->where(array('uid'=>$uid))->save(array('uname'=>$newname));
        D('album')->where(array('uid'=>$uid))->save(array('uname'=>$newname));
        return true;
    }
    public function name_exists($name, $id = 0) {
        $where = "username='" . $name . "' AND id<>'" . $id . "'";
        $result = $this->where($where)->count('id');
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function email_exists($email, $id = 0) {
        $where = "email='" . $email . "' AND id<>'" . $id . "'";
        $result = $this->where($where)->count('id');
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}