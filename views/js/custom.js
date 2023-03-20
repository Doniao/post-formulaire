jQuery(document).ready(function(){
	var formInputs = jQuery('input[type="text"]');
	formInputs.focus(function() {
       jQuery(this).parent().children('p.formLabel').addClass('formTop');
	});
	formInputs.focusout(function() {
		if (jQuery.trim(jQuery(this).val()).length == 0){
		jQuery(this).parent().children('p.formLabel').removeClass('formTop');
		}
		
	});
	jQuery('p.formLabel').click(function(){
		 jQuery(this).parent().children('.form-style').focus();
	});
   
});