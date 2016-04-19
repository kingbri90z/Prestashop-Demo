<?php /* Smarty version Smarty-3.1.19, created on 2016-04-18 20:16:23
         compiled from "/var/www/html/themes/theme1133/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1868452655571578d7108da5-60130210%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1043418a95c642c2a2d6ff09184afe49f50ae735' => 
    array (
      0 => '/var/www/html/themes/theme1133/footer.tpl',
      1 => 1460918941,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1868452655571578d7108da5-60130210',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_only' => 0,
    'right_column_size' => 0,
    'HOOK_RIGHT_COLUMN' => 0,
    'HOOK_HOME' => 0,
    'HOOK_FOOTER' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_571578d717f6c9_94543630',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_571578d717f6c9_94543630')) {function content_571578d717f6c9_94543630($_smarty_tpl) {?><?php if (!isset($_smarty_tpl->tpl_vars['content_only']->value)||!$_smarty_tpl->tpl_vars['content_only']->value) {?>
					</div><!-- #center_column -->
					<?php if (isset($_smarty_tpl->tpl_vars['right_column_size']->value)&&!empty($_smarty_tpl->tpl_vars['right_column_size']->value)) {?>
						<div id="right_column" class="col-xs-12 col-sm-<?php echo intval($_smarty_tpl->tpl_vars['right_column_size']->value);?>
 column"><?php echo $_smarty_tpl->tpl_vars['HOOK_RIGHT_COLUMN']->value;?>
</div>
					<?php }?>
					</div><!-- .row -->
				</div><!-- #columns -->
			</div><!-- .columns-container -->
			<?php if (isset($_smarty_tpl->tpl_vars['HOOK_HOME']->value)&&trim($_smarty_tpl->tpl_vars['HOOK_HOME']->value)) {?>
				<div id="parallax-home">
					 <div class="container">
						<div class="row"><?php echo $_smarty_tpl->tpl_vars['HOOK_HOME']->value;?>
</div>
					</div>
				</div>
			<?php }?>
			<?php if (isset($_smarty_tpl->tpl_vars['HOOK_FOOTER']->value)) {?>
				<!-- Footer -->
				<div class="footer-container">
					<footer id="footer"  class="container">
					</footer>
				</div><!-- #footer -->
			<?php }?>
			<div class="footer-logo">
				<!-- <a  rel="nofollow"><img src="" alt="logo"></a> -->
				<div class="row">	&#169; Powered by AutoSol Limited. All Rights Reserved. </div>

			</div>
		</div><!-- #page -->
<?php }?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./global.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</body>
</html>
<?php }} ?>
