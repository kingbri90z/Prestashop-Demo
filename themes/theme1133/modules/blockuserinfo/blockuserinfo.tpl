<!-- Block user information module NAV  -->
<ul class="user_info">
    {if $is_logged}
    	<li>
        	<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='View my customer account' mod='blockuserinfo'}" class="account" rel="nofollow">
            	<span>{$cookie->customer_firstname|truncate:2:'.'|escape:'html':'UTF-8'} {$cookie->customer_lastname}</span>
            </a>
        </li>
        <li>
        	<a class="logout" href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log me out' mod='blockuserinfo'}">
            	{l s='Sign out' mod='blockuserinfo'}
        	</a>
        </li>
    {else}
    	<li>
        	<a href="{$link->getPageLink('my-account', true)}" title="{l s='View my customer account' mod='blockuserinfo'}" rel="nofollow">
            	{l s='Your Account' mod='blockuserinfo'}
            </a>
        </li>
        <li>
        	<a class="login" href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Login to your customer account' mod='blockuserinfo'}">
            	{l s='Sign in' mod='blockuserinfo'}
        	</a>
        </li>
    {/if}
</ul>
<!-- /Block usmodule NAV -->