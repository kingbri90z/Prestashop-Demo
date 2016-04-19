<!-- Breadcrumb -->
{if isset($smarty.capture.path)}
	{assign var='path' value=$smarty.capture.path}
{/if}

<div class="breadcrumb clearfix">
	<a class="home" href="{$base_dir}" title="{l s='Return to Home'}">
    	<i class="fa fa-home"></i>
    </a>
	{if isset($path) AND $path}
		<span class="navigation-pipe" {if isset($category) && isset($category->id_category) && $category->id_category == 1}style="display:none;"{/if}>{$navigationPipe|escape:'html':'UTF-8'}</span>
		{if !$path|strpos:'span'}
			<span class="navigation_page">{$path}</span>
		{else}
			{$path}
		{/if}
	{/if}
</div>

{if isset($smarty.get.search_query) && isset($smarty.get.results) && $smarty.get.results > 1 && isset($smarty.server.HTTP_REFERER)}
    <div class="pull-right">
        <strong>
            <a href="{$smarty.server.HTTP_REFERER|escape}" name="back" title="">
                <i class="fa fa-chevron-left left"></i> 
                {l s='Back to Search results for "%s" (%d other results)' sprintf=[$smarty.get.search_query,$smarty.get.results]}
            </a>
        </strong>
    </div>
{/if}
<!-- /Breadcrumb -->