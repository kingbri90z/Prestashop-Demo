<?php
/**
 * 2014 LivePerson Inc.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to support@liveperson.com so we can send you a copy immediately.
 *
 * @author    LivePerson www.liveperson.com
 * @copyright 2014 LivePerson Inc.
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of LivePerson
 */

if (!defined('_PS_VERSION_'))
exit;

class LivePerson extends Module
{
	public function __construct()
	{
		$this->name = 'liveperson';
		$this->tab = 'advertising_marketing';
		$this->version = '1.0.1';
		$this->author = 'LivePerson Inc.';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->bootstrap = true;
		$this->module_key = '2e8f61f64d4b129066239d4f2a349e60';

		parent::__construct();

		$this->displayName = $this->l('LivePerson - LiveEngage');
		$this->description = $this->l('LivePerson delivers an easy-to-use application for live digital engagement.  This includes chat, targeted offers and messaging. This type of personalized engagement helps drive increased conversions, decrease cart abandonment, and increase customer satisfaction.');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall LivePerson from your store?');

		if (!Configuration::get('LP_SITEID'))
		$this->warning = $this->l('No name provided');
	}

	public function install()
	{
		if (!parent::install() ||
		!$this->registerHook('footer') ||
		!Configuration::updateValue('LP_SITEID', '0'))
		return false;

	return true;
	}

	public function uninstall()
	{
		if (!parent::uninstall() ||
		!Configuration::deleteByName('LP_SITEID'))
		return false;

	return true;
	}

	public function getContent()
	{
		$output = null;

		if (Tools::isSubmit('submit'.$this->name))
		{

			$lp_site_id = Tools::getValue('LP_SITEID');

			if (!$lp_site_id
			|| empty($lp_site_id)
			|| !Validate::isGenericName($lp_site_id))
			$output .= $this->displayError($this->l('You have entered an invalid LivePerson ID.'));

			else
			{
				Configuration::updateValue('LP_SITEID', $lp_site_id);
				$output .= $this->displayConfirmation($this->l('You have successfully connected your LivePerson account!  We deployed the LiveEngage tag to your store.'));
			}
		}
		$lp_site_id = Configuration::get('LP_SITEID');
		if($lp_site_id == "0")
		{
			$lp_site_id = "";
		}

		$link = $this->context->link->getAdminLink('AdminModules');
		$link = $link . "&configure=liveperson";

		$this->context->smarty->assign(
			array(
				'lp_site_id' => $lp_site_id,
				'link' => $link
			)
		);
		return $output.$this->display(__FILE__, 'views/templates/admin/configure.tpl');
	}

	public function displayForm()
	{
		$fields_form = array();

		// Get default language
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

		// Init Fields form array
		$fields_form[0]['form'] = array(
		'legend' => array(
		'title' => $this->l('Step 3: Connect Your LivePerson Account'),
		),
		'input' => array(
		array(
		'type' => 'text',
		'label' => $this->l('LiveEngage Account Number'),
		'name' => 'LP_SITEID',
		'size' => 20,
		'required' => true
		)
		),
		'submit' => array(
		'title' => $this->l('Connect'),
		'class' => 'button'
		)
		);

		$helper = new HelperForm();

		// Module, token and currentIndex
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

		// Language
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;

		// Title and toolbar
		$helper->title = $this->displayName;
		$helper->show_toolbar = false;        // false -> remove toolbar
		$helper->toolbar_scroll = false;      // yes - > Toolbar is always visible on the top of the screen.
		$helper->submit_action = 'submit'.$this->name;
		// Load current value
		$helper->fields_value['LP_SITEID'] = Configuration::get('LP_SITEID');

		return $helper->generateForm($fields_form);
	}

	public function hookDisplayFooter($params)
	{
		$lp_site_id = Configuration::get('LP_SITEID');

		return "<!-- BEGIN LivePerson Monitor. --><script type='text/javascript'>window.lpTag=window.lpTag||{};if(typeof window.lpTag._tagCount==='undefined'){window.lpTag={site:'".$lp_site_id . "'||'',section:lpTag.section||'',autoStart:lpTag.autoStart===false?false:true,ovr:lpTag.ovr||{},_v:'1.5.1',_tagCount:1,protocol:location.protocol,events:{bind:function(app,ev,fn){lpTag.defer(function(){lpTag.events.bind(app,ev,fn);},0);},trigger:function(app,ev,json){lpTag.defer(function(){lpTag.events.trigger(app,ev,json);},1);}},defer:function(fn,fnType){if(fnType==0){this._defB=this._defB||[];this._defB.push(fn);}else if(fnType==1){this._defT=this._defT||[];this._defT.push(fn);}else{this._defL=this._defL||[];this._defL.push(fn);}},load:function(src,chr,id){var t=this;setTimeout(function(){t._load(src,chr,id);},0);},_load:function(src,chr,id){var url=src;if(!src){url=this.protocol+'//'+((this.ovr&&this.ovr.domain)?this.ovr.domain:'lptag.liveperson.net')+'/tag/tag.js?site='+this.site;}var s=document.createElement('script');s.setAttribute('charset',chr?chr:'UTF-8');if(id){s.setAttribute('id',id);}s.setAttribute('src',url);document.getElementsByTagName('head').item(0).appendChild(s);},init:function(){this._timing=this._timing||{};this._timing.start=(new Date()).getTime();var that=this;if(window.attachEvent){window.attachEvent('onload',function(){that._domReady('domReady');});}else{window.addEventListener('DOMContentLoaded',function(){that._domReady('contReady');},false);window.addEventListener('load',function(){that._domReady('domReady');},false);}if(typeof(window._lptStop)=='undefined'){this.load();}},start:function(){this.autoStart=true;},_domReady:function(n){if(!this.isDom){this.isDom=true;this.events.trigger('LPT','DOM_READY',{t:n});}this._timing[n]=(new Date()).getTime();},vars:lpTag.vars||[],dbs:lpTag.dbs||[],ctn:lpTag.ctn||[],sdes:lpTag.sdes||[],ev:lpTag.ev||[]};lpTag.init();}else{window.lpTag._tagCount+=1;}</script><!-- END LivePerson Monitor. -->";
	}

}
