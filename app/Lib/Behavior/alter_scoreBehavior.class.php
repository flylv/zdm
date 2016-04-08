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
defined('THINK_PATH') or exit();
class alter_scoreBehavior extends Behavior {
    public function run(&$_data){
        $this->_alter_score($_data);
    }
    private function _alter_score($_data) {
        $score = C('pin_score_rule.'.$_data['action']); 
        if (intval($score) == 0) return false; 
        if ($this->_check_num($_data['uid'], $_data['action'])) {            
            if ($score >= 0) {
				$score_data = array('score'=>array('exp','score+'.$score), 'score_level'=>array('exp', 'score_level+'.$score));
			} else {
				$score_data = array('score'=>array('exp','score+'.$score));
			}
            D('user')->where(array('id'=>$_data['uid']))->setField($score_data); 
            $score_log_mod = D('score_log');
            $score_log_mod->create(array(
                'uid' => $_data['uid'],
                'uname' => $_data['uname'],
                'action' => $_data['action'],
                'score' => $score,
            ));
            $score_log_mod->add();
        }
    }
    private function _check_num($uid, $action){
        $return = false;
        $user_stat_mod = D('user_stat');
        $max_num = C('pin_score_rule.'.$action.'_nums');
        $stat = $user_stat_mod->field('num,last_time')->where(array('uid'=>$uid, 'action'=>$action))->find();
        if (!$stat) {
            $user_stat_mod->create(array('uid'=>$uid, 'action'=>$action));
            $user_stat_mod->add();
        }
        $new_num = $stat['num'] + 1;
        if ($max_num == 0) {
            $return = true; 
        } else {
            if ($stat['last_time'] < todaytime()) {
                $new_num = 1;
                $return = true;
            } else {
                $return = $stat['num'] >= $max_num ? false : true;
            }
        }
        $user_stat_mod->create(array('num'=>$new_num));
        $user_stat_mod->where(array('uid'=>$uid, 'action'=>$action))->save();
        return $return;
    }
}