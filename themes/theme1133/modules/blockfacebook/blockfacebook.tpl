{if $facebookurl != ''}
<div id="fb-root"></div>
<div id="facebook_block" class="col-xs-4">
    <div class="insert">
        <h4 >{l s='Follow us on facebook' mod='blockfacebook'}</h4>
        <div class="facebook-fanbox">
            <div class="fb-like-box" 
                data-href="{$facebookurl|escape:'html':'UTF-8'}" 
                data-height="237" 
                data-colorscheme="light" 
                data-show-faces="true" 
                data-header="false" 
                data-stream="false" 
                data-show-border="false"
                connections="10">
            </div>
        </div>
    </div>
</div>
{/if}
