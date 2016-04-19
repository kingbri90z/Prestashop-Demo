<script>
	function addVideoParallax(selector, path, filename)
	{
		var selector = $(selector);

		selector.addClass('parallax_section');
		selector.attr('data-type-media', 'video_html');
		selector.attr('data-mp4', 'true');
		selector.attr('data-webm', 'true');
		selector.attr('data-ogv', 'true');
		selector.attr('data-poster', 'true');
		selector.wrapInner('<div class="parallax_content"></div>');
		selector.append('<div class="parallax_inner"><video class="parallax_media" width="100%" height="100%" autoplay loop poster="{$base_path}'+path+filename+'.jpg"><source src="{$base_path}'+path+filename+'.mp4" type="video/mp4"><source src="{$base_path}'+path+filename+'.webdm" type="video/webm"><source src="{$base_path}'+path+filename+'.ogv" type="video/ogg"></video></div>');

		selector.tmMediaParallax();
	}
	
	function addImageParallax(selector, path, filename, width, height)
	{
		var selector = $(selector);

		selector.addClass('parallax_section');
		selector.attr('data-type-media', 'image');
		selector.wrapInner('<div class="parallax_content"></div>');
		selector.append('<div class="parallax_inner"><img class="parallax_media" src="{$base_path}'+path+filename+'" data-base-width="'+width+'" data-base-height="'+height+'"/></div>');

		selector.tmMediaParallax();
	}

	function checkBrowser()
	{
	    var ua = navigator.userAgent;
	    
	    if (ua.search(/MSIE/) > 0) return 'Internet Explorer';
	    if (ua.search(/Firefox/) > 0) return 'Firefox';
	    if (ua.search(/Opera/) > 0) return 'Opera';
	    if (ua.search(/Chrome/) > 0) return 'Google Chrome';
	    if (ua.search(/Safari/) > 0) return 'Safari';
	    if (ua.search(/Konqueror/) > 0) return 'Konqueror';
	    if (ua.search(/Iceweasel/) > 0) return 'Debian Iceweasel';
	    if (ua.search(/SeaMonkey/) > 0) return 'SeaMonkey';
	    if (ua.search(/Gecko/) > 0) return 'Gecko';

	    return 'Search Bot';
	}

	{if $smooth_scroll_on == 1}

		$(window).load(function(){  
		    if(checkBrowser() == 'Google Chrome' && device.windows()){
		        if (window.addEventListener) window.addEventListener('DOMMouseScroll', wheel, false);
		            window.onmousewheel = document.onmousewheel = wheel;

		            var time = {$smooth_scroll_time};
		            var distance = {$smooth_scroll_distance};

		            function wheel(event) {
		                if (event.wheelDelta) delta = event.wheelDelta / 90;
		                else if (event.detail) delta = -event.detail / 3;
		                handle();
		                if (event.preventDefault) event.preventDefault();
		                event.returnValue = false;
		            }

		            function handle() {
		                $('html, body').stop().animate({
		                    scrollTop: $(window).scrollTop() - (distance * delta)
		                }, time);
		            }
		    }
		});

	{/if}

	$(window).load(function(){
		{foreach from=$parallaxitems item=item}
			{if $item.type == 'image'}
				addImageParallax('{$item.selector}','{$media_path}','{$item.filename}','{$item.width}','{$item.height}');
			{/if}
			{if $item.type == 'video'}
				addVideoParallax('{$item.selector}','{$media_path}','{$item.filename}');
			{/if}
		{/foreach}
	});
</script>
