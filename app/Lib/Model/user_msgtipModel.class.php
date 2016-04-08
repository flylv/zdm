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
class user_msgtipModel extends baseModel {
    private $_type = array(
        '1' => 'fans',
        '2' => 'atme',
        '3' => 'msg',
        '4' => 'system',
    );
    public function add_tip($uid, $type, $num = 1) {
        $is_tip = $this->where(array('uid' => $uid, 'type' => $type))->count();
        if ($is_tip) {
            return $this->where(array('uid' => $uid, 'type' => $type))->setInc('num', $num);
        } else {
            return $this->add(array(
                        'uid' => $uid,
                        'type' => $type,
                        'num' => $num,
                    ));
        }
    }
    public function get_list($uid) {
        $tiplist = $this->field('type,num')->where(array('uid' => $uid))->select();
        $result = array();
        foreach ($tiplist as $val) {
            $result[$this->_type[$val['type']]] = $val['num'];
        }
        return $result;
    }
    public function clear_tip($uid, $type = '') {
        $map = array('uid' => $uid);
        $type && $map['type'] = $type;
        return $this->where($map)->save(array('num'=>0));
    }
}