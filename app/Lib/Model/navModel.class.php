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
class navModel extends baseModel
{
    public function nav_cache() {
        $nav_list = array();
        $nav_data = $this->field('type,name,alias,link,target')->where('status=1')->order('ordid')->select();
        foreach ($nav_data as $val) {
            switch ($val['type']) {
                case 'main':
                    $nav_list['main'][] = $val;
                    break;
                case 'bottom':
                    $nav_list['bottom'][] = $val;
                    break;
            }
        }
        F('nav_list', $nav_list);
        return $nav_list;
    }
    protected function _before_write(&$data) {
        F('nav_list', NULL);
    }
    protected function _after_delete($data, $options) {
        F('nav_list', NULL);
    }
}