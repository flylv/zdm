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
class albumTag {
    public function cate($options) {
        $options['field'] = isset($options['field']) ? trim($options['field']) : '*';
        $options['where'] = isset($options['where']) ? trim($options['where']) : '';
        $options['num'] = isset($options['num']) ? intval($options['num']) : 0;
        $options['order'] = isset($options['order']) ? trim($options['order']) : 'ordid';
        if ($options['field'] != '*' || $options['where'] || $options['order'] != 'ordid') {
            $album_cate_mod = D('album_cate');
            $map = array('status'=>'1');
            $select = $album_cate_mod->field($options['field']); 
            $options['where'] && $map['_string'] = $options['where'];
            $select->where($map); 
            $options['num'] && $select->limit($options['num']); 
            $select->order($options['order']); 
            $data = $select->select();
        } else {
            if (false === $cate_list = F('album_cate_list')) {
                $cate_list = D('album_cate')->cate_cache();
            }
            $options['num'] && $cate_list = array_slice($cate_list, 0, $options['num']);
            $data = $cate_list;
        }
        return $data;
    }
    public function lists($options) {
        $options['field'] = isset($options['field']) ? trim($options['field']) : '*';
        $options['cateid'] = isset($options['cateid']) ? intval($options['cateid']) : 0;
        $options['uid'] = isset($options['uid']) ? intval($options['uid']) : 0;
        $options['where'] = isset($options['where']) ? trim($options['where']) : '';
        $options['num'] = isset($options['num']) ? intval($options['num']) : 0;
        $options['order'] = isset($options['order']) ? trim($options['order']) : 'ordid,id DESC';
        $album_mod = D('album');
        $select = $album_mod->field($options['field']); 
        $map = array('status'=>'1');
        $options['cateid'] && $map['cate_id'] = $options['cateid'];
        $options['uid'] && $map['uid'] = $options['uid'];
        $options['where'] && $map['_string'] = $options['where'];
        $select->where($map);
        $options['num'] && $select->limit($options['num']); 
        $select->order($options['order']); 
        $data = $select->select();
        if ($data) {
            foreach ($data as $key=>$val) {
                $data[$key]['cover'] = unserialize($val['cover_cache']);
            }
        }
        return $data;
    }
}