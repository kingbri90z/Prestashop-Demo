<?php /*%%SmartyHeaderCode:2699161495713a411cfd296-68171152%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7d646e88e3bdb78b3a7e6c15b956865b9cbc04f1' => 
    array (
      0 => '/var/www/html/themes/theme1133/modules/blockmyaccountfooter/blockmyaccountfooter.tpl',
      1 => 1460904921,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2699161495713a411cfd296-68171152',
  'variables' => 
  array (
    'link' => 0,
    'returnAllowed' => 0,
    'voucherAllowed' => 0,
    'HOOK_BLOCK_MY_ACCOUNT' => 0,
    'is_logged' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5713a411d82fe0_99828940',
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5713a411d82fe0_99828940')) {function content_5713a411d82fe0_99828940($_smarty_tpl) {?><!-- Block myaccount module -->
<section class="footer-block col-xs-12 col-sm-2">
	<h4>
    	<a href="http://162.243.199.85/index.php?controller=my-account" title="Manage my customer account" rel="nofollow">My account</a>
    </h4>
	<div class="block_content toggle-footer">
		<ul class="bullet">
			<li>
            	<a href="http://162.243.199.85/index.php?controller=history" title="My orders" rel="nofollow">My orders</a>
            </li>
						<li>
            	<a href="http://162.243.199.85/index.php?controller=order-slip" title="My credit slips" rel="nofollow">My credit slips</a>
            </li>
			<li>
            	<a href="http://162.243.199.85/index.php?controller=addresses" title="My addresses" rel="nofollow">My addresses</a>
            </li>
			<li>
            	<a href="http://162.243.199.85/index.php?controller=identity" title="Manage my personal information" rel="nofollow">My personal info</a>
            </li>
						
            		</ul>
	</div>
</section>
<!-- /Block myaccount module -->
<?php }} ?>
