<!--
* G2APay Submit Controller.
*
* @author      G2A Team
* @copyright   Copyright (c) 2015 G2A.COM
* @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
-->
<form {if isset($current) && $current} action="{$current|escape:'html':'UTF-8'}{if isset($token) && $token}&amp;token={$token|escape:'html':'UTF-8'}{/if}"{/if}
        method="post" enctype="multipart/form-data">
    {if !empty($submit_action)}
        <input type="hidden" name="{$submit_action|escape:'htmlall':'UTF-8'}" value="1"/>
    {/if}
    {foreach $fields as $f => $fieldset}
        <div class="tab-page" id="fieldset_{$f|escape:'htmlall':'UTF-8'}">
            {foreach $fieldset.form as $key => $field}
                {if $key == 'legend'}
                    <h2>{$field.title|escape:'htmlall':'UTF-8'}</h2>
                {elseif $key == 'input'}
                    {foreach $field as $input}
                        {assign var='value' value=$fields_value[$input.name]}
                        {if $input.type == 'hidden'}
                            <input type="hidden" name="{$input.name|escape:'htmlall':'UTF-8'}" id="{$input.name|escape:'htmlall':'UTF-8'}"
                                   value="{$fields_value[$input.name]|escape:'html':'UTF-8'}"/>
                        {else}
                            <div class="margin-form">
                                <label for="{$input.name|escape:'htmlall':'UTF-8'}">
                                    {$input.label|escape:'htmlall':'UTF-8'}{if isset($input.required) && $input.required && $input.type != 'radio'}*{/if}
                                </label>
                                {if $input.type == 'text'}
                                    <input type="text" name="{$input.name|escape:'htmlall':'UTF-8'}" id="{$input.name|escape:'htmlall':'UTF-8'}"
                                           value="{$value|escape:'html':'UTF-8'}" size="30"/>
                                {elseif $input.type == 'password'}
                                    <input type="password" name="{$input.name|escape:'htmlall':'UTF-8'}" id="{$input.name|escape:'htmlall':'UTF-8'}"
                                           value="{$value|escape:'html':'UTF-8'}" size="30"/>
                                {elseif $input.type == 'radio'}
                                    {foreach $input.values as $value}
                                        <input type="radio" name="{$input.name|escape:'htmlall':'UTF-8'}" id="{$value.id|escape:'htmlall':'UTF-8'}"
                                               value="{$value.value|escape:'html':'UTF-8'}"{if $fields_value[$input.name] == $value.value} checked="checked"{/if} />
                                        <label for="{$value.id|escape:'htmlall':'UTF-8'}" class="t">{$value.label|escape:'htmlall':'UTF-8'}</label>
                                    {/foreach}
                                {/if}
                            </div>
                        {/if}
                        <div class="clear"></div>
                    {/foreach}
                {elseif $key == 'submit'}
                    <p class="center">
                        <input type="submit" class="button" value="{$field.title|escape:'htmlall':'UTF-8'}"/>
                    </p>
                {/if}
            {/foreach}
        </div>
    {/foreach}
</form>