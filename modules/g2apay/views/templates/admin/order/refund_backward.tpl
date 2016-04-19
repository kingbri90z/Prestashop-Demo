{*
* @author      G2A Team
* @copyright   Copyright (c) 2015 G2A.COM
* @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*}
<br/>
<div style="float: left">
    <fieldset style="width: 400px;">
        <legend><img src="{$g2apay_path|escape:'htmlall':'UTF-8'}/logo.gif" />{l s='G2A Pay Online Refund' mod='g2apay'}</legend>
        {foreach from=$errors item=error}
            <p class="alert alert-danger">{$error|escape:'htmlall':'UTF-8'}</p>
        {/foreach}
        <form method="post" action="{$smarty.server.REQUEST_URI|escape:'htmlall':'UTF-8'}">
            <input type="hidden" name="id_order" value="{$params.id_order|intval}"/>

            <p>{l s='Send amount G2A Pay that will be automatically refunded. Must be confirmed by IPN to be recorded in the system.' mod='g2apay'}</p>

            <p class="center">
                <input value="{$max_online_refund_amount|escape:'htmlall':'UTF-8'}" name="G2APAY_REFUND_AMOUNT" />
                <button type="submit" class="btn btn-default" name="submitG2APayOnlineRefund"
                        onclick="if (!confirm('{l s='Are you sure?' mod='g2apay'}'))return false;">
                    <i class="icon-undo"></i>
                    {l s='Refund online' mod='g2apay'}
                </button>
            </p>
        </form>
    </fieldset>
</div>
