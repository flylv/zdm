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
    'code'      => 'qq',
    'name'      => 'QQ登录',
    'desc'      => '申请地址：http://connect.opensns.qq.com/',
    'author'    => 'ZhiPHP TEAM',
    'version'   => '1.0',
    'config'    => array(
        'app_key'   => array(
            'text'  => 'App Key',
            'desc'  => '申请：http://connect.opensns.qq.com/',
            'type'  => 'text',
        ),
        'app_secret'=> array(
            'text'  => 'App Secret',
            'desc'  => '申请：http://connect.opensns.qq.com/',
            'type'  => 'text',
        )
    )
);