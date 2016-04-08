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
class adboardModel extends baseModel {
    public function name_exists($name, $id=0) {
        $where = "name='" . $name . "' AND id<>'" . $id . "'";
        $result = $this->where($where)->count('id');
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function get_tpl_list() {
        $cfg_files = glob(LIB_PATH.'Widget/advert/*.config.php');
        $tpl_list = array();
        foreach ($cfg_files as $file) {
            $basefile = basename($file);
            $key = str_replace('.config.php', '', $basefile);
            $tpl_list[$key] = include_once($file);
            $tpl_list[$key]['alias'] = $key;
        }
        return $tpl_list;
    }
}