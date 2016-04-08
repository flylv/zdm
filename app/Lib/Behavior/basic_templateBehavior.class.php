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
class basic_templateBehavior extends Behavior {
    protected $options   =  array(
        'BASIC_THEME' => 'default', 
    );
    public function run(&$templateFile){
        if(!file_exists_case($templateFile)) {
            $templateFile   = $this->parseTemplateFile($templateFile);
        }   
    }
    private function parseTemplateFile($templateFile) {
        if(''==$templateFile) {
            $templateFile = C('TEMPLATE_NAME');
            if(!file_exists_case($templateFile) && C('DEFAULT_THEME') && C('BASIC_THEME')) {
                $pin_default_theme = C('BASIC_THEME');
                $group = defined('GROUP_NAME') ? GROUP_NAME . '/' : '';
                $pin_theme_path = TMPL_PATH . $group . $pin_default_theme . '/';
                $templateFile = $pin_theme_path.MODULE_NAME.(defined('GROUP_NAME')?C('TMPL_FILE_DEPR'):'/').ACTION_NAME.C('TMPL_TEMPLATE_SUFFIX');
            }
        }elseif(false === strpos($templateFile,C('TMPL_TEMPLATE_SUFFIX'))){
            $path   =  explode(':',$templateFile);
            $action = array_pop($path);
            $module = !empty($path)?array_pop($path):MODULE_NAME;
            if(!empty($path)) {
                $path = dirname(THEME_PATH).'/'.array_pop($path).'/';
            }else{
                $path = THEME_PATH;
            }
            $depr = defined('GROUP_NAME')?C('TMPL_FILE_DEPR'):'/';
            $templateFile  =  $path.$module.$depr.$action.C('TMPL_TEMPLATE_SUFFIX');
            if(!file_exists_case($templateFile) && C('DEFAULT_THEME') && C('BASIC_THEME')) {
                $path = dirname(THEME_PATH) . '/' . C('BASIC_THEME') . '/';
                $templateFile = $path.$module.$depr.$action.C('TMPL_TEMPLATE_SUFFIX');
            }
        }
        if(!file_exists_case($templateFile)) {
            throw_exception(L('_TEMPLATE_NOT_EXIST_').'['.$templateFile.']');
        }
        return $templateFile;
    }
}