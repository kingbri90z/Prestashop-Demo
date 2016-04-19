function categoryReload () {
//animate the opening of the branch (span.grower jQueryElement)
function openBranch(jQueryElement, noAnimation)
{
		jQueryElement.addClass('OPEN').removeClass('CLOSE');
		if(noAnimation)
			jQueryElement.parent().find('ul:first').show();
		else
			jQueryElement.parent().find('ul:first').slideDown();
}
//animate the closing of the branch (span.grower jQueryElement)
function closeBranch(jQueryElement, noAnimation)
{
	jQueryElement.addClass('CLOSE').removeClass('OPEN');
	if(noAnimation)
		jQueryElement.parent().find('ul:first').hide();
	else
		jQueryElement.parent().find('ul:first').slideUp();
}

//animate the closing or opening of the branch (ul jQueryElement)
function toggleBranch(jQueryElement, noAnimation)
{
	if(jQueryElement.hasClass('OPEN'))
		closeBranch(jQueryElement, noAnimation);
	else
		openBranch(jQueryElement, noAnimation);
}

	//when the page is loaded...

	//to do not execute this script as much as it's called...
		$('.column ul.tree.dhtml ul').parent().find("span.grower").remove();
		$('.column ul.tree.dhtml ul').prev().before("<span class='grower OPEN'> </span>");
		
		//dynamically add the '.last' class on each last item of a branch
		$('.column ul.tree.dhtml ul li:last-child, .column ul.tree.dhtml li:last-child').addClass('last');
		
		//collapse every expanded branch
		$('.column ul.tree.dhtml span.grower.OPEN').addClass('CLOSE').removeClass('OPEN').parent().find('ul:first').hide();
		$('.column ul.tree.dhtml').show();
		
		//open the tree for the selected branch
			$('.column ul.tree.dhtml .selected').parents().each( function() {
				if ($(this).is('ul'))
					toggleBranch($(this).prev().prev(), true);
			});
			toggleBranch( $('.column ul.tree.dhtml .selected').prev(), true);
		
		//add a fonction on clicks on growers
		var clickEventType=((document.ontouchstart!==null)?'click':'touchstart');
		$('.column ul.tree.dhtml span.grower').on(clickEventType,function(){
			toggleBranch($(this));
		});
}