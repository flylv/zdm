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
class settingModel extends baseModel
{
    public function setting_cache() {
        $setting = array();
        $res = $this->getField('name,data');
        foreach ($res as $key=>$val) {
            $setting['pin_'.$key] = unserialize($val) ? unserialize($val) : $val;
        }
        F('setting', $setting);
        return $setting;
    }
    protected function _before_write($data, $options) {
        F('setting', NULL);
    }
    function update($setting){
        foreach ($setting as $key => $val) {
            $val = is_array($val) ? serialize($val) : $val;
            if($this->where(array('name' => $key))->find()){
                $this->where(array('name' => $key))->save(array('data' => $val));
            }else{
                $this->add(array('name'=>$key,'data'=>$val));
            }
        }                
        if(file_exists(DATA_PATH."setting.php")){
            !unlink(DATA_PATH."setting.php")&&exit(DATA_PATH."setting.php文件无法删除，请检查文件权限");    
        }         
    }
}