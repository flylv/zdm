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
class collect_batchAction extends backendAction
{
    public function index() {
        $auto_user = D('auto_user')->select();
        $this->assign('auto_user', $auto_user);
    	$this->display();
    }
    public function import() {
        $type = $this->_post('type', 'trim', 'input');
        $auid = $this->_post('auid', 'intval');
        !$auid && $this->error('auto_user_error');
        switch ($type) {
            case 'input':
                $url_list = $this->_post('url_list', 'urldecode');
                break;
            case 'file':
                $url_file = $_FILES['url_file'];
                $url_list = file_get_contents($url_file['tmp_name']);
                break;
        }
        $url_list = split(PHP_EOL, $url_list);
        $auto_user_mod = D('auto_user');
        $user_mod = D('user');
        $unames = $auto_user_mod->where(array('id'=>$auid))->getField('users');
        $unamea = explode(',', $unames);
        $users = $user_mod->field('id,username')->where(array('username'=>array('in', $unamea)))->select();
        !$users && $this->error('auto_user_error');
        $item_mod = D('item');
        foreach ($url_list as $url) {
            if (!$url) continue;
            $itemcollect = new itemcollect();
            $itemcollect->url_parse($url);
            $item = $itemcollect->fetch();
            if (!$item = $itemcollect->fetch()) continue;
            $item = $item['item'];
            $item_id = $item_mod->where(array('key_id'=>$item['key_id']))->getField('id');
            if ($item_id) continue;
            $user_rand = array_rand($users);
            $item['uid'] = $users[$user_rand]['id'];
            $item['uname'] = $users[$user_rand]['username'];
            $result = $item_mod->publish($item);
        }
        $this->success(L('operation_success'));
    }
}