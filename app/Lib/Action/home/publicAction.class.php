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
class publicAction extends frontendAction
{
    public function go()
    {
        $id = $this->_get('id', 'intval', 0);
        $type = $this->_get('type', 'trim', 'post');
        if ($type == 'post') {
            $url = D('post')->where(array('id' => $id))->getField('url');
        } else {
            $url = D('jky_item')->where(array('id' => $id))->getField('url');
        }
        $info = array();
        $res = parse_uri($url);
        if (in_array($res['host'], array('item.taobao.com', 'detail.tmall.com'))) {
            $info = array(
                'id' =>$res['_query']['id'],
                'site' => 'taobao',
                'url' => $url
            );
        } else {
            $info = array(
                'url' => $url
            );
        }
        $this->assign('info', $info);
        $this->display();
    }
}