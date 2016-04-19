{if isset($new_products) && $new_products}
	{include file="$tpl_dir./product-list.tpl" products=$new_products class='blocknewproducts tab-pane' id='blocknewproducts'}
{else}
    <ul id="blocknewproducts" class="blocknewproducts tab-pane">
        <li class="alert alert-info">{l s='No new products at this time.' mod='blocknewproducts'}</li>
    </ul>
{/if}