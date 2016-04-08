$('.J_favs').live('click', function() {
	var $this = $(this);
	var id = $this.attr("data-id");
	$.get('index.php?m=user&a=favs_add', {
		id: id
	}, function(data) {
		$.zhiphp._tip({
			content: data.msg,
			status: data.status == 1
		});
		if (data.status == 1) {
			$this.find('span').html(data.data);
		}
	}, 'json');
});
$(document).ready(function() {
    $('#click_show').hover(function(){
        $('.content',this).show();
    },function(){
        $('.content',this).hide();
    });
    
    //----------------------------------
});

function toggle_detail($this) {
    var is_short = $this.hasClass('short_content');
    $showtext_body = $this.parents('.singlepro-desc').find('.singlepro-desc-hidden');
    var old_height, new_height;
    if (is_short) {
        $this.removeClass('short_content').addClass('long_content').text('<向上收起');
        $old_height = $showtext_body.height();
        $showtext_body.css({
            'overflow': 'visible',
            'height': 'auto'
        });
        $new_height = $showtext_body.height();
        $('img', $showtext_body).show();
        $showtext_body.removeClass('showcont_l');
        //$showtext_body.removeClass('fl');
    } else {
        $this.removeClass('long_content').addClass('short_content').text('展开全文>');
        $showtext_body.css({
            'overflow': 'hidden',
            'height': '189px'
        });
        $('img', $showtext_body).hide();
        $showtext_body.addClass('showcont_l');
        //$showtext_body.addClass('fl');
    }
}