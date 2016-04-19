<?php

@ini_set('max_execution_time', 0);

/** No max line limit since the lines can be more than 4096. Performance impact is not significant. */
define('MAX_LINE_SIZE', 0);

/** correct Mac error on eof */
@ini_set('auto_detect_line_endings', '1');

class AdminSampleDataInstallImportController extends ModuleAdminController {

	public function __construct()
	{
		$this->bootstrap = true;

		$this->meta_title = $this->l('Import Data');
		parent::__construct();
		if (!$this->module->active)
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminHome'));

		require_once(dirname(__FILE__).'/../../helper/fields_list.php');
	}

	public function initContent()
	{
		parent::initContent();
	}

	public function renderList()
	{
		if ($this->compabilityBrowser())
		{
			$this->context->smarty->assign('vars', array(
				'baseDir'     	=> $this->context->link->getAdminLink('AdminSampleDataInstallImport')
			));

			$output = $this->context->smarty->fetch($this->getTemplatePath().'sampledatainstallimport-header.tpl');

			$this->context->smarty->assign('actions', array(
				'max_file_size'			=> $this->convertBytes(ini_get('upload_max_filesize')),
				'max_file_size_text'	=> ini_get('upload_max_filesize'),
				'baseDir'				=> $this->context->link->getAdminLink('AdminSampleDataInstallImport'),
				'regenerateDir'			=> $this->context->link->getAdminLink('AdminImages').'#image_type_form',
				'output'				=> $this->compabilityServer()
			));

			$output .= $this->context->smarty->fetch($this->getTemplatePath().'sampledatainstallimport.tpl');
		}
		else
			$output = $this->context->smarty->fetch($this->getTemplatePath().'old-browser.tpl');

		return $output;
	}

	public function setMedia()
	{
		$path = new Sampledatainstall();
		$this->addJquery();
		$this->addJS($path->sendPath().'views/js/import.js');
		$this->addCss($path->sendPath().'views/css/sampledatainstall.css');
		parent::setMedia();
	}

	public function postProcess()
	{
		if (Tools::getValue('action') == 'installData')
		{

			//import localizations data
			$this->clearDb();
			$this->importLanguages();
			$this->importCurrencies();
			$this->importZones();
			$this->importCountries();
			$this->importStates();
			//import taxes
			$this->importTaxRulesGroups();
			$this->importTaxRules();
			$this->importTaxes();
			//import addresses
			$this->importAddresses();
			$this->importAlias();
			//import main content data
			$this->importAttachments();
			$this->importAttributeGroups();
			$this->importAttributes();
			$this->importCategories();
			$this->importManufacturers();
			$this->importSuppliers();
			$this->importFeatures();
			$this->importFeatureValues();
			$this->importProducts();
			$this->importProductsAttributes();
			$this->importProductsPacks();
			$this->importImages();
			$this->importStockAvailable();
			$this->importSpecificPrices();
			$this->importSpecificPriceRules();
			$this->importCMSCategories();
			$this->importCMS();
			$this->importCarriers();
			$this->importDeliveries();
			$this->importContacts();
			$this->importHomeSlides();
			$this->importInfos();
			// import configurations
			$this->importConfigurations();
			$this->importSQLdata();

			exit('import_end');
		}
		else if (Tools::getValue('action') == 'getSettigs')
			$this->getSettings(true);
		else
			$this->filesUpload();
	}

	protected function importLanguages()
	{
		$this->truncateTables(array('lang', 'lang_shop'));

		$handle = $this->openCsvFile('languages.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
			Language::downloadAndInstallLanguagePack($line[2]);

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importCurrencies()
	{
		$this->truncateTables(array('currency', 'currency_shop'));

		$handle = $this->openCsvFile('currencies.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Currency', $this->currencies_fields, $line);

			if (!isset($fields['id']))
			{
				$currency = new Currency($line[0]);
				$currency->id = $line[0];
			}
			else
				$currency = new Currency($fields['id']);

			foreach ($fields as $key=>$field)
				$currency->$key = $field;

			$currency->force_id = true;
			if (!$res)
				$res = $currency->add();
		}
		$this->closeCsvFile($handle);

		return true;
	}

	protected function importZones()
	{
		$this->truncateTables(array('zone', 'zone_shop'));

		$handle = $this->openCsvFile('zones.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Zone', $this->zones_fields, $line);

			if (!isset($fields['id_zone']))
			{
				$zone = new Zone($line[0]);
				$zone->id = $line[0];
			}
			else
				$zone = new Zone($fields['id_zone']);

			foreach ($fields as $key=>$field)
				$zone->$key = $field;

			$zone->force_id = true;
			if (!$res)
				$res = $zone->add();
		}
		$this->closeCsvFile($handle);

		return true;
	}

	protected function importCountries()
	{
		$this->truncateTables(array('country', 'country_lang', 'country_shop'));

		$handle = $this->openCsvFile('countries.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Country', $this->countries_fields, $line);

			if (!isset($fields['id_country']))
			{
				$country = new Country($line[0]);
				$country->id = $line[0];
			}
			else
				$country = new Country($fields['id_country']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'name')
					$country->$key = $this->multilFild($field);
				else
					$country->$key = $field;
			}

			$country->force_id = true;
			if (!$res)
				$res = $country->add();
		}
		$this->closeCsvFile($handle);

		return true;
	}

	protected function importStates()
	{
		$this->truncateTables(array('state'));

		$handle = $this->openCsvFile('states.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('State', $this->states_fields, $line);

			if (!isset($fields['id_state']))
			{
				$state = new State($line[0]);
				$state->id = $line[0];
			}
			else
				$state = new State($fields['id_state']);

			foreach ($fields as $key=>$field)
				$state->$key = $field;

			$state->force_id = true;
			if (!$res)
				$res = $state->add();
		}
		$this->closeCsvFile($handle);

		return true;
	}

	protected function importTaxRulesGroups()
	{
		$this->truncateTables(array('tax_rules_group', 'tax_rules_group_shop'));

		$handle = $this->openCsvFile('tax_rule_groups.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('TaxRulesGroup', $this->tax_rule_group_fields, $line);

			if (!isset($fields['id']))
			{
				$tax_rule_group = new TaxRulesGroup($line[0]);
				$tax_rule_group->id = $line[0];
			}
			else
				$tax_rule_group = new TaxRulesGroup($fields['id']);

			foreach ($fields as $key=>$field)
				$tax_rule_group->$key = $field;

			$tax_rule_group->force_id = true;

			if (!$res)
				$res = $tax_rule_group->add();
		}
		$this->closeCsvFile($handle);

		return true;
	}

	protected function importTaxRules()
	{
		$this->truncateTables(array('tax_rule'));

		$handle = $this->openCsvFile('tax_rules.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('TaxRule', $this->tax_rule_fields, $line);

			if (!isset($fields['id']))
			{
				$tax_rule = new TaxRule($line[0]);
				$tax_rule->id = $line[0];
			}
			else
				$tax_rule = new TaxRule($fields['id']);

			foreach ($fields as $key=>$field)
				$tax_rule->$key = $field;

			$tax_rule->force_id = true;
			if (!$res)
				$res = $tax_rule->add();
		}
		$this->closeCsvFile($handle);

		return true;
	}

	protected function importTaxes()
	{
		$this->truncateTables(array('tax', 'tax_lang'));

		$handle = $this->openCsvFile('taxes.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Tax', $this->tax_fields, $line);

			if (!isset($fields['id']))
			{
				$tax = new Tax($line[0]);
				$tax->id = $line[0];
			}
			else
				$tax = new Tax($fields['id']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'name')
					$tax->$key = $this->multilFild($field);
				else
					$tax->$key = $field;
			}

			$tax->force_id = true;
			if (!$res)
				$res = $tax->add();
		}
		$this->closeCsvFile($handle);

		return true;
	}

	protected function importAddresses()
	{
		$this->truncateTables(array('address'));

		$handle = $this->openCsvFile('address.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Address', $this->address_fields, $line);

			if (!isset($fields['id']))
			{
				$address = new Address((int)$line[0]);
				$address->id = $line[0];
			}
			else
				$address = new Address((int)$fields['id']);

			foreach ($fields as $key=>$field)
				$address->$key = $field;

			$address->force_id = true;
			if (!$res)
				$res = $address->add();
		}
		$this->closeCsvFile($handle);

		return true;
	}

	protected function importAlias()
	{
		$this->truncateTables(array('alias'));

		$handle = $this->openCsvFile('alias.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Alias', $this->alias_fields, $line);

			if (!isset($fields['id']))
			{
				$alias = new Alias((int)$line[0]);
				$alias->id = $line[0];
			}
			else
				$alias = new Alias((int)$fields['id']);

			foreach ($fields as $key=>$field)
				$alias->$key = $field;

			$alias->force_id = true;
			if (!$res)
				$alias->add();
		}
		$this->closeCsvFile($handle);

		return true;
	}

	protected function importAttachments()
	{
		$this->truncateTables(array('attachment', 'attachment_lang'));

		$handle = $this->openCsvFile('attachments.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Attachment', $this->attachments_fields, $line);

			if (!isset($fields['id']))
			{
				$attacment = new Attachment((int)$line[0]);
				$attacment->id = $line[0];
			}
			else
				$attacment = new Attachment((int)$fields['id']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'name' || $key == 'description')
					$attacment->$key = $this->multilFild($field);
				else
					$attacment->$key = $field;
			}

			$attacment->force_id = true;
			if (!$res)
				$attacment->add();
		}
		$this->closeCsvFile($handle);

		return true;
	}

	protected function importAttributeGroups()
	{
		$this->truncateTables(array('attribute_group', 'attribute_group_lang', 'attribute_group_shop'));

		$handle = $this->openCsvFile('attribute_groups.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('AttributeGroup', $this->attribute_groups_fields, $line);

			if (!isset($fields['id_attribute_group']))
			{
				$attribute_group = new AttributeGroup((int)$line[0]);
				$attribute_group->id = $line[0];
			}
			else
				$attribute_group = new AttributeGroup((int)$fields['id_attribute_group']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'name' || $key == 'public_name')
					$attribute_group->$key = $this->multilFild($field);
				else
					$attribute_group->$key = $field;
			}

			$attribute_group->force_id = true;
			if (!$res)
				$attribute_group->add();
		}
		$this->closeCsvFile($handle);

		return true;
	}

	protected function importAttributes()
	{
		$this->truncateTables(array('attribute', 'attribute_lang', 'attribute_shop'));

		$handle = $this->openCsvFile('attributes.csv');
		$languages = Language::getLanguages(false);

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Attribute', $this->attributes_fields, $line);

			if (!isset($fields['id']))
			{
				$attribute = new Attribute((int)$line[0]);
				$attribute->id = $line[0];
			}
			else
				$attribute = new Attribute((int)$fields['id']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'name')
					$attribute->$key = $this->multilFild($field);
				else
					$attribute->$key = $field;
			}

			$attribute->force_id = true;
			if (!$res)
				$attribute->add();
		}
		$this->closeCsvFile($handle);

		return true;
	}

	protected function importCarriers()
	{
		$this->truncateTables(array('carrier', 'carrier_group',
									'carrier_lang', 'carrier_shop',
									'carrier_tax_rules_group_shop', 'carrier_zone',
									'range_weight', 'range_price'));

		$handle = $this->openCsvFile('carriers.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Carrier', $this->carriers_fields, $line);

			if (!isset($fields['id']))
			{
				$carrier = new Carrier((int)$line[0]);
				$carrier->id = $line[0];
			}
			else
				$carrier = new Carrier((int)$fields['id']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'delay')
					$carrier->$key = $this->multilFild($field);
				else
					$carrier->$key = $field;
			}

			if (!Tools::isEmpty($line[2])) // Tax Rules Group ID
			{
				$values = array(
					'id_carrier' => (int)$line[0],
					'id_tax_rules_group' => (int)$line[2],
					'id_shop' => (int)Context::getContext()->shop->id,
				);

				Cache::clean('carrier_id_tax_rules_group_'.(int)$line[0].'_'.(int)Context::getContext()->shop->id);
				Db::getInstance()->insert('carrier_tax_rules_group_shop', $values);
			}
			if (trim($line[22])) // Carrier Groups
			{
				$groups = explode(',', $line[22]);
				foreach ($groups as $group)
				{
					$values = array(
						'id_carrier' => (int)$line[0],
						'id_group' => (int)$group
					);
					Db::getInstance()->insert('carrier_group', $values);
				}
			}
			if (trim($line[23])) // Carrier Zones
			{
				$zones = explode(',', $line[23]);
				foreach ($zones as $zone)
				{
					$values = array(
						'id_carrier' => (int)$line[0],
						'id_zone' => (int)$zone
					);
					Db::getInstance()->insert('carrier_zone', $values);
				}
			}
			if (trim($line[24])) // Range Price
			{
				$range_line = explode(',', $line[24]);
				foreach ($range_line as $range)
				{
					$rp_res = false;
					$values = explode('-', $range);

					$rp = new RangePrice();
					$rp->id_carrier = (int)$line[0];
					$rp->delimiter1 = $values[0];
					$rp->delimiter2 = $values[1];
					if (!$rp_res)
						$rp->add();
				}
			}
			if (trim($line[25])) // Range Weight
			{
				$range_line = explode(',', $line[25]);
				foreach ($range_line as $range)
				{
					$rw_res = false;
					$values = explode('-', $range);
					$rw = new RangeWeight();
					$rw->id_carrier = (int)$line[0];
					$rw->delimiter1 = $values[0];
					$rw->delimiter2 = $values[1];
					if (!$rw_res)
						$rw->add();
				}
			}

			$carrier->force_id = true;
			if (!$res)
				$carrier->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importCMSCategories()
	{
		$this->truncateTables(array('cms_category', 'cms_category_lang', 'cms_category_shop'));

		$handle = $this->openCsvFile('cms_categories.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('CMSCategory', $this->cms_category_fields, $line);

			if (!isset($fields['id']))
			{
				$cms_cat = new CMSCategory((int)$line[0]);
				$cms_cat->id = $line[0];
			}
			else
				$cms_cat = new CMSCategory((int)$fields['id']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'name' || $key == 'description' || $key == 'meta_keywords' || $key == 'meta_description' || $key == 'link_rewrite')
					$cms_cat->$key = $this->multilFild($field);
				else
					$cms_cat->$key = $field;
			}

			$cms_cat->force_id = 1;
			if (!$res)
				$cms_cat->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importCMS()
	{
		$new_path = new Sampledatainstall();
		$file = $new_path->sendPath().'input/cms_pages.csv';
		// do nothing if file is empty
		if (Tools::isEmpty(trim(file_get_contents($file))))
			return;

		$this->truncateTables(array('cms', 'cms_lang', 'cms_shop'));

		$handle = $this->openCsvFile('cms_pages.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('CMS', $this->cms_pages_fields, $line);

			if (!isset($fields['id']))
			{
				$cms = new CMS((int)$line[0]);
				$cms->id = $line[0];
			}
			else
				$cms = new CMS((int)$fields['id']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'meta_title' || $key == 'meta_description' || $key == 'meta_keywords' || $key == 'content' || $key == 'link_rewrite')
					$cms->$key = $this->multilFild($field);
				else
					$cms->$key = $field;
			}

			$cms->force_id = true;
			if (!$res)
				$cms->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importDeliveries()
	{
		$this->truncateTables(array('delivery'));

		$handle = $this->openCsvFile('deliveries.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Delivery', $this->delivery_fields, $line);

			if (!isset($fields['id']))
			{
				$delivery = new Delivery($line[0]);
				$delivery->id = $line[0];
			}
			else
				$delivery = new Delivery($fields['id']);

			foreach ($fields as $key=>$field)
				$delivery->$key = $field;

			$delivery->force_id = true;
			if (!$res)
				$delivery->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importCategories()
	{
		$handle = $this->openCsvFile('categories.csv');

		$this->cleanCategoriesTables();
		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Category', $this->category_fields, $line);

			if (!isset($fields['id']))
			{
				$category = new Category($line[0]);
				$category->id = $line[0];
			}
			else
				$category = new Category($fields['id']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'name' || $key == 'description' || $key == 'meta_title' || $key == 'meta_keywords' || $key == 'meta_description' || $key == 'link_rewrite')
					$category->$key = $this->multilFild($field);
				else if ($key == 'id_parent')
				{
					// hack for old wersion where force_id don't working
					$parent_category = new Category((int)$field);
					if (!Validate::isLoadedObject($parent_category))
						$category->$key = '';
					else
						$category->$key = $field;
				}
				else
					$category->$key = $field;
			}

			$category->force_id = true;

			if (!$res)
				$res = $category->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importManufacturers()
	{
		$this->truncateTables(array('manufacturer', 'manufacturer_lang', 'manufacturer_shop'));

		$handle = $this->openCsvFile('manufacturers.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Manufacturer', $this->manufacturers_fields, $line);

			if (!isset($fields['id']))
			{
				$manufacturer = new Manufacturer($line[0]);
				$manufacturer->id = $line[0];
			}
			else
				$manufacturer = new Manufacturer($fields['id']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'description' || $key == 'short_description' || $key == 'meta_title' || $key == 'meta_keywords' || $key == 'meta_description')
					$manufacturer->$key = $this->multilFild($field);
				else
					$manufacturer->$key = $field;
			}

			$manufacturer->force_id = true;
			if (!$res)
				$res = $manufacturer->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importSuppliers()
	{
		$this->truncateTables(array('supplier', 'supplier_lang', 'supplier_shop'));

		$handle = $this->openCsvFile('suppliers.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Supplier', $this->suppliers_fields, $line);

			if (!isset($fields['id']))
			{
				$supplier = new Supplier($line[0]);
				$supplier->id = $line[0];
			}
			else
				$supplier = new Supplier($fields['id']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'description' || $key == 'meta_title' || $key == 'meta_keywords' || $key == 'meta_description')
					$supplier->$key = $this->multilFild($field);
				else
					$supplier->$key = $field;
			}

			$supplier->force_id = true;
			if (!$res)
				$res = $supplier->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importFeatures()
	{
		$this->truncateTables(array('feature', 'feature_lang', 'feature_shop'));

		$handle = $this->openCsvFile('features.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Feature', $this->feature_fields, $line);

			if (!isset($fields['id']))
			{
				$feature = new Feature($line[0]);
				$feature->id = $line[0];
			}
			else
				$feature = new Feature($fields['id']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'name')
					$feature->$key = $this->multilFild($field);
				else
					$feature->$key = $field;
			}

			$feature->force_id = true;
			if (!$res)
				$res = $feature->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importFeatureValues()
	{
		$this->truncateTables(array('feature_value', 'feature_value_lang'));

		$handle = $this->openCsvFile('feature_values.csv');
		$languages = Language::getLanguages(false);

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('FeatureValue', $this->feature_value_fields, $line);

			if (!isset($fields['id']))
			{
				$feature_value = new FeatureValue($line[0]);
				$feature_value->id = $line[0];
			}
			else
				$feature_value = new FeatureValue($fields['id']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'value')
					$feature_value->$key = $this->multilFild($field);
				else
					$feature_value->$key = $field;
			}

			$feature_value->force_id = true;
			if (!$res)
				$res = $feature_value->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	/**
	**	Clean all categories tables except root & home categories
	**/
	protected function cleanCategoriesTables()
	{
		Db::getInstance()->execute('
			DELETE FROM `'._DB_PREFIX_.'category`
			WHERE id_category NOT IN ('.(int)Configuration::get('PS_HOME_CATEGORY').
			', '.(int)Configuration::get('PS_ROOT_CATEGORY').')');
		Db::getInstance()->execute('
			DELETE FROM `'._DB_PREFIX_.'category_lang`
			WHERE id_category NOT IN ('.(int)Configuration::get('PS_HOME_CATEGORY').
			', '.(int)Configuration::get('PS_ROOT_CATEGORY').')');
		Db::getInstance()->execute('
			DELETE FROM `'._DB_PREFIX_.'category_shop`
			WHERE `id_category` NOT IN ('.(int)Configuration::get('PS_HOME_CATEGORY').
			', '.(int)Configuration::get('PS_ROOT_CATEGORY').')');
		Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'category` AUTO_INCREMENT = 3');
	}

	protected function importProducts()
	{
		$this->truncateTables(array('product', 'product_lang', 'product_shop',
									'product_sale', 'product_supplier', 'product_tag',
									'feature_product', 'category_product', 'product_carrier',
									'compare_product', 'product_attachment', 'product_country_tax',
									'product_download', 'product_group_reduction_cache', 'scene_products',
									'warehouse_product_location', 'customization', 'customization_field',
									'customization_field_lang', 'supply_order_detail', 'attribute_impact',
									'pack'));

		$handle = $this->openCsvFile('products.csv');
		$languages = Language::getLanguages(false);

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$product = new Product((int)$line[0]);

			$product->id = (int)$line[0];
			$product->active = $line[1];
			foreach ($languages as $lang)
				$product->name[$lang['id_lang']] = $line['2'];
			$categories = explode(',', $line[3]);
			$product->id_category_default = $categories[0] ? $categories[0] : Configuration::get('PS_HOME_CATEGORY');

			if (isset($categories) && $categories && count($categories))
				$product->addToCategories($categories);

			if (isset($line[4]))
				$product->price_tex = $line[4];
			if (isset($line[5]))
				$product->price_tin = $line[5];

			$product->id_tax_rules_group = trim($line[6]) ? $line[6] : 0;
			$product->wholesale_price = trim($line[7]) ? $line[7] : 0;
			$product->on_sale = trim($line[8]) ? $line[8] : 0;
			if (trim($line[13]))
				$product->reference = $line[13];
			if (trim($line[14]))
				$product->supplier_reference = trim($line[14]);
			if (trim($line[15]))
				$product->id_supplier = (int)$line[15];
			if (isset($product->id) && $product->id && isset($product->id_supplier) && property_exists($product, 'supplier_reference'))
			{
				$id_product_supplier = (int)ProductSupplier::getIdByProductAndSupplier((int)$product->id, 0, (int)$product->id_supplier);
				if ($id_product_supplier)
					$product_supplier = new ProductSupplier($id_product_supplier);
				else
					$product_supplier = new ProductSupplier();

				$product_supplier->id_product = (int)$product->id;
				$product_supplier->id_product_attribute = 0;
				$product_supplier->id_supplier = (int)$product->id_supplier;
				$product_supplier->product_supplier_price_te = $product->wholesale_price;
				$product_supplier->product_supplier_reference = $product->supplier_reference;
				$product_supplier->save();
			}
			if (trim($line[16]))
				$product->id_manufacturer = $line[16];
			if (!Tools::isEmpty(trim($line[17])))
				$product->ean13 = $line[17];
			if (trim($line[18]))
				$product->upc = $line[18];
			if (trim($line[19]))
				$product->ecotax = $line[19];
			$product->width = $line[20];
			$product->height = $line[21];
			$product->depth = $line[22];
			$product->weight = $line[23];
			if ($line[24])
				StockAvailable::setQuantity((int)$product->id, 0, (int)$line[24], (int)$this->context->shop->id);

			$product->minimal_quantity = $line[25];
			$product->visibility = $line[26];
			$product->additional_shipping_cost = $line[27];
			if (trim($line[28]))
				$product->unity = $line[28];
			if (trim($line[29]))
				$product->unit_price = $line[29];
			foreach ($languages as $lang)
			{
				$product->description_short[$lang['id_lang']] = $line[30];
				$product->description[$lang['id_lang']] = $line[31];
			}
			if ($line[32])
				foreach ($languages as $lang)
					Tag::addTags($lang['id_lang'], $product->id, $line[32]);

			foreach ($languages as $lang)
			{
				$product->meta_title[$lang['id_lang']] = $line[33];
				$product->meta_keywords[$lang['id_lang']] = $line[34];
				$product->meta_description[$lang['id_lang']] = $line[35];
				$product->link_rewrite[$lang['id_lang']] = $line[36];
				$product->available_now[$lang['id_lang']] = $line[37];
				$product->available_later[$lang['id_lang']] = $line[38];
			}

			$product->available_for_order = $line[39];
			$product->available_date = $line[40];
			$product->date_add = $line[41];
			$product->show_price = $line[42];

			// Features import
			$features = explode(',', $line[45]);
			if ($features)
				foreach ($features as $feature)
				{
					$value = explode(':', $feature);

					if ($value[0] && $value[1])
					{
						Product::addFeatureProductImport((int)$product->id, (int)$value[0], (int)$value[1]);
						SpecificPriceRule::applyAllRules(array((int)$product->id));
					}
				}
			$product->online_only = trim($line[46]) ? $line[46] : 0;
			$product->condition = $line[47];
			$product->customizable = trim($line[48]) ? $line[48] : 0;
			$product->uploadable_files = trim($line[49]) ? $line[49] : 0;
			$product->text_fields = trim($line[50]) ? $line[50] : 0;

			if ($product->getType() == Product::PTYPE_VIRTUAL)
				StockAvailable::setProductOutOfStock((int)$product->id, 1);
			else
				StockAvailable::setProductOutOfStock((int)$product->id, (int)$line[51]);

			$product->id_shop_default = $line[52];

			// add product accessories
			if ($line[56])
			{
				$accessories = explode(',', $line[56]);
				foreach ($accessories as $accessory)
					$a[]['id'] = $accessory;
				$product->setWsAccessories($a);
			}

			// add product carriers
			if ($line[57])
			{
				$carriers = explode(',', $line[57]);
				$product->setCarriers($carriers);
			}

			// add costomisation fields
			if (!Tools::isEmpty($line[58]) && class_exists('CustomizationField'))
			{
				$customisation_fields_ids = explode(',', $line[58]);
				foreach ($customisation_fields_ids as $customisation_field)
				{
					$result = false;
					$customisation_data = explode(':', $customisation_field);
					$cf = new CustomizationField();

					$cf->id_product = $product->id;
					$cf->type = $customisation_data[1];
					$cf->required = $customisation_data[2];
					foreach ($languages as $lang)
						$cf->name[$lang['id_lang']] = $customisation_data[3] ? $customisation_data[3] : ' ';
					$cf->force_id = 1;
					if (!$result)
						$result = $cf->add();
				}
			}

			// add attachments
			if ($line[59])
			{
				$attachments = explode(',', $line[59]);
				if (isset($attachments) && count($attachments))
					Attachment::attachToProduct($product->id, $attachments);
			}

			if ($line[60])
				$product->date_upd = $line[60];
			$product->price = $line[61];

			$product->force_id = 1;
			if (!$res)
				$res = $product->add();
		}

		$this->closeCsvFile($handle);
		Search::indexation(true);
		return true;
	}

	protected function importProductsAttributes()
	{
		$this->truncateTables(array('product_attribute', 'product_attribute_combination', 'product_attribute_shop', 'product_attribute_image'));

		$handle = $this->openCsvFile('product_attributes.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Combination', $this->product_attribute_fields, $line);

			if (!isset($fields['id']))
			{
				$attribute = new Combination($line[0]);
				$attribute->id = $line[0];
			}
			else
				$attribute = new Combination($fields['id']);

			foreach ($fields as $key=>$field)
				$attribute->$key = $field;

			// add attribute values in ps_product_attribute_combination
			if ($line[16])
			{
				$values = explode(',', $line[16]);
				$attribute->setAttributes($values);
			}
			// add attribute images to ps_product_attribute_image
			if ($line[17])
			{
				$images = explode(',', $line[17]);
				$attribute->setImages($images);
			}

			$attribute->force_id = true;
			if (!$res)
				$res = $attribute->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importProductsPacks()
	{
		$this->truncateTables(array('pack'));

		$handle = $this->openCsvFile('product_packs.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
			Pack::addItem($line[0], $line[1], $line[3], $line[2]);

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importImages()
	{
		$this->truncateTables(array('image', 'image_lang', 'image_shop'));

		$handle = $this->openCsvFile('images.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Image', $this->image_fields, $line);

			if (!isset($fields['id_image']))
				$img = new Image($line[0]);
			else
				$img = new Image($fields['id_image']);

			$img->id = $line[0];			
			foreach ($fields as $key=>$field)
			{
				if ($key == 'legend')
					$img->$key = $this->multilFild($field);
				else
					$img->$key = $field;
			}

			$img->force_id = true;
			if (!$res)
				$res = $img->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importStockAvailable()
	{
		$this->truncateTables(array('stock', 'stock_available', 'stock_mvt'));

		$handle = $this->openCsvFile('stock_available.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('StockAvailable', $this->stock_available_fields, $line);

			if (!isset($fields['id']))
			{
				$sa = new StockAvailable($line[0]);
				$sa->id = $line[0];
			}
			else
				$sa = new StockAvailable($fields['id']);

			foreach ($fields as $key=>$field)
				$sa->$key = $field;

			$sa->force_id = true;
			if (!$res)
				$res = $sa->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importSpecificPrices()
	{
		$this->truncateTables(array('specific_price'));

		$handle = $this->openCsvFile('specific_prices.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('SpecificPrice', $this->specific_price_fields, $line);

			if (!isset($fields['id']))
			{
				$specific_price = new SpecificPrice($line[0]);
				$specific_price->id = $line[0];
			}
			else
				$specific_price = new SpecificPrice($fields['id']);

			foreach ($fields as $key=>$field)
				$specific_price->$key = $field;

			$specific_price->force_id = true;
			if (!$res)
				$res = $specific_price->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importSpecificPriceRules()
	{
		$this->truncateTables(array('specific_price_rule', 'specific_price_rule_condition', 'specific_price_rule_condition_group'));

		$handle = $this->openCsvFile('specific_price_rules.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('SpecificPriceRule', $this->specific_price_rule_fields, $line);

			if (!isset($fields['id']))
			{
				$specific_price_rule = new SpecificPriceRule($line[0]);
				$specific_price_rule->id = $line[0];
			}
			else
				$specific_price_rule = new SpecificPriceRule($fields['id']);

			foreach ($fields as $key=>$field)
				$specific_price_rule->$key = $field;

			// add price rule conditions ps_specific_price_rule_condition
			if (trim($line[13]))
			{
				$conditions = explode(',', $line[13]);
				$values = array();
				foreach ($conditions as $condition)
				{
					$cond = explode(':', $condition);
					$values[] = array('type' => $cond[0], 'value' => $cond[1]);
				}
				$specific_price_rule->addConditions($values);
			}

			$specific_price_rule->force_id = true;
			if (!$res)
				$res = $specific_price_rule->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importContacts()
	{
		$this->truncateTables(array('contact', 'contact_lang', 'contact_shop'));

		$handle = $this->openCsvFile('contacts.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('Contact', $this->contacts_fields, $line);

			if (!isset($fields['id']))
			{
				$contact = new Contact($line[0]);
				$contact->id = $line[0];
			}
			else
				$contact = new Contact($fields['id']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'name' || $key == 'description')
					$contact->$key = $this->multilFild($field);
				else
					$contact->$key = $field;
			}

			$contact->force_id = true;
			if (!$res)
				$res = $contact->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importHomeSlides()
	{
		if (!(int)Validate::isLoadedObject(Module::getInstanceByName('homeslider')) || !Module::isEnabled('homeslider') || !Module::isInstalled('homeslider'))
			return;

		$new_path = new Sampledatainstall();
		$sfile = $new_path->sendPath().'input/home_slides.csv';
		if (!is_file($sfile) && !is_readable($sfile))
			return;

		$this->truncateTables(array('homeslider', 'homeslider_slides', 'homeslider_slides_lang'));

		$handle = $this->openCsvFile('home_slides.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('HomeSlide', $this->home_slide_fields, $line);

			if (!isset($fields['id']))
			{
				$slide = new HomeSlide($line[0]);
				$slide->id = $line[0];
			}
			else
				$slide = new HomeSlide($fields['id']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'description' || $key == 'title' || $key == 'legend' || $key == 'url' || $key == 'image')
					$slide->$key = $this->multilFild($field);
				else
					$slide->$key = $field;
			}

			$slide->force_id = true;
			if (!$res)
				$res = $slide->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importInfos()
	{
		if (!(int)Validate::isLoadedObject(Module::getInstanceByName('blockcmsinfo')) || !Module::isEnabled('blockcmsinfo') || !Module::isInstalled('blockcmsinfo'))
			return;

		$new_path = new Sampledatainstall();
		$sfile = $new_path->sendPath().'input/infos.csv';
		if (!is_file($sfile) || !is_readable($sfile) || !class_exists('InfoBlock'))
			return;

		$this->truncateTables(array('info', 'info_lang'));

		$handle = $this->openCsvFile('infos.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$res = false;
			$fields = $this->filterFields('InfoBlock', $this->info_fields, $line);

			if (!isset($fields['id']))
			{
				$info = new InfoBlock($line[0]);
				$info->id = $line[0];
			}
			else
				$info = new InfoBlock($fields['id']);

			foreach ($fields as $key=>$field)
			{
				if ($key == 'text')
					$info->$key = $this->multilFild($field);
				else
					$info->$key = $field;
			}

			$info->id_shop = $this->context->shop->id;
			$info->force_id = true;
			if (!$res)
				$res = $info->add();
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importConfigurations()
	{
		$handle = $this->openCsvFile('configurations.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			if (strpos($line[1], '</') !== false)
			{
				Configuration::updateValue($line[0], $line[1], true);
				Configuration::updateValue($line[0], $line[1], true); // hack for html content adding
			}
			else
				Configuration::updateValue($line[0], $line[1]);
		}

		$this->closeCsvFile($handle);

		return true;
	}

	protected function importSQLdata()
	{
		$new_path = new Sampledatainstall();
		$path = $new_path->sendPath().'input/';

		$sql_list = Tools::scandir($path, 'sql');
		$sql_settings_list = $this->getSettings();

		if ($sql_list)
		{
			foreach ($sql_list as $file)
			{
				if (in_array(str_replace('sql', 'lqs', $file), $sql_settings_list['files_list']))
				{
					$sql = Tools::file_get_contents($path.$file);
					if (!Db::getInstance()->execute($sql))
						$this->errors[] = Tools::displayError('Cannot read the .SQL file');
				}
			}
		}

		return true;
	}

	protected function getSettings($ajax = false)
	{
		$handle = $this->openCsvFile('settings.csv');

		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, ';'); $current_line++)
		{
			$data = array(
				'current_ps_ver' => _PS_VERSION_,
				'sd_ps_ver' => $line[0],
				'current_db_ver' => Configuration::get('PS_VERSION_DB'),
				'sd_db_ver' => $line[1],
				'files_list' => explode(',', $line[2])
			);
		}

		$this->closeCsvFile($handle);
		if ($ajax)
			die(Tools::jsonEncode($data));
		else
			return $data;
	}

	protected function openCsvFile($file)
	{
		$new_path = new Sampledatainstall();
		$file = $new_path->sendPath().'input/'.$file;
		$handle = false;
		if (is_file($file) && is_readable($file))
			$handle = fopen($file, 'r');

		if (!$handle)
			$this->errors[] = Tools::displayError('Cannot read the .CSV file');

		$this->rewindBomAware($handle);

		for ($i = 0; $i < 1; ++$i)
			fgetcsv($handle, MAX_LINE_SIZE, ';');
		return $handle;
	}

	protected function closeCsvFile($handle)
	{
		fclose($handle);
	}

	protected static function rewindBomAware($handle)
	{
		// A rewind wrapper that skips BOM signature wrongly
		if (!is_resource($handle))
			return false;
		rewind($handle);
		if ((fread($handle, 3)) != "\xEF\xBB\xBF")
			rewind($handle);
	}

	private function convertBytes($value)
	{
		/**** convert from byte to kb, mb, gb ***/

		if (is_numeric( $value ))
			return $value;
		else
		{
			$value_length = Tools::strlen($value);
			$qty = Tools::substr( $value, 0, $value_length - 1 );
			$unit = Tools::strtolower(Tools::substr( $value, $value_length - 1 ));
			switch ($unit)
			{
				case 'k':
					$qty *= 1024;
					break;
				case 'm':
					$qty *= 1048576;
					break;
				case 'b':
					$qty *= 1073741824;
					break;
			}
			return $qty;
		}
	}

	private function getBrowser()
	{
		/*** get info about curent browser ***/

		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version = '';

		//First get the platform?
		if (preg_match('/linux/i', $u_agent))
			$platform = 'linux';
		elseif (preg_match('/macintosh|mac os x/i', $u_agent))
			$platform = 'mac';
		elseif (preg_match('/windows|win32/i', $u_agent))
			$platform = 'windows';

		// Next get the name of the useragent yes seperately and for good reason
		if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent))
		{
			$bname = 'Internet Explorer';
			$ub = 'MSIE';
		}
		elseif (preg_match('/Firefox/i', $u_agent))
		{
			$bname = 'Mozilla Firefox';
			$ub = 'Firefox';
		}
		elseif (preg_match('/Chrome/i', $u_agent))
		{
			$bname = 'Google Chrome';
			$ub = 'Chrome';
		}
		elseif (preg_match('/Safari/i', $u_agent))
		{
			$bname = 'Apple Safari';
			$ub = 'Safari';
		}
		elseif (preg_match('/Opera/i', $u_agent))
		{
			$bname = 'Opera';
			$ub = 'Opera';
		}
		elseif (preg_match('/Netscape/i', $u_agent))
		{
			$bname = 'Netscape';
			$ub = 'Netscape';
		}

		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>'.join('|', $known).')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		preg_match_all($pattern, $u_agent, $matches);

		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1)
		{
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent, 'Version') < strripos($u_agent, $ub))
				$version = $matches['version'][0];
			else
				$version = $matches['version'][1];
		}
		else
			$version = $matches['version'][0];

		// check if we have a number
		if ($version == null || $version == '')
			$version = '?';

		return array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'    => $pattern
		);
	}

	private function compabilityServer()
	{
		/*** Check server settings ***/

		// correct settings for server
		$must_settings = array(
			'safe_mode'           => 'off',
			'file_uploads'        => 'on',
			'memory_limit'        => 128,
			'post_max_size'       => 8,
			'upload_max_filesize' => 8,
			'max_input_time'      => 45,
			'max_execution_time'  => 30
		);

		// curret server settings
		$current_settings = array();

		//result array
		$result = array();

		if (ini_get('safe_mode')) $current_settings['safe_mode'] = 'on';
			else $current_settings['safe_mode'] = 'off';
		if (ini_get('file_uploads')) $current_settings['file_uploads'] = 'on';
			else $current_settings['file_uploads'] = 'off';
		if ((int)ini_get('memory_limit') == -1)
			$current_settings['memory_limit'] = 1000;
		else
			$current_settings['memory_limit'] = (int)ini_get('memory_limit');
		$current_settings['post_max_size'] = (int)ini_get('post_max_size');
		$current_settings['upload_max_filesize'] = (int)ini_get('upload_max_filesize');
		if ((int)ini_get('max_input_time') == -1)
			$current_settings['max_input_time'] = 1000;
		else
			$current_settings['max_input_time'] = (int)ini_get('max_input_time');
		if ((int)ini_get('max_execution_time') == 0)
			$current_settings['max_execution_time'] = 1000;
		else
			$current_settings['max_execution_time'] = (int)ini_get('max_execution_time');

		$diff = array_diff_assoc($must_settings, $current_settings);

		if (strcmp($must_settings['safe_mode'], $current_settings['safe_mode']))
			$result['safe_mode'] = $must_settings['safe_mode'];
		if (strcmp($must_settings['file_uploads'], $current_settings['file_uploads']))

			$result['file_uploads'] = $must_settings['file_uploads'];

		foreach ($diff as $key => $value)
		{
			if ($current_settings[$key] < $value)
				$result[$key] = $value;
		}
		if (!empty($result))
		{
			$output = '';
			$count = 0;
			foreach ($result as $key => $value)
			{
				$units = '';
				if ($key == 'memory_limit' || $key == 'post_max_size' || $key == 'upload_max_filesize')
					$units = ' (Mb)';
				if ($key == 'max_input_time' || $key == 'max_execution_time')
					$units = ' (s)';
				$output .= '<tr>';
				$output .= '<td>'.$key.$units.'</td>';
				$output .= '<td class="text-center">'.$current_settings[$key].'</td>';
				$output .= '<td class="text-center">'.$must_settings[$key].'</td>';
				$count++;
				if ($count == 3)
					$output .= '</tr>';
			}

			return $output;
		}
	}

	private function compabilityBrowser()
	{
		/*** check browser compability ***/

		$response = $this->getBrowser();
		$browser_not_supported = $response['name'] == 'Internet Explorer' && $response['version'] <= 9 || $response['name'] == 'Safari' && $response['version'] <= 6 ? true : false;
		if ($browser_not_supported)
		{
			$this->context->smarty->assign('info', array(
				'name' => $response['name'],
				'version' => $response['version']
			));
			return false;
		}
		else
			return true;
	}

	public function filesUpload()
	{
		$import_path = new Sampledatainstall();
		/*** upload files from local storage ***/
		if (array_key_exists('file', $_FILES))
		{
			$file_name = basename($_FILES['file']['name']);
			$file_arr = explode('.', $file_name);
			$file_ext = $file_arr[(count($file_arr) - 1)]; 			// file extension
			if (count($file_arr) > 1) 								// check if this file from download folder
				$file_name = $file_arr['0'].'.'.strrev($file_ext);
			else
				$file_name = $file_arr['0'];

			if (strrev($file_ext) == 'sql' || strrev($file_ext) == 'csv')
				$upload_file = $import_path->sendPath().'input/'.$file_name;
			else
			{
				$path_tmp = explode('@', $file_name);
				$file_insert_path = str_replace('\\', '/', _PS_ROOT_DIR_.'/'.str_replace('#', '/', $path_tmp[0]).'/');
				$file_name = $path_tmp[1];
				// check for path folder
				if (!is_dir($file_insert_path))
					@mkdir($file_insert_path, 0777, true);

				$upload_file = $file_insert_path.$file_name;
			}

			if (!move_uploaded_file($_FILES['file']['tmp_name'], $upload_file))
				die(Tools::jsonEncode(array('error_status' => 'File Upload Fail')));
			die(Tools::jsonEncode(array('success_status' => 'File Upload Success!', 'error' => false)));
		}
	}

	public function filterFields($class_name, $fields, $line)
	{
		if (count($fields) != count($line))
			exit('error');

		$converted_array = array();
		$i = 0;
		foreach ($fields as $key => $field)
		{
			if (property_exists($class_name, $key) && !Tools::isEmpty(trim($line[$i])))
				$converted_array[$key] = $line[$i];
			$i++;
		}
		return $converted_array;
	}

	public function multilFild($data)
	{
		$res = array();
		$languages = Language::getLanguages(false);
		foreach ($languages as $lang)
			$res[$lang['id_lang']] = $data;
		return $res;
	}

	protected function clearDb()
	{
		$new_path = new Sampledatainstall();
		$sql_list = Tools::scandir($new_path->sendPath().'input/', 'sql');
		foreach ($sql_list as $sql)
		{
			// return if sql file for this table is empty
			if (Tools::isEmpty(trim(file_get_contents($new_path->sendPath().'input/'.$sql))))
				return;
			$table_name = explode('.', $sql);
			if ($table_name[0] != 'themeconfigurator')
				$this->dropTable($table_name[0]);
		}
	}

	protected function truncateTables($tables)
	{
		foreach ($tables as $table)
		{
			if (count(Db::getInstance()->executeS('SHOW TABLES LIKE \''._DB_PREFIX_.$table.'\' '))) //check if table exist
				Db::getInstance()->execute('TRUNCATE TABLE `'._DB_PREFIX_.$table.'`');
		}
	}

	protected function dropTable($table)
	{
		if (count(Db::getInstance()->executeS('SHOW TABLES LIKE \''._DB_PREFIX_.$table.'\' '))) //check if table exist
			Db::getInstance()->execute('DROP TABLE `'._DB_PREFIX_.$table.'`');
	}
}
