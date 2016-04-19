<?php /* Smarty version Smarty-3.1.19, created on 2016-04-18 20:18:04
         compiled from "/var/www/html/admin101/themes/default/template/controllers/tax_rules/helpers/list/list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20167721405715793c417a05-65187769%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '34a661f3ab914b657c1406e5c5d9f44d1666ab8b' => 
    array (
      0 => '/var/www/html/admin101/themes/default/template/controllers/tax_rules/helpers/list/list_action_edit.tpl',
      1 => 1448579398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20167721405715793c417a05-65187769',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5715793c431e20_90102109',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5715793c431e20_90102109')) {function content_5715793c431e20_90102109($_smarty_tpl) {?>
<a onclick="loadTaxRule('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
'); return false;" href="#" class="btn btn-default">
	<i class="icon-pencil"></i> 
	<?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a><?php }} ?>
