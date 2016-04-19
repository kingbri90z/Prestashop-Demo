<?php /* Smarty version Smarty-3.1.19, created on 2016-04-18 20:16:27
         compiled from "/var/www/html/modules/tmproductvideos/views/templates/hooks/tmproductvideos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2100270460571578dbdd5576-68126254%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b1311949a5434ad538ffef84599db9cf42c345d7' => 
    array (
      0 => '/var/www/html/modules/tmproductvideos/views/templates/hooks/tmproductvideos.tpl',
      1 => 1460904921,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2100270460571578dbdd5576-68126254',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'videos' => 0,
    'video' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_571578dbe23fa6_67755235',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_571578dbe23fa6_67755235')) {function content_571578dbe23fa6_67755235($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['videos']->value)&&$_smarty_tpl->tpl_vars['videos']->value) {?>
    <section id="product-videos" class="page-product-box">
        <h3 class="page-product-heading"><?php if (count($_smarty_tpl->tpl_vars['videos']->value)>1) {?><?php echo smartyTranslate(array('s'=>'Videos','mod'=>'tmproductvideos'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Video','mod'=>'tmproductvideos'),$_smarty_tpl);?>
<?php }?></h3>
        <?php  $_smarty_tpl->tpl_vars['video'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['video']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['videos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['video']->key => $_smarty_tpl->tpl_vars['video']->value) {
$_smarty_tpl->tpl_vars['video']->_loop = true;
?>
        	<?php if ($_smarty_tpl->tpl_vars['video']->value['type']=='youtube') {?>
            	<div class="videowrapper">
                	<iframe type="text/html" 
                    	src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['video']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
?wmode=transparent"
                    	frameborder="0"></iframe>
                </div>
            <?php } elseif ($_smarty_tpl->tpl_vars['video']->value['type']=='vimeo') {?>
            	<div class='embed-container'>
                	<iframe 
                    	src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['video']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
"
                        frameborder="0"
                        webkitAllowFullScreen
                        mozallowfullscreen
                        allowFullScreen>
                    </iframe>
                </div>
            <?php }?>
        	<?php if ($_smarty_tpl->tpl_vars['video']->value['name']) {?>
            	<h4 class="video-name"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['video']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</h4>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['video']->value['description']) {?>
            	<p class="video-description"><?php echo $_smarty_tpl->tpl_vars['video']->value['description'];?>
</p>
            <?php }?>
        <?php } ?>
    </section>
<?php }?><?php }} ?>
