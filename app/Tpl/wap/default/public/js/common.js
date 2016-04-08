$(function(){
    init_input();
});
function init_input() {
	$('.text,.J_tip').each(function() {	   
		$this = $(this);
        if(!empty($(this).val()))return;
        
		var tag = $this[0].tagName;
		if (tag == 'INPUT') {
			$this.val($this.attr('data-default'));
		} else if (tag == 'TEXTAREA') {
			$this.html($this.attr('data-default'));
		}
        $this.css('color','#666');
	}).click(function() {
		if ($(this).attr('data-default') == $(this).val()) {
			$(this).val('');
            $this.css('color','#000');
		}
	}).blur(function() {
		$this = $(this);
		if ($this.attr('data-default') == $this.val() || $.trim($this.val()) == '') {
			$this.val($this.attr('data-default'));
            $this.css('color','#666');
		}
	});
}
function empty (mixed_var) {
  var undef, key, i, len;
  var emptyValues = [undef, null, false, 0, "", "0"];

  for (i = 0, len = emptyValues.length; i < len; i++) {
    if (mixed_var === emptyValues[i]) {
      return true;
    }
  }

  if (typeof mixed_var === "object") {
    for (key in mixed_var) {
      // TODO: should we check for own properties only?
      //if (mixed_var.hasOwnProperty(key)) {
      return false;
      //}
    }
    return true;
  }

  return false;
}