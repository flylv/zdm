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
defined('THINK_PATH') or exit();
class check_ipbanBehavior extends Behavior {
    public function run(&$params){
        if (false === $setting = F('setting')) {
            $setting = D('setting')->setting_cache();
        }
        if (!$setting['pin_ipban_switch']) return false;
        $ip = get_client_ip();
        $ipban_mod = D('ipban');
        $ipban_mod->clear(); 
        $isban = $ipban_mod->where(array('type'=>'ip', 'name'=>$ip))->count();
        $isban && exit('对不起，您的IP被禁止访问本站！');
        session_start();
            $user_info=D("user")->where("id=".intval($_SESSION['user_info']['id']))->find();
            if($ipban_mod->where("name='$user_info[username]' and type='uname'")->count()>0){                   
                _exit("用户名被列入黑名单");
            }
            if($ipban_mod->where("name='$user_info[email]' and type='email'")->count()>0){                
                _exit("邮箱被列入黑名单");
            }
    }
}