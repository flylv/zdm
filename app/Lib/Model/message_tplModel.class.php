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
class message_tplModel extends baseModel{
    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
    );
    public function get_mail_info($alias, $data = array()) {
        return $this->_fetch_tpl($alias, $data, 'mail');
    }
    public function get_msg_info($alias, $data = array()) {
        return $this->_fetch_tpl($alias, $data, 'msg');
    }
    protected function _before_write($data){
        $this->_set_tpl($data['alias'], $data['type'], $data['content']);
    }
    private function _set_tpl($alias, $type, $content) {
        $tpl_file = $this->_get_tplfile($alias, $type);
        file_put_contents($tpl_file, $content);
    }
    private function _get_tplfile($alias, $type) {
        return ZHI_DATA_PATH . $type . '_tpl/' . $alias . '.html';
    }
    private function _fetch_tpl($alias, $data, $type) {
        $tpl_file = $this->_get_tplfile($alias, $type);
        if (!is_file($tpl_file)) {
            return false;
        }
        $tpl_data = array(
            'site_name' => C('pin_site_name'),
            'send_time' => date('Y-m-d H:i:s'),
        );
        $tpl_data = array_merge($tpl_data, $data);
        $view = Think::instance('View');
        $view->assign($tpl_data);
        return $view->fetch($tpl_file);
    }
}