<li class="category_{$node.id}{if isset($last) && $last == 'true'} last{/if}">
	<h4>
		<a href="{$node.link|escape:'html':'UTF-8'}"{if isset($currentCategoryId) && $node.id == $currentCategoryId} class="selected"{/if} title="{$node.desc|strip_tags|trim|escape:'html':'UTF-8'}">
			{$node.name|escape:'html':'UTF-8'}
		</a>
	</h4>
		
	{if $node.children|@count > 0}
		<ul class="main-level-submenus">
			{foreach from=$node.children item=child name=categoryTreeBranch}
				{if $smarty.foreach.categoryTreeBranch.last}
					{include file="$branche_tpl_path" node=$child last='true'}
				{else}
					{include file="$branche_tpl_path" node=$child last='false'}
				{/if}
			{/foreach}
		</ul>		
	{/if}
</li>
