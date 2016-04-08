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
class Url {
    static public function replace($url, $options) {
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $query_arr);
        foreach ($options as $key=>$val) {
            if (array_key_exists($key, $query_arr)) {
                $query_arr[$key] = $options[$key];
            }
        }
        $return = http_build_query($query_arr);
        if (false !== strpos($url, '?')) {
            $return = array_shift(explode('?', $url)) . '?' . $return;
        }
        return $return;
    }
}