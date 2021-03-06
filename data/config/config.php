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
return array(
    'APP_GROUP_LIST' => 'home,admin,mobile,wap', 
    'DEFAULT_GROUP' => 'home', 
    'DEFAULT_MODULE' => 'index', 
    'TAGLIB_PRE_LOAD' => 'pin,list', 
    'APP_AUTOLOAD_PATH' => '@.Instag,@.Inslib,@.ORG', 
    'TMPL_ACTION_SUCCESS' => 'public:success',
    'TMPL_ACTION_ERROR' => 'public:error',
    'DATA_CACHE_SUBDIR' => true, 
    'DATA_PATH_LEVEL' => 3, 
    'DATA_CACHE_TIME' => 3600,
    'LOAD_EXT_CONFIG' => 'url,db', 
    'SHOW_PAGE_TRACE' => false,    'URL_TYPE_LIST' => array('dm' => '多麦','yqf' => '亿起发','other' => '其他','empty' => '未填写'),
    'YESNO' => array('否', '是'),
    'ZHIAPI_URL' => 'http://data.insuny.com',
    'URL_ROUTER_ON'=>true,
    'URL_ROUTE_RULES'=>array(
        '/^index-p(\d+).html$/' => 'index/index?p=:1',        '/^detail-(\d+).html$/' => 'post/index?id=:1',
	'/^go-(\w+)-(\d+).html$/' => 'public/go?type=:1&id=:2',
	'/^zhidemai.html$/' => 'post_cate/post_list',
        '/^zhi\/detail-(\d+).html$/' => 'post/index?id=:1',
        '/^[0-9]{4}\/[0-9]{1,2}\/detail-(\d+).html$/' => 'post/index?id=:1',
        '/^zhi\/(\d+)\/$/' => 'post/index?id=:1',
        '/^zhi-(\w+).html$/' => 'post/index?post_key=:1',   
        '/^baoliao.html$/' => 'post/submit',
        '/^cate-(\d+).html$/' => 'post_cate/index?id=:1',
        '/^cate-(\d+)-(\d+).html$/' => 'post_cate/index?id=:1&p=:2',
        '/^article-(\d+).html$/' => 'article/index?id=:1',
        '/^mall.html$/' => 'mall/index',
        '/^mall-(\d+).html$/' => 'mall/info?id=:1',
        '/^mall-c(\d+).html$/' => 'mall/index?cate=:1',
        '/^mall-c(\d+)-p(\d+).html$/' => 'mall/index?cate=:1&p=:2',
        '/^mall-w(\w+).html$/' => 'mall/index?word=:1',
        '/^mall-w(\w+)-c(\d+).html$/' => 'mall/index?word=:1&cate=:2',
        '/^mall-w(\w+)-c(\d+)-p(\d+).html$/' => 'mall/index?word=:1&cate=:2&p=:3',
        '/^jiukuaiyou.html$/' => 'jky_item/index',
        '/^jiukuaiyou-(\w+)-(\d+)-(\d+).html$/' => 'jky_item/index?state=:1&c1=:2&c2=:3',
        '/^jiukuaiyou-(\d+)-(\d+).html$/' => 'jky_item/index?c1=:1&c2=:2',
        '/^jiukuaiyou-(\d+).html$/' => 'jky_item/detail?id=:1',
        '/^jiukuaiyou-p(\d+).html$/' => 'jky_item/index?p=:1',
        '/^jiukuaiyou-go(\d+).html$/' => 'jky_item/go?id=:1',
        '/^zhe\/detail-(\d+).html$/' => 'jky_item/detail?id=:1',
        '/^[0-9]{4}\/[0-9]{1,2}\/item-(\d+).html$/' => 'jky_item/detail?id=:1',
        '/^zhe\/(\d+)\/$/' => 'jky_item/detail?id=:1',
        '/^zhe-(\w+).html$/' => 'jky_item/detail?post_key=:1', 
        '/^exchange.html$/' => 'exchange/index',
        '/^exchange-c(\d+).html$/' => 'exchange/index?cid=:1',
        '/^exchange-p(\d+).html$/' => 'exchange/index?p=:1',
        '/^exchange-c(\d+)-p(\d+).html$/' => 'exchange/index?cid=:1&p=:2',
        '/^exchange-(\d+).html$/' => 'exchange/detail?id=:1',
        '/^login.html$/' => 'user/login',
        '/^login.html?ret_url=(\w+)$/' => 'user/login?ret_url=:1',
        '/^register.html$/' => 'user/register',
        '/^logout.html$/' => 'user/logout',
        '/^logout.html?ret_url=(\w+)$/' => 'user/logout?ret_url=:1',
		'/^findpwd.html$/' => 'findpwd/index',
        '/^qq.html$/' => 'oauth/index?mod=qq',
        '/^qq-cb.html$/' => 'oauth/callback?mod=qq',
        '/^sina.html$/' => 'oauth/index?mod=sina',
        '/^sina-cb.html$/' => 'oauth/callback?mod=sina',
        '/^taobao.html$/' => 'oauth/index?mod=taobao',
        '/^taobao-cb.html$/' => 'oauth/callback?mod=taobao',		
        '/^help_about.html$/' => 'help/page?id=2',
        '/^help_contact.html$/' => 'help/page?id=3',
        '/^help_partner.html$/' => 'help/page?id=4',
        '/^help_rules.html$/' => 'help/page?id=6',
        '/^help_weixin.html$/' => 'help/page?id=12',
        '/^help_friends.html$/' => 'help/page?id=23',
        '/^help_new.html$/' => 'help/page?id=45',
        '/^help_ju.html$/' => 'help/page?id=46',
        '/^help_zdm.html$/' => 'help/page?id=47',
        '/^help_jifen.html$/' => 'help/faq?cate_id=20',
        '/^help_mall.html$/' => 'help/faq?cate_id=43',
        '/^help_exchange.html$/' => 'help/faq?cate_id=44',
        '/^help_faq.html$/' => 'help/faq?cate_id=19',        
        '/^help_flink.html$/' => 'help/flink',
        '/^user.html$/' => 'user/index',
        '/^profile.html$/' => 'user/profile',
        '/^bind.html$/' => 'user/bind',
        '/^binding.html$/' => 'user/binding',
        '/^password.html$/' => 'user/password',
        '/^comments.html$/' => 'user/comments',
        '/^comments-(\d+).html$/' => 'user/comments?p=:1',
        '/^favs.html$/' => 'user/favs',
        '/^favs-(\d+).html$/' => 'user/favs?p=:1',
        '/^baoliao-list.html$/' => 'user/baoliao',
        '/^baoliao-(\d+).html$/' => 'user/baoliao?type=:1',
        '/^baoliao-(\d+)-(\d+).html$/' => 'user/baoliao?type=:1&p=:2',
        '/^score_log.html$/' => 'user/score_log',
        '/^score_log-(\d+).html$/' => 'user/score_log?p=:1',
        '/^score_order.html$/' => 'user/score_order',
        '/^score_order-(\d+).html$/' => 'user/score_order?p=:1',
        '/^user_address.html$/' => 'user/address',
        '/^user_address-p(\d+).html$/' => 'user/address?p=:1',
        '/^user_anhao.html$/' => 'user/anhao',
        '/^user_anhao-p(\d+).html$/' => 'user/anhao?p=:1',
        '/^message.html$/' => 'user/message',
        '/^message-(\d+).html$/' => 'user/message?p=:1',
        '/^ad-(\d+).html$/' => 'advert/tgo?id=:1',   		'/^wap-index.html$/' => 'wap/index/index',    
		'/^wap.html$/' => 'wap/jky_item/index',      
		'/^wap-p(\d+).html$/' => 'wap/jky_item/index?p=:1',      
		'/^wap-c(\d+).html$/' => 'wap/jky_item/index?cid=:1',      
		'/^wap-c(\d+)-p(\d+).html$/' => 'wap/jky_item/index?cid=:1&p=:2', 
		'/^wap-search.html$/' => 'wap/jky_item/search',  
		'/^wap-p(\d+).html?keyword=(\w+)$/' => 'wap/jky_item/index?p=:1&keyword=:2',  
    ),
);