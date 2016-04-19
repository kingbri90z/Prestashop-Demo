{if isset($best_sellers) && $best_sellers}
	{include file="$tpl_dir./product-list.tpl" products=$best_sellers class='blockbestsellers tab-pane' id='blockbestsellers'}
{else}
	<ul id="blockbestsellers" class="blockbestsellers tab-pane">
		<li class="alert alert-info">{l s='No best sellers at this time.' mod='blockbestsellers'}</li>
	</ul>
{/if}