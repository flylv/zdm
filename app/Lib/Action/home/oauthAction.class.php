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
class oauthAction extends frontendAction {
    public function index() {
    	$mod = $this->_get('mod', 'trim');
    	$type = $this->_get('type', 'trim', 'login');
    	!$mod && $this->_404();
        if ('unbind' == $type) {
            !$this->visitor->is_login && $this->redirect('user/login');
            D('user_bind')->where(array('uid'=>$this->visitor->info['id'], 'type'=>$mod))->delete();
            $this->redirect('user/bind');
        }
        $oauth = new oauth($mod);
        cookie('callback_type', $type);
        return $oauth->authorize();
    }
    function callback() {
        $mod = $this->_get('mod', 'trim');
        !$mod && $this->_404();
        $callback_type = cookie('callback_type');
        $oauth = new oauth($mod);
        $rk = $oauth->NeedRequest();
        $request_args = array();
        foreach ($rk as $v) {
            $request_args[$v] = $this->_get($v);
        }
        switch ($callback_type) {
            case 'login':
                $url = $oauth->callbackLogin($request_args);
                break;
            case 'bind':
                $url = $oauth->callbackbind($request_args);
                break;
            default:
                $url = U('index/index');
                break;
        }
        cookie('callback_type', null);
        redirect($url);
    }
}