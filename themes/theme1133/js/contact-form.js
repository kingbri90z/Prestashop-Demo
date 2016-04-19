//global variables
if (typeof $.uniform.defaults !== 'undefined')
{
	if (typeof contact_fileDefaultHtml !== 'undefined')
		$.uniform.defaults.fileDefaultHtml = contact_fileDefaultHtml;
	if (typeof contact_fileButtonHtml !== 'undefined')
		$.uniform.defaults.fileButtonHtml = contact_fileButtonHtml;
}

$(document).ready(function(){
	$(document).on('change', 'select[name=id_contact]', function(){
		showElemFromSelect('id_contact', 'desc_contact')
	});

	$(document).on('change', 'select[name=id_order]', function (){
		showProductSelect($(this).attr('value'));
	});

	showProductSelect($('select[name=id_order]').attr('value'));
});

function showProductSelect(id_order)
{
	$('.product_select').hide().prop('disabled', 'disabled').parent('.selector').hide();
	$('.product_select').parents('.form-group').find('label').hide();
	if ($('#' + id_order + '_order_products').length > 0)
	{
		$('#' + id_order + '_order_products').removeProp('disabled').show().parent('.selector').removeClass('disabled').show();
		$('.product_select').parents('.form-group').show().find('label').show();
	}
}