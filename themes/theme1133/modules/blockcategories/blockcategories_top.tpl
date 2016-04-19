<!-- Block categories module -->
<div id="categories_block_top">
	<div class="category_top">
		<div class="list">
			<ul class="tree {if $isDhtml}dhtml{/if} sf-menu sf-js-enabled clearfix">
				{foreach from=$blockCategTree.children item=child name=blockCategTree}				
					{if $smarty.foreach.blockCategTree.last}
						{include file="$branche_tpl_path" node=$child last='true'}
					{else}
						{include file="$branche_tpl_path" node=$child}
					{/if}

					{if isset($blockCategTree.thumbnails) && $blockCategTree.thumbnails|count > 0}
						<div id="category-thumbnails">
							{foreach $blockCategTree.thumbnails as $thumbnail}
								<div>{$thumbnail}</div>
							{/foreach}
						</div>
					{/if}
					{if ($smarty.foreach.blockCategTree.iteration mod $numberColumn) == 0 AND !$smarty.foreach.blockCategTree.last}
			</ul>
		</div>
	</div>

	<div class="category_footer" style="float:left;clear:none;width:{$widthColumn}%">
		<div style="float:left" class="list">
			<ul class="tree {if $isDhtml}dhtml{/if}">
					{/if}
				{/foreach}
			</ul>
		</div>
	</div>
</div>
<!-- /Block categories module -->