<?php /* Smarty version Smarty-3.1.19, created on 2016-04-18 20:15:40
         compiled from "/var/www/html/admin101/themes/default/template/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1106334639571578acec75b2-90605863%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a68e2e01e3da3878bdf9beccdf1a888d53dc2903' => 
    array (
      0 => '/var/www/html/admin101/themes/default/template/content.tpl',
      1 => 1448579398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1106334639571578acec75b2-90605863',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_571578aced3da7_50867733',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_571578aced3da7_50867733')) {function content_571578aced3da7_50867733($_smarty_tpl) {?>
<div id="ajax_confirmation" class="alert alert-success hide"></div>

<div id="ajaxBox" style="display:none"></div>


<div class="row">
	<div class="col-lg-12">
		<?php if (isset($_smarty_tpl->tpl_vars['content']->value)) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div><?php }} ?>
