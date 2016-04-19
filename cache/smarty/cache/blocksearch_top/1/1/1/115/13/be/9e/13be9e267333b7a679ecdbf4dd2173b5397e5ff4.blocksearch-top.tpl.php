<?php /*%%SmartyHeaderCode:14876312785713a412762c30-09928686%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '13be9e267333b7a679ecdbf4dd2173b5397e5ff4' => 
    array (
      0 => '/var/www/html/themes/theme1133/modules/blocksearch/blocksearch-top.tpl',
      1 => 1460904921,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14876312785713a412762c30-09928686',
  'variables' => 
  array (
    'link' => 0,
    'search_query' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5713a41278efc3_75111667',
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5713a41278efc3_75111667')) {function content_5713a41278efc3_75111667($_smarty_tpl) {?><!-- Block search module TOP -->
<div id="search_block_top">
	<form id="searchbox" method="get" action="http://162.243.199.85/index.php?controller=search" >
		<input type="hidden" name="controller" value="search" />
		<input type="hidden" name="orderby" value="position" />
		<input type="hidden" name="orderway" value="desc" />
		<input class="search_query form-control" type="text" id="search_query_top" name="search_query" placeholder="Search..." value="" />
		<button type="submit" name="submit_search" class="btn btn-default button-search">
			<span>Search...</span>
		</button>
	</form>
</div>
<!-- /Block search module TOP --><?php }} ?>
