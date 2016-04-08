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
class integrateAction extends backendAction {
    public function index() {
        $path = LIB_PATH . 'Inslib/passport/';
        $opdir  = dir($path);
        $list = array();
        while (false !== ($file = $opdir->read())) {
            if (!preg_match("/^.*?\.php$/", $file)) {
                continue;
            }
            $code = explode('.', $file);
            $mod = passport::uc($code[0]);
            $info = $mod->get_info();
            $list[$file] = $info;
        }
        $this->assign('list', $list);
        $this->display();
    }
    public function install() {
        if (IS_POST) {
            $code = $this->_post('code', 'trim');
            $mod = passport::uc($code);
            $info = $mod->get_info();
            foreach ($info['config'] as $key => $val) {
                $config[$key] = $this->_post($key);
            }
            $config = serialize($config);
            D('setting')->where(array('name'=>'integrate_code'))->setField('data', $code);
            D('setting')->where(array('name'=>'integrate_config'))->setField('data', $config);
            $this->success(L('operation_success'), U('integrate/index'));
        } else {
            $code = $this->_get('code', 'trim');
            if ($code == 'default') {
                D('setting')->where(array('name'=>'integrate_code'))->setField('data', $code);
                D('setting')->where(array('name'=>'integrate_config'))->setField('data', '');
                $this->success(L('operation_success'), U('integrate/index'));
            } else {
                $mod = passport::uc($code);
                if (!$mod->install_check()) {
                    $this->error($mod->get_error());
                }
                $info = $mod->get_info();
                $this->assign('info', $info);
                $this->display();
            }
        }
    }
    public function setting() {
        if (IS_POST) {
            $code = $this->_post('code', 'trim');
            $mod = passport::uc($code);
            $info = $mod->get_info();
            foreach ($info['config'] as $key => $val) {
                $config[$key] = $this->_post($key);
            }
            $config = serialize($config);
            D('setting')->where(array('name'=>'integrate_code'))->setField('data', $code);
            D('setting')->where(array('name'=>'integrate_config'))->setField('data', $config);
            $this->success(L('operation_success'), U('integrate/index'));
        } else {
            $code = $this->_get('code', 'trim');
            $mod = passport::uc($code);
            $info = $mod->get_info();
            $this->assign('info', $info);
            $this->assign('icv', C('pin_integrate_config'));
            $this->display();
        }
    }
}