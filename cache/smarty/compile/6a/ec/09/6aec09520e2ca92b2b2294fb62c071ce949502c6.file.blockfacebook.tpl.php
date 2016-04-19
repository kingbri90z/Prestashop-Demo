<?php /* Smarty version Smarty-3.1.19, created on 2016-04-18 20:16:21
         compiled from "/var/www/html/themes/theme1133/modules/blockfacebook/blockfacebook.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1575323886571578d5f2fff9-75975164%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6aec09520e2ca92b2b2294fb62c071ce949502c6' => 
    array (
      0 => '/var/www/html/themes/theme1133/modules/blockfacebook/blockfacebook.tpl',
      1 => 1460904921,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1575323886571578d5f2fff9-75975164',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'facebookurl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_571578d5f40bd6_49386315',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_571578d5f40bd6_49386315')) {function content_571578d5f40bd6_49386315($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['facebookurl']->value!='') {?>
<div id="fb-root"></div>
<div id="facebook_block" class="col-xs-4">
    <div class="insert">
        <h4 ><?php echo smartyTranslate(array('s'=>'Follow us on facebook','mod'=>'blockfacebook'),$_smarty_tpl);?>
</h4>
        <div class="facebook-fanbox">
            <div class="fb-like-box" 
                data-href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['facebookurl']->value, ENT_QUOTES, 'UTF-8', true);?>
" 
                data-height="237" 
                data-colorscheme="light" 
                data-show-faces="true" 
                data-header="false" 
                data-stream="false" 
                data-show-border="false"
                connections="10">
            </div>
        </div>
    </div>
</div>
<?php }?>
<?php }} ?>
