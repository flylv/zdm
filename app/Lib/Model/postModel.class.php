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
class postModel extends baseModel {
    protected $_auto = array(
        //array('add_time', 'time', 1, 'function'),
    );
    protected $_validate = array(
        array('title', 'require', '{%article_title_empty}'),
    );
    protected $_link = array(
        'mall' => array(
            'mapping_type' => BELONGS_TO,
            'class_name' => 'mall',
            'foreign_key' => 'mall_id',
        ),
    );
    public function addtime() {
        return date("Y-m-d H:i:s", time());
    }
    public function get_cid_by_title($title){
        $cid=array();
        $tags=D('tag')->get_tags_by_title($title);
        foreach($tags as $val){
            $cate=D("post_cate")->where(array('name'=>$val))->find();
            if(empty($cate)){
                $cid[]=$cate['id'];    
            }
        }
        return $cid;
    }
    function parse_data($data){
        $fields=array('is_hot','is_recommend','status','mall_id');
        foreach($fields as $val){
            if($data[$val]<0){
                unset($data[$val]);
            }
        }
        if(empty($data['uname'])){
            unset($data['uname']);
        }
        return $data;
    }
    protected function _parse_item($info){
        $info['_detail_url']=item_rewrite($info,$this->name);
        $info['info']=String::validateHtml($info['info']);
        return $info;
    }
}