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
class jky_cateModel extends baseModel
{
    public function get_child($pid=1){
        $res=$this->where("pid=$pid and status=1")->select();        
        if($res==false)return;
        foreach($res as $key=>$val){            
            $res[$key]['child']=$this->get_child($val['id']);
        }
        return $res;
    }
    public function get_spid($pid) {
        if (!$pid) {
            return 0; 
        }
        $pspid = $this->where(array('id'=>$pid))->getField('spid');
        if ($pspid) {
            $spid = $pspid . $pid . '|';
        } else {
            $spid = $pid . '|';
        }
        return $spid;
    }
    public function get_child_ids($id, $with_self=false) {
        $spid = $this->where(array('id'=>$id))->getField('spid');
        $spid = $spid ? $spid .= $id .'|' : $id .'|';
        $id_arr = $this->field('id')->where(array('spid'=>array('like', $spid.'%')))->select();
        $array = array();
        foreach ($id_arr as $val) {
            $array[] = $val['id'];
        }
        $with_self && $array[] = $id;
        return $array;
    }
    public function name_exists($name, $pid, $id=0) {
        $where = "name='" . $name . "' AND pid='" . $pid . "' AND id<>'" . $id . "'";
        $result = $this->where($where)->count('id');
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function cate_cache() {
        $artcate_list = array();
        $cate_data = $this->field('id,pid,name')->where('status=1')->order('ordid')->select();
        foreach ($cate_data as $val) {
            if ($val['pid'] == '0') {
                $artcate_list['p'][$val['id']] = $val;
            } else {
                $artcate_list['s'][$val['pid']][] = $val;
            }
        }
        F('jky_cate_list', $artcate_list);
        return $artcate_list;
    }
    protected function _before_write(&$data) {
        F('jky_cate_list', NULL);
    }
    protected function _after_delete($data, $options) {
        F('jky_cate_list', NULL);
    }
}