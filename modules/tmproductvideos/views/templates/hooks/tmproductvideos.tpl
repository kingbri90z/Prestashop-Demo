{if isset($videos) && $videos}
    <section id="product-videos" class="page-product-box">
        <h3 class="page-product-heading">{if count($videos) > 1}{l s='Videos' mod='tmproductvideos'}{else}{l s='Video' mod='tmproductvideos'}{/if}</h3>
        {foreach from=$videos item=video name=myvideo}
        	{if $video.type == 'youtube'}
            	<div class="videowrapper">
                	<iframe type="text/html" 
                    	src="{$video.link|escape:'html'}?wmode=transparent"
                    	frameborder="0"></iframe>
                </div>
            {elseif $video.type == 'vimeo'}
            	<div class='embed-container'>
                	<iframe 
                    	src="{$video.link|escape:'html'}"
                        frameborder="0"
                        webkitAllowFullScreen
                        mozallowfullscreen
                        allowFullScreen>
                    </iframe>
                </div>
            {/if}
        	{if $video.name}
            	<h4 class="video-name">{$video.name|escape:'html'}</h4>
            {/if}
            {if $video.description}
            	<p class="video-description">{$video.description}</p>
            {/if}
        {/foreach}
    </section>
{/if}