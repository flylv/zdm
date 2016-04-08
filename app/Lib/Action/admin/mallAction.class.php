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
class mallAction extends backendAction
{
    var $list_relation = true;
    public function _initialize()
    {
        parent::_initialize();
        $this->img_dir = "./data/upload/mall/";
        $this->assign('img_dir', $this->img_dir);
        $this->assign('cate_list', $this->_get_cate_list());
        $this->assign('index_list', get_index());
    }
    protected function _search()
    {
        $map = array();
        ($cid = $this->_get('cid', 'intval')) > 0 && $map['cid'] = array('eq', $cid);
        $status = $this->_get('status');
        if ($status != null) {
            $map['status'] = array('eq', intval($status));
        }
        ($keyword = $this->_get('keyword', 'trim')) && $map['title|domain'] = array('like', '%' . $keyword . '%');
        $url = $this->_get('url', 'trim');
        if (!empty($url) && $url != -1) {
            if ($url == 'empty') {
                $map['url'] = array('eq', "");
            } else {
                $map['url'] = $url;
            }
        }
        $this->assign('search', array(
            'keyword' => $keyword,
            'cid' => $cid,
            'status' => $status,
            'url' => $url,
        ));
        return $map;
    }
    protected function _before_insert($data)
    {
        if (!empty($_FILES['img']['name'])) {
            $art_add_time = date('ym/d');
            $result = $this->_upload($_FILES['img'], 'mall/' . $art_add_time);
            if ($result['error']) {
                $this->error($result['info']);
            } else {
                $data['img'] = $art_add_time . '/' . $result['info'][0]['savename'];
            }
        }
        ($post_time = $this->_get('post_time', 'trim')) && $data['post_time'] = strtotime($post_time);
        return $data;
    }
    protected function _before_update($data)
    {
        if (!empty($_FILES['img']['name'])) {
            $art_add_time = date('ym/d');
            $old_img = D("mall")->where(array('id' => $data['id']))->getField('img');
            $old_img = $this->img_dir . $old_img;
            is_file($old_img) && @unlink($old_img);
            $result = $this->_upload($_FILES['img'], 'mall/' . $art_add_time);
            if ($result['error']) {
                $this->error($result['info']);
            } else {
                $data['img'] = $art_add_time . '/' . $result['info'][0]['savename'];
            }
        } else {
            unset($data['img']);
        }
        ($post_time = $this->_get('post_time', 'trim')) && $data['post_time'] = strtotime($post_time);
        return $data;
    }
    protected function _get_cate_list()
    {
        $res = D("mall_cate")->where("status=1")->order("ordid")->select();
        $list = array();
        foreach ($res as $key => $val) {
            $list[$val['id']] = $val['title'];
        }
        return $list;
    }
    public function get_mall_list()
    {
        $index=$this->_get('index','strtoupper');
        $where="";
        if($index){
            $where=" `index`='$index'";
        }
        $list=D('mall')->field("id,title")->where($where)->limit("0,500")->select();
        print_r(json_encode($list));
    }
    public function get_mall(){
        $id=$this->_get('id','intval');
        $info=D('mall')->field('id,title,index')->where("id=$id")->find();
        print_r(json_encode($info));
    }
}