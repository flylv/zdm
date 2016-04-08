$.fn.extend({
    tab: function (obj) {
        var args = {
            event: 'click'
        };
        args = $.extend(args, obj);
        return $(this).each(function () {
            var context = this;
            $(".merchantinfo-head li", context).bind(args.event, function () {
                var index = parseInt($(this).index()) + 1;
                $(".merchantinfoCont:nth-child(" + index + ")", context).siblings().hide();
                $(".merchantinfoCont:nth-child(" + index + ")", context).show();
                $(this).siblings().removeClass('current');
                $(this).addClass('current');
            });
        });
    },
    toggle_cls: function (cls) {
        $(this).hover(function () {
            $(this).addClass(cls);
        }, function () {
            $(this).removeClass(cls);
        });
    }
});
$(function () {
    $('.merchantinfo').tab();
});

