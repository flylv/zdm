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
class userAction extends mobileAction {
    function login(){
        $username=$this->_post('username','trim');
        $password=$this->_post('password','trim');
        $res=array();
        if($user=D('user')->field("id,username,score")->where(array('username'=>$username,'password'=>md5($password)))->find()){
            $user['validate']=array('error_code'=>1,'error_message'=>'登录成功!');
            $user['avatar']=avatar($user['id']);
            $res=$user;
        }else{
            $res['validate']=array('error_code'=>0,'error_message'=>'用户名或密码错误!');
        }
        $this->response($res);
    }
    function register(){
        $username=$this->_post('username','trim');
        $password=$this->_post('password','trim');
        $email=$this->_post('email','trim');
        $res=array();
        if($user=D('user')->field("id,username,score")->where(array('username'=>$username))->find()){
            $res['validate']=array('error_code'=>0,'error_message'=>'用户名已经注册了!');
        }else{
            D('user')->add(array('username'=>$username,'password'=>md5($password),'email'=>$email));            
            $res=D('user')->where(array('id'=>D('user')->getLastInsID()))->find();
            $res['avatar']=avatar($user['id']);
            $res['validate']=array('error_code'=>1,'error_message'=>'注册成功!');
        }
        $this->response($res);
    }
}