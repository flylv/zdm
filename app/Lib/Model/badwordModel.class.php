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
class badwordModel extends baseModel
{
    protected $_auto = array (array('add_time','time',1,'function'));
    public function check($content) {
        $result = array('code'=>0, 'content'=>$content);
        if (!$content) {
            return $result;
        }
        $words = D('tag')->get_tags_by_title($content, 500);
        !$words && $words = $content;
        $badwords = $this->field('word_type,badword,replaceword')->where(array('badword'=>array('IN', $words)))->order('word_type')->select();
        if (!$badwords) {
            return $result;
        }
        foreach ($badwords as $val) {
            if ($val['word_type'] == 1) {
                $result['code'] = 1;
                return $result;
            }
            if ($val['word_type'] == 2) {
                $result['content'] = str_replace($val['badword'], $val['replaceword'], $result['content']);
            }
            if ($val['word_type'] == 3) {
                $result['code'] = 3;
            }
        }
        return $result;
    }
    public function name_exists($name, $id=0)
    {
        $pk = $this->getPk();
        $where = "badword='" . $name . "'  AND ". $pk ."<>'" . $id . "'";
        $result = $this->where($where)->count($pk);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}