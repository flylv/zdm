<?php if (!defined('THINK_PATH')) exit();?><!doctype html><html><head><meta charset="utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><link href="__TMPL__public/css/style.css" rel="stylesheet"/><title><?php echo L('website_manage');?></title><script>	var URL = '__URL__';
	var SELF = '__SELF__';
	var ROOT_PATH = '__ROOT__';
	var APP	 =	 '__APP__';
    var MODULE_NAME='<?php echo MODULE_NAME;?>';
    var ACTION_NAME='<?php echo ACTION_NAME;?>';
	//语言项目
	var lang = new Object();
	<?php $_result=L('js_lang');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>lang.<?php echo ($key); ?> = "<?php echo ($val); ?>";<?php endforeach; endif; else: echo "" ;endif; ?></script></head><body><div id="J_ajax_loading" class="ajax_loading"><?php echo L('ajax_loading');?></div><?php if(($sub_menu != '') OR ($big_menu != '')): ?><div class="subnav"><div class="content_menu ib_a blue line_x"><?php if(!empty($big_menu)): if($big_menu['title']): ?><a class="add fb J_showdialog" href="javascript:void(0);" data-uri="<?php echo ($big_menu["iframe"]); ?>" data-title="<?php echo ($big_menu["title"]); ?>" data-id="<?php echo ($big_menu["id"]); ?>" data-width="<?php echo ($big_menu["width"]); ?>" data-height="<?php echo ($big_menu["height"]); ?>"><em><?php echo ($big_menu["title"]); ?></em></a><?php else: if(is_array($big_menu)): $i = 0; $__LIST__ = $big_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><a class="add fb J_showdialog" href="javascript:void(0);" data-uri="<?php echo ($val["iframe"]); ?>" data-title="<?php echo ($val["title"]); ?>" data-id="<?php echo ($val["id"]); ?>" data-width="<?php echo ($val["width"]); ?>" data-height="<?php echo ($val["height"]); ?>"><em><?php echo ($val["title"]); ?></em></a><?php endforeach; endif; else: echo "" ;endif; endif; endif; if(!empty($sub_menu)): if(is_array($sub_menu)): $key = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($key % 2 );++$key; if($key != 1): ?><span>|</span><?php endif; ?><a href="<?php echo U($val['module_name'].'/'.$val['action_name'],array('menuid'=>$menuid)); echo ($val["data"]); ?>" class="<?php echo ($val["class"]); ?>"><em><?php echo ($val['name']); ?></em></a><?php endforeach; endif; else: echo "" ;endif; endif; ?></div></div><?php endif; ?><!--文章列表--><div class="pad_10" ><form name="searchform" method="get" ><table width="100%" cellspacing="0" class="search_form"><tbody><tr><td><div class="explain_col"><input type="hidden" name="g" value="<?php echo GROUP_NAME;?>" /><input type="hidden" name="m" value="<?php echo MODULE_NAME;?>" /><input type="hidden" name="a" value="<?php echo ACTION_NAME;?>" /><input type="hidden" name="menuid" value="<?php echo ($menuid); ?>" /><?php echo L('publish_time');?>：
                <input type="text" name="time_start" id="time_start" class="date J_date_picker" size="12" value="<?php echo ($search["time_start"]); ?>">                -
                <input type="text" name="time_end" id="time_end" class="date J_date_picker" size="12" value="<?php echo ($search["time_end"]); ?>">                &nbsp;&nbsp;<?php echo L('article_cateid');?>：
                <select class="J_cate_select mr10" data-pid="0" data-uri="<?php echo U('post_cate/ajax_getchilds');?>" data-selected="<?php echo ($search["selected_ids"]); ?>"></select><input type="hidden" name="cate_id" id="J_cate_id" value="<?php echo ($search["cate_id"]); ?>" />                &nbsp;&nbsp;来源:
                <?php echo html_select('mall_id',$mall_list,$search['mall_id']);?>                &nbsp;&nbsp;<?php echo L('status');?>:
                <select name="status"><option value="">-<?php echo L('all');?>-</option><option value="1" <?php if($search["status"] == '1'): ?>selected="selected"<?php endif; ?>>已审核</option><option value="0" <?php if($search["status"] == '0'): ?>selected="selected"<?php endif; ?>>未审核</option></select>                &nbsp;&nbsp;<?php echo L('keyword');?> :
                <input name="keyword" type="text" class="input-text" size="25" value="<?php echo ($search["keyword"]); ?>" /><input type="submit" name="search" class="btn" value="<?php echo L('search');?>" /><input type="hidden" name="collect_flag" value="<?php echo ($_GET['collect_flag']); ?>"></div></td></tr></tbody></table></form><div class="J_tablelist table_list" data-acturi="<?php echo U(MODULE_NAME.'/ajax_edit');?>"><table width="100%" cellspacing="0"><thead><tr><th width="30">序号</th><th width=25><input type="checkbox" id="checkall_t" class="J_checkall"></th><th><span data-tdtype="order_by" data-field="id">ID</span></th><th width="40">图片</th><th align="left"><span data-tdtype="order_by" data-field="title"><?php echo L('title');?></span></th><th width="80">来源</th><th width=100>发布人</th><th width="140"><span data-tdtype="order_by" data-field="add_time"><?php echo L('publish_time');?></span></th><th width="60"><span data-tdtype="order_by" data-field="ordid"><?php echo L('sort_order');?></span></th><th width="28">热门</th><th width="28">推荐</th><th width="28"><span data-tdtype="order_by" data-field="status"><?php echo L('status');?></span></th><th width="80">操作</th></tr></thead><tbody><?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr><td align="center"><?php echo ($p*20-20+$i); ?></td><td align="center"><input type="checkbox" class="J_checkitem" value="<?php echo ($val["id"]); ?>"></td><td align="center"><?php echo ($val["id"]); ?></td><td><?php if(!empty($val['img'])): ?><div class="img_border"><img src="<?php echo ($val["_img"]); ?>" width="32" class="J_preview" data-bimg="<?php echo ($val["_img"]); ?>"/></div><?php endif; ?></td><td align="left"><span data-tdtype="edit" data-field="title" data-id="<?php echo ($val["id"]); ?>" class="tdedit" style="color:<?php echo ($val["colors"]); ?>;"><?php echo ($val["title"]); ?></span></td><td align="center"><strong><?php echo ($val["mall"]["title"]); ?></strong></td><td align="center"><b><?php echo ($val["uname"]); ?></b></td><td align="center"><span data-tdtype="edit" data-field="post_time" data-id="<?php echo ($val["id"]); ?>" class="date"><?php echo date("Y-m-d H:i:s",$val['post_time']);?></span></td><td align="center"><span data-tdtype="edit" data-field="ordid" data-id="<?php echo ($val["id"]); ?>" class="tdedit"><?php echo ($val["ordid"]); ?></span></td><td align="center"><img data-tdtype="toggle" data-id="<?php echo ($val["id"]); ?>" data-field="is_hot" data-value="<?php echo ($val["is_hot"]); ?>" src="__TMPL__public/images/toggle_<?php if($val["is_hot"] == 0): ?>disabled<?php else: ?>enabled<?php endif; ?>.gif" /></td><td align="center"><img data-tdtype="toggle" data-id="<?php echo ($val["id"]); ?>" data-field="is_recommend" data-value="<?php echo ($val["is_recommend"]); ?>" src="__TMPL__public/images/toggle_<?php if($val["is_recommend"] == 0): ?>disabled<?php else: ?>enabled<?php endif; ?>.gif" /></td><td align="center"><img data-tdtype="toggle" data-id="<?php echo ($val["id"]); ?>" data-field="status" data-value="<?php echo ($val["status"]); ?>" src="__TMPL__public/images/toggle_<?php if($val["status"] == 0): ?>disabled<?php else: ?>enabled<?php endif; ?>.gif" /></td><td align="center"><a href="<?php echo u(MODULE_NAME.'/edit', array('id'=>$val['id'], 'menuid'=>$menuid,'collect_flag'=>$Think['request']['collect_flag']));?>"><?php echo L('edit');?></a>| 
                    <a href="javascript:void(0);" class="J_confirmurl" data-acttype="ajax" 
                        data-uri="<?php echo u(MODULE_NAME.'/delete', array('id'=>$val['id']));?>" 
                        data-msg="<?php echo sprintf(L('confirm_delete_one'),$val['title']);?>"><?php echo L('delete');?></a></td></tr><?php endforeach; endif; else: echo "" ;endif; ?></tbody></table><div class="btn_wrap_fixed"><label class="select_all"><input type="checkbox" name="checkall" class="J_checkall"><?php echo L('select_all');?>/<?php echo L('cancel');?></label><input type="button" class="btn" data-tdtype="batch_action" data-acttype="ajax"
                data-uri="<?php echo U(MODULE_NAME.'/delete');?>" data-name="id" data-msg="<?php echo L('confirm_delete');?>" value="<?php echo L('delete');?>" /><input type="button" class="btn" data-tdtype="batch_action" data-acttype="ajax_form"  data-id="batch_collect_form"
               data-title="<?php echo L('batch_edit');?>"
               data-uri="<?php echo U(MODULE_NAME.'/batch_edit');?>" data-name="id"
               value="<?php echo L('batch_edit');?>" data-width="500" value="<?php echo L('batch_action');?>" /><?php if($Think['request']['collect_flag'] == 0): ?><input type="button" class="btn" data-tdtype="batch_action" data-acttype="ajax"
                   data-uri="<?php echo U(MODULE_NAME.'/batch_edit',array('collect_flag'=>1,'act'=>'edit'));?>"
                   data-name="id" data-msg="<?php echo L('confirm_batch_publish');?>"
                   value="<?php echo L('batch_publish');?>" /><?php endif; ?><div id="pages"><?php echo ($page); ?></div></div></div></div><script type="text/javascript" src="__STATIC__/js/jquery/jquery.js"></script><script type="text/javascript" src="__STATIC__/js/jquery-ui/ui/jquery-ui.js"></script><link rel="stylesheet" type="text/css" href="__STATIC__/js/jquery-ui/themes/blue/jquery.ui.all.css" /><script type="text/javascript" src="__STATIC__/js/jquery-ui/extend/datepicker/jquery-ui-sliderAccess.js"></script><link rel="stylesheet" type="text/css" href="__STATIC__/js/jquery-ui/extend/datepicker/jquery-ui-timepicker-addon.css" /><script type="text/javascript" src="__STATIC__/js/jquery-ui/extend/datepicker/jquery-ui-timepicker-addon.js"></script><script type="text/javascript" src="__STATIC__/js/jquery-ui/ui/i18n/jquery.ui.datepicker-zh-CN.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/jquery.tools.min.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/formvalidator.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/jquery.artDialog.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/artDialog.plugins.js"></script><script type="text/javascript" src="__STATIC__/js/common.js"></script><script type="text/javascript" src="__STATIC__/js/zhiphp.js"></script><script>//初始化弹窗
(function (d) {
    d['okValue'] = lang.dialog_ok;
    d['cancelValue'] = lang.dialog_cancel;
    d['title'] = lang.dialog_title;
})($.dialog.defaults);
$('.J_preview').preview(); //查看大图
</script><?php if(isset($list_table)): ?><script type="text/javascript" src="__STATIC__/js/jquery/plugins/listTable.js"></script><script>$(function(){
	$('.J_tablelist').listTable();
});
</script><?php endif; ?><script>$('.J_cate_select').cate_select({top_option:lang.all});
</script></body></html>