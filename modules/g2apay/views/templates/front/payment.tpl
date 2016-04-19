{*
* @author      G2A Team
* @copyright   Copyright (c) 2015 G2A.COM
* @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*}
{capture name=path}
    {l s='Confirm & Pay' mod='g2apay'}
{/capture}

<h1 class="page-heading">
    {l s='G2A Pay' mod='g2apay'}
</h1>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}
{if isset($nbProducts) && $nbProducts <= 0}
    <p class="warning">{l s='Shopping cart is empty.' mod='g2apay'}</p>
{else}
    <img src="{$g2apay_path|escape:'htmlall':'UTF-8'}views/img/g2a-pay.png" alt="{l s='G2A Pay' mod='g2apay'}"/>
    <form action="{$controller_link|escape:'htmlall':'UTF-8'}" method="post">
        <p>
            {l s='You have chosen to pay with G2A Pay.' mod='g2apay'}
            {l s='The total amount of your order:' mod='g2apay'}
            <strong>{displayPrice price=$total}</strong>
            {if $use_taxes == 1}
                {l s='(tax incl.)' mod='g2apay'}
            {/if}
        </p>

        <p>
            <strong>{l s='To confirm and pay your order click the Checkout Button below' mod='g2apay'}</strong>
        </p>

        <p class="cart_navigation" id="cart_navigation">
            <a href="{$link->getPageLink('order.php', true)|escape:'htmlall':'UTF-8'}?step=3"
               class="button button-exclusive btn btn-default"><i
                        class="icon-chevron-left"></i>{l s='Change method' mod='g2apay'}</a>
            <input name="submitToken" type="hidden" value="{$submit_token|escape:'htmlall':'UTF-8'}"/>
            <input style="float: right;" type="image" src="{$g2apay_path|escape:'htmlall':'UTF-8'}views/img/checkout.png"
                   alt="{l s='Confirm and Pay' mod='g2apay'}"/>
        </p>
    </form>
{/if}
