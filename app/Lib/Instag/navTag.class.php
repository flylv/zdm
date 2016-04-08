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
class navTag {    
    public function lists($options) {
        $options['field'] = isset($options['field']) ? trim($options['field']) : '*';
        $options['style'] = isset($options['style']) ? trim($options['style']) : '';
        $options['where'] = isset($options['where']) ? trim($options['where']) : '';
        $options['num'] = isset($options['num']) ? intval($options['num']) : 0;
        $options['order'] = isset($options['order']) ? trim($options['order']) : 'ordid';
        if ($options['field'] != '*' || $options['where'] || $options['order'] != 'ordid') {
            $nav_mod = D('nav');
            $select = $nav_mod->field($field); 
            $map = array('status'=>'1');
            $options['style'] && $map = array('type' => $options['style']); 
            $select->where($map);
            $options['num'] && $select->limit($options['num']); 
            $select->order($options['order']); 
            $data = $select->select();
        } else {
            if (false === $nav_list = F('nav_list')) {
                $nav_list = D('nav')->nav_cache();
            }
            $nav_list = $nav_list[$options['style']];
            $options['num'] && $nav_list = array_slice($nav_list, 0, $options['num']);
            $data = $nav_list;
        }
        foreach ($data as $key=>$val) {
            switch ($val['alias']) {
                case 'book':
                    $data[$key]['link'] = U('book/index');
                    break;
                case 'album':
                    $data[$key]['link'] = U('album/index');
                    break;
                case 'exchange':
                    $data[$key]['link'] = U('exchange/index');
                    break;
            }
        }
        return $data;
    }
}