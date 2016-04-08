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
class menuModel extends baseModel {
    protected $_validate = array(
        array('name', 'require', '{%menu_name_require}'), 
        array('name', 'require', '{%module_name_require}'), 
        array('name', 'require', '{%action_name_require}'), 
    );
    public function admin_menu($pid, $with_self=false) {
        $pid = intval($pid);
        $where="pid=$pid and display=1 ";
        if ($with_self) {
            $where.=" or id=$pid";
        }
        if($_SESSION['admin']['role_id']>1){
            $where.=" and (select count(a.menu_id) from ".table("admin_auth")." as a 
                where a.role_id=".$_SESSION['admin']['role_id']." and a.menu_id=id)>0";   
        }
        $menus = D("menu")->where($where)->order('ordid')->select();
        return $menus;
    }
    public function sub_menu($pid = '', $big_menu = false) {
        $array = $this->admin_menu($pid, false);
        $numbers = count($array);
        if ($numbers==1 && !$big_menu) {
            return '';
        }
        return $array;
    }
    public function get_level($id,$array=array(),$i=0) {
        foreach($array as $n=>$value){
            if ($value['id'] == $id) {
                if($value['pid']== '0') return $i;
                $i++;
                return $this->get_level($value['pid'],$array,$i);
            }
        }
    }
    function get_menu_data(){            
        $where="display=1";
        if($_SESSION['admin']['role_id']>1){
            $where.=" and (select count(a.menu_id) from ".table("admin_auth")." as a 
            where a.role_id=".$_SESSION['admin']['role_id']." and a.menu_id=id)>0"; 
        }
        $res=$this->where($where)->field("id,name,module_name as m,action_name as a,data")->select();
        $menu_data=array('id_0'=>array('name'=>'后台首页','m'=>'index','a'=>'panel','data'=>''));
        foreach($res as $key=>$val){
            $menu_data['id_'.$val['id']]=$val;
            unset($menu_data['id_'.$val['id']]['id']);
        }
        return $menu_data;
    }
}