<?php

$this->product_fields = array(
	'id'                        => array('label' => 'Product ID'),
	'active'                    => array('label' => 'Active (0/1)'),
	'name'                      => array('label' => 'Name'),
	'categories'                => array('label' => 'Categories (x,y,z...)'),
	'price_tex'                 => array('label' => 'Price tax excluded'),
	'price_tin'                 => array('label' => 'Price tax included'),
	'id_tax_rules_group'        => array('label' => 'Tax rules ID'),
	'wholesale_price'           => array('label' => 'Wholesale price'),
	'on_sale'                   => array('label' => 'On sale (0/1)'),
	'reduction_price'           => array('label' => 'Discount amount'),
	'reduction_percent'         => array('label' => 'Discount percent'),
	'reduction_from'            => array('label' => 'Discount from (yyyy-mm-dd)'),
	'reduction_to'              => array('label' => 'Discount to (yyyy-mm-dd)'),
	'reference'                 => array('label' => 'Reference #'),
	'supplier_reference'        => array('label' => 'Supplier reference #'),
	'id_supplier'	            => array('label' => 'Supplier ID'),
	'id_manufacturer'        	=> array('label' => 'Manufacturer ID'),
	'ean13'                     => array('label' => 'EAN13'),
	'upc'                       => array('label' => 'UPC'),
	'ecotax'                    => array('label' => 'Ecotax'),
	'width'                     => array('label' => 'Width'),
	'height'                    => array('label' => 'Height'),
	'depth'                     => array('label' => 'Depth'),
	'weight'                    => array('label' => 'Weight'),
	'quantity'                  => array('label' => 'Quantity'),
	'minimal_quantity'          => array('label' => 'Minimal quantity'),
	'visibility'                => array('label' => 'Visibility'),
	'additional_shipping_cost'  => array('label' => 'Additional shipping cost'),
	'unity'                     => array('label' => 'Unit for the unit price'),
	'unit_price'                => array('label' => 'Unit price'),
	'description_short'         => array('label' => 'Short description'),
	'description'               => array('label' => 'Description'),
	'tags'                      => array('label' => 'Tags (x,y,z...)'),
	'meta_title'                => array('label' => 'Meta title'),
	'meta_keywords'             => array('label' => 'Meta keywords'),
	'meta_description'          => array('label' => 'Meta description'),
	'link_rewrite'              => array('label' => 'URL rewritten'),
	'available_now'             => array('label' => 'Text when in stock'),
	'available_later'           => array('label' => 'Text when backorder allowed'),
	'available_for_order'       => array('label' => 'Available for order (0 = No, 1 = Yes)'),
	'available_date'            => array('label' => 'Product available date'),
	'date_add'                  => array('label' => 'Product creation date'),
	'show_price'                => array('label' => 'Show price (0 = No, 1 = Yes)'),
	'image'                     => array('label' => 'Image URLs (x,y,z...)'),
	'delete_existing_images'    => array(
		'label' => 'Delete existing images (0 = No, 1 = Yes)'
	),
	'features'                  => array('label' => 'Feature (Name:Value:Position:Customized)'),
	'online_only'               => array('label' => 'Available online only (0 = No, 1 = Yes)'),
	'condition'                 => array('label' => 'Condition'),
	'customizable'              => array('label' => 'Customizable (0 = No, 1 = Yes)'),
	'uploadable_files'          => array('label' => 'Uploadable files (0 = No, 1 = Yes)'),
	'text_fields'               => array('label' => 'Text fields (0 = No, 1 = Yes)'),
	'out_of_stock'              => array('label' => 'Action when out of stock'),
	'shop'                      => array(
		'label' => 'ID / Name of shop',
		'help'  => 'Ignore this field if you don\'t use the Multistore tool. If you leave this field empty, the default shop will be used.',
	),
	'advanced_stock_management' => array(
		'label' => 'Advanced Stock Management',
		'help'  => 'Enable Advanced Stock Management on product (0 = No, 1 = Yes).',
	),
	'depends_on_stock'          => array(
		'label' => 'Depends on stock',
		'help'  => '0 = Use quantity set in product, 1 = Use quantity from warehouse.',
	),
	'warehouse'                 => array(
		'label' => 'Warehouse',
		'help'  => 'ID of the warehouse to set as storage.'
	),
	'accessories'				=> array('label' => 'Accessories'),
	'carriers'					=> array('label' => 'Carriers'),
	'customization_fields_ids'	=> array('label' => 'Customization Fields'),
	'attachments'				=> array('label' => 'Attacments Ids'),
	'date_upd'					=> array('label' => 'Date Update'),
	'base_price'				=> array('label' => 'Base price'),
);

$this->product_attribute_fields = array(
	'id'						=> array('label' => 'Attribute ID'),
	'id_product'				=> array('label' => 'Product ID'),
	'reference'					=> array('label' => 'Refference'),
	'supplier_reference'		=> array('label' => 'Supplier Refference'),
	'location'					=> array('label' => 'Location'),
	'ean13'						=> array('label' => 'ean13'),
	'upc'						=> array('label' => 'UPC'),
	'wholesale_price'			=> array('label' => 'Wholesale Price'),
	'price'						=> array('label' => 'Price'),
	'unit_price_impact'			=> array('label' => 'Unit Price Impact'),
	'ecotax'					=> array('label' => 'Ecotax'),
	'minimal_quantity'			=> array('label' => 'Minimal Quantity'),
	'quantity'					=> array('label' => 'Quantity'),
	'weight'					=> array('label' => 'Weight'),
	'default_on'				=> array('label' => 'Default On'),
	'available_date'			=> array('label' => 'Available Date'),
	'values'					=> array('label' => 'Values'),
	'image'						=> array('label' => 'Image'),
);

$this->product_pack_fields		= array(
	'id_product'				=> array('label' => 'Product ID'),
	'id_produc_item'			=> array('label' => 'Item ID'),
	'id_product_attribute_item'	=> array('label' => 'Product Attribute Item'),
	'quantity'					=> array('label' => 'Quantity'),
);

$this->stock_available_fields	= array(
	'id'						=> array('label' => 'ID'),
	'id_product'				=> array('label' => 'Product ID'),
	'id_product_attribute'		=> array('label' => 'Product Attribute ID'),
	'id_shop'					=> array('label' => 'Shop ID'),
	'id_shop_group'				=> array('label' => 'Shop Group ID'),
	'quantity'					=> array('label' => 'Quantity'),
	'depends_on_stock'			=> array('label' => 'Depends On Stock'),
	'out_of_stock'				=> array('label' => 'Out of stock'),
);

$this->image_fields	= array(
	'id_image'					=> array('label' => 'Image ID'),
	'id_product'				=> array('label' => 'Product ID'),
	'position'					=> array('label' => 'Position'),
	'cover'						=> array('label' => 'Cover'),
	'legend'					=> array('label' => 'Legend'),
);

$this->category_fields = array(
	'id'						=> array('label' => 'Category ID'),
	'active'					=> array('label' => 'Active (0/1)'),
	'name'						=> array('label' => 'Name *'),
	'id_parent'					=> array('label' => 'Parent category'),
	'description'				=> array('label' => 'Description'),
	'meta_title'				=> array('label' => 'Meta title'),
	'meta_keywords'				=> array('label' => 'Meta keywords'),
	'meta_description'			=> array('label' => 'Meta description'),
	'link_rewrite'				=> array('label' => 'URL rewritten'),
	'image_url'					=> array('label' => 'Image URL'),
);

$this->manufacturers_fields = array(
	'id'						=> array('label' => 'Manufacturer ID'),
	'active'					=> array('label' => 'Active (0/1)'),
	'name'						=> array('label' => 'Name *'),
	'description'				=> array('label' => 'Description'),
	'short_description'			=> array('label' => 'Short description'),
	'meta_title'				=> array('label' => 'Meta title'),
	'meta_keywords'				=> array('label' => 'Meta keywords'),
	'meta_description'			=> array('label' => 'Meta description'),
	'link_rewrite'				=> array('label' => 'URL rewritten'),
);

$this->suppliers_fields = array(
	'id'						=> array('label' => 'Supplier ID'),
	'active'					=> array('label' => 'Active (0/1)'),
	'name'						=> array('label' => 'Name *'),
	'description'				=> array('label' => 'Description'),
	'meta_title'				=> array('label' => 'Meta title'),
	'meta_keywords'				=> array('label' => 'Meta keywords'),
	'meta_description'			=> array('label' => 'Meta description'),
	'link_rewrite'				=> array('label' => 'URL rewritten'),
);

$this->customers_fields = array(
	'id'						=> array('label' => 'Customer ID'),
	'active'					=> array('label' => 'Active (0/1)'),
	'id_gender'					=> array('label' => 'Titles ID (Mr = 1, Ms = 2, else 0)'),
	'email'						=> array('label' => 'Email *'),
	'passwd'					=> array('label' => 'Password *'),
	'birthday'					=> array('label' => 'Birthday (yyyy-mm-dd)'),
	'lastname'					=> array('label' => 'Last Name *'),
	'firstname'					=> array('label' => 'First Name *'),
	'newsletter'				=> array('label' => 'Newsletter (0/1)'),
	'optin'						=> array('label' => 'Opt-in (0/1)'),
	'id_default_group'			=> array('label' => 'Default group ID'),
);

$this->address_fields = array(
	'id'						=> array('label' => 'Address ID', 'type' => 'int'),
	'active'					=> array('label' => 'Active (0/1)', 'type' => 'int'),
	'alias'						=> array('label' => 'Alias*', 'type' => 'string'),
	'id_customer'				=> array('label' => 'Customer ID', 'type' => 'int'),
	'id_manufacturer'			=> array('label' => 'Manufacturer ID', 'type' => 'int'),
	'id_supplier'				=> array('label' => 'Supplier ID', 'type' => 'int'),
	'id_warehouse'				=> array('label' => 'Warehouse ID', 'type' => 'int'),
	'id_country'				=> array('label' => 'Country ID', 'type' => 'int'),
	'id_state'					=> array('label' => 'State ID', 'type' => 'int'),
	'country'					=> array('label' => 'Country', 'type' => 'string'),
	'company'					=> array('label' => 'Company', 'type' => 'string'),
	'lastname'					=> array('label' => 'Lastname', 'type' => 'string'),
	'firstname'					=> array('label' => 'Firstname', 'type' => 'string'),
	'address1'					=> array('label' => 'Address 1', 'type' => 'string'),
	'address2'					=> array('label' => 'Address 2', 'type' => 'string'),
	'postcode'					=> array('label' => 'Postcode', 'type' => 'string'),
	'city'						=> array('label' => 'City', 'type' => 'string'),
	'other'						=> array('label' => 'Other', 'type' => 'string'),
	'phone'						=> array('label' => 'Phone', 'type' => 'string'),
	'phone_mobile'				=> array('label' => 'Phone_mobile', 'type' => 'string'),
	'vat_number'				=> array('label' => 'Vat_number', 'type' => 'string'),
	'dni'						=> array('label' => 'DNI', 'type' => 'string'),
	'deleted'					=> array('label' => 'Deleted', 'type' => 'int'),
);

$this->alias_fields = array(
	'id'						=> array('label' => 'Alias ID', 'type' => 'int'),
	'alias'						=> array('label' => 'Alias *', 'type' => 'string'),
	'search'					=> array('label' => 'Search *', 'type' => 'string'),
	'active'					=> array('label' => 'Active (0/1)', 'type' => 'int'),
);

$this->cms_category_fields = array(
	'id'						=> array('label' => 'CMS Category ID', 'type' => 'int'),
	'active'					=> array('label' => 'Active (0/1)', 'type' => 'int'),
	'name'						=> array('label' => 'Name *', 'type' => 'string'),
	'position'					=> array('label' => 'Position', 'type' => 'int'),
	'description'				=> array('label' => 'Description', 'type' => 'string'),
	'id_parent'					=> array('label' => 'ID parent', 'type' => 'int'),
	'level_depth'				=> array('label' => 'Level', 'type' => 'int'),
	'meta_keywords'				=> array('label' => 'Meta keywords', 'type' => 'string'),
	'meta_description'			=> array('label' => 'Meta description', 'type' => 'string'),
	'link_rewrite'				=> array('label' => 'URL rewritten', 'type' => 'string'),
);

$this->cms_pages_fields = array(
	'id'						=> array('label' => 'CMS Page ID', 'type' => 'int'),
	'id_cms_category'			=> array('label' => 'CMS Category ID', 'type' => 'int'),
	'position'					=> array('label' => 'Position', 'type' => 'int'),
	'active'					=> array('label' => 'Active (0/1)', 'type' => 'int'),
	'indexation'				=> array('label' => 'Indexation', 'type' => 'int'),
	'meta_title'				=> array('label' => 'Meta tile', 'type' => 'string'),
	'meta_description'			=> array('label' => 'Meta description', 'type' => 'string'),
	'meta_keywords'				=> array('label' => 'Meta keywords', 'type' => 'string'),
	'content'					=> array('label' => 'Content', 'type' => 'string'),
	'link_rewrite'				=> array('label' => 'URL rewritten', 'type' => 'string'),
);

$this->languages_fields = array(
	'id'						=> array('label' => 'Language ID', 'type' => 'int'),
	'name'						=> array('label' => 'Language name', 'type' => 'string'),
	'iso_code'					=> array('label' => 'ISO Code', 'type' => 'string'),
	'language_code'				=> array('label' => 'Language code', 'type' => 'string'),
	'active'					=> array('label' => 'Active (0/1)', 'type' => 'int'),
	'is_rtl'					=> array('label' => 'RTL', 'type' => 'int'),
	'date_format_lite'			=> array('label' => 'Date format(lite)', 'type' => 'string'),
	'date_format_full'			=> array('label' => 'Date format(full)', 'type' => 'string'),
);

$this->currencies_fields = array(
	'id'						=> array('label' => 'Currency ID', 'type' => 'int'),
	'name'						=> array('label' => 'Currency name', 'type' => 'string'),
	'iso_code'					=> array('label' => 'ISO Code', 'type' => 'int'),
	'iso_code_num'				=> array('label' => 'ISO Code Numeric', 'type' => 'int'),
	'sign'						=> array('label' => 'Sign', 'type' => 'string'),
	'blank'						=> array('label' => 'Blank', 'type' => 'int'),
	'conversion_rate'			=> array('label' => 'Conversion Rate', 'type' => 'int'),
	'deleted'					=> array('label' => 'Deleted', 'type' => 'int'),
	'format'					=> array('label' => 'Format', 'type' => 'int'),
	'decimals'					=> array('label' => 'Decimals', 'type' => 'int'),
	'active'					=> array('label' => 'Active (0/1)', 'type' => 'int'),
);

$this->attachments_fields = array(
	'id'						=> array('label' => 'Attachment ID', 'type' => 'int'),
	'file'						=> array('label' => 'File', 'type' => 'string'),
	'mime'						=> array('label' => 'Mime', 'type' => 'string'),
	'file_name'					=> array('label' => 'File Name', 'type' => 'string'),
	'file_size'					=> array('label' => 'File Size', 'type' => 'int'),
	'name'						=> array('label' => 'Name', 'type' => 'string'),
	'description'				=> array('label' => 'Description', 'type' => 'string')
);

$this->carriers_fields = array(
	'id'						=> array('label' => 'Carrier ID', 'type' => 'int'),
	'id_reference'				=> array('label' => 'Reference ID', 'type' => 'int'),
	'id_tax_rules_group'		=> array('label' => 'Tax Rules Group ID', 'type' => 'int'),
	'name'						=> array('label' => 'Name', 'type' => 'string'),
	'active'					=> array('label' => 'Active (0/1)', 'type' => 'int'),
	'is_free'					=> array('label' => 'Is free', 'type' => 'int'),
	'url'						=> array('label' => 'Url', 'type' => 'string'),
	'shipping_handling'			=> array('label' => 'Shipping Handling', 'type' => 'int'),
	'shipping_external'			=> array('label' => 'Shipping External', 'type' => 'int'),
	'range_behavior'			=> array('label' => 'Range Behavior', 'type' => 'int'),
	'shipping_method'			=> array('label' => 'Shipping Method', 'type' => 'int'),
	'max_width'					=> array('label' => 'Max Width', 'type' => 'int'),
	'max_height'				=> array('label' => 'Max Height', 'type' => 'int'),
	'max_depth'					=> array('label' => 'Max Depth', 'type' => 'int'),
	'max_weight'				=> array('label' => 'Max Weight', 'type' => 'int'),
	'grade'						=> array('label' => 'Grade', 'type' => 'int'),
	'external_module_name'		=> array('label' => 'External Module Name', 'type' => 'string'),
	'is_module'					=> array('label' => 'Is Module', 'type' => 'int'),
	'need_range'				=> array('label' => 'Need Range', 'type' => 'int'),
	'position'					=> array('label' => 'Position', 'type' => 'int'),
	'deleted'					=> array('label' => 'Deleted', 'type' => 'int'),
	'delay'						=> array('label' => 'Delay', 'type' => 'string'),
	'carrier_groups'			=> array('label' => 'Carrier Groups', 'type' => 'string'),
	'zones'						=> array('label' => 'Carrier Zones', 'type' => 'string'),
	'range_price'				=> array('label' => 'Range Price', 'type' => 'string'),
	'range_weight'				=> array('label' => 'Range Weight', 'type' => 'string'),
);

$this->cartrules_fields = array(
	'id'						=> array('label' => 'Cart Rule ID', 'type' => 'int'),
	'id_customer'				=> array('label' => 'Customer ID', 'type' => 'int'),
	'date_from'					=> array('label' => 'Date From', 'type' => 'string'),
	'date_to'					=> array('label' => 'Date To', 'type' => 'string'),
	'description'				=> array('label' => 'Description', 'type' => 'string'),
	'quantity'					=> array('label' => 'Quantity', 'type' => 'int'),
	'quantity_per_user'			=> array('label' => 'Quantity Per User', 'type' => 'int'),
	'priority'					=> array('label' => 'Priority', 'type' => 'int'),
	'partial_use'				=> array('label' => 'Partial Use', 'type' => 'int'),
	'code'						=> array('label' => 'Code', 'type' => 'string'),
	'minimum_amount'			=> array('label' => 'Minimum Amount', 'type' => 'int'),
	'minimum_amount_tax'		=> array('label' => 'Minimum Amount Tax', 'type' => 'int'),
	'minimum_amount_currency'	=> array('label' => 'Minimum Amount Currency', 'type' => 'int'),
	'minimum_amount_shipping'	=> array('label' => 'Minimum Amount Shipping', 'type' => 'int'),
	'country_restriction'		=> array('label' => 'Country Restriction', 'type' => 'int'),
	'carrier_restriction'		=> array('label' => 'Carrier Restriction', 'type' => 'string'),
	'group_restriction'			=> array('label' => 'Group Restriction', 'type' => 'int'),
	'cart_rule_restriction'		=> array('label' => 'Cart Rule Restriction', 'type' => 'int'),
	'product_restriction'		=> array('label' => 'Product Restriction', 'type' => 'int'),
	'shop_restriction'			=> array('label' => 'Shop Restriction', 'type' => 'int'),
	'free_shipping'				=> array('label' => 'Free Shipping', 'type' => 'int'),
	'reduction_percent'			=> array('label' => 'Reduction Percent', 'type' => 'int'),
	'reduction_amount'			=> array('label' => 'Reduction Amount', 'type' => 'int'),
	'reduction_tax'				=> array('label' => 'Reduction Tax', 'type' => 'int'),
	'reduction_currency'		=> array('label' => 'Reduction Currency', 'type' => 'int'),
	'reduction_product'			=> array('label' => 'Reduction Product', 'type' => 'int'),
	'gift_product'				=> array('label' => 'Gift Product', 'type' => 'int'),
	'gift_product_attribute'	=> array('label' => 'Gift Product Attribute', 'type' => 'int'),
	'highlight'					=> array('label' => 'Highlight', 'type' => 'int'),
	'active'					=> array('label' => 'Active', 'type' => 'int'),
	'date_add'					=> array('label' => 'Date Add', 'type' => 'string'),
	'date_upd'					=> array('label' => 'Date Upd', 'type' => 'string'),
	'name'						=> array('label' => 'Name', 'type' => 'string'),
);

$this->contacts_fields = array(
	'id'						=> array('label' => 'Contacts ID', 'type' => 'int'),
	'email'						=> array('label' => 'E-mail', 'type' => 'string'),
	'customer_service'			=> array('label' => 'Customer Service', 'type' => 'int'),
	'name'						=> array('label' => 'Name', 'type' => 'string'),
	'description'				=> array('label' => 'Description', 'type' => 'string'),
);

$this->zones_fields = array(
	'id_zone'					=> array('label' => 'State ID', 'type' => 'int'),
	'name'				=> array('label' => 'Country ID', 'type' => 'int'),
	'active'					=> array('label' => 'Active', 'type' => 'int'),
);

$this->countries_fields = array(
	'id_country'				=> array('label' => 'Country ID', 'type' => 'int'),
	'id_zone'					=> array('label' => 'Zone ID', 'type' => 'int'),
	'id_currency'				=> array('label' => 'Currency ID', 'type' => 'int'),
	'call_prefix'				=> array('label' => 'Call Prefix', 'type' => 'int'),
	'iso_code'					=> array('label' => 'ISO Code', 'type' => 'string'),
	'active'					=> array('label' => 'Active', 'type' => 'int'),
	'contains_states'			=> array('label' => 'Contains States', 'type' => 'int'),
	'need_identification_number'=> array('label' => 'Need Identification Number', 'type' => 'int'),
	'need_zip_code'				=> array('label' => 'Need Zip Code', 'type' => 'int'),
	'zip_code_format'			=> array('label' => 'ZIP Code Format', 'type' => 'string'),
	'display_tax_label'			=> array('label' => 'Display Tax Label', 'type' => 'int'),
	'name'						=> array('label' => 'Name', 'type' => 'string'),
	'country'					=> array('label' => 'Country', 'type' => 'string'),
	'zone'						=> array('label' => 'Zone', 'type' => 'string'),
);

$this->states_fields = array(
	'id_state'					=> array('label' => 'State ID', 'type' => 'int'),
	'id_country'				=> array('label' => 'Country ID', 'type' => 'int'),
	'id_zone'					=> array('label' => 'Zone ID', 'type' => 'int'),
	'iso_code'					=> array('label' => 'ISO Code', 'type' => 'string'),
	'name'						=> array('label' => 'Name', 'type' => 'string'),
	'active'					=> array('label' => 'Active', 'type' => 'int'),
);

$this->attributes_fields = array(
	'id'						=> array('label' => 'Atribure ID', 'type' => 'int'),
	'id_attribute_group'		=> array('label' => 'Attribute Group ID', 'type' => 'int'),
	'color'						=> array('label' => 'Color', 'type' => 'string'),
	'position'					=> array('label' => 'Position', 'type' => 'int'),
	'name'						=> array('label' => 'Name', 'type' => 'int'),
);

$this->attribute_groups_fields = array(
	'id_attribute_group'		=> array('label' => 'Atribure Group ID', 'type' => 'int'),
	'is_color_group'			=> array('label' => 'Is Color Group', 'type' => 'int'),
	'group_type'				=> array('label' => 'Group Type', 'type' => 'string'),
	'position'					=> array('label' => 'Position', 'type' => 'int'),
	'name'						=> array('label' => 'Name', 'type' => 'string'),
	'public_name'				=> array('label' => 'Public Name', 'type' => 'string'),
);

$this->combinations_fields = array(
	'id'						=> array('label' => 'Combination ID', 'type' => 'int'),
	'id_product'				=> array('label' => 'Product ID', 'type' => 'int'),
	'location'					=> array('label' => 'Location', 'type' => 'string'),
	'ean13'						=> array('label' => 'ean13', 'type' => 'string'),
	'upc'						=> array('label' => 'Position', 'type' => 'string'),
	'quantity'					=> array('label' => 'Quantity', 'type' => 'int'),
	'reference'					=> array('label' => 'Reference', 'type' => 'string'),
	'supplier_reference'		=> array('label' => 'Supplier Reference', 'type' => 'string'),
	'wholesale_price'			=> array('label' => 'Wholesale price', 'type' => 'int'),
	'price'						=> array('label' => 'Price', 'type' => 'int'),
	'ecotax'					=> array('label' => 'Ecotax', 'type' => 'int'),
	'weight'					=> array('label' => 'Weight', 'type' => 'int'),
	'unit_price_impact'			=> array('label' => 'Unit Price Impact', 'type' => 'int'),
	'minimal_quantity'			=> array('label' => 'Minimal Quantity', 'type' => 'int'),
	'default_on'				=> array('label' => 'Default On', 'type' => 'int'),
	'available_date'			=> array('label' => 'Available Date', 'type' => 'int'),
);

$this->delivery_fields = array(
	'id_delivery'				=> array('label' => 'delivery ID', 'type' => 'int'),
	'id_carrier'				=> array('label' => 'Carrier ID', 'type' => 'int'),
	'id_range_price'			=> array('label' => 'Range Price ID', 'type' => 'int'),
	'id_range_weight'			=> array('label' => 'Range Weight ID', 'type' => 'int'),
	'id_zone'					=> array('label' => 'Zone ID', 'type' => 'int'),
	'price'						=> array('label' => 'Price', 'type' => 'int'),
);

$this->specific_price_fields = array(
	'id'						=> array('label' => 'Specific Price ID', 'type' => 'int'),
	'id_specific_price_rule'	=> array('label' => 'Specific Price Rule ID', 'type' => 'int'),
	'id_cart'					=> array('label' => 'Cart ID', 'type' => 'int'),
	'id_product'				=> array('label' => 'Product ID', 'type' => 'int'),
	'id_shop'					=> array('label' => 'Shop ID', 'type' => 'int'),
	'id_shop_group'				=> array('label' => 'Shop Group ID', 'type' => 'int'),
	'id_currency'				=> array('label' => 'Currency ID', 'type' => 'int'),
	'id_country'				=> array('label' => 'Country ID', 'type' => 'int'),
	'id_group'					=> array('label' => 'Group ID', 'type' => 'int'),
	'id_customer'				=> array('label' => 'Customer ID', 'type' => 'int'),
	'id_product_attribute'		=> array('label' => 'Product Attribute ID', 'type' => 'int'),
	'price'						=> array('label' => 'Price', 'type' => 'int'),
	'from_quantity'				=> array('label' => 'From Quantity', 'type' => 'int'),
	'reduction'					=> array('label' => 'Reduction', 'type' => 'int'),
	'reduction_tax'				=> array('label' => 'Reduction Tax', 'type' => 'int'),
	'reduction_type'			=> array('label' => 'Reduction Type', 'type' => 'int'),
	'from'						=> array('label' => 'From', 'type' => 'int'),
	'to'						=> array('label' => 'To', 'type' => 'int'),
);

$this->specific_price_rule_fields = array(
	'id'						=> array('label' => 'Specific Price Rule ID', 'type' => 'int'),
	'name'						=> array('label' => 'Name', 'type' => 'int'),
	'id_shop'					=> array('label' => 'Shop ID', 'type' => 'int'),
	'id_currency'				=> array('label' => 'Currency ID', 'type' => 'int'),
	'id_country'				=> array('label' => 'Country ID', 'type' => 'int'),
	'id_group'					=> array('label' => 'Group ID', 'type' => 'int'),
	'from_quantity'				=> array('label' => 'From Quantity', 'type' => 'int'),
	'price'						=> array('label' => 'Price', 'type' => 'int'),
	'reduction'					=> array('label' => 'Reduction', 'type' => 'int'),
	'reduction_tax'				=> array('label' => 'Reduction Tax', 'type' => 'int'),
	'reduction_type'			=> array('label' => 'Reduction Type', 'type' => 'int'),
	'from'						=> array('label' => 'From', 'type' => 'int'),
	'to'						=> array('label' => 'To', 'type' => 'int'),
	'conditions'					=> array('label' => 'Conditions', 'type' => 'int'),
);

$this->tax_fields = array(
	'id'						=> array('label' => 'Tax ID', 'type' => 'int'),
	'name'						=> array('label' => 'Name', 'type' => 'string'),
	'rate'						=> array('label' => 'Rate', 'type' => 'int'),
	'active'					=> array('label' => 'Active', 'type' => 'int'),
	'deleted'					=> array('label' => 'Deleted', 'type' => 'int'),
);

$this->tax_rule_fields = array(
	'id'						=> array('label' => 'Tax Rule ID', 'type' => 'int'),
	'id_tax_rules_group'		=> array('label' => 'Tax Rules Group ID', 'type' => 'int'),
	'id_country'				=> array('label' => 'Country ID', 'type' => 'int'),
	'id_state'					=> array('label' => 'State ID', 'type' => 'int'),
	'zipcode_from'				=> array('label' => 'Zipcode From', 'type' => 'string'),
	'zipcode_to'				=> array('label' => 'Zipcode To', 'type' => 'string'),
	'id_tax'					=> array('label' => 'Tax ID', 'type' => 'int'),
	'behavior'					=> array('label' => 'Behavior', 'type' => 'int'),
	'description'				=> array('label' => 'Description', 'type' => 'string'),
);

$this->tax_rule_group_fields = array(
	'id'						=> array('label' => 'Tax Rule Group ID', 'type' => 'int'),
	'name'						=> array('label' => 'Name', 'type' => 'string'),
	'active'					=> array('label' => 'Active', 'type' => 'int'),
	'deleted'					=> array('label' => 'Deleted', 'type' => 'int'),
	'date_add'					=> array('label' => 'Date Add', 'type' => 'string'),
	'date_upd'					=> array('label' => 'Date Upd', 'type' => 'string'),
);

$this->feature_fields = array(
	'id'						=> array('label' => 'Feature ID', 'type' => 'int'),
	'position'					=> array('label' => 'Position', 'type' => 'int'),
	'name'						=> array('label' => 'Name', 'type' => 'string'),
);

$this->feature_value_fields = array(
	'id'						=> array('label' => 'Feature Value ID', 'type' => 'int'),
	'id_feature'				=> array('label' => 'Feature ID', 'type' => 'int'),
	'value'						=> array('label' => 'Value', 'type' => 'string'),
	'custom'					=> array('label' => 'Custom', 'type' => 'int'),
);

$this->home_slide_fields = array(
	'id'						=> array('label' => 'Slide ID', 'type' => 'int'),
	'active'					=> array('label' => 'Active', 'type' => 'int'),
	'position'					=> array('label' => 'Position', 'type' => 'int'),
	'description'				=> array('label' => 'Description', 'type' => 'string'),
	'title'						=> array('label' => 'Title', 'type' => 'string'),
	'legend'					=> array('label' => 'Legend', 'type' => 'string'),
	'url'						=> array('label' => 'Url', 'type' => 'string'),
	'image'						=> array('label' => 'Image', 'type' => 'string'),
);

$this->info_fields = array(
	'id'						=> array('label' => 'Info ID', 'type' => 'int'),
	'text'						=> array('label' => 'Text', 'type' => 'string'),
);

$this->configuration_fields = array(
	'name'						=> array('label' => 'Configuration Name', 'type' => 'string'),
	'value'						=> array('label' => 'Value', 'type' => 'string'),
);