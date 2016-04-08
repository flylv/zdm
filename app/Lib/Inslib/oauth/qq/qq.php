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
require_once dirname(__FILE__) . '/qq.class.php'; 
class qq_oauth
{
    private $_need_request = array('code', 'state');
    public function __construct($setting) {
		$this->redirect_uri ="http://".$_SERVER["HTTP_HOST"]."/index.php?m=oauth&a=callback&mod=qq";
        $this->setting = $setting;
    }
    function getAuthorizeURL() {
        $oauth = new QqTOAuthV2($this->setting['app_key'], $this->setting['app_secret']);
        return $oauth->getAuthorizeURL($this->redirect_uri);
    }
    public function getUserInfo($request_args) {
        $oauth = new QqTOAuthV2($this->setting['app_key'], $this->setting['app_secret']);
        $keys = array('code'=>$request_args['code'], 'state'=>$request_args['state'], 'redirect_uri'=>$this->redirect_uri);
        $token = $oauth->getAccessToken($keys);
        $openid = $oauth->getOpenid($token["access_token"]);
        $user = $oauth->getUserInfo($token["access_token"], $openid);
        $result['keyid'] = $openid;
        $result['keyname'] = $user['nickname'];
        $result['keyavatar_small'] = $user['figureurl'];
        $result['keyavatar_big'] = $user['figureurl_2'];
        $result['bind_info'] = $token;
        return $result;
    }
    public function send($bind_user, $data) {
        $token = unserialize($bind_user['info']);
        $client = new QqTOAuthV2($this->setting['app_key'], $this->setting['app_secret']);
        try {
            $return = $client->add_topic($token['access_token'], $bind_user['keyid'], array(
                'format' => '',
                'richtype' => '2',
                'richval' => $data['url'],
                'con' => $data['content'],
                'lbs_nm' => '',
                'lbs_x' => '',
                'lbs_y' => '',
                'third_source' => '',
            ));
        }catch(Exception $e){}
    }
    public function getFriends($bind_user, $page, $count) {
    }
    public function follow($bind_user, $uid) {
    }
    public function NeedRequest() {
        return $this->_need_request;
    }
}