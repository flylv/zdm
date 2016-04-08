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
class mail_queueModel extends baseModel
{
    private $_max_err = 3; 
    private $_send_lock = 30; 
    public function clear() {
        $this->where(array('err_num'=>array('gt', $this->_max_err)))->delete();
    }
    public function send($limit = 5) {
        $this->clear();
        $mails = $this->where(array('lock_expiry'=>array('lt', time())))->order('priority DESC,id,err_num')->limit($limit)->select();
        if (!$mails) return false;
        $qids = array();
        foreach ($mails as $_mail) {
            $qids[] = $_mail['id'];
        }
        $this->where(array('id'=>array('in', $qids)))->save(array(
            'err_num' => array('exp', 'err_num+1'),
            'lock_expiry' => array('exp', 'lock_expiry+' . $this->_send_lock),
        ));
        $mailer = mailer::get_instance();
        foreach ($mails as $_mail) {
            if ($mailer->send($_mail['mail_to'], $_mail['mail_subject'], $_mail['mail_body'])) {
                $this->delete($_mail['id']);
            } else {
            }
        }
    }
}