<?php /* Smarty version Smarty-3.1.19, created on 2016-04-18 20:15:44
         compiled from "/var/www/html/admin101/themes/default/template/helpers/list/list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1605290818571578b00404e3-22711141%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ce0305e110418137d0046cee521b5855224c99df' => 
    array (
      0 => '/var/www/html/admin101/themes/default/template/helpers/list/list_action_edit.tpl',
      1 => 1448579398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1605290818571578b00404e3-22711141',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_571578b0051970_66560493',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_571578b0051970_66560493')) {function content_571578b0051970_66560493($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="edit">
	<i class="icon-pencil"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a><?php }} ?>
