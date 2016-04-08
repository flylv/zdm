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
class check_inputBehavior extends Behavior {
    public function run(&$params) {
        if (GROUP_NAME != 'home') return;
        if (MODULE_NAME == 'uc') return;
        $_REQUEST = $this->filter($_REQUEST);
        $_GET = $this->filter($_GET);
        $_POST = $this->filter($_POST);
    }
    protected function filter($list) {
        import("ORG.Util.Input");
        foreach ($list as $key => $val) {
            $list[$key] = $this->no_xss($val);
        }
        return $list;
    }
    function no_xss($str) {
        $str = str_replace('	', ' ', $str);
        $str = str_replace(':e/*', 'e', $str);
        $str = str_replace(':ex/*', 'ex', $str);
        $str = str_replace(':exp/*', 'exp', $str);
        $str = str_replace(':expr/*', 'expr', $str);
        $str = str_replace(':expre/*', 'expre', $str);
        $str = str_replace(':expres/*', 'expres', $str);
        $str = str_replace(':express/*', 'express', $str);
        $str = str_replace(':expressi/*', 'expressi', $str);
        $str = str_replace(':expressio/*', 'expressio', $str);
        $val = $str;
        $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
        $search = 'abcdefghijklmnopqrstuvwxyz';
        $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $search .= '1234567890!@#$%^&#038;*()';
        $search .= '~`";:?+/={}[]-_|\'\\';
        for ($i = 0; $i < strlen($search); $i++) {
            $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i],
                $val); 
            $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); 
        }
        $ra1 = array(
            'javascript',
            'vbscript',
            'expression',
            'applet',
            'meta',
            'xml',
            'blink',
            'link',
            'frameset',
            'ilayer',
            'bgsound',
            'title',
            'base');
        $ra2 = array(
            'onabort',
            'onactivate',
            'onafterprint',
            'onafterupdate',
            'onbeforeactivate',
            'onbeforecopy',
            'onbeforecut',
            'onbeforedeactivate',
            'onbeforeeditfocus',
            'onbeforepaste',
            'onbeforeprint',
            'onbeforeunload',
            'onbeforeupdate',
            'onblur',
            'onbounce',
            'oncellchange',
            'onchange',
            'onclick',
            'oncontextmenu',
            'oncontrolselect',
            'oncopy',
            'oncut',
            'ondataavailable',
            'ondatasetchanged',
            'ondatasetcomplete',
            'ondblclick',
            'ondeactivate',
            'ondrag',
            'ondragend',
            'ondragenter',
            'ondragleave',
            'ondragover',
            'ondragstart',
            'ondrop',
            'onerror',
            'onerrorupdate',
            'onfilterchange',
            'onfinish',
            'onfocus',
            'onfocusin',
            'onfocusout',
            'onhelp',
            'onkeydown',
            'onkeypress',
            'onkeyup',
            'onlayoutcomplete',
            'onload',
            'onlosecapture',
            'onmousedown',
            'onmouseenter',
            'onmouseleave',
            'onmousemove',
            'onmouseout',
            'onmouseover',
            'onmouseup',
            'onmousewheel',
            'onmove',
            'onmoveend',
            'onmovestart',
            'onpaste',
            'onpropertychange',
            'onreadystatechange',
            'onreset',
            'onresize',
            'onresizeend',
            'onresizestart',
            'onrowenter',
            'onrowexit',
            'onrowsdelete',
            'onrowsinserted',
            'onscroll',
            'onselect',
            'onselectionchange',
            'onselectstart',
            'onstart',
            'onstop',
            'onsubmit',
            'onunload');
        $ra = array_merge($ra1, $ra2);
        $found = true; 
        while ($found == true) {
            $val_before = $val;
            for ($i = 0; $i < sizeof($ra); $i++) {
                $pattern = '/';
                for ($j = 0; $j < strlen($ra[$i]); $j++) {
                    if ($j > 0) {
                        $pattern .= '(';
                        $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                        $pattern .= '|';
                        $pattern .= '|(&#0{0,8}([9|10|13]);)';
                        $pattern .= ')*';
                    }
                    $pattern .= $ra[$i][$j];
                }
                $pattern .= '/i';
                $replacement = "x"; 
                $val = preg_replace($pattern, $replacement, $val); 
                if ($val_before == $val) {
                    $found = false;
                }
            }
        }
        $farr = array(
            "/\s+/",
            "/<(\/?)(script|i?frame|style|html|body|title|link|meta|\?|\%)([^>]*?)>/isU",
        );
        $tarr = array(
            " ",
            "",
        );
        $val = preg_replace($farr, $tarr, $val);
        return $val;
    }
}