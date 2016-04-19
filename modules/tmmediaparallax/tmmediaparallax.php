<?php 

if (!defined('_PS_VERSION_'))
	exit;

class TmMediaParallax extends Module{

	public function __construct(){
		$this->name = 'tmmediaparallax';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'TemplateMonster (Alexey Svistunov)';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_); 
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Media parallax module');
		$this->description = $this->l('Module adds media parallax to the selected block.');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');		
	}

	public function install(){

		if (Shop::isFeatureActive())
    		Shop::setContext(Shop::CONTEXT_ALL);

		if(!parent::install() ||
			!$this->installDB() ||
			!$this->registerHook('displayHeader') ||
			!$this->registerHook('displayFooter') ||
			!Configuration::updateValue('smooth_scroll_on', 1) ||
			!Configuration::updateValue('smooth_scroll_time', '330') ||
			!Configuration::updateValue('smooth_scroll_distance', '100')
			)
			return false;		
		return true;
	}

	private function installDB()	{
		return (
			Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'tmmediaparallax`') &&
			Db::getInstance()->Execute('
			CREATE TABLE `'._DB_PREFIX_.'tmmediaparallax` (
					`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					`selector` VARCHAR(64),
					`filename` VARCHAR(64),
					`width` int(10),
					`height` int(10),
					`type` VARCHAR(32),					
					PRIMARY KEY (`id`)
			) ENGINE = '._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;')
		);

	}
	public function uninstall(){
		if (!Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'tmmediaparallax`') || !parent::uninstall())
			return false;
		return true;
	}

	public function getContent(){
		$output = null;

		if (Tools::isSubmit('submit'.$this->name)) {
			$tmmp_smooth_scroll 		= strval(Tools::getValue('smooth_scroll_on'));
			$smooth_scroll_time 		= strval(Tools::getValue('smooth_scroll_time'));
			$smooth_scroll_distance 	= strval(Tools::getValue('smooth_scroll_distance'));

		if (empty($smooth_scroll_time) || 
			empty($smooth_scroll_distance)
			){
				$output .= $this->displayError($this->l('Invalid Configuration values'));
			} else {
				Configuration::updateValue('smooth_scroll_on', $tmmp_smooth_scroll);
				Configuration::updateValue('smooth_scroll_time', $smooth_scroll_time);
				Configuration::updateValue('smooth_scroll_distance', $smooth_scroll_distance);
            	$output .= $this->displayConfirmation($this->l('Settings updated'));
			}
		}	

		$this->context->smarty->assign('formAction', 'index.php?tab=AdminModules&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&tab_module=front_office_features&module_name='.$this->name.'');

		if (Tools::isSubmit('newItem')){
			$output .= $this->addItem();
		} elseif (Tools::isSubmit('updateItem')){
			$this->updateItem();
			$output .= $this->displayConfirmation($this->l('Item updated.'));
		} elseif (Tools::isSubmit('removeItem')){
			$this->removeItem();
			$output .= $this->displayConfirmation($this->l('Item removed.'));
		}

		$output .= $this->displayForm();
		$this->getItems();
		$output .= $this->displayNewContainerForm();

		return $output;
	}

	public function addItem(){
		$media_data = $this->getMediaData();

		$selector_match = 0;
		$items = $this->getItems();
		foreach ($items as $item) {
			if ($item['selector'] == $selector) {
				$selector_match++;
			}
		}

		if ($selector_match > 0) {
			$message = $this->displayError($this->l('Selector already exists. You can\'t assign multiple parallax effects to a single block.'));
		} else {
			if (!Db::getInstance()->Execute('
				INSERT INTO `'._DB_PREFIX_.'tmmediaparallax` ( 
						`selector`, `filename`, `width`, `height`, `type`
				) VALUES ( 
						\''.pSQL($media_data['selector']).'\',
						\''.pSQL($media_data['filename']).'\',
						\''.pSQL($media_data['width']).'\',
						\''.pSQL($media_data['height']).'\',
						\''.pSQL($media_data['type']).'\'
						)
				')
			);
			$message = $this->displayConfirmation($this->l('Item added.'));
		}	
		return $message;	
	}

	public function updateItem(){

		$media_data = $this->getMediaData();

		if (!Db::getInstance()->Execute('
			UPDATE `'._DB_PREFIX_.'tmmediaparallax` SET 
					`selector` = \''.$media_data['selector'].'\',
					`filename` = \''.$media_data['filename'].'\',
					`width` = \''.$media_data['width'].'\',
					`height` = \''.$media_data['height'].'\',
					`type` = \''.$media_data['type'].'\'				
			WHERE id = '.(int)Tools::getValue('item_id')
		));
	}

	public function removeItem(){
		$item_id = (int)Tools::getValue('item_id');

		Db::getInstance()->delete(_DB_PREFIX_.'tmmediaparallax', 'id = '.(int)$item_id);
	}

	public function getItem($id)
	{
		$item = Db::getInstance()->ExecuteS('
			SELECT * FROM `'._DB_PREFIX_.'tmmediaparallax`
			WHERE id =' . $id);
		return $item;
	}

	public function getItems(){
		$items = Db::getInstance()->ExecuteS('
			SELECT * FROM `'._DB_PREFIX_.'tmmediaparallax` 			
			ORDER BY id ASC'
		);

		$this->context->smarty->assign('parallaxitems', $items);

		return $items;
	}

	public function displayForm(){
		// Get default language
    	$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

	    $fields_form[0]['form'] = array(
    		'legend' 	=> array(
    			'title' 	=> $this->l('Settings'),
    		),
    		'input' 	=> array(
    			array(
					'type' => 'checkbox',
					'name' => 'smooth_scroll',
					'values' => array(
						'query' => array(
							array(
								'id' => 'on',
								'name' => $this->l('Enable smooth scroll for Google Chrome browser'),
								'val' => '1'
							),
						),
						'id' => 'id',
						'name' => 'name'
					)
				),	
    			array(
	    			'type' 		=> 'text',
	    			'label' 	=> $this->l('Smooth scroll time'),
	    			'name' 		=> 'smooth_scroll_time',
	    			'size' 		=> 20,
	    			'required' 	=> false,
	    			'desc'		=> $this->l('Set time for smooth scroll in milliseconds'),
	    		),
    			array(
	    			'type' 		=> 'text',
	    			'label' 	=> $this->l('Smooth scroll distance'),
	    			'name' 		=> 'smooth_scroll_distance',
	    			'size' 		=> 20,
	    			'required' 	=> false,
	    			'desc'		=> $this->l('Set distance for smooth scroll'),
	    		),
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'button'
			)
		);

    	$helper = new HelperForm();

    	$helper->module = $this;
    	$helper->name_controller = $this->name;
	    $helper->token = Tools::getAdminTokenLite('AdminModules');
	    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

	    // Language
	    $helper->default_form_language = $default_lang;
	    $helper->allow_employee_form_lang = $default_lang;

	    // Title and toolbar
	    $helper->title 				= $this->displayName;
	    $helper->show_toolbar 		= true;        // false -> remove toolbar
	    $helper->toolbar_scroll 	= true;      // yes - > Toolbar is always visible on the top of the screen.
	    $helper->submit_action 		= 'submit'.$this->name;
	    $helper->toolbar_btn 		= array(
	        'save' =>
	        array(
	            'desc' => $this->l('Save'),
	            'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
	            '&token='.Tools::getAdminTokenLite('AdminModules'),
	        ),
	        'back' => array(
	            'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
	            'desc' => $this->l('Back to list')
	        )
	    );

	    // Load current value
    	$helper->fields_value['smooth_scroll_on'] 			= Configuration::get('smooth_scroll_on');
    	$helper->fields_value['smooth_scroll_time'] 		= Configuration::get('smooth_scroll_time');
    	$helper->fields_value['smooth_scroll_distance'] 	= Configuration::get('smooth_scroll_distance');

    	return $helper->generateForm($fields_form);
	}

	public function displayNewContainerForm(){
		return $this->display(__FILE__, 'views/templates/admin/tmmediaparallax.tpl');
	}

	public function getMediaData(){

		$media_data = array();

		//get item form data
		$media_data['selector']		= Tools::getValue('item_selector');
		$media_data['type']			= Tools::getValue('item_type');
		$media_data['filename']		= null;
		$media_data['width'] 		= null;
		$media_data['height'] 		= null;

		if (Tools::getValue('item_id')) {
			$items_array = $this->getItem(Tools::getValue('item_id'));
			$current_item = $items_array[0];	

			$media_data['width'] = $current_item['width'];
			$media_data['height'] = $current_item['height'];
			$media_data['filename'] = $current_item['filename'];
		}

		if ($this->uploadMedia()) {
			$filenames = $this->uploadMedia();
			$media_name = $this->getUploadedFilename($filenames);
			$media_data['filename'] = $media_name;

			if (Tools::getValue('item_type') == 'image') {	
				//get image parallax dimentions		
				$image_data = getimagesize(_PS_MODULE_DIR_ . 'tmmediaparallax/media/' . $filenames[0]);
				$media_data['width'] = $image_data[0];
				$media_data['height'] = $image_data[1];

				//set image media filename
				$media_data['filename'] = $filenames[0];
			}
		}		
			
		return $media_data;
	}

	public function uploadMedia()
	{
		$uploaddir = _PS_MODULE_DIR_ . 'tmmediaparallax/media/';
		$filenames = array();

		//check iа any files uploaded
		if (strlen($_FILES['item_filename']['name'][0]) > 0) {
			foreach ($_FILES['item_filename']['error'] as $key => $error) {
				if ($error == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES['item_filename']['tmp_name'][$key];
					$name = $_FILES["item_filename"]["name"][$key];
					$filenames[] = $name;
					move_uploaded_file($tmp_name, "$uploaddir/$name");
				}
			}
			return $filenames;
		}
		return false;	
	}

	public function getUploadedFilename($filenames)
	{	
		if (isset($filenames)) {
			$name = explode('.',$filenames[0]);
			return $name[0];
		}
		return false;
	}

	public function hookDisplayHeader($params){
		$this->context->controller->addCSS($this->_path.'css/tm-media-parallax-styles.css');
		$this->context->controller->addJS($this->_path.'js/tm-media-parallax.js');
		$this->context->controller->addJS($this->_path.'js/device.min.js');

		$this->getItems();

		$this->context->smarty->assign('base_path', __PS_BASE_URI__);
		$this->context->smarty->assign('media_path', 'modules/tmmediaparallax/media/');
		$this->context->smarty->assign(
			array(
				'smooth_scroll_on' 			=> Configuration::get('smooth_scroll_on'),
				'smooth_scroll_time' 		=> Configuration::get('smooth_scroll_time'),
				'smooth_scroll_distance' 	=> Configuration::get('smooth_scroll_distance'),
			)
		);

		return $this->display(__FILE__, 'tmmediaparallax.tpl');
	}

}