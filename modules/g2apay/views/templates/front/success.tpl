{*
* @author      G2A Team
* @copyright   Copyright (c) 2015 G2A.COM
* @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*}
{capture name=path}
    {l s='Order confirmed' mod='g2apay'}
{/capture}

<h1 class="page-heading">
    {l s='Order confirmation' mod='g2apay'}
</h1>

<div id="g2apay__confirmation" class="g2apay__confirmation bootstrap"
     data-update-url="{$status_link|escape:'htmlall':'UTF-8'}"
     data-order-id="{$order_id|intval}">
    <div id="g2apay__loading" class="g2apay__loading">
        <img class="g2apay__loading-image" src="{$g2apay_path|escape:'htmlall':'UTF-8'}views/img/logo.png"
             alt="{l s='Please wait' mod='g2apay'}"/>

        <p>{l s='Waiting for payment status update...' mod='g2apay'}</p>
    </div>

    <div id="g2apay__message" class="alert">

    </div>

    <div>
        <p class="center">
            <a class="exclusive_large" href="{$link->getPageLink('history.php', true)|escape:'htmlall':'UTF-8'}">
                {l s='Show orders history' mod='g2apay'}</a>
        </p>
    </div>
</div>
