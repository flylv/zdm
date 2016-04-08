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
class item_siteModel extends Model
{    protected $_validate = array(
        array('code', 'require', '{%item_site_code_empty}'),
        array('name', 'require', '{%item_site_name_empty}'),
        array('domain', 'require', '{%item_site_domain_empty}')
    );
    public function get_installed() {
        $installed_list = array();
        $installed_res = $this->select();
        foreach ($installed_res as $val) {
            $installed_list[$val['code']] = $val;
        }
        return $installed_list;
    }
    public function get_file_info($code) {
        return include(LIB_PATH . 'Inslib/itemcollect/'.$code.'/info.php');
    }    public function site_cache() {
        $item_site_list = array();
        $result = $this->field('id,code,name,domain,url,config')->where('status=1')->order('ordid')->select();
        foreach ($result as $val) {
            $val['config'] = unserialize($val['config']);
            $item_site_list[$val['code']] = $val;
        }
        F('item_site_list', $item_site_list);
        return $item_site_list;
    }    protected function _before_write(&$data) {
        F('item_site_list', NULL);
    }    protected function _after_delete($data, $options) {
        F('item_site_list', NULL);
    }
}