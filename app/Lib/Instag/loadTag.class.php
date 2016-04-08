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
class loadTag {
    private $jm;
    private $dir;
    function __construct() {
        $this->dir = new Dir();
    }
    public function js($options) {
        $path = ZHI_DATA_PATH . 'static/' . md5($options['href']) . '.js';
        $statics_url = C('pin_statics_url') ? C('pin_statics_url') : 'static';
        $html = "";
        if (!is_file($path)||APP_DEBUG) {
            $files = explode(',', $options['href']);
            $content = '';
            foreach ($files as $val) {
                $val = str_replace('__STATIC__', $statics_url, $val);
                if(APP_DEBUG){
                    $html .= '<script type="text/javascript" src="' .__ROOT__.'/'.$val .'"></script>';  
                }else{
                    $content .= file_get_contents(trim("./".$val));
                }   
            }
            file_put_contents($path,$content);
        }
        if (APP_DEBUG) {
            echo $html;
        } else {
            echo ('<script type="text/javascript" src="' . __ROOT__ . '/data/static/' . md5($options['href']) .'.js?' . ZHI_RELEASE . '"></script>');
        }
    }
}
?>