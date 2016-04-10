<?php if (!defined('THINK_PATH')) exit();?><!doctype html><html><head><meta charset="utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><link href="__TMPL__public/css/style.css" rel="stylesheet"/><title><?php echo L('website_manage');?></title><script>	var URL = '__URL__';
	var SELF = '__SELF__';
	var ROOT_PATH = '__ROOT__';
	var APP	 =	 '__APP__';
    var MODULE_NAME='<?php echo MODULE_NAME;?>';
    var ACTION_NAME='<?php echo ACTION_NAME;?>';
	//语言项目
	var lang = new Object();
	<?php $_result=L('js_lang');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>lang.<?php echo ($key); ?> = "<?php echo ($val); ?>";<?php endforeach; endif; else: echo "" ;endif; ?></script></head><body><div id="J_ajax_loading" class="ajax_loading"><?php echo L('ajax_loading');?></div><?php if(($sub_menu != '') OR ($big_menu != '')): ?><div class="subnav"><div class="content_menu ib_a blue line_x"><?php if(!empty($big_menu)): if($big_menu['title']): ?><a class="add fb J_showdialog" href="javascript:void(0);" data-uri="<?php echo ($big_menu["iframe"]); ?>" data-title="<?php echo ($big_menu["title"]); ?>" data-id="<?php echo ($big_menu["id"]); ?>" data-width="<?php echo ($big_menu["width"]); ?>" data-height="<?php echo ($big_menu["height"]); ?>"><em><?php echo ($big_menu["title"]); ?></em></a><?php else: if(is_array($big_menu)): $i = 0; $__LIST__ = $big_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><a class="add fb J_showdialog" href="javascript:void(0);" data-uri="<?php echo ($val["iframe"]); ?>" data-title="<?php echo ($val["title"]); ?>" data-id="<?php echo ($val["id"]); ?>" data-width="<?php echo ($val["width"]); ?>" data-height="<?php echo ($val["height"]); ?>"><em><?php echo ($val["title"]); ?></em></a><?php endforeach; endif; else: echo "" ;endif; endif; endif; if(!empty($sub_menu)): if(is_array($sub_menu)): $key = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($key % 2 );++$key; if($key != 1): ?><span>|</span><?php endif; ?><a href="<?php echo U($val['module_name'].'/'.$val['action_name'],array('menuid'=>$menuid)); echo ($val["data"]); ?>" class="<?php echo ($val["class"]); ?>"><em><?php echo ($val['name']); ?></em></a><?php endforeach; endif; else: echo "" ;endif; endif; ?></div></div><?php endif; ?><style type="text/css">#mall_id{
    width: 200px;
}
select[name="index"]{
    width: 40px;
}
</style><form id="info_form" action="<?php echo U(MODULE_NAME.'/'.ACTION_NAME);?>" method="post" enctype="multipart/form-data"><div class="pad_10"><div class="col_tab"><ul class="J_tabs tab_but cu_li"><li class="current"><?php echo L('article_basic');?></li></ul><div class="J_panes"><div class="content_list pad_10"><table><tr><td style="width: 80%;"><table width="100%" cellspacing="0" class="table_form"><tr><th style="width: 100px;">封面图片名称：</th><td style="width: 680px;"><input type="text" name="cover_image_name" id="J_cover_image_name" rel="cover_image_name" class="input-text" value="<?php echo ($info["cover_image_name"]); ?>"/></td></tr><tr><th>Logo图片名称：</th><td><input type="text" name="logo_image_name" id="J_logo_image_name" class="input-text" value="<?php echo ($info["logo_image_name"]); ?>"/></td></tr><tr><th>中文名称：</th><td><input type="text" name="name_cn" class="input-text" value="<?php echo ($info["name_cn"]); ?>"/></td></tr><tr><th>法文名称：</th><td><input type="text" name="name_fr" class="input-text" value="<?php echo ($info["name_fr"]); ?>"/></td></tr><tr><th>版本：</th><td><input type="text" name="num_version" id="num_version" class="input-text"  value="<?php echo ($info["num_version"]); ?>"/></td></tr><tr><th>状态：</th><td><label><input type="radio" name="status" class="radio_style" value="1" <?php if($info['status'] == 1): ?>checked="checked"<?php endif; ?>/> 已通过</label>&nbsp;&nbsp;
                                        <label><input type="radio" name="status" class="radio_style" value="0" <?php if($info['status'] == 0): ?>checked="checked"<?php endif; ?>/>未审核</label></td></tr><tr><th>描述：</th><td><textarea name="description" id="description" style="width:100%;height:350px;visibility:hidden;resize:none;"><?php echo ($info["description"]); ?></textarea></td></tr></table></td></tr></table></div></div></div><input type="hidden" name="menuid"  value="<?php echo ($menuid); ?>"/><div class="btn_wrap_fixed"><div class="mt10"><input type="submit" value="<?php echo L('submit');?>" id="dosubmit" name="dosubmit" class="btn btn_submit" style="margin:0px 0px 0px 100px;"/></div></div></div><input type="hidden" name="id" id="id" value="<?php echo ($info["id"]); ?>" /><?php if($Think['request']['collect_flag'] == 0 and isset($Think['request']['collect_flag'])): ?><input type="hidden" name="collect_flag" value="1"/><?php endif; ?></form><script type="text/javascript" src="__STATIC__/js/jquery/jquery.js"></script><script type="text/javascript" src="__STATIC__/js/jquery-ui/ui/jquery-ui.js"></script><link rel="stylesheet" type="text/css" href="__STATIC__/js/jquery-ui/themes/blue/jquery.ui.all.css" /><script type="text/javascript" src="__STATIC__/js/jquery-ui/extend/datepicker/jquery-ui-sliderAccess.js"></script><link rel="stylesheet" type="text/css" href="__STATIC__/js/jquery-ui/extend/datepicker/jquery-ui-timepicker-addon.css" /><script type="text/javascript" src="__STATIC__/js/jquery-ui/extend/datepicker/jquery-ui-timepicker-addon.js"></script><script type="text/javascript" src="__STATIC__/js/jquery-ui/ui/i18n/jquery.ui.datepicker-zh-CN.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/jquery.tools.min.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/formvalidator.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/jquery.artDialog.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/artDialog.plugins.js"></script><script type="text/javascript" src="__STATIC__/js/common.js"></script><script type="text/javascript" src="__STATIC__/js/zhiphp.js"></script><script>//初始化弹窗
(function (d) {
    d['okValue'] = lang.dialog_ok;
    d['cancelValue'] = lang.dialog_cancel;
    d['title'] = lang.dialog_title;
})($.dialog.defaults);
$('.J_preview').preview(); //查看大图
</script><?php if(isset($list_table)): ?><script type="text/javascript" src="__STATIC__/js/jquery/plugins/listTable.js"></script><script>$(function(){
	$('.J_tablelist').listTable();
});
</script><?php endif; ?><script src="__STATIC__/js/jquery/plugins/colorpicker.js"></script><script src="__STATIC__/js/kindeditor/kindeditor-min.js"></script><script>//$('.J_cate_select').cate_select('请选择');
$(function() {
	KindEditor.create('#description', {
		uploadJson : '<?php echo U("attachment/editer_upload");?>',
		fileManagerJson : '<?php echo U("attachment/editer_manager");?>',
		allowFileManager : true,
        items:['source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
		'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
		'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
		'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen',
		'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
		'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', 'image', 'multiimage', 
		'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
		'anchor', 'link', 'unlink']
	});
	$('ul.J_tabs').tabs('div.J_panes > div');
	
	//颜色选择器
	$('.J_color_picker').colorpicker();
	//自动获取标签
	$('#J_gettags').live('click', function() {
		var title = $.trim($('#J_title').val());
		if(title == ''){
			$.zhiphp.tip({content:lang.article_title_isempty, icon:'alert'});
			return false;
		}
		$.getJSON('<?php echo U(MODULE_NAME."/ajax_gettags");?>', {title:title}, function(result){
			if(result.status == 1){
				$('#J_tags').val(result.data);
			}else{
				$.zhiphp.tip({content:result.msg});
			}
		});
	});
    create_mall_index($('.J_mall_index'));
    $('.J_link_tab').each(function(){
        $this=$(this);
        var selected=$this.attr('data-selected');
        if($.trim(selected).length==0){
            selected='taobao';
        }
        $select_item=$('.tab_menu .tab_item[data-data="'+selected+'"]',$this);
        $select_item.attr('checked','checked');
        $('.tab_content .tab_item',$this).eq($select_item.index()).show().siblings().hide();
        $('.tab_menu .tab_item',$this).click(function(){
            $('.tab_content .tab_item',$this).eq($(this).index()).show().siblings().hide();
        });         
    });    
    $('.btn_b2c').click(function(){
        var link=$.trim($('.link_b2c').val());
        if(link.length>0){
            $.get("<?php echo U(MODULE_NAME.'/convert_link');?>",{link:link},function(data){
                if(data.status==1){
                    $('.url_b2c').val(data.data);
                }
            },'json');
        }
    });    
});
</script></body></html>