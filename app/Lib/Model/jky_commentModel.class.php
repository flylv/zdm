<?php 
/**
* ZhePHP 值得买模式的海淘网站程序
* ====================================================================
* ====================================================================
* Author: brivio <brivio@qq.com>
* 授权技术支持: 1142503300@qq.com
*/
class jky_commentModel extends baseModel
{
    protected $_auto = array (array('add_time','time',1,'function'));
    protected $_link = array(
        'user' => array(
            'mapping_type' => BELONGS_TO,
            'class_name' => 'user',
            'foreign_key' => 'uid',
        ),        
        'item'=> array(
            'mapping_type' => BELONGS_TO,
            'class_name' => 'jky_item',
            'foreign_key' => 'item_id',
        ),   
    );
    protected function _after_insert($data,$options) {
        $jky_item_mod = D('jky_item');
        $jky_item_mod->where(array('id'=>$data['item_id']))->setInc('comments');
    }
}