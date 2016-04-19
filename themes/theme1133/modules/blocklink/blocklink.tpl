<!-- Block links module -->
<section id="links_block_left" class="block">
	<h4 class="title_block">
	{if $url}
		<a href="{$url|escape}" title="{$title|escape}">{$title|escape}</a>
	{else}
		{$title|escape}
	{/if}
	</h4>
    <div class="block_content list-block">
        <ul>
            {foreach from=$blocklink_links item=blocklink_link}
                {if isset($blocklink_link.$lang)} 
                    <li><a href="{$blocklink_link.url|escape}"{if $blocklink_link.newWindow} onclick="window.open(this.href);return false;"{/if} title="{$blocklink_link.$lang|escape}">{$blocklink_link.$lang|escape}</a></li>
                {/if}
            {/foreach}
        </ul>
    </div>
</section>
<!-- /Block links module -->
