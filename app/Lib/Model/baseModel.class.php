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
*/class baseModel extends RelationModel {
    var $attach_fields = array('img', 'extimg');
    var $editor_fields=array('info');
    protected function _after_find(&$result, $options) {
        parent::_after_find($result,$options);
        if (method_exists($this, '_parse_item')) {
            $result = $this->_parse_item($result);
        }
        $result = $this->parse($result);
    }
    protected function _after_getField(&$result, $options) {
        parent::_after_getField($result,$options);
        if(!is_array($result) &&in_array($options['field'],$this->attach_fields)){            
            $result=attach($result, $this->name,true);
        }        
    }
    function _after_select(&$result, $options) {
        parent::_after_select($result,$options);
        foreach ($result as $key => $val) {
            if (method_exists($this, '_parse_item')) {
                $result[$key] = $this->_parse_item($val);
            }
            $result[$key] = $this->parse($result[$key]);
        }
    }    function parse($info) {
        foreach ($this->attach_fields as $val) {
            if (array_key_exists($val, $info)) {
                $info['_'.$val] = attach($info[$val], $this->name,true);
            }
        }
        foreach($this->editor_fields as $val){
            if(array_key_exists($val,$info)){
                $info[$val]=parse_editor_info($info[$val]);    
            }     
        }        
        return $info;
    }
}