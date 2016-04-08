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
class flink_cateModel extends baseModel
{
    public function name_exists($name, $id=0)
    {
        $pk = $this->getPk();
        $where = "name='" . $name . "'  AND ". $pk ."<>'" . $id . "'";
        $result = $this->where($where)->count($pk);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function cate_cache() {
        $cate_list = array();
        $cate_data = $this->where('status=1')->order('ordid')->select();
        foreach ($cate_data as $val) {
            $cate_list[$val['id']] = $val;
        }
        F('flink_cate_list', $cate_list);
        return $cate_list;
    }
    protected function _before_write(&$data) {
        F('flink_cate_list', NULL);
    }
    protected function _after_delete($data, $options) {
        F('flink_cate_list', NULL);
    }
}