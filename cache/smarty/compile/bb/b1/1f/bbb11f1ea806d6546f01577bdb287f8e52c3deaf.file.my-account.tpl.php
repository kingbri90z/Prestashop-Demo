<?php /* Smarty version Smarty-3.1.19, created on 2016-04-18 20:34:22
         compiled from "/var/www/html/modules/blockwishlist/my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:61693388957157d0ed85996-06219204%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bbb11f1ea806d6546f01577bdb287f8e52c3deaf' => 
    array (
      0 => '/var/www/html/modules/blockwishlist/my-account.tpl',
      1 => 1460936673,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '61693388957157d0ed85996-06219204',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'module_template_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_57157d0edb1b64_72818764',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57157d0edb1b64_72818764')) {function content_57157d0edb1b64_72818764($_smarty_tpl) {?>

<!-- MODULE WishList -->
<li class="lnk_wishlist">
	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('blockwishlist','mywishlist',array(),true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'My wishlists','mod'=>'blockwishlist'),$_smarty_tpl);?>
">
		<img src="<?php echo $_smarty_tpl->tpl_vars['module_template_dir']->value;?>
img/gift.gif" alt="<?php echo smartyTranslate(array('s'=>'My wishlists','mod'=>'blockwishlist'),$_smarty_tpl);?>
" class="icon" />
		<?php echo smartyTranslate(array('s'=>'My wishlists','mod'=>'blockwishlist'),$_smarty_tpl);?>

	</a>
</li>
<!-- END : MODULE WishList --><?php }} ?>
