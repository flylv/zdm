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
class seoAction extends backendAction {
    public function url() {
        $config_file = CONF_PATH . 'url.php';
        $config = require $config_file;
        if (IS_POST) {
            D('setting')->update($this->_post('setting'));
            $url_model = $this->_post('url_model', 'intval', 0);
            $url_suffix = $this->_post('url_suffix', 'trim','.html');
            $url_depr = $this->_post('url_depr', 'trim','/');
            $new_config = array(
                'URL_MODEL' => $url_model,
                'URL_HTML_SUFFIX' => $url_suffix,
                'URL_PATHINFO_DEPR' => $url_depr,
                'REWRITE_DETAIL'=>$this->_post('rewrite_detail','trim','orig'),
            );
            $content="<?php\n return ".str_replace('\\\\','\\',var_export($new_config,true)).";";
            if (file_put_contents($config_file,$content)) {
                $this->success(L('operation_success'));
            } else {
                $this->error(L('file_no_authority'));
            }
        } else {
            $this->assign('config', $config);
            $this->display();
        }
    }
    public function page() {
        $setting_mod = D('setting');
        if (IS_POST) {
            $seo_config = $this->_post('seo_config', ',');
            $seo_config = serialize($seo_config);
            $setting_mod->where(array('name'=>'seo_config'))->save(array('data'=>$seo_config));
            $setting = $this->_post('setting', ',');                    
            foreach ($setting as $key => $val) {
                $val = is_array($val) ? serialize($val) : $val;
                if($setting_mod->where(array('name' => $key))->find()){
                    $setting_mod->where(array('name' => $key))->save(array('data' => $val));
                }else{
                    $setting_mod->add(array('name'=>$key,'data'=>$val));
                }
            }           
            $this->success(L('operation_success'));
        } else {
            $seo_config = $setting_mod->where(array('name'=>'seo_config'))->getField('data');
            $this->assign('seo_config', unserialize($seo_config));
            $this->display();
        }
    }
}