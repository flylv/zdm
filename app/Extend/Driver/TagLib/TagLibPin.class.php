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
class TagLibPin extends TagLib {
    protected $tags = array(
        'itemcate' => array(
            'attr' => 'type,cateid,field,num,img,where,order,return',
            'close' => 1,
            'level' => 3),
        'album' => array('attr' => 'type,cateid,uid,field,num,where,order,return',
                'close' => 1),
        'user' => array('attr' => 'type,field,num,where,order,return', 'close' => 1),
        'scoreitem' => array('attr' => 'type,cateid,field,num,where,order,return',
                'close' => 1),
        'article' => array('attr' =>
                'type,cateid,field,num,image,where,order,return,relation', 'close' => 1),
        'nav' => array('attr' => 'type,field,style,num,order,return', 'close' => 1),
        'flink' => array(
            'attr' => 'type,cateid,style,field,num,order,cache,return',
            'close' => 1,
            'level' => 2),
        'load' => array('attr' => 'type,href', 'close' => 0),
        );
    public function __call($method, $args) {
        $tag = substr($method, 1);
        if (!isset($this->tags[$tag])) return false;
        $_tag = parent::parseXmlAttr($args[0], $tag);
        $_tag['cache'] = isset($_tag['cache']) ? intval($_tag['cache']) : 0;
        $_tag['return'] = isset($_tag['return']) ? trim($_tag['return']) : 'data';
        $_tag['type'] = isset($_tag['type']) ? trim($_tag['type']) : '';
        if (!$_tag['type']) return false;
        $parse_str = '<?php ';
        if ($_tag['cache']) {
            ksort($_tag);
            $tag_id = md5($tag . '&' . implode('&', array_keys($_tag)) . '&' . implode('&',
                array_values($_tag)));
            $parse_str .= '$' . $_tag['return'] . ' = S(\'' . $tag_id . '\');';
            $parse_str .= 'if (false === $' . $_tag['return'] . ') { ';
        }
        $action = $_tag['type'];
        $class = '$tag_' . $tag . '_class';
        $parse_str .= $class . ' = new ' . $tag . 'Tag;';
        $parse_str .= '$' . $_tag['return'] . ' = ' . $class . '->' . $action . '(' .self::arr_to_html($_tag). ');';
        if ($_tag['cache']) {
            $parse_str .= 'S(\'' . $tag_id . '\', $' . $_tag['return'] . ', ' . $_tag['cache'] .
                ');';
            $parse_str .= ' }';
        }
        $parse_str .= '?>';
        $parse_str .= $args[1];
        return $parse_str;
    }
    private static function arr_to_html($data) {
        if (is_array($data)) {
            $str = 'array(';
            foreach ($data as $key=>$val) {
                if (is_array($val)) {
                    $str .= "'$key'=>".self::arr_to_html($val).",";
                } else {
                    if (strpos($val, '$')===0) {
                        $str .= "'$key'=>$val,";
                    } else {
                        $str .= "'$key'=>'".addslashes_deep($val)."',";
                    }
                }
            }
            return $str.')';
        }
        return false;
    }
}
?>