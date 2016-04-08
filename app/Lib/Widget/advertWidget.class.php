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
class advertWidget extends Action {
    public function index($id) {
        $id = intval($id);
        $board_info = D('adboard')->where(array('id'=>$id, 'status'=>'1'))->find();
        if (!$board_info) {
            return false;
        }
        $tpl_cfg = include dirname(__FILE__).'/advert/'.$board_info['tpl'].'.config.php';
        $time_now = time();
        $map['board_id'] = $id;
        $map['start_time'] = array('elt', $time_now);
        $map['end_time'] = array('egt', $time_now);
        $map['status'] = '1';
        $limit = $tpl_cfg['option'] ? '' : '1';
        $ad_list = D('ad')->field('id,type,name,url,content,desc,extimg,extval')->where($map)->order('ordid')->limit($limit)->select();
        foreach ($ad_list as $key=>$val) {
            $ad_list[$key]['html'] = $this->_get_html($val, $board_info);
        }        
        $this->assign('board_info', $board_info);
        $this->assign('ad_list', $ad_list);
        $this->display(dirname(__FILE__).'/advert/'.$board_info['tpl'].'.html');
    }
    private function _get_html($ad, $board_info) {
        $html = $ad['content'];
        $size_html = '';
        $board_info['width'] && $size_html .= 'width="'.$board_info['width'].'"';
        $board_info['height'] && $size_html .= ' height="'.$board_info['height'].'"';
        switch ($ad['type']) {
            case 'image':
                $html  = '<a title="'.$ad['name'].'" href="'.U('advert/tgo',array('id'=>$ad['id'])).'" target="_blank">';
                $html .= '<img alt="'.$ad['name'].'" src="'.__ROOT__.'/data/upload/ad/'.$ad['content'].'" '.$size_html.'>';
                $html .= '</a>';
                break;
            case 'flash':
                $html  = '<a title="'.$ad['name'].'" href="'.U('advert/tgo',array('id'=>$ad['id'])).'" target="_blank">';
                $html .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" '.$size_html.' codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0">';
                $html .= '<param name="movie" value="'.__ROOT__.'/data/upload/ad/'.$ad['content'].'" />';
                $html .= '<param name="quality" value="autohigh" />';
                $html .= '<param name="wmode" value="opaque" />';
                $html .= '<embed src="'.__ROOT__.'/data/upload/ad/'.$ad['content'].'" quality="autohigh" wmode="opaque" name="flashad" swliveconnect="TRUE" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" '.$size_html.'></embed>';
                $html .= '</object>';
                $html .= '</a>';
                break;
        }
        return $html;
    }
}