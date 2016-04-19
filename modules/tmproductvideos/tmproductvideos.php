<?php
if (!defined('_PS_VERSION_'))
	exit;

class TmProductVideos extends Module
{
	
	protected $is_saved = false;

	public function __construct()
	{
		$this->name = 'tmproductvideos';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->bootstrap = true;
		$this->secure_key = Tools::encrypt($this->name);
		$this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
		$this->languages = Language::getLanguages();
		$this->author = 'Template Monster (Alexander Grosul)';
		parent::__construct();
		$this->displayName = $this->l('TM Product Videos');
		$this->description = $this->l('This module allow add videos to product.');
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->admin_tpl_path = _PS_MODULE_DIR_.$this->name.'/views/templates/admin/';
		$this->hooks_tpl_path = _PS_MODULE_DIR_.$this->name.'/views/templates/hooks/';
		$this->media_path = _PS_MODULE_DIR_.$this->name.'/media/';
	}

	public function createAjaxController()
	{
		$tab = new Tab();
		$tab->active = 1;
		$languages = Language::getLanguages(false);
		if (is_array($languages))
			foreach ($languages as $language)
				$tab->name[$language['id_lang']] = 'tmproductvideos';
		$tab->class_name = 'AdminTMProductVideos';
		$tab->module = $this->name;
		$tab->id_parent = - 1;
		return (bool)$tab->add();
	}

	private function _removeAjaxContoller()
	{
		if ($tab_id = (int)Tab::getIdFromClassName('AdminTMProductVideos'))
		{
			$tab = new Tab($tab_id);
			$tab->delete();
		}
		return true;
	}

	public function install()
	{
		if (!parent::install() ||
			!$this->_createTables() ||
			!$this->registerHook('actionAdminControllerSetMedia') ||
			!$this->registerHook('actionProductUpdate') ||
			!$this->registerHook('displayAdminProductsExtra') ||
			!$this->registerHook('header') ||
			!$this->registerHook('productFooter') ||
			!$this->createAjaxController())
			return false;
		return true;
	}

	public function uninstall()
	{
		if (!parent::uninstall() ||
			!$this->_removeAjaxContoller() ||
			!$this->_deleteTables())
			return false;
		return true;
	}

	protected function _createTables()
	{
		/* Videos */
		$result = (bool)Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'product_video` (
				`id_video` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_shop` int(10) unsigned NOT NULL,
				`id_product` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_video`, `id_shop`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		/* Videos Lang */
		$result &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'product_video_lang` (
			  `id_video` int(10) unsigned NOT NULL,
			  `id_shop` int(10) unsigned NOT NULL,
			  `id_product` int(10) unsigned NOT NULL,
			  `id_lang` int(10) unsigned NOT NULL,
			  `link` varchar(255) NOT NULL,
			  `name` varchar(255) NOT NULL,
			  `description` TEXT,
			  `sort_order` int(10) unsigned NOT NULL,
			  `status` tinyint(1) unsigned NOT NULL DEFAULT \'1\',
			  PRIMARY KEY (`id_video`,`id_lang`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		return $result;
	}

	protected function _deleteTables()
	{
		return Db::getInstance()->execute('
			DROP TABLE IF EXISTS `'._DB_PREFIX_.'product_video`, `'._DB_PREFIX_.'product_video_lang`;
		');
	}

	public function getLanguages()
	{
		$cookie = $this->context->cookie;
		$this->allow_employee_form_lang = (int)Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');
		if ($this->allow_employee_form_lang && !$cookie->employee_form_lang)
			$cookie->employee_form_lang = (int)Configuration::get('PS_LANG_DEFAULT');

		$lang_exists = false;
		$this->_languages = Language::getLanguages(false);
		foreach ($this->_languages as $lang)
			if (isset($cookie->employee_form_lang) && $cookie->employee_form_lang == $lang['id_lang'])
				$lang_exists = true;

		$this->default_form_language = $lang_exists ? (int)$cookie->employee_form_lang : (int)Configuration::get('PS_LANG_DEFAULT');

		foreach ($this->_languages as $k => $language)
			$this->_languages[$k]['is_default'] = ((int)($language['id_lang'] == $this->default_form_language));

		return $this->_languages;
	}

	public function prepareNewTab()
	{
		$this->context->smarty->assign(array(
			'video' => $this->getVideoFields(),
			'id_lang' => $this->context->language->id,
			'languages' => $this->getLanguages(),
			'default_language' => $this->default_language,
			'theme_url' => $this->context->link->getAdminLink('AdminTMProductVideos')
		));
	}

	public function hookActionAdminControllerSetMedia()
	{
		// add necessary javascript to products back office
		if ($this->context->controller->controller_name == 'AdminProducts' && Tools::getValue('id_product'))
		{
			$this->context->controller->addJqueryUI('ui.sortable');
			$this->context->controller->addJS(array(
				_PS_JS_DIR_.'tiny_mce/tiny_mce.js',
				_PS_JS_DIR_.'tinymce.inc.js',
			));
			$this->context->controller->addJS($this->_path.'/js/admin.js');

			$this->context->controller->addCSS($this->_path.'/css/admin.css');
		}

	}

	public function hookDisplayAdminProductsExtra()
	{
		if (Validate::isLoadedObject($product = new Product((int)Tools::getValue('id_product'))))
		{
			if (Shop::isFeatureActive())
			{
				if (Shop::getContext() != Shop::CONTEXT_SHOP)
				{
					$this->context->smarty->assign(array(
						'multishop_edit' => true
					));
				}
			}

			$this->prepareNewTab();

			return $this->display(__FILE__, 'views/templates/admin/tmproductvideos_tab.tpl');
		}
	}

	public function hookActionProductUpdate()
	{
		// get all languages
		// for each of them, store the video fields
		$id_product = (int)Tools::getValue('id_product');
		$id_shop = $this->context->shop->id;
		$new_video = false;

		foreach ($languages = Language::getLanguages() as $lang)
		{
			if (trim(Tools::getValue('video_link_'.$lang['id_lang'])) !='')
				$new_video = true;
		}

		if ($new_video)
		{
			if ($this->is_saved)
				return null;

			$is_insert = $this->addVideo($id_product, $id_shop);

			if ($is_insert)
				$this->is_saved = true;
		}

		$this->is_saved = true;
	}

	public function addVideo($id_product, $id_shop)
	{
		if (!Db::getInstance()->insert('product_video', array(
									'id_shop' => $id_shop,
									'id_product' => $id_product,
								)) || !$id_video = Db::getInstance()->Insert_ID())

			return false;
		foreach ($languages = Language::getLanguages() as $lang)
				if (trim(Tools::getValue('video_link_'.$lang['id_lang'])) !='')
					if (!Validate::isCleanHtml(Tools::getValue('video_name_'.$lang['id_lang']), (int)Configuration::get('PS_ALLOW_HTML_IFRAME')) || !Validate::isCleanHtml(Tools::getValue('video_description_'.$lang['id_lang']), (int)Configuration::get('PS_ALLOW_HTML_IFRAME')))
					{
							$this->context->smarty->assign('error', $this->l('Invalid content'));
							return false;
					}
					else
					{
					if (!Db::getInstance()->execute('INSERT INTO '._DB_PREFIX_.'product_video_lang (`id_video`, `id_shop`, `id_product`, `id_lang`, `link`, `name`, `description`, `sort_order`, `status`) 
														VALUES (
															'.(int)$id_video.',
															'.(int)$id_shop.',
															'.(int)$id_product.',
															'.(int)$lang['id_lang'].',
															\''.pSQL(Tools::getValue('video_link_'.$lang['id_lang'])).'\',
															\''.pSQL(Tools::getValue('video_name_'.$lang['id_lang']), true).'\',
															\''.pSQL(Tools::getValue('video_description_'.$lang['id_lang']), true).'\',
															\''.$this->setSortOrder($id_shop, (int)$lang['id_lang'], $id_product).'\',
															\'1\'
														)'
													))
						return false;
					}
		return true;
	}

	public function setSortOrder($id_shop, $id_lang, $id_product)
	{
		$result = Db::getInstance()->ExecuteS('
				SELECT MAX(sort_order) AS sort_order
				FROM '._DB_PREFIX_.'product_video_lang
				WHERE id_shop ='.$id_shop.'
				AND id_lang ='.$id_lang.'
				AND id_product ='.$id_product);

		if (!$result)
			return false;

		foreach ($result as $res)
			$result = $res['sort_order'];

		$result = $result + 1;

		return $result;
	}

	public function getVideoType($link)
	{
		if (strpos($link, 'youtube') > 0)
			return 'youtube';
		elseif (strpos($link, 'vimeo') > 0)
			return 'vimeo';
		else
			return 'unknown';
	}

	public function getVideoFields()
	{
		$result = Db::getInstance()->ExecuteS('
			SELECT pvl.`link`, pvl.`name`, pvl.`description`, pvl.`id_lang`, pvl.`sort_order`, pvl.`status`, pv.`id_video`
			FROM '._DB_PREFIX_.'product_video_lang pvl
			LEFT JOIN '._DB_PREFIX_.'product_video pv
			ON pvl.id_video = pv.id_video
			WHERE pv.id_product = '.(int)Tools::getValue('id_product').'
			AND pv.id_shop='.$this->context->shop->id.'
			ORDER BY pvl.`sort_order`');
		if (!$result)
			return array();

		$fields = array();
		$i = 0;
		foreach ($result as $field)
		{
			$fields[$field['id_lang']][$i]['id_lang'] = $field['id_lang'];
			$fields[$field['id_lang']][$i]['id_video'] = $field['id_video'];
			$fields[$field['id_lang']][$i]['video_link'] = $field['link'];
			$fields[$field['id_lang']][$i]['video_name'] = $field['name'];
			$fields[$field['id_lang']][$i]['video_description'] = $field['description'];
			$fields[$field['id_lang']][$i]['sort_order'] = $field['sort_order'];
			$fields[$field['id_lang']][$i]['status'] = $field['status'];
			$fields[$field['id_lang']][$i]['video_type'] = $this->getVideoType($field['link']);
			$i++;
		}

		return $fields;
	}

	public function getShopVideos($id_shop, $id_lang, $id_product)
	{
		$result = Db::getInstance()->ExecuteS('
			SELECT *
			FROM '._DB_PREFIX_.'product_video_lang
			WHERE id_shop = '.$id_shop.'
			AND id_lang = '.$id_lang.'
			AND id_product = '.$id_product.'
			AND status = 1
			ORDER BY sort_order
		');

		if (!$result)
			return false;
		$fields = array();
		$i = 0;
		foreach ($result as $field)
		{
			$fields[$i]['name'] = $field['name'];
			$fields[$i]['link'] = $field['link'];
			$fields[$i]['description'] = $field['description'];
			$fields[$i]['type'] = $this->getVideoType($field['link']);
			$i++;
		}

		return $fields;
	}

	public function hookHeader()
	{
		$this->context->controller->addCSS(($this->_path).'css/tmproductvideos.css', 'all');
	}

	public function hookProductFooter()
	{
		$id_shop = $this->context->shop->id;
		$id_lang = $this->context->language->id;
		$product = $this->context->controller->getProduct();
		$id_product = $product->id;

		$this->context->smarty->assign('videos', $this->getShopVideos($id_shop, $id_lang, $id_product));

		return $this->display(__FILE__, 'views/templates/hooks/tmproductvideos.tpl');
	}
}