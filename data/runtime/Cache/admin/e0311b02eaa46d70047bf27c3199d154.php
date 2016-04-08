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
</style><form id="info_form" action="<?php echo U(MODULE_NAME.'/'.ACTION_NAME);?>" method="post" enctype="multipart/form-data"><div class="pad_10"><div class="col_tab"><ul class="J_tabs tab_but cu_li"><li class="current"><?php echo L('article_basic');?></li><li><?php echo L('article_seo');?></li></ul><div class="J_panes"><div class="content_list pad_10"><table><tr><td style="width: 80%;"><table width="100%" cellspacing="0" class="table_form"><tr><th style="width: 60px;">商品名称：</th><td style="width: 680px;"><input type="text" name="title" id="J_title" rel="title_color" class="input-text iColorPicker" size="72" value="<?php echo ($info["title"]); ?>" style="color:<?php echo ($info["tcolor"]); ?>"><input type="hidden" value="<?php echo ($info["tcolor"]); ?>" name="tcolor" id="J_color"><a href="javascript:;" class="color_picker_btn"><img class="J_color_picker" data-it="J_title" data-ic="J_color" src="__STATIC__/images/color.png"></a></td></tr><tr><th>商品标签：</th><td><input type="text" name="tags" id="J_tags" class="input-text" size="65" value="<?php echo ($tags); ?>"/><input type="button" value="<?php echo L('auto_get');?>" id="J_gettags" name="tags_btn" class="btn"/></td></tr><tr><th>商品链接：</th><td><input type="text" name="url" class="input-text" size="60"value="<?php echo ($info["url"]); ?>"/></td></tr><tr><th>商品价格：</th><td><input type="text" name="prices" class="input-text" size="60" value="<?php echo ($info["prices"]); ?>"/></td></tr><tr><th>所属商城：</th><td><div class="J_mall_index" data-id="<?php echo ($info["mall_id"]); ?>"><select class="index"></select><select class="list" name="mall_id"></select></div></td></tr><tr><th>商品图片：</th><td><?php if(!empty($info['img'])): ?><span class="attachment_icon J_attachment_icon" file-type="image" file-rel="<?php echo ($info["_img"]); ?>"></span><br /><?php endif; ?>                                        上传：<input type="file" name="img" class="input-text"  style="width:200px;" />                                        &nbsp;&nbsp;<input type="text" class="input-text J_tip" data-default="或者输入外部图片地址" name="img_url" value="<?php echo ($info["img"]); ?>" size="55"/></td></tr><tr><th> 开始时间：</th><td><input type="text" name="start_time" id="J_start_time" class="date J_date_picker" size="20" value="<?php echo ($info['start_time']); ?>"/></td></tr><tr><th> 结束时间：</th><td><input type="text" name="end_time" id="J_end_time" class="date J_date_picker" size="20" value="<?php echo ($info['end_time']); ?>"/></td></tr><tr><th>物流信息：</th><td><textarea name="delivery_info" id="delivery_info" style="width:90%;height:100px;resize:none;"><?php echo ($info["delivery_info"]); ?></textarea></td></tr><tr><th>提示：</th><td><textarea name="tips" id="tips" style="width:90%;height:100px;resize:none;"><?php echo ($info["tips"]); ?></textarea></td></tr><tr><th>所属品牌：</th><td><select name="brand_id"><option value=""></option><option value="1">品牌1</option><option value="2">品牌2</option><option value="3">品牌3</option></select></td></tr><tr><th>语言：</th><td><select name="lang"><option value=""></option><option value="cn">中文</option><option value="fr">法语</option></select></td></tr><tr><td colspan="2"><textarea name="info" id="info" style="width:100%;height:350px;visibility:hidden;resize:none;"><?php echo ($info["info"]); ?></textarea></td></tr></table></td><td valign="top"><table width="100%" cellspacing="0" class="table_form inner_table"><tr><td><div class="box"><div class="box_title">所属栏目：</div><div class="box_content" style="height: 250px;overflow-y: scroll;"><?php echo ($cate_tree); ?></div></div></td></tr><tr><td>                                    作者：
                                        <input type="text" name="uname" class="input-text" size="28" value="<?php echo ($info["uname"]); ?>"/></td></tr><tr><td>                                    热门：
                                    <label><input type="radio" name="is_hot" class="radio_style" value="1" <?php if($info['is_hot'] == 1): ?>checked="checked"<?php endif; ?>/> 是</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          							<label><input type="radio" name="is_hot" class="radio_style" value="0"<?php if($info['is_hot'] == 0): ?>checked="checked"<?php endif; ?>/>否</label></td></tr><tr><td>                                    推荐：
                                    <label><input type="radio" name="is_recommend" class="radio_style" value="1" <?php if($info['is_recommend'] == 1): ?>checked="checked"<?php endif; ?>/> 已推荐</label>&nbsp;&nbsp;
          							<label><input type="radio" name="is_recommend" class="radio_style" value="0"<?php if($info['is_recommend'] == 0): ?>checked="checked"<?php endif; ?>/>未推荐</label></td></tr><tr><td>                                        审核状态：
                                        <label><input type="radio" name="status" class="radio_style" value="1" <?php if($info['status'] == 1): ?>checked="checked"<?php endif; ?>/> 已通过</label>&nbsp;&nbsp;
            							<label><input type="radio" name="status" class="radio_style" value="0" <?php if($info['status'] == 0): ?>checked="checked"<?php endif; ?>/>未审核</label></td></tr><tr><td>                                        定时发布：
                                        <input type="text" name="post_time" id="J_time_start" class="date J_date_picker" size="20" value="<?php echo date('Y-m-d H:i',$info['post_time']);?>"/></td></tr><tr><td>                                        排序：
                                        <input type="text" name="ordid" class="input-text" size="28" value="<?php echo ($info["ordid"]); ?>"/></td></tr><tr><td>                                        发布状态：
                                        <?php if($info['post_time'] <= time()): ?>已发布
                                        <?php else: ?><span class="red">未发布</span><?php endif; ?></td></tr><tr><td>                                        添加时间：<?php echo date("Y-m-d H:i:s",$info['add_time']);?></td></tr></table></td></tr></table></div><div class="content_list pad_10 hidden"><table width="100%" cellspacing="0" class="table_form"><tr><th width="120"><?php echo L('seo_title');?>：</th><td><input type="text" name="seo_title" id="seo_title" class="input-text" size="60" value="<?php echo ($info["seo_title"]); ?>"></td></tr><tr><th><?php echo L('seo_keys');?>：</th><td><input type="text" name="seo_keys" id="seo_keys" class="input-text" size="60" value="<?php echo ($info["seo_keys"]); ?>"></td></tr><tr><th><?php echo L('seo_desc');?>：</th><td><textarea name="seo_desc" id="seo_desc" cols="80" rows="8"><?php echo ($info["seo_desc"]); ?></textarea></td></tr></table></div></div></div><input type="hidden" name="menuid"  value="<?php echo ($menuid); ?>"/><div class="btn_wrap_fixed"><div class="mt10"><input type="submit" value="<?php echo L('submit');?>" id="dosubmit" name="dosubmit" class="btn btn_submit" style="margin:0px 0px 0px 100px;"/></div></div></div><input type="hidden" name="id" id="id" value="<?php echo ($info["id"]); ?>" /><?php if($Think['request']['collect_flag'] == 0 and isset($Think['request']['collect_flag'])): ?><input type="hidden" name="collect_flag" value="1"/><?php endif; ?></form><script type="text/javascript" src="__STATIC__/js/jquery/jquery.js"></script><script type="text/javascript" src="__STATIC__/js/jquery-ui/ui/jquery-ui.js"></script><link rel="stylesheet" type="text/css" href="__STATIC__/js/jquery-ui/themes/blue/jquery.ui.all.css" /><script type="text/javascript" src="__STATIC__/js/jquery-ui/extend/datepicker/jquery-ui-sliderAccess.js"></script><link rel="stylesheet" type="text/css" href="__STATIC__/js/jquery-ui/extend/datepicker/jquery-ui-timepicker-addon.css" /><script type="text/javascript" src="__STATIC__/js/jquery-ui/extend/datepicker/jquery-ui-timepicker-addon.js"></script><script type="text/javascript" src="__STATIC__/js/jquery-ui/ui/i18n/jquery.ui.datepicker-zh-CN.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/jquery.tools.min.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/formvalidator.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/jquery.artDialog.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/artDialog.plugins.js"></script><script type="text/javascript" src="__STATIC__/js/common.js"></script><script type="text/javascript" src="__STATIC__/js/zhiphp.js"></script><script>//初始化弹窗
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
	KindEditor.create('#info', {
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