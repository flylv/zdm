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
class scoreAction extends backendAction
{
    public function setting() {
        if (IS_POST) {
            $score_rule = $this->_post('score_rule', ',');
            D('setting')->where(array('name'=>'score_rule'))->save(array('data'=>serialize($score_rule)));
            $this->success(L('operation_success'));
        } else {
            $this->display();
        }
    }
    public function logs() {
        $score_log_mod = D('score_log');
        $map = array();
        $keyword = $this->_request('keyword', 'trim');
        $keyword && $map = array('uname'=>array('like', '%'.$keyword.'%'));
        $count = $score_log_mod->where($map)->count();
        $pager = new Page($count, 20);
        $list = $score_log_mod->order('id DESC')->limit($pager->firstRow.','.$pager->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$pager->show());
        $this->assign('keyword', array('keyword' => $keyword,));
        $this->display();
    }
}