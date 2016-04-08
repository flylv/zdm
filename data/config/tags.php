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
    'app_begin' => array(
        'load_lang', 
        'check_input',
    ),
    'app_end' => array(
        'check_ipban', 
    ),
    'view_template' => array(
        'basic_template', '_overlay' => 1, 
    ),
    'view_filter' => array(
        'content_replace', 
        'ContentReplace', 
        'TokenBuild', 
        'WriteHtmlCache', 
        'ShowRuntime', 
    ),
    'login_begin' => array(
        'check_ipban', 
    ),
    'login_end' => array(
        'alter_score', 
    ),
    'register_begin' => array(),
    'register_end' => array(
        'alter_score', 
    ),
    'submit_end' => array(
        'alter_score', 
    ),
    'comment_end' => array(
        'alter_score', 
    ),
    'favs_end' => array(
        'alter_score', 
    ),
    'qiandao_end' => array(
        'alter_score',
    ),
);