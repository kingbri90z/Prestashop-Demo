<div id="contact-link">
	<a href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}" title="{l s='Contact Us' mod='blockcontact'}">{l s='Contact us' mod='blockcontact'}</a>
</div>
{if $telnumber}
	<span class="shop-phone">
		<i class="fa fa-phone"></i>
        {l s='Call us now:' mod='blockcontact'} 
        <strong>{$telnumber}</strong>
	</span>
{/if}