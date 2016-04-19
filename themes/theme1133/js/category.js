$(document).ready(function(){
	$(document).on('click', '.lnk_more', function(e){
		e.preventDefault();
		$('#category_description_short').hide(); 
		$('#category_description_full').show(); 
		$(this).hide();
	});
});