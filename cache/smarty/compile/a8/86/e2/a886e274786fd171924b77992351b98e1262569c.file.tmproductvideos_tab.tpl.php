<?php /* Smarty version Smarty-3.1.19, created on 2016-04-18 20:16:02
         compiled from "/var/www/html/modules/tmproductvideos/views/templates/admin/tmproductvideos_tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1760582004571578c2ce9f13-46036059%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a886e274786fd171924b77992351b98e1262569c' => 
    array (
      0 => '/var/www/html/modules/tmproductvideos/views/templates/admin/tmproductvideos_tab.tpl',
      1 => 1460904921,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1760582004571578c2ce9f13-46036059',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'error' => 0,
    'multishop_edit' => 0,
    'id_lang' => 0,
    'languages' => 0,
    'video' => 0,
    'index' => 0,
    'videos' => 0,
    'v' => 0,
    'link' => 0,
    'theme_url' => 0,
    'default_language' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_571578c2f3b947_39668902',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_571578c2f3b947_39668902')) {function content_571578c2f3b947_39668902($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/var/www/html/tools/smarty/plugins/modifier.escape.php';
?><?php if (isset($_smarty_tpl->tpl_vars['error']->value)&&$_smarty_tpl->tpl_vars['error']->value) {?>
	<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['error']->value, ENT_QUOTES, 'UTF-8', true);?>

<?php }?>

<script type="text/javascript">
	shopCount = []
</script>
<div class="panel product-tab">
	<input type="hidden" name="submitted_tabs[]" value="ModuleTmproductvideos" />
	<h3 class="tab"><?php echo smartyTranslate(array('s'=>'Product Videos','mod'=>'tmproductvideos'),$_smarty_tpl);?>
</h3>
	<?php if (isset($_smarty_tpl->tpl_vars['multishop_edit']->value)&&$_smarty_tpl->tpl_vars['multishop_edit']->value) {?>
    	<div class="alert alert-danger">
        	<?php echo smartyTranslate(array('s'=>'You cannot manage video items from a "All Shops" or a "Group Shop" context, select directly the shop you want to edit.','mod'=>'tmproductvideos'),$_smarty_tpl);?>

        </div>
    <?php } else { ?>
        <div class="form-group">
            <label class="control-label col-lg-2" for="name_<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['id_lang']->value, 'intval');?>
">
                <span class="label-tooltip" data-toggle="tooltip" title="<?php echo smartyTranslate(array('s'=>'Enter link to video(Youtube, vimeo) hrere.','mod'=>'tmproductvideos'),$_smarty_tpl);?>
">
                    <?php echo smartyTranslate(array('s'=>'Video Link','mod'=>'tmproductvideos'),$_smarty_tpl);?>

                </span>
            </label>
            <div class="col-lg-5">
                <?php echo $_smarty_tpl->getSubTemplate ("controllers/products/input_text_lang.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('languages'=>$_smarty_tpl->tpl_vars['languages']->value,'input_class'=>"updateCurrentLink",'input_name'=>"video_link"), 0);?>

            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-2" for="name_<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['id_lang']->value, 'intval');?>
">
                <span class="label-tooltip" data-toggle="tooltip" title="<?php echo smartyTranslate(array('s'=>'Enter link to video(Youtube, vimeo) hrere.','mod'=>'tmproductvideos'),$_smarty_tpl);?>
">
                    <?php echo smartyTranslate(array('s'=>'Video Heading','mod'=>'tmproductvideos'),$_smarty_tpl);?>

                </span>
            </label>
            <div class="col-lg-5">
                <?php echo $_smarty_tpl->getSubTemplate ("controllers/products/input_text_lang.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('languages'=>$_smarty_tpl->tpl_vars['languages']->value,'input_class'=>"updateCurrentLink",'input_name'=>"video_name"), 0);?>

            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-2" for="video_description_<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['id_lang']->value, 'intval');?>
">
                <span class="label-tooltip" data-toggle="tooltip"
                    title="<?php echo smartyTranslate(array('s'=>'Videos description.','mod'=>'tmproductvideos'),$_smarty_tpl);?>
">
                    <?php echo smartyTranslate(array('s'=>'Videos Description','mod'=>'tmproductvideos'),$_smarty_tpl);?>

                </span>
            </label>
            <div class="col-lg-9">
                <?php echo $_smarty_tpl->getSubTemplate ("controllers/products/textarea_lang.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('languages'=>$_smarty_tpl->tpl_vars['languages']->value,'input_name'=>'video_description','class'=>"autoload_rte_custom"), 0);?>

            </div>
        </div>
        <?php  $_smarty_tpl->tpl_vars['videos'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['videos']->_loop = false;
 $_smarty_tpl->tpl_vars['index'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['video']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['videos']->key => $_smarty_tpl->tpl_vars['videos']->value) {
$_smarty_tpl->tpl_vars['videos']->_loop = true;
 $_smarty_tpl->tpl_vars['index']->value = $_smarty_tpl->tpl_vars['videos']->key;
?>
	       	<div class="translatable-field lang-<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['index']->value, 'intval');?>
">
            	<script type="text/javascript">shopCount.push(<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['index']->value, 'intval');?>
)</script>
            	<div class="row">
                	<div class="col-lg-12">
                    	<h3 class="tab"><?php echo smartyTranslate(array('s'=>'Video List','mod'=>'tmproductvideos'),$_smarty_tpl);?>
</h3>
                        <ul id="video-list-<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['index']->value, 'intval');?>
" class="video-list">
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['videos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                            	<li id="video_<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['v']->value['id_video'], 'intval');?>
" class="video-item">
                                	<div class="row">
                                    	<h4 class="item-tile">
                                            <?php if ($_smarty_tpl->tpl_vars['v']->value['video_name']) {?>
                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['video_name'], ENT_QUOTES, 'UTF-8', true);?>

                                            <?php }?>
                                        </h4>
                                        <div class="col-lg-3">
                                        	<span class="sort-order hidden"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['v']->value['sort_order'], 'intval');?>
</span>
                                            <?php if ($_smarty_tpl->tpl_vars['v']->value['video_type']=='youtube') {?>
                                            	<div class="video-preview">
                                                 	<embed width="250" height="200" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['video_link'], ENT_QUOTES, 'UTF-8', true);?>
&showinfo=0&autoplay=0&controls=0">
                                                    <div class="preview-video">
                                                        <a class="fancybox-media fancybox.iframe" onclick="return false;" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['video_link'], ENT_QUOTES, 'UTF-8', true);?>
?autoplay=1?html5=1"><i class="icon-search-plus"></i></a>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['v']->value['video_type']=='vimeo') {?>
                                            	<div class="video-preview">
                                                    <iframe 
                                                        src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['video_link'], ENT_QUOTES, 'UTF-8', true);?>
"
                                                        width="250"
                                                        height="200"
                                                        frameborder="0"
                                                        webkitAllowFullScreen
                                                        mozallowfullscreen
                                                        allowFullScreen>
                                                    </iframe>
                                                </div>
                                            	<a class="fancybox-media fancybox.iframe" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['video_link'], ENT_QUOTES, 'UTF-8', true);?>
"><i class="icon-search-plus"></i></a>
                                            <?php }?>
                                        </div>
                                        <div class="col-lg-7">
                                        	<div class="form-group">
                                        		<input type="text" name="video_name" value="<?php if ($_smarty_tpl->tpl_vars['v']->value['video_name']) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['video_name'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>"  autocomplete="off" />
                                            </div>
                                            <div class="form-group">
                                            	<textarea class="autoload_rte_custom" name="video_description" autocomplete="off"><?php if ($_smarty_tpl->tpl_vars['v']->value['video_description']) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['video_description'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 controls">
                                        	<div class="status">
                                                <button type="submit" class="list-action-enable<?php if ($_smarty_tpl->tpl_vars['v']->value['status']) {?> action-enabled<?php } else { ?> action-disabled<?php }?>" name="updateStatus">
                                                    <?php if ($_smarty_tpl->tpl_vars['v']->value['status']) {?>
                                                        <i class="icon-check"></i>
                                                    <?php } else { ?>
                                                        <i class="icon-remove"></i>
                                                    <?php }?>
                                                </button>
                                            </div>
                                        	<button type="submit" class="btn btn-default btn-save" name="updateItem"><i class="icon-save"></i> <?php echo smartyTranslate(array('s'=>'Update video','mod'=>'tmproductvideos'),$_smarty_tpl);?>
</button>
                                            <button type="submit" class="btn btn-default btn-remove" name="removeItem"><i class="icon-trash"></i> <?php echo smartyTranslate(array('s'=>'Remove video','mod'=>'tmproductvideos'),$_smarty_tpl);?>
</button>
                                        </div>
                                        <input type="hidden" name="id_lang" value="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['v']->value['id_lang'], 'intval');?>
" />
                                        <input type="hidden" name="item_status" value="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['v']->value['status'], 'intval');?>
" />
                                        <input type="hidden" name="id_video" value="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['v']->value['id_video'], 'intval');?>
" />
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                	</div>
                </div>
           </div>
        <?php } ?>
        <div class="panel-footer">
            <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminProducts'), ENT_QUOTES, 'UTF-8', true);?>
" class="btn btn-default"><i class="process-icon-cancel"></i> <?php echo smartyTranslate(array('s'=>'Cancel','mod'=>'tmproductvideos'),$_smarty_tpl);?>
</a>
            <button type="submit" name="submitAddproduct" class="btn btn-default pull-right"><i class="process-icon-save"></i> <?php echo smartyTranslate(array('s'=>'Save','mod'=>'tmproductvideos'),$_smarty_tpl);?>
</button>
            <button type="submit" name="submitAddproductAndStay" class="btn btn-default pull-right"><i class="process-icon-save"></i> <?php echo smartyTranslate(array('s'=>'Save and stay','mod'=>'tmproductvideos'),$_smarty_tpl);?>
</button>
        </div>
    <?php }?>
</div>

<script type="text/javascript">
	theme_url='<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['theme_url']->value, "intval");?>
';
	hideOtherLanguage(<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['default_language']->value['id_lang'], "intval");?>
);
</script><?php }} ?>
