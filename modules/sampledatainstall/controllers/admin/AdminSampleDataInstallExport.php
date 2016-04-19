<?php

set_time_limit(0);

if (!defined('_PS_CORE_IMG_DIR_'))
	define('_PS_CORE_IMG_DIR_',      _PS_IMG_DIR_);

class AdminSampleDataInstallExportController extends ModuleAdminController {

	protected $use_lang = '';
	public $frendly_url = 0;


	public function __construct()
	{
		$this->bootstrap = true;

		$this->meta_title = $this->l('Export Data');

		parent::__construct();

		if (!$this->module->active)
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminHome'));

		require_once(dirname(__FILE__).'/../../helper/tables_list.php');
		require_once(dirname(__FILE__).'/../../helper/configuration_exeptions.php');
		require_once(dirname(__FILE__).'/../../helper/fields_list.php');

	}

	public function renderConfigurationForm()
	{
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$langs = Language::getLanguages();
		$options = array();
		foreach ($langs as $language)
			$options[] = array('id_option' => $language['id_lang'], 'name' => $language['name']);

		$inputs = array(
			array(
				'type'    => 'select',
				'label'   => $this->l('Language'),
				'desc'    => $this->l('Choose a language you wish to export'),
				'name'    => 'export_language',
				'class'   => 't',
				'options' => array(
					'query' => $options,
					'id'    => 'id_option',
					'name'  => 'name'
				),
			),
		);

		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Export Options'),
					'icon'  => 'icon-cogs'
				),
				'input'  => $inputs,
				'submit' => array(
					'title' => $this->l('Export'),
				)
			),
		);

		$helper = new HelperForm();
		$helper->show_toolbar = false;

		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitExport';
		$helper->currentIndex = self::$currentIndex;
		$helper->token = Tools::getAdminTokenLite('AdminSampleDataInstallExport');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages'    => $this->context->controller->getLanguages(),
			'id_language'  => $this->context->language->id
		);

		return $helper->generateForm(array($fields_form));
	}


	public function getConfigFieldsValues()
	{
		return array(
			'export_language'  => (int)Configuration::get('PS_LANG_DEFAULT')
		);
	}

	public function postProcess()
	{
		if (Tools::isSubmit('submitExport'))
		{
			$this->use_lang = Tools::getValue('export_language');
			$this->clearOutputDirectory();
			$this->checkFrendlyUrl();
			$this->generateProductsData();
			$this->generateProductAttributesData();
			$this->generateProductPackData();
			$this->generateStockAvailableData();
			$this->generateImagesData();
			$this->generateCategoryData();
			$this->generateManufacturerData();
			$this->generateSupplierData();
			$this->generateCustomerData();
			$this->generateAddressData();
			$this->generateAliasData();
			$this->generateAttributeData();
			$this->generateAttributeGroupData();
			$this->generateCMSCategoryData();
			$this->generateCMSPageData();
			$this->generateLanguageData();
			$this->generateCurrencyData();
			$this->generateAttachmentData();
			$this->generateCarrierData();
			$this->generateCartRuleData();
			$this->generateContactData();
			$this->generateZoneData();
			$this->generateCountryData();
			$this->generateStateData();
			$this->generateDeliveryData();
			$this->generateSpecificPriceData();
			$this->generateSpecificPriceRuleData();
			$this->generateTaxData();
			$this->generateTaxRuleData();
			$this->generateTaxRuleGroupData();
			$this->generateFeaturesData();
			$this->generateFeatureValuesData();
			$this->generateHomeSlidesData();
			$this->generateInfosData();
			$this->generateConfigurationData();
			$this->getCustomTablesSQL();
			$this->getAdditionalImages();
			$this->checkFrendlyUrl(true);
			$this->generateParametersFile();
			$this->archiveData();
		}
	}

	public function initContent()
	{
		$this->content = $this->displayWarning($this->l('1. Module is working in test mode. Please backup your store data before export.'));
		$this->content .= $this->displayWarning($this->l('2. Exported archive contains the following store data: Address, Alias, Attachments, Attributes, 
			Carriers, Categories, CMS Categories, CMS Pages, Configurations(only custom fields), Contacts, Countries, Currencies, Deliveries, Features, Home Slides, Images, Infos, Languages, 
			Manufacturers, Products, Product Attributes, Product Packs, Specific Prices, States, Stock Available, Suppliers, Taxes, Zones and non-prestashop tables.'));
		$this->content .= $this->displayWarning($this->l('3. Export and import are fully functional only with single langue stores. Only one language can be used for export and import.'));
		$this->content .= $this->displayWarning($this->l('4. We do not guarantee the correct work of exported erchive with other third party importing tools.'));
		$this->content .= $this->renderConfigurationForm();
		parent::initContent();
	}

	public function getWarehouses($id_warehouses)
	{
		return $id_warehouses['id_warehouse'];
	}

	protected function generateProductsData()
	{
		$delimiter = ';';
		$titles = array();
		$id_lang = $this->use_lang;

		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/products.vsc', 'w');

		foreach ($this->product_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$products = Product::getProducts($id_lang, 0, 0, 'id_product', 'ASC', false, true);

		foreach ($products as $product)
		{
			$line = array();
			$p = new Product($product['id_product'], true, $id_lang, 1);

			foreach ($this->product_fields as $field => $array)
				$line[$field] = property_exists('Product', $field) && !is_array($p->$field) && !Tools::isEmpty($p->$field) ? $p->$field : '';

			$cats = $p->getProductCategoriesFull($p->id, 1);
			$cat_array = array();
			foreach ($cats as $cat)
				$cat_array[] = $cat['id_category'];

			$line['categories'] = implode(',', $cat_array);

			$line['price_tex'] = $p->getPrice(false);
			$line['price_tin'] = $p->getPrice(true);
			$line['upc'] = $p->upc ? $p->upc : '';

			$line['features'] = '';
			$features = $p->getFrontFeatures($id_lang);
			$position = 1;
			$devider = '';
			foreach ($features as $feature)
			{
				$sql = 'SELECT `id_feature`
						FROM '._DB_PREFIX_.'feature_lang
						WHERE `name` = "'.pSql($feature['name']).'"';
				$sql1 = 'SELECT `id_feature_value`
						FROM '._DB_PREFIX_.'feature_value_lang
						WHERE `value` = "'.pSql($feature['value']).'"';
		
				$id_feature = Db::getInstance()->getValue($sql);
				$id_feature_value = Db::getInstance()->getValue($sql1);
				$line['features'] .= $devider.$id_feature.':'.$id_feature_value.':'.$position;
				$devider = ',';
				$position++;
			}

			$specificPrice = SpecificPrice::getSpecificPrice($p->id, 1, 0, 0, 0, 0);

			$line['reduction_price'] = '';
			$line['reduction_percent'] = '';
			$line['reduction_from'] = '';
			$line['reduction_to'] = '';

			if ($specificPrice)
			{
				if ($specificPrice['reduction_type'] == 'amount')
					$line['reduction_price'] = $specificPrice['reduction'];
				elseif ($specificPrice['reduction_type'] == 'percent')
					$line['reduction_percent'] = $specificPrice['reduction'];

				if ($line['reduction_price'] !== '' || $line['reduction_percent'] !== '')
				{
					$line['reduction_from'] = $specificPrice['from'];
    				$line['reduction_to'] = $specificPrice['to'];
				}
			}

			$tags = $p->getTags($id_lang);
			$line['tags'] = $tags;

			$link = new Link();
			$imagelinks = array();
			$images = $p->getImages($id_lang);
			foreach ($images as $image)
			{
				$imagelink = Tools::getShopProtocol().$link->getImageLink($p->link_rewrite, $p->id.'-'.$image['id_image']);
				$this->copyConverFileName($imagelink);
				$imagelinks[] = $imagelink;
			}

			$line['image'] = implode(',', $imagelinks);
			$line['delete_existing_images'] = 0;
			$line['shop'] = 1;
			$warehouses = Warehouse::getWarehousesByProductId($p->id);
			$line['warehouse'] = '';
			if (!empty($warehouses))
				$line['warehouse'] = implode(',', array_map("$this->getWarehouses", $warehouses));

			$values = array();
			$accesories = $p->getAccessories($id_lang);
			if (isset($accesories) && $accesories && count($accesories))
			{
				foreach ($accesories as $accesorie)
					$values[] = $accesorie['id_product'];
			}

			$line['accessories'] = $values ? implode(',', $values) : '';

			$values = array();
			$carriers = $p->getCarriers();
			if (isset($carriers) && $carriers && count($carriers))
			{
				foreach ($carriers as $carrier)
					$values[] = $carrier['id_carrier'];
			}

			$line['carriers'] = $values ? implode(',', $values) : '';

			$values = array();
			$customization_fields_ids = $p->getCustomizationFieldIds();
			if (class_exists('CustomizationField') && isset($customization_fields_ids) && $customization_fields_ids && count($customization_fields_ids))
			{
				foreach ($customization_fields_ids as $customization_field_id)
				{
					$cf = new CustomizationField($customization_field_id['id_customization_field'], $this->use_lang);
					$values[] = $cf->id.':'.$cf->type.':'.$cf->required.':'.$cf->name;
				}
			}

			$line['customization_fields_ids'] = $values ? implode(',', $values) : '';

			$values = array();
			$attachments = $p->getAttachments($this->use_lang);

			if (isset($attachments) && $attachments && count($attachments))
			{
				foreach ($attachments as $attachment)
					$values[] = $attachment['id_attachment'];
			}

			$line['attachments'] = $values ? implode(',', $values) : '';
			if (!property_exists('Product', 'base_price')) // for versions < 1.6.0.13
				$line['base_price'] = !is_array($p->base_price) && !Tools::isEmpty($p->base_price) ? $p->base_price : '';

			if (!$line[$field])
				$line[$field] = '';
			fputcsv($f, $line, $delimiter, '"');
		}
		fclose($f);
	}

	protected function generateProductAttributesData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();

		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/product_attributes.vsc', 'w');

		foreach ($this->product_attribute_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$product_attributes = $this->getAllProductsAttributes();

		if ($product_attributes)
		{
			foreach ($product_attributes as $product_attribute)
			{
				$pa = new Combination($product_attribute);

				foreach ($this->product_attribute_fields as $field => $array)
					$line[$field] = property_exists('Combination', $field) && !is_array($pa->$field) && !Tools::isEmpty($pa->$field) ? $pa->$field : '';

				$value = $this->getAttributeValues($pa->id);
				$line['values'] = $value ? implode(',', $value) : '';
				$attr_images = array();
				$images = $pa->getWsImages();
				foreach ($images as $image)
					$attr_images[] = $image['id'];
				$line['image'] = $attr_images ? implode(',', $attr_images) : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	/**
	**	Get all products attributes for $this->generateProductAttributesData()
	**  @return array
	**/
	private function getAllProductsAttributes()
	{
		$data = array();
		$sql = 'SELECT pa.`id_product_attribute`
				FROM '._DB_PREFIX_.'product_attribute pa
				LEFT JOIN '._DB_PREFIX_.'product_attribute_shop pas
				ON (pa.`id_product_attribute` = pas.`id_product_attribute`)
				AND pas.`id_shop` = '.$this->context->shop->id;
		if (!$result = Db::getInstance()->executeS($sql))
			return false;

		foreach ($result as $res)
			$data[] = $res['id_product_attribute'];

		return $data;
	}

	/**
	**	Get attribute values for $this->generateProductAttributesData()
	**  @return array
	**/
	private function getAttributeValues($id_product_attribute)
	{
		$data = array();
		$sql = 'SELECT `id_attribute`
				FROM '._DB_PREFIX_.'product_attribute_combination
				WHERE `id_product_attribute` = '.$id_product_attribute;

		if (!$result = Db::getInstance()->executeS($sql))
			return false;

		foreach ($result as $res)
			$data[] = $res['id_attribute'];

		return $data;
	}

	protected function generateProductPackData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();

		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/product_packs.vsc', 'w');

		foreach ($this->product_pack_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$product_packs = $this->getAllProductsPacks();

		if ($product_packs)
		{
			foreach ($product_packs as $product_pack)
			{
				$line['id_product_pack'] = $product_pack['id_product_pack'];
				$line['id_product_item'] = $product_pack['id_product_item'];
				$line['id_product_attribute_item'] = $product_pack['id_product_attribute_item'];
				$line['quantity'] = $product_pack['quantity'];
				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	/**
	**	get all products packs for $this->generateProductPackData()
	** 	@return array
	**/
	protected function getAllProductsPacks()
	{
		$sql = 'SELECT * FROM '._DB_PREFIX_.'pack';

		if (!$result = Db::getInstance()->executeS($sql))
			return false;

		return $result;
	}

	protected function generateStockAvailableData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();

		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/stock_available.vsc', 'w');

		foreach ($this->stock_available_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$stock_availables = $this->getAllStockAvailibleData();

		if ($stock_availables)
		{
			foreach ($stock_availables as $stock_available)
			{
				$sa = new StockAvailable($stock_available);

				foreach ($this->stock_available_fields as $field => $array)
					$line[$field] = property_exists('StockAvailable', $field) && !is_array($sa->$field) && !Tools::isEmpty($sa->$field) ? $sa->$field : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	/**
	**	Get all stock availible data for $this->generateStockAvailableData()
	**	@return array(ID's)
	**/
	protected function getAllStockAvailibleData()
	{
		$data = array();
		$sql = 'SELECT `id_stock_available`
				FROM '._DB_PREFIX_.'stock_available
				WHERE `id_shop` = '.$this->context->shop->id;
		if (!$result = Db::getInstance()->executeS($sql))
			return false;
		foreach ($result as $res)
			$data[] = $res['id_stock_available'];
		return $data;
	}

	protected function generateImagesData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();

		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/images.vsc', 'w');

		foreach ($this->image_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$images = Image::getAllImages();
		if ($images)
		{
			foreach ($images as $image)
			{
				$i = new Image($image['id_image'], $this->use_lang);

				foreach ($this->image_fields as $field => $array)
					$line[$field] = property_exists('Image', $field) && !is_array($i->$field) && !Tools::isEmpty($i->$field) ? $i->$field : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	protected function generateCategoryData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$id_lang = $this->use_lang;

		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/categories.vsc', 'w');

		foreach ($this->category_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$categories = Category::getCategories($id_lang, true);

		foreach ($categories as $category)
		{
			foreach ($category as $c)
			{
				$line = array();
				$categor_id = $c['infos']['id_category'];
				// check if category is not ROOT and not HOME
				if ($categor_id != Configuration::get('PS_HOME_CATEGORY')
					&& $categor_id != Configuration::get('PS_ROOT_CATEGORY'))
				{
					$cat = new Category($c['infos']['id_category'], $id_lang);

					foreach ($this->category_fields as $field => $array)
						$line[$field] = property_exists('Category', $field) && !is_array($cat->$field) && !Tools::isEmpty($cat->$field) ? $cat->$field : '';

					$link = new Link();
					$imagelink = '';
					if ($cat->id_image)
					{
						$imagelink = Tools::getShopProtocol().$link->getCatImageLink($cat->link_rewrite, $cat->id_image);
						$this->copyConverFileName($imagelink);
					}

					for ($i = 0; $i < 3; $i++)
					{
						if (file_exists(_PS_CAT_IMG_DIR_.(int)$cat->id.'-'.$i.'_thumb.jpg'))
							$this->copyConverFileName(_PS_CAT_IMG_DIR_.(int)$cat->id.'-'.$i.'_thumb.jpg');
					}

					$line['image_url'] = $imagelink ? $imagelink : '';

					if (!$line[$field])
						$line[$field] = '';
					fputcsv($f, $line, $delimiter, '"');
				}
			}
		}
		fclose($f);
	}

	protected function generateManufacturerData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$id_lang = $this->use_lang;

		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/manufacturers.vsc', 'w');

		foreach ($this->manufacturers_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$manufacturers = Manufacturer::getManufacturers(false, $id_lang, true);

		foreach ($manufacturers as $manufacturer)
		{
			$m = new Manufacturer($manufacturer['id_manufacturer'], $id_lang);

			foreach ($this->manufacturers_fields as $field => $array)
			{
				$line[$field] = property_exists('Manufacturer', $field) && !is_array($m->$field) && !Tools::isEmpty($m->$field) ? $m->$field : '';

				if (file_exists(_PS_MANU_IMG_DIR_.$m->id.'.jpg'))
					$this->copyConverFileName(_PS_MANU_IMG_DIR_.$m->id.'.jpg');
			}

			if (!$line[$field])
				$line[$field] = '';
			fputcsv($f, $line, $delimiter, '"');
		}
		fclose($f);
	}

	protected function generateSupplierData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$id_lang = $this->use_lang;

		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/suppliers.vsc', 'w');

		foreach ($this->suppliers_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$suppliers = Supplier::getSuppliers(false, $id_lang, true);

		foreach ($suppliers as $supplier)
		{
			$s = new Supplier($supplier['id_supplier'], $id_lang);

			foreach ($this->suppliers_fields as $field => $array)
				$line[$field] = property_exists('Supplier', $field) && !is_array($s->$field) && !Tools::isEmpty($s->$field) ? $s->$field : '';

			if (file_exists(_PS_SUPP_IMG_DIR_.$s->id.'.jpg'))
				$this->copyConverFileName(_PS_SUPP_IMG_DIR_.$s->id.'.jpg');

			if (!$line[$field])
				$line[$field] = '';
			fputcsv($f, $line, $delimiter, '"');
		}
		fclose($f);
	}

	protected function generateCustomerData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();

		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/customers.vsc', 'w');

		foreach ($this->customers_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$customers = Customer::getCustomers();

		foreach ($customers as $customer)
		{
			$c = new Customer($customer['id_customer']);

			foreach ($this->customers_fields as $field => $array)
			{
				if ($field == 'passwd')
					$line[$field] = Tools::encrypt($c->$field);
				else
					$line[$field] = property_exists('Customer', $field) && !is_array($c->$field) && !Tools::isEmpty($c->$field) ? $c->$field : '';
			}
			if (!$line[$field])
				$line[$field] = '';

			fputcsv($f, $line, $delimiter, '"');
		}
		fclose($f);
	}

	protected function generateAddressData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/address.vsc', 'w');

		foreach ($this->address_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$address = $this->getCustomersAdress();

		foreach ($address as $addres)
		{
			$a = new Address($addres['id_address']);

			foreach ($this->address_fields as $field => $array)
			{
				$line['id'] = $addres['id_address'];
				$line['active'] = $addres['active'];
				if ($field != 'id' && $field != 'active')
					$line[$field] = property_exists('Address', $field) && !is_array($a->$field) && !Tools::isEmpty($a->$field) ? $a->$field : '';
			}
			fputcsv($f, $line, $delimiter, '"');
		}

		fclose($f);
	}

	protected function getCustomersAdress()
	{
		$sql = 'SELECT `id_address`, `active`
				FROM '._DB_PREFIX_.'address 
				ORDER BY `id_address`';
		if (!$result = Db::getInstance()->executeS($sql))
			return false;

		return $result;
	}

	protected function generateAliasData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/alias.vsc', 'w');

		foreach ($this->alias_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$aliases = $this->getAliases();

		if ($aliases)
		{
			foreach ($aliases as $alias)
			{
				$a = new Alias($alias['id_alias']);

				foreach ($this->alias_fields as $field => $array)
					$line[$field] = property_exists('Alias', $field) && !is_array($a->$field) && !Tools::isEmpty($a->$field) ? $a->$field : '';

				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	protected function getAliases()
	{
		$sql = 'SELECT *
				FROM '._DB_PREFIX_.'alias';

		if (!$result = Db::getInstance()->executeS($sql))
			return false;
		return $result;
	}

	protected function generateAttributeData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();
		$id_lang = $this->use_lang;

		$f = fopen($new_path->sendPath().'output/attributes.vsc', 'w');

		foreach ($this->attributes_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$attributes = Attribute::getAttributes($id_lang);

		if ($attributes)
		{
			foreach ($attributes as $attribute)
			{
				$a = new Attribute($attribute['id_attribute'], $id_lang);

				foreach ($this->attributes_fields as $field => $array)
					$line[$field] = property_exists('Attribute', $field) && !is_array($a->$field) && !Tools::isEmpty($a->$field) ? $a->$field : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	protected function generateAttributeGroupData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();
		$id_lang = $this->use_lang;

		$f = fopen($new_path->sendPath().'output/attribute_groups.vsc', 'w');

		foreach ($this->attribute_groups_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$attribute_groups = AttributeGroup::getAttributesGroups($id_lang);

		if ($attribute_groups)
		{
			uasort($attribute_groups, array('SampleDataInstall', 'cmp'));

			foreach ($attribute_groups as $attribute_group)
			{
				foreach ($this->attribute_groups_fields as $field => $array)
					$line[$field] = !Tools::isEmpty($attribute_group[$field]) ? $attribute_group[$field] : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}

		fclose($f);
	}

	protected function generateCMSCategoryData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();
		$id_lang = $this->use_lang;

		$f = fopen($new_path->sendPath().'output/cms_categories.vsc', 'w');

		foreach ($this->cms_category_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$cms_categories = CMSCategory::getCategories($id_lang);

		if ($cms_categories)
		{
			foreach ($cms_categories as $cms_category)
			{
				foreach ($cms_category as $cc)
				{
					$cms_cat = new Category($cc['infos']['id_cms_category'], $id_lang);

					foreach ($this->cms_category_fields as $field => $array)
						$line[$field] = property_exists('Category', $field) && !is_array($cms_cat->$field) && !Tools::isEmpty($cms_cat->$field) ? $cms_cat->$field : '';

					if (!$line[$field])
						$line[$field] = '';
					fputcsv($f, $line, $delimiter, '"');
				}
			}
		}
		fclose($f);
	}

	protected function generateCMSPageData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();
		$id_lang = $this->use_lang;

		$f = fopen($new_path->sendPath().'output/cms_pages.vsc', 'w');

		foreach ($this->cms_pages_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$cms_pages = CMS::getCMSPages($id_lang);

		foreach ($cms_pages as $cms_page)
		{
			$cms_p = new CMS($cms_page['id_cms'], $id_lang);

			foreach ($this->cms_pages_fields as $field => $array)
				$line[$field] = property_exists('CMS', $field) && !is_array($cms_p->$field) && !Tools::isEmpty($cms_p->$field) ? $cms_p->$field : '';

			if (!$line[$field])
				$line[$field] = '';
			fputcsv($f, $line, $delimiter, '"');
		}
		fclose($f);
	}

	protected function generateLanguageData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/languages.vsc', 'w');

		foreach ($this->languages_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$languages = Language::getLanguages();

		if ($languages)
		{
			foreach ($languages as $language)
			{
				$l = new Language($language['id_lang']);
				foreach ($this->languages_fields as $field => $array)
					$line[$field] = property_exists('Language', $field) && !is_array($l->$field) && !Tools::isEmpty($l->$field) ? $l->$field : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	protected function generateCurrencyData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/currencies.vsc', 'w');

		foreach ($this->currencies_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$currencies = Currency::getCurrencies();

		if ($currencies)
		{
			foreach ($currencies as $currency)
			{
				$c = new Currency($currency['id_currency']);

				foreach ($this->currencies_fields as $field => $array)
					$line[$field] = property_exists('Currency', $field) && !is_array($c->$field) && !Tools::isEmpty($c->$field) ? $c->$field : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	protected function generateAttachmentData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$id_lang = $this->use_lang;
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/attachments.vsc', 'w');

		foreach ($this->attachments_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$attachments = $this->getAttachments();

		if ($attachments)
		{
			foreach ($attachments as $attachment)
			{
				$a = new Attachment($attachment['id_attachment'], $id_lang);

				foreach ($this->attachments_fields as $field => $array)
					$line[$field] = property_exists('Attachment', $field) && !is_array($a->$field) && !Tools::isEmpty($a->$field) ? $a->$field : '';

				if (!$line[$field])
					$line[$field] = '';
				if (file_exists(_PS_DOWNLOAD_DIR_.$a->file))
				{
					fputcsv($f, $line, $delimiter, '"');
					$this->copyConverFileName(_PS_DOWNLOAD_DIR_.$a->file, false, true);
				}
			}
		}
		fclose($f);
	}

	protected function getAttachments()
	{
		$sql = 'SELECT * FROM '._DB_PREFIX_.'attachment';

		if (!$result = Db::getInstance()->executeS($sql))
			return false;
		return $result;
	}

	protected function generateCarrierData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$id_lang = $this->use_lang;
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/carriers.vsc', 'w');

		foreach ($this->carriers_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$carriers = Carrier::getCarriers($id_lang);

		if ($carriers)
		{
			foreach ($carriers as $carrier)
			{
				$c = new Carrier($carrier['id_carrier'], $id_lang);

				foreach ($this->carriers_fields as $field => $array)
					$line[$field] = property_exists('Carrier', $field) && !is_array($c->$field) && !Tools::isEmpty($c->$field) ? $c->$field : '';
					
				$line['carrier_groups'] = $c->getGroups($carrier['id_carrier']) ?
										implode(',', $this->oneL($c->getGroups($carrier['id_carrier']))) : '';
				$line['zones'] = $this->getCarrierZones($carrier['id_carrier']) ?
										implode(',', $this->getCarrierZones($carrier['id_carrier'])) : '';
				$line['range_price'] = $this->getRengePriceByCarrier('range_price', $carrier['id_carrier']) ?
										implode(',', $this->getRengePriceByCarrier('range_price', $carrier['id_carrier'])) : '';
				$line['range_weight'] = $this->getRengePriceByCarrier('range_weight', $carrier['id_carrier']) ?
										implode(',', $this->getRengePriceByCarrier('range_weight', $carrier['id_carrier'])) : '';

				if (file_exists(_PS_SHIP_IMG_DIR_.$c->id.'.jpg'))
					$this->copyConverFileName(_PS_SHIP_IMG_DIR_.$c->id.'.jpg');

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	/**
	** transform multilevel array to one level for $this->generateCarrierData();
	** @return array
	**/
	protected function oneL($array)
	{
		$result = array();
		foreach ($array as $key => $value)
			$result[$key] = $value['id_group'];

		return $result;
	}

	/**
	** Get all carriers zones by id
	** @return array
	**/
	protected function getCarrierZones($id_carrier)
	{
		$data = array();
		$sql = 'SELECT `id_zone`
				FROM '._DB_PREFIX_.'carrier_zone
				WHERE `id_carrier` = '.$id_carrier;
		if (!$result = Db::getInstance()->executeS($sql))
			return false;
		foreach ($result as $res)
			$data[] = $res['id_zone'];
		return $data;
	}

	protected function getRengePriceByCarrier($range, $id_carrier)
	{
		$data = array();
		$sql = 'SELECT `delimiter1`, `delimiter2`
				FROM '._DB_PREFIX_.$range.'
				WHERE `id_carrier` = '.$id_carrier;
		if (!$result = Db::getInstance()->executeS($sql))
			return false;

		foreach ($result as $res)
			$data[] = $res['delimiter1'].'-'.$res['delimiter2'];
		return $data;
	}

	protected function generateCartRuleData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$id_lang = $this->use_lang;
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/cart_rules.vsc', 'w');

		foreach ($this->cartrules_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$cart_rules = $this->getCartRules();

		if ($cart_rules)
		{
			foreach ($cart_rules as $cart_rule)
			{
				$cr = new CartRule($cart_rule['id_cart_rule'], $id_lang);

				foreach ($this->cartrules_fields as $field => $array)
					$line[$field] = property_exists('CartRule', $field) && !is_array($cr->$field) && !Tools::isEmpty($cr->$field) ? $cr->$field : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	protected function getCartRules()
	{
		$sql = 'SELECT `id_cart_rule`
				FROM '._DB_PREFIX_.'cart_rule';

		if (!$result = Db::getInstance()->executeS($sql))
			return false;
		return $result;
	}

	protected function generateContactData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$id_lang = $this->use_lang;
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/contacts.vsc', 'w');

		foreach ($this->contacts_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$contacts = Contact::getContacts($id_lang);

		if ($contacts)
		{
			foreach ($contacts as $contact)
			{
				$c = new Contact($contact['id_contact'], $id_lang);

				foreach ($this->contacts_fields as $field => $array)
					$line[$field] = property_exists('Contact', $field) && !is_array($c->$field) && !Tools::isEmpty($c->$field) ? $c->$field : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	protected function generateCountryData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$id_lang = $this->use_lang;
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/countries.vsc', 'w');

		foreach ($this->countries_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$countries = Country::getCountries($id_lang);

		if ($countries)
		{
			foreach ($countries as $country)
			{
				foreach ($this->countries_fields as $field => $array)
					$line[$field] = !Tools::isEmpty($country[$field]) ? $country[$field] : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	protected function generateStateData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$id_lang = $this->use_lang;
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/states.vsc', 'w');

		foreach ($this->states_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$states = State::getStates($id_lang);

		if ($states)
		{
			foreach ($states as $state)
			{
				foreach ($this->states_fields as $field => $array)
					$line[$field] = !Tools::isEmpty($state[$field]) ? $state[$field] : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	protected function generateZoneData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/zones.vsc', 'w');

		foreach ($this->zones_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$zones = Zone::getZones();

		if ($zones)
		{
			foreach ($zones as $zone)
			{
				foreach ($this->zones_fields as $field => $array)
					$line[$field] = !Tools::isEmpty($zone[$field]) ? $zone[$field] : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	protected function generateDeliveryData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/deliveries.vsc', 'w');

		foreach ($this->delivery_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$deliveries = $this->getDeliveries();

		if ($deliveries)
		{
			foreach ($deliveries as $delivery)
			{
				$d = new Delivery($delivery['id_delivery']);

				foreach ($this->delivery_fields as $field => $array)
					$line[$field] = property_exists('Delivery', $field) && !is_array($d->$field) && !Tools::isEmpty($d->$field) ? $d->$field : 0;

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	protected function getDeliveries()
	{
		$sql = 'SELECT `id_delivery`
				FROM '._DB_PREFIX_.'delivery';
		if (!$result = Db::getInstance()->executeS($sql))
			return false;
		return $result;
	}

	protected function generateSpecificPriceData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/specific_prices.vsc', 'w');

		foreach ($this->specific_price_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$specific_prices = $this->getAllSpecificPrices();

		if ($specific_prices)
		{
			foreach ($specific_prices as $specific_price)
			{
				$sp = new SpecificPrice($specific_price['id_specific_price']);

				foreach ($this->specific_price_fields as $field => $array)
					$line[$field] = property_exists('SpecificPrice', $field) && !is_array($sp->$field) && !Tools::isEmpty($sp->$field) ? $sp->$field : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}
	/**
	**	Get all specific prices for $this->generateSpecificPriceData()
	**	@return array (IDs)
	**/
	protected function getAllSpecificPrices()
	{
		$sql = 'SELECT `id_specific_price`
				FROM '._DB_PREFIX_.'specific_price';

		if (!$result = Db::getInstance()->executeS($sql))
			return false;

		return $result;
	}

	protected function generateSpecificPriceRuleData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/specific_price_rules.vsc', 'w');

		foreach ($this->specific_price_rule_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$specific_price_rules = $this->getAllSpecificPriceRules();

		if ($specific_price_rules)
		{
			foreach ($specific_price_rules as $specific_price_rule)
			{
				$spr = new SpecificPriceRule($specific_price_rule['id_specific_price_rule']);

				foreach ($this->specific_price_rule_fields as $field => $array)
					$line[$field] = property_exists('SpecificPriceRule', $field) && !is_array($spr->$field) && !Tools::isEmpty($spr->$field) ? $spr->$field : '';

				$values = array();
				$conditions = $spr->getConditions();
				if ($conditions)
				{
					foreach ($conditions as $condition)
					{
						foreach ($condition as $c)
							$values[] = $c['type'].':'.$c['value'];
					}
				}
				$line['conditions'] = $conditions ? implode(',', $values) : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	/**
	**	Get all specific prices rule for $this->generateSpecificPriceRuleData()
	**	@return array (IDs)
	**/
	protected function getAllSpecificPriceRules()
	{
		$sql = 'SELECT `id_specific_price_rule`
				FROM '._DB_PREFIX_.'specific_price_rule';

		if (!$result = Db::getInstance()->executeS($sql))
			return false;

		return $result;
	}

	protected function generateTaxData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/taxes.vsc', 'w');

		foreach ($this->tax_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$taxes = Tax::getTaxes();

		if ($taxes)
		{
			foreach ($taxes as $tax)
			{
				$t = new Tax($tax['id_tax'], $this->use_lang);

				foreach ($this->tax_fields as $field => $array)
					$line[$field] = property_exists('Tax', $field) && !is_array($t->$field) && !Tools::isEmpty($t->$field) ? $t->$field : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	protected function generateTaxRuleData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/tax_rules.vsc', 'w');

		foreach ($this->tax_rule_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$tax_rules = $this->getAllTaxRules();

		if ($tax_rules)
		{
			foreach ($tax_rules as $tax_rule)
			{
				$tr = new TaxRule($tax_rule);

				foreach ($this->tax_rule_fields as $field => $array)
					$line[$field] = property_exists('TaxRule', $field) && !is_array($tr->$field) && !Tools::isEmpty($tr->$field) ? $tr->$field : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	/**
	**	Get all tax rules for $this->generateTaxRuleData()
	** @return array (ID's)
	**/
	protected function getAllTaxRules()
	{
		$data = array();
		$sql  = 'SELECT `id_tax_rule` FROM '._DB_PREFIX_.'tax_rule';

		if (!$result = Db::getInstance()->executeS($sql))
			return false;
		foreach ($result as $res)
			$data[] = $res['id_tax_rule'];
		return $data;
	}

	protected function generateTaxRuleGroupData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/tax_rule_groups.vsc', 'w');

		foreach ($this->tax_rule_group_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$tax_rule_groups = TaxRulesGroup::getTaxRulesGroups();

		if ($tax_rule_groups)
		{
			foreach ($tax_rule_groups as $tax_rule_group)
			{
				$trg = new TaxRulesGroup($tax_rule_group['id_tax_rules_group']);

				foreach ($this->tax_rule_group_fields as $field => $array)
					$line[$field] = property_exists('TaxRulesGroup', $field) && !is_array($trg->$field) && !Tools::isEmpty($trg->$field) ? $trg->$field : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	protected function generateFeaturesData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/features.vsc', 'w');

		foreach ($this->feature_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$features = Feature::getFeatures($this->use_lang);

		if ($features)
		{
			foreach ($features as $feature)
			{
				$feature = new Feature($feature['id_feature'], $this->use_lang);

				foreach ($this->feature_fields as $field => $array)
					$line[$field] = property_exists('Feature', $field) && !is_array($feature->$field) && !Tools::isEmpty($feature->$field) ? $feature->$field : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	protected function generateFeatureValuesData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/feature_values.vsc', 'w');

		foreach ($this->feature_value_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$feature_values = $this->getAllFeaturesValues();

		if ($feature_values)
		{
			foreach ($feature_values as $feature_value)
			{
				$fv = new FeatureValue($feature_value, $this->use_lang);

				foreach ($this->feature_value_fields as $field => $array)
					$line[$field] = property_exists('FeatureValue', $field) && !is_array($fv->$field) && !Tools::isEmpty($fv->$field) ? $fv->$field : '';


				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	/**
	**	Get all features values for $this->generateFeatureValuesData()
	**	@return array (ID's)
	**/

	protected function getAllFeaturesValues()
	{
		$data = array();
		$sql = 'SELECT `id_feature_value` FROM '._DB_PREFIX_.'feature_value';

		if (!$result = Db::getInstance()->executeS($sql))
			return false;

		foreach ($result as $res)
			$data[] = $res['id_feature_value'];

		return $data;
	}

	protected function generateHomeSlidesData()
	{
		if (!(int)Validate::isLoadedObject(Module::getInstanceByName('homeslider')) || !Module::isEnabled('homeslider') || !Module::isInstalled('homeslider'))
			return;

		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/home_slides.vsc', 'w');

		foreach ($this->home_slide_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$slides = $this->getAllHomeSlides();

		if ($slides)
		{
			foreach ($slides as $slide)
			{
				$s = new HomeSlide($slide, $this->use_lang);

				foreach ($this->home_slide_fields as $field => $array)
					$line[$field] = property_exists('HomeSlide', $field) && !is_array($s->$field) && !Tools::isEmpty($s->$field) ? $s->$field : '';

				if (file_exists(_PS_MODULE_DIR_.'homeslider/images/'.$s->image))
					$this->copyConverFileName(_PS_MODULE_DIR_.'homeslider/images/'.$s->image, true);

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	/**
	**	Get all home slides for $this->generateHomeSlidesData()
	**	@retun array (ID's)
	**/
	protected function getAllHomeSlides()
	{
		$data = array();

		$sql = 'SELECT `id_homeslider_slides`
				FROM '._DB_PREFIX_.'homeslider
				WHERE `id_shop` = '.$this->context->shop->id;

		if (!$result = Db::getInstance()->executeS($sql))
			return false;

		foreach ($result as $res)
			$data[] = $res['id_homeslider_slides'];

		return $data;
	}

	protected function generateInfosData()
	{
		if (!(int)Validate::isLoadedObject(Module::getInstanceByName('blockcmsinfo')) || !Module::isEnabled('blockcmsinfo') || !Module::isInstalled('blockcmsinfo'))
			return;

		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/infos.vsc', 'w');

		foreach ($this->info_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$infos = $this->getAllInfos();

		if ($infos)
		{
			if (!class_exists('InfoBlock'))
				return;
			foreach ($infos as $info)
			{
				$i = new InfoBlock($info, $this->use_lang);

				foreach ($this->info_fields as $field => $array)
					$line[$field] = property_exists('InfoBlock', $field) && !is_array($i->$field) && !Tools::isEmpty($i->$field) ? $i->$field : '';

				if (!$line[$field])
					$line[$field] = '';
				fputcsv($f, $line, $delimiter, '"');
			}
		}
		fclose($f);
	}

	/**
	**	Get all infos for $this->generateInfosData()
	**	@retun array (ID's)
	**/
	protected function getAllInfos()
	{
		$data = array();

		$sql = 'SELECT `id_info`
				FROM '._DB_PREFIX_.'info
				WHERE `id_shop` = '.$this->context->shop->id;

		if (!$result = Db::getInstance()->executeS($sql))
			return false;

		foreach ($result as $res)
			$data[] = $res['id_info'];

		return $data;
	}
	protected function generateConfigurationData()
	{
		$delimiter = ';';
		$line = array();
		$titles = array();
		$new_path = new Sampledatainstall();

		$f = fopen($new_path->sendPath().'output/configurations.vsc', 'w');

		foreach ($this->configuration_fields as $field => $array)
			$titles[] = $array['label'];

		fputcsv($f, $titles, $delimiter, '"');

		$configurations = $this->getAllConfigurations();

		if ($configurations)
		{
			$exeptions = $this->configuration_exeptions;
			foreach ($configurations as $configuration)
			{
				if (!in_array($configuration['name'], $exeptions))
				{
					$line['name'] = $configuration['name'];
					$line['value'] = $configuration['value'];

					if (!$line[$field])
						$line[$field] = '';
					fputcsv($f, $line, $delimiter, '"');
				}
			}
		}
		fclose($f);
	}

	protected function getAllConfigurations()
	{
		$sql = 'SELECT `name`, `value` FROM '._DB_PREFIX_.'configuration';

		if (!$result = Db::getInstance()->executeS($sql))
			return false;

		return $result;
	}

	protected function getCustomTablesSQL()
	{
		$path = new Sampledatainstall();
		$tables = array_diff($this->getAllTablesList(), $this->defaultTablesList);
		foreach ($tables as $table)
		{
			$file = fopen($path->sendPath().'output/'.$table.'.lqs', 'w');
			if (!is_resource($file))
				return false;
			$data = $this->mySQLDumpTableStructure(_DB_PREFIX_.$table);
			$data .= $this->mySQLDumpTableData(_DB_PREFIX_.$table);
			fwrite($file, $data);
			fclose($file);
		}
	}

	protected function getAllTablesList()
	{
		$list = array();
		$result = Db::getInstance()->executeS('SHOW TABLES');
		if (!$result)
			return false;

		foreach ($result as $res)
		{
			$key = array_keys($res);
			$list[] = str_replace(_DB_PREFIX_, '', $res[$key[0]]);
		}

		return $list;
	}

	private function mySQLDumpTableStructure($table)
	{
		$data = '';
		$schema = Db::getInstance()->executeS('SHOW CREATE TABLE `'.$table.'`');

		$data .= 'DROP TABLE IF EXISTS `'.$schema[0]['Table'].'`;'."\n";
		$data .= $schema[0]['Create Table'].";\n\n";

		return $data;
	}

	private function mySQLDumpTableData($table)
	{
		$schema = Db::getInstance()->executeS('SHOW CREATE TABLE `'.$table.'`');
		$data = '';

		$query = Db::getInstance()->query('SELECT * FROM `'.$schema[0]['Table'].'`', false);
		$sizeof = DB::getInstance()->NumRows();
		$lines = explode("\n", $schema[0]['Create Table']);

		if ($query && $sizeof > 0)
		{
			// Export the table data
			$data .= '/* Scheme for table '.$schema[0]['Table']." */\n";

			$data .= 'INSERT INTO `'.$schema[0]['Table']."` VALUES\n";
			$i = 1;
			while ($row = DB::getInstance()->nextRow($query))
			{
				$s = '(';

				foreach ($row as $field => $value)
				{
					$tmp = "'".pSQL($value, true)."',";
					if ($tmp != "'',")
						$s .= $tmp;
					else
					{
						foreach ($lines as $line)
							if (strpos($line, '`'.$field.'`') !== false)
							{
								if (preg_match('/(.*NOT NULL.*)/Ui', $line))
									$s .= "'',";
								else
									$s .= 'NULL,';
								break;
							}
					}
				}
				$data .= rtrim($s, ',');

				if ($i % 200 == 0 && $i < $sizeof)
					$data .= ");\nINSERT INTO `".$schema[0]['Table']."` VALUES\n";
				elseif ($i < $sizeof)
					$data .= "),\n";
				else
					$data .= ");\n";

				++$i;
			}
		}

		return $data;
	}

	protected function generateParametersFile()
	{
		$delimiter = ';';
		$titles = array();
		$new_path = new Sampledatainstall();
		$path = $new_path->sendPath().'output/';
		$file_list = array();

		if ($dh = opendir($path))
		{
			while (($file = readdir($dh)) !== false)
			{
				if ($file != '.' && $file != '..')
					$file_list[] = $file;
			}
			closedir($dh);
		}
		$file_list[] = 'settings.vsc';

		$f = fopen($path.'settings.vsc', 'w');

		$titles = array('Database version', 'Prestashop Version', 'Files list');

		fputcsv($f, $titles, $delimiter, '"');

		$lines = array(Configuration::get('PS_VERSION_DB'), _PS_VERSION_, implode(',', $file_list));

		fputcsv($f, $lines, $delimiter, '"');

		fclose($f);
	}

	protected function getAdditionalImages()
	{
		// copy logo + favicon + stores icon
		$main_images = array(Configuration::get('PS_LOGO'), Configuration::get('PS_FAVICON'), Configuration::get('PS_STORES_ICON'));
		foreach ($main_images as $main_image)
		{
			if (file_exists(_PS_CORE_IMG_DIR_.$main_image))
				$this->copyConverFileName(_PS_CORE_IMG_DIR_.$main_image);
		}
		// copy themeconfigurator images
		if ((int)Validate::isLoadedObject(Module::getInstanceByName('themeconfigurator')))
		{
			$sql = 'SELECT `image`
					FROM '._DB_PREFIX_.'themeconfigurator
					WHERE `id_shop` = '.$this->context->shop->id;
			if ($result = Db::getInstance()->executeS($sql))
				foreach ($result as $res)
				{
					if ($res['image'] && file_exists(_PS_MODULE_DIR_.'themeconfigurator/img/'.$res['image']))
						$this->copyConverFileName(_PS_MODULE_DIR_.'themeconfigurator/img/'.$res['image'], true);
				}
		}
		// copy cms images
		$images = array();
		$cms_images_path = _PS_CORE_IMG_DIR_.'cms/';
		$images_jpg = Tools::scandir($cms_images_path, 'jpg');
		$images_gif = Tools::scandir($cms_images_path, 'gif');
		$images_png = Tools::scandir($cms_images_path, 'png');
		$images_jpeg = Tools::scandir($cms_images_path, 'jpeg');
		$images = array_merge($images_jpg, $images_gif, $images_png, $images_jpeg);
		if ($images && count($images))
			foreach ($images as $image)
				$this->copyConverFileName($cms_images_path.$image);
	}

	protected function copyConverFileName($file, $is_module = false, $is_download = false)
	{
		$devider = $is_module ? 'modules/' : 'img/';
		if ($is_download)
			$devider = 'download/';

		$path = new Sampledatainstall();
		$get_file_name = explode('/', $file);
		$file_name = $get_file_name[count($get_file_name) - 1];

		$file_path_name = str_replace('/', '#', rtrim(str_replace($file_name, '', strstr($file, $devider)), '/'));

		$file_type = explode('.', $file_name);
		$name_f = $file_type[0];
		$file_type = strrev($file_type[count($file_type) - 1]);

		if ($is_download)
			copy($file, $path->sendPath().'output/'.$file_path_name.'@'.$name_f);
		else
			copy($file, $path->sendPath().'output/'.$file_path_name.'@'.$name_f.'.'.$file_type);
	}

	protected function clearOutputDirectory()
	{
		$path = new Sampledatainstall();
		$files = glob($path->sendPath().'output/{,.}*', GLOB_BRACE);
		foreach ($files as $file)
		{
			if (is_file($file))
				unlink($file);
		}
	}

	protected function archiveData()
	{
		$p = new Sampledatainstall();
		$path = $p->sendPath().'output/';
		$file_name = 'sample_data.zip';
		$files = array();
		if ($dh = opendir($path))
		{
			while (($file = readdir($dh)) !== false)
			{
				if ($file != '.' && $file != '..')
					$files[] = $file;
			}
			closedir($dh);
		}

		$zip = new ZipArchive();
		if ($zip->open($path.$file_name, ZipArchive::OVERWRITE | ZipArchive::CREATE) !== true)
			$this->displayError($this->l('cannot open '.$file_name.'\n'));

		foreach ($files as $file)
			$zip->addFile($path.$file, ltrim($file, '/'));

		if ($zip->close())
			foreach ($files as $file)
				unlink($path.$file);

		$this->zipSave($path, $file_name);
	}

	protected function zipSave($path, $file_name)
	{
		$file = $path.$file_name;

		session_write_close();

		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: public');
		header('Content-Description: File Transfer');
		header('Content-type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$file_name.'');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.@filesize($file));

		$this->readfileChunked($file) || header('Location: '.$path);
		@unlink($file);
		exit();
	}

	protected function readfileChunked($file, $retbytes = true)
	{
		$chunksize = 1024 * 1024;
		$buffer    = '';
		$cnt       = 0;
		$handle    = @fopen($file, 'r');

		if ($size = @filesize($file))
			header('Content-Length: '.$size);

		if (false === $handle)
			return false;

		while (!@feof($handle))
		{
			$buffer = @fread($handle, $chunksize);
			echo $buffer;
			ob_flush();
			flush();
			if ($retbytes)
				$cnt += Tools::strlen($buffer);
		}

		$status = @fclose($handle);

		if ($retbytes && $status)
			return $cnt;

		return $status;
	}
	
	protected function checkFrendlyUrl($refresh = false)
	{		
		if ($refresh)
			Configuration::updateValue('PS_REWRITING_SETTINGS', $this->frendly_url);
		else
		{
			$this->frendly_url = Configuration::get('PS_REWRITING_SETTINGS');
			Configuration::updateValue('PS_REWRITING_SETTINGS', false);
		}
	}
}