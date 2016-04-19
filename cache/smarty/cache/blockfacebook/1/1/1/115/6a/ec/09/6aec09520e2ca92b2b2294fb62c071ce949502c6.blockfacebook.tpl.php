<?php /*%%SmartyHeaderCode:20710470545713a4112ee355-81816821%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '20710470545713a4112ee355-81816821',
  'variables' => 
  array (
    'facebookurl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5713a411304382_63364063',
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5713a411304382_63364063')) {function content_5713a411304382_63364063($_smarty_tpl) {?><div id="fb-root"></div>
<div id="facebook_block" class="col-xs-4">
    <div class="insert">
        <h4 >Follow us on facebook</h4>
        <div class="facebook-fanbox">
            <div class="fb-like-box" 
                data-href="https://www.facebook.com/prestashop" 
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
<?php }} ?>
