<?php /* Smarty version Smarty-3.1.19, created on 2016-04-18 20:16:33
         compiled from "/var/www/html/modules/brinkscheckout/views/templates/hook/1.6/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:269840071571578e1b6c601-43234837%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b8bfa071a5a0bf1d109de6e5e9142199646adc31' => 
    array (
      0 => '/var/www/html/modules/brinkscheckout/views/templates/hook/1.6/header.tpl',
      1 => 1461024956,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '269840071571578e1b6c601-43234837',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_571578e1b7e0f1_55607007',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_571578e1b7e0f1_55607007')) {function content_571578e1b7e0f1_55607007($_smarty_tpl) {?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('addJsDefL', array('name'=>'twoco_loading_msg')); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'twoco_loading_msg'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo smartyTranslate(array('s'=>'Just a moment while we process your payment...','mod'=>'brinkscheckout'),$_smarty_tpl);?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'twoco_loading_msg'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php }} ?>
