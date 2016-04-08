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
vendor('Taobaotop.TopClient');
vendor('Taobaotop.RequestCheckUtil');
vendor('Taobaotop.Logger');
require_once dirname(__FILE__) . '/taobao.class.php';
class taobao_oauth
{
    private $_need_request = array('code');
    public function __construct($setting) {
		$this->redirect_uri ="http://".$_SERVER["HTTP_HOST"]."/index.php?m=oauth&a=callback&mod=taobao";
        $this->setting = $setting;
    }
    function getAuthorizeURL() {
      $oauth = new TaobaoTOAuthV2($this->setting['app_key'], $this->setting['app_secret'] );
      return $oauth->getAuthorizeURL($this->redirect_uri);
    }
    public function getUserInfo($request_args) {
        $oauth = new TaobaoTOAuthV2($this->setting['app_key'], $this->setting['app_secret'] );
        $keys = array('code'=>$request_args['code'], 'redirect_uri'=>$this->redirect_uri);
        $token = $oauth->getAccessToken($keys);
        $result['keyid'] = $token['taobao_user_id'];
        $result['keyname'] = $token['taobao_user_nick'];
        $result['keyavatar_small'] = '';
        $result['keyavatar_big'] = '';
        $result['bind_info'] = $token;
        return $result;
    }
    public function getFriends($bind_user, $page, $count) {
    }
    public function send($bind_user, $data) {
    }
    public function follow($bind_user, $uid) {
    }
    public function NeedRequest() {
        return $this->_need_request;
    }
    public function CheckTaoBaoSign($top_secret,$top_parameters,$top_sign) {
        $sign = base64_encode(md5($top_parameters.$top_secret,true));
        return $sign == $top_sign;
    }
}