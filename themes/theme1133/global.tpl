{strip}
    {addJsDef baseDir=$content_dir}
    {addJsDef baseUri=$base_uri}
    {addJsDef static_token=$static_token}
    {addJsDef token=$token}
    {addJsDef priceDisplayPrecision=$priceDisplayPrecision*$currency->decimals}
    {addJsDef priceDisplayMethod=$priceDisplay}
    {addJsDef roundMode=$roundMode}
    {addJsDef isLogged=$is_logged|intval}
    {addJsDef isGuest=$is_guest|intval}
    {addJsDef page_name=$page_name|escape:'html':'UTF-8'}
    {addJsDef contentOnly=$content_only|boolval}
    {if isset($cookie->id_lang)}
        {addJsDef id_lang=$cookie->id_lang|intval}
    {/if}
    {addJsDefL name=FancyboxI18nClose}{l s='Close'}{/addJsDefL}
    {addJsDefL name=FancyboxI18nNext}{l s='Next'}{/addJsDefL}
    {addJsDefL name=FancyboxI18nPrev}{l s='Previous'}{/addJsDefL}
    {addJsDef usingSecureMode=Tools::usingSecureMode()|boolval}
    {addJsDef ajaxsearch=Configuration::get('PS_SEARCH_AJAX')|boolval}
    {addJsDef instantsearch=Configuration::get('PS_INSTANT_SEARCH')|boolval}
    {addJsDef quickView=$quick_view|boolval}
    {addJsDef displayList=Configuration::get('PS_GRID_PRODUCT')|boolval}
{/strip}