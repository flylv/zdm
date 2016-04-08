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
class load_langBehavior extends Behavior {
    protected $options   =  array(
        'DEFAULT_LANG' => 'zh-cn', 
    );
    public function run(&$params){        
        $lang = $group_lang = $module_lang = array();
        $lang_dir = LANG_PATH . C('DEFAULT_LANG');
        if (is_file($lang_dir . '/common.php')) {
            $lang = include $lang_dir . '/common.php';
        }
        if (defined('GROUP_NAME')) {
            $group_lang_file = $lang_dir . '/' . GROUP_NAME . '/common.php';
            if (is_file($group_lang_file)) {
                $group_lang = include $group_lang_file;
            }
        }
        $module_lang_file = $lang_dir . '/' . GROUP_NAME . '/' . MODULE_NAME . '.php';
        if (is_file($module_lang_file)) {
            $module_lang = include $module_lang_file;
        }
        $lang = array_merge($lang, $group_lang, $module_lang);
        $js_lang = isset($lang['js_lang']) ? $lang['js_lang'] : array();
        $module_js_lang = isset($lang['js_lang_' . MODULE_NAME]) ? $lang['js_lang_' . MODULE_NAME] : array();
        $lang['js_lang'] = array_merge($js_lang, $module_js_lang);
        L($lang);
    }
}