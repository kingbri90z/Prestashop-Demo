<?php /* Smarty version Smarty-3.1.19, created on 2016-04-18 20:16:21
         compiled from "/var/www/html/themes/theme1133/modules/blockcmsinfo/blockcmsinfo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:710597989571578d6009a00-56719538%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '59880dc55a5322013a914e295c36b2554e41fcce' => 
    array (
      0 => '/var/www/html/themes/theme1133/modules/blockcmsinfo/blockcmsinfo.tpl',
      1 => 1460904921,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '710597989571578d6009a00-56719538',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'infos' => 0,
    'info' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_571578d604faf8_14206516',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_571578d604faf8_14206516')) {function content_571578d604faf8_14206516($_smarty_tpl) {?>
<?php if (count($_smarty_tpl->tpl_vars['infos']->value)>0) {?>
<!-- MODULE Block cmsinfo -->
		<?php  $_smarty_tpl->tpl_vars['info'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['info']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['infos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['info']->key => $_smarty_tpl->tpl_vars['info']->value) {
$_smarty_tpl->tpl_vars['info']->_loop = true;
?>
			<div class="col-xs-4 wrap-cms-info">
				<div class="block_cms_info "><?php echo $_smarty_tpl->tpl_vars['info']->value['text'];?>
</div>
			</div>
		<?php } ?>
<!-- /MODULE Block cmsinfo -->
<?php }?><?php }} ?>
