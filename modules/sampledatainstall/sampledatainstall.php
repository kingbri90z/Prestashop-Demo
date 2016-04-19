<?php

if (!defined('_PS_VERSION_'))
	exit;

class Sampledatainstall extends Module
{
	protected $config_form = false;

	public function __construct()
	{
		$this->name = 'sampledatainstall';
		$this->tab = 'export';
		$this->version = '2.1.8';
		$this->author = 'TemplateMonster (Alexander Grosul)';
		$this->need_instance = 0;

		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Sample Data Install');
		$this->description = $this->l('Imports sample data to make your theme look like at template live demo. Imports sample products, categories, module settings, static pages etc.');
	}

	public function install()
	{
		return parent::install() &&
			$this->registerHook('displayBackOfficeHeader') &&
			$this->addTab();
	}

	public function uninstall()
	{
		return parent::uninstall() && $this->removeTab();
	}

	protected function addTab()
	{
		$tab = new Tab();
		$tab->class_name = 'AdminSampleDataInstall';
		$tab->id_parent = 0;
		$tab->module = $this->name;
		$tab->position = 100;
		$languages = Language::getLanguages(false);
		foreach ($languages as $lang)
			$tab->name[$lang['id_lang']] = 'Sample Data Install';

		if (!$tab->save())
			return false;

		$tab_id = $tab->id;

		require_once(dirname(__FILE__).'/install/install_tab.php');

		foreach ($tabvalue as $tab)
		{
			$newtab = new Tab();
			$newtab->class_name = $tab['class_name'];
			$newtab->id_parent = $tab_id;
			$newtab->module = $tab['module'];

			foreach ($languages as $l)
				$newtab->name[$l['id_lang']] = $this->l($tab['name']);

			if (!$newtab->save())
				return false;
		}

		return true;
	}

	protected function removeTab()
	{
		$tab_id = TabCore::getIdFromClassName('AdminSampleDataInstall');
		$tab = new Tab($tab_id);
		if (!$tab->delete())
			return false;

		require_once(dirname(__FILE__).'/install/uninstall_tab.php');

		foreach ($idtabs as $id)
		{
			if ($id)
			{
				$t = new Tab($id);
				if (!$t->delete())
					return false;
			}
		}
		return true;
	}

	public function sendPath()
	{
		return $this->local_path;
	}

	public static function cmp($a, $b)
	{
		return strcmp($a['id_attribute_group'], $b['id_attribute_group']);
	}

	public function hookDisplayBackOfficeHeader()
	{
		$this->context->controller->addCss($this->_path.'views/css/sampledatainstall-tab.css');
		if (version_compare(_PS_VERSION_, '1.6.0.2', '<=') === true)
		{
			$this->context->controller->addJs($this->_path.'views/js/import.js');
			$this->context->controller->addCss($this->_path.'views/css/sampledatainstall.css');
		}
	}
}
