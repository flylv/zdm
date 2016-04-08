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
class admin_roleModel extends baseModel
{
    protected $_link = array(
        'role_priv' => array(
            'mapping_type'  => MANY_TO_MANY,
            'class_name'    => 'menu',
            'foreign_key'   => 'role_id',
            'relation_foreign_key'=>'menu_id',
            'relation_table' => 'admin_auth',
            'auto_prefix' => true
        )
    );
    protected $_validate = array(
        array('name','require','{%role_name_empty}'),
        array('name','','{%role_name_exists}',0,'unique',1),
    );
    public function check_name($name, $id='')
    {
        $where = "name='$name'";
        if ($id) {
            $where .= " AND id<>'$id'";
        }
        $id = $this->where($where)->getField('id');
        if ($id) {
            return false;
        } else {
            return true;
        }
    }
}