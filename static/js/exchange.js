/**
 * @name 积分兑换
 * @author andery@foxmail.com
 * @url http://www.zhiphp.com
 */
;(function($){
    $.zhiphp.exchange = {
        settings: {
            ec_btn: '.J_ec_btn'
        },
        init: function(options){
            options && $.extend($.zhiphp.exchange.settings, options);
            //详细信息切换
            $('ul.J_desc_tab').tabs('div.J_desc_panes > div');
            $.zhiphp.exchange.ec();
        },
        ec: function(){
            var s = $.zhiphp.exchange.settings;
            $(s.ec_btn).live('click', function(){
                if(!$.zhiphp.dialog.islogin()) return !1;
                var id = $(this).attr('data-id');
                $.getJSON(PINER.root + '/?m=exchange&a=ec', {id:id, num:1}, function(result){
                    if(result.status == 1){
                        $.zhiphp._tip({content:result.msg});
                    }else if(result.status == 2){
                        $.dialog({id:'ec_address', title:result.msg, content:result.data, width:450, padding:'', fixed:true, lock:true});
                        $.zhiphp.exchange.daddress_form($('#J_daddress_form'));
                    }else{
                        $.zhiphp._tip({content:result.msg, status:0});
                    }
                });
            });
        },
        //收货地址表单
        daddress_form: function(form){
            form.ajaxForm({
                success: function(result){
                    if(result.status == 1){
                        $.dialog.get('ec_address').close();
                        $.zhiphp.tip({content:result.msg});
                        window.location.reload();
                    } else {
                        $.zhiphp.tip({content:result.msg, icon:'error'});
                    }
                },
                dataType: 'json'
            });
        }
    };
    $.zhiphp.exchange.init();
})(jQuery);