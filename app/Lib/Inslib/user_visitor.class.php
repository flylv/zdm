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
class user_visitor {
    public $is_login = false; 
    public $info = null;
    public function __construct() {
        $where="";
        if ($user_info=session('user_info')) {
            $where="id=$user_info[id]";
        } elseif ($user_info = (array)cookie('user_info')) {
            $where="id=$user_info[id] and password='$user_info[password]'";
        } else {
            $this->is_login = false;
        }
        if(!empty($where)){
            $user_info = D('user')->field('id,username,password,score,is_merchant')->where($where)->find();
            if ($user_info) {
                $this->assign_info($user_info);
                $this->is_login = true;
            }
        }
    }
    function assign_info($user_info) {
        session('user_info', $user_info);
        $this->info =$this->parse_info($user_info);
    }
    public function remember($user_info, $remember = null) {
        if ($remember) {
            $time = 3600 * 24 * 14; 
            cookie('user_info', array('id'=>$user_info['id'], 'password'=>$user_info['password']), $time);
        }
    }
    public function get($key = null) {
        $info = null;
        if (is_null($key) && $this->info['id']) {
            $info = D('user')->find($this->info['id']);
        } else {
            if (isset($this->info[$key])) {
                return $this->info[$key];
            } else {
                $fields = D('user')->getDbFields();
                if (!is_null(array_search($key, $fields))) {
                    $info = D('user')->where(array('id' => $this->info['id']))->getField($key);
                }
            }
        }                
        return $this->parse_info($info);
    }
    public function login($uid, $remember = null) {
        $user_mod = D('user');
        $user_mod->where(array('id' => $uid))->save(array('last_time' => time(), 'last_ip' => get_client_ip()));
        $user_info = $user_mod->field('id,username,password,score,is_merchant')->find($uid);
        $this->assign_info($user_info);
        $this->remember($user_info, $remember);
    }
    private function parse_info($info){
        $info['msg_num']=D('message')->where("to_id=$info[id] and status=0")->count();
        return $info;
    }
    public function logout() {
        session('user_info', null);
        cookie('user_info', null);
    }
}