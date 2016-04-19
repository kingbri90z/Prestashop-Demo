<?php /* Smarty version Smarty-3.1.19, created on 2016-04-18 20:34:22
         compiled from "/var/www/html/themes/theme1133/my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:60444212057157d0edfc2b4-44880134%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ac09dceceb95958a7eac9fab20740d2b6a751e0d' => 
    array (
      0 => '/var/www/html/themes/theme1133/my-account.tpl',
      1 => 1460904921,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '60444212057157d0edfc2b4-44880134',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'hide_left_column' => 0,
    'hide_right_column' => 0,
    'account_created' => 0,
    'linkWidthSmall' => 0,
    'linkWidth' => 0,
    'has_customer_an_address' => 0,
    'link' => 0,
    'returnAllowed' => 0,
    'voucherAllowed' => 0,
    'HOOK_CUSTOMER_ACCOUNT' => 0,
    'base_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_57157d0eec85f3_94439692',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57157d0eec85f3_94439692')) {function content_57157d0eec85f3_94439692($_smarty_tpl) {?><?php if (($_smarty_tpl->tpl_vars['hide_left_column']->value||$_smarty_tpl->tpl_vars['hide_right_column']->value)&&($_smarty_tpl->tpl_vars['hide_left_column']->value!='true'||$_smarty_tpl->tpl_vars['hide_right_column']->value!='true')) {?>
	<?php $_smarty_tpl->tpl_vars["linkWidth"] = new Smarty_variable("2", null, 0);?>
    <?php $_smarty_tpl->tpl_vars["linkWidthSmall"] = new Smarty_variable("2", null, 0);?>
<?php } elseif (($_smarty_tpl->tpl_vars['hide_left_column']->value&&$_smarty_tpl->tpl_vars['hide_right_column']->value)&&($_smarty_tpl->tpl_vars['hide_left_column']->value=='true'&&$_smarty_tpl->tpl_vars['hide_right_column']->value=='true')) {?>
	<?php $_smarty_tpl->tpl_vars["linkWidth"] = new Smarty_variable("3", null, 0);?>
    <?php $_smarty_tpl->tpl_vars["linkWidthSmall"] = new Smarty_variable("2", null, 0);?>
<?php } else { ?>
	<?php $_smarty_tpl->tpl_vars["linkWidth"] = new Smarty_variable("2", null, 0);?>
    <?php $_smarty_tpl->tpl_vars["linkWidthSmall"] = new Smarty_variable("1", null, 0);?>
<?php }?>

<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'My account'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<h1 class="page-heading"><?php echo smartyTranslate(array('s'=>'My account'),$_smarty_tpl);?>
</h1>

<?php if (isset($_smarty_tpl->tpl_vars['account_created']->value)) {?>
	<p class="alert alert-success">
		<?php echo smartyTranslate(array('s'=>'Your account has been created.'),$_smarty_tpl);?>

	</p>
<?php }?>

<p class="info-account"><?php echo smartyTranslate(array('s'=>'Welcome to your account. Here you can manage all of your personal information and orders.'),$_smarty_tpl);?>
</p>

<div class="row addresses-lists">
	<div class="col-xs-12 col-sm-<?php echo 12/$_smarty_tpl->tpl_vars['linkWidthSmall']->value;?>
 col-md-<?php echo 12/$_smarty_tpl->tpl_vars['linkWidth']->value;?>
 col-lg-<?php echo 12/$_smarty_tpl->tpl_vars['linkWidth']->value;?>
">
		<ul class="myaccount-link-list">
            <?php if ($_smarty_tpl->tpl_vars['has_customer_an_address']->value) {?>
            <li>
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('address',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Add my first address'),$_smarty_tpl);?>
">
                	<i class="fa fa-building"></i>
                    <span><?php echo smartyTranslate(array('s'=>'Add my first address'),$_smarty_tpl);?>
</span>
                </a>
            </li>
            <?php }?>
            <li>
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('history',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Orders'),$_smarty_tpl);?>
">
                	<i class="fa fa-list-ol"></i>
                    <span><?php echo smartyTranslate(array('s'=>'Order history and details'),$_smarty_tpl);?>
</span>
                </a>
            </li>
            <?php if ($_smarty_tpl->tpl_vars['returnAllowed']->value) {?>
                <li>
                	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order-follow',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Merchandise returns'),$_smarty_tpl);?>
">
                    	<i class="fa fa-refresh"></i>
                        <span><?php echo smartyTranslate(array('s'=>'My merchandise returns'),$_smarty_tpl);?>
</span>
                    </a>
                </li>
            <?php }?>
            <li>
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order-slip',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Credit slips'),$_smarty_tpl);?>
">
                	<i class="fa fa-ban"></i>
                    <span><?php echo smartyTranslate(array('s'=>'My credit slips'),$_smarty_tpl);?>
</span>
                </a>
            </li>
            <li>
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('addresses',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Addresses'),$_smarty_tpl);?>
">
                	<i class="fa fa-building"></i>
                    <span><?php echo smartyTranslate(array('s'=>'My addresses'),$_smarty_tpl);?>
</span>
                </a>
            </li>
            <li>
            	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('identity',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Information'),$_smarty_tpl);?>
">
                	<i class="fa fa-user"></i>
                    <span><?php echo smartyTranslate(array('s'=>'My personal information'),$_smarty_tpl);?>
</span>
                </a>
            </li>
        </ul>
	</div>
<?php if ($_smarty_tpl->tpl_vars['voucherAllowed']->value||isset($_smarty_tpl->tpl_vars['HOOK_CUSTOMER_ACCOUNT']->value)&&$_smarty_tpl->tpl_vars['HOOK_CUSTOMER_ACCOUNT']->value!='') {?>
	<div class="col-xs-12 col-sm-<?php echo 12/$_smarty_tpl->tpl_vars['linkWidthSmall']->value;?>
 col-md-<?php echo 12/$_smarty_tpl->tpl_vars['linkWidth']->value;?>
 col-lg-<?php echo 12/$_smarty_tpl->tpl_vars['linkWidth']->value;?>
">
        <ul class="myaccount-link-list">
            <?php if ($_smarty_tpl->tpl_vars['voucherAllowed']->value) {?>
                <li>
                	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('discount',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Vouchers'),$_smarty_tpl);?>
">
                    	<i class="fa fa-barcode"></i>
                        <span><?php echo smartyTranslate(array('s'=>'My vouchers'),$_smarty_tpl);?>
</span>
                    </a>
                </li>
            <?php }?>
            <?php echo $_smarty_tpl->tpl_vars['HOOK_CUSTOMER_ACCOUNT']->value;?>

        </ul>
    </div>
<?php }?>
</div>

<ul class="footer_links clearfix">
	<li>
    	<a class="btn btn-default btn-sm icon-left" href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
" title="<?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
">
        	<span>
                <?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>

            </span>
        </a>
    </li>
</ul>
<?php }} ?>
