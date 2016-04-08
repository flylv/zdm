<?php 
return array (
  'HTML_CACHE_ON' => true,
  'HTML_CACHE_RULES' => 
  array (
    'index:index' => 
    array (
      0 => '{$_SERVER.REQUEST_URI|md5}',
      1 => 600,
    ),
    'jky_item:index' => 
    array (
      0 => '{$_SERVER.REQUEST_URI|md5}',
      1 => 600,
    ),
    'post_cate:index' => 
    array (
      0 => '{$_SERVER.REQUEST_URI|md5}',
      1 => 600,
    ),
  ),
  'BASIC_THEME' => 'default',
  'DEFAULT_THEME' => 'zhe800',
  'TPL_SIGNATURE' => 
  array (
    'zhe800' => 'czoxODoiTVRJM0xqQXVNQzR4emhlODAwIjs=',
  ),
);