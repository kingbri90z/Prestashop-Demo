{*
 * 2007-2014 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 *         DISCLAIMER   *
 * ***************************************
 * Do not edit or add to this file if you wish to upgrade Prestashop to newer
 * versions in the future.
 * ****************************************************
 *
 * @category	Belvg
 * @package	Belvg_Twocheckout
 * @author    Alexander Simonchik <support@belvg.com>
 * @copyright Copyright (c) 2010 - 2014 BelVG LLC. (http://www.belvg.com)
 * @license   http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
*}
<div id="container" class="brinkscheckout ps16">
	<div id="brinkscheckout_header">
		<div class="logo"><img src="{$twocheckout_img_url|escape:false}img/brinkscheckoutlogo.png"/></div>
			<div class="rightext">
				{l s='Brink\'s Checkout: Start Selling Now with Safe, Fast and Easy online payments.' mod='brinkscheckout'}
				<br>
				<div id="button"><a href="http://www.brinkscheckout.com/landing/prestashop?utm_source=PrestaShop&utm_medium=Partnership&utm_campaign=PrestaShop%20Configuration%20Page" target="_blank">{l s='Start Selling Now' mod='brinkscheckout'}</a></div>
			</div>
	</div>
	<div class="clear"></div>
	<div class="wrapper">
		<div id="content"> 
			<div class="column1">
				<h1>{l s='The Brink\'s Benefits' mod='brinkscheckout'}</h1>
				<ul>
					<li>
						<span>{l s='Maximize Conversion' mod='brinkscheckout'}</span><br>
						{l s='The transparent checkout, payment options, currencies and 
						langauges give shoppers what they need to want to click "pay".' mod='brinkscheckout'}</li>
					<li>
						<span>{l s='Maximize Sales' mod='brinkscheckout'}</span><br>
						{l s='Reach customers in 196 countries in 26 currencies and 15 languages 
						with the payment methods they want.' mod='brinkscheckout'}</li>
					<li>
						<span>{l s='Minimize Fraud' mod='brinkscheckout'}</span><br>
						{l s='The only platform with 15 years with international selling experience, 
						300 variables and patented technology. Our specialists personally 
						review all red-flagged transactions to maximize sales.' mod='brinkscheckout'}
					</li>
					<li>
						<span>{l s='The All-in-One of Payments' mod='brinkscheckout'}</span><br>
                        {l s='Get all you need to start accepting payments now: payment gateway 
                        and processor, merchant account and fraud prevention.' mod='brinkscheckout'} 
					</li>
				</ul>
			</div>
			<div class="column2">
				<h1>{l s='Simple, Affordable Pricing' mod='brinkscheckout'}</h1>
				<ul>
					<li>{l s='No monthly fee' mod='brinkscheckout'}</li>
					<li>{l s='No setup fee' mod='brinkscheckout'}</li>
					<li>{l s='No minimum fee' mod='brinkscheckout'}</li>
					<li>{l s='No hidden fees' mod='brinkscheckout'}</li>
					<li>{l s='Same rate for all cards' mod='brinkscheckout'}</li>
                    <li>
						<span>{l s='All included:' mod='brinkscheckout'}</span>
					</li>
					<ul>
						<li>{l s='Payment gateway and processing' mod='brinkscheckout'}</li>
						<li>{l s='Merchant account' mod='brinkscheckout'}</li>
						<li>{l s='Fraud prevention' mod='brinkscheckout'}</li>
						<li>{l s='PCI compliance' mod='brinkscheckout'}</li>
					</ul>
				</ul>
				<p>{l s='For pricing details, click' mod='brinkscheckout'} <a href="http://www.brinkscheckout.com/landing/prestashop?utm_source=PrestaShop&utm_medium=Partnership&utm_campaign=PrestaShop%20Configuration%20Page" target="_blank">{l s='here' mod='brinkscheckout'}</a>.</p>
				<h1>{l s='The Brink\'s Advantage' mod='brinkscheckout'}</h1>
				<p>{l s='Our brand next to the pay button because when people see our brand they think security, safety and peace-of-mind.' mod='brinkscheckout'}</p>
			</div>
		</div>
		<div class="clear"></div>
	   <div id="mainbottom">
			<div class="title">{l s='Accept payments in 196 countries including the US and the European countries' mod='brinkscheckout'}</div> 
			<img src="{$twocheckout_img_url|escape:false}img/payment_methods.png"/>
			
			<div class="formcontainer">
				<div class="form">
					<h2>{l s='Want To Start Selling Right Now?' mod='brinkscheckout'}</h2>
					<form action="http://www.brinkscheckout.com/prestashop/" accept-charset="utf-8" method="get">
						<div class="form-group">
							<input type="text" name="fullname" id="fullname" placeholder="{l s='Name(required)' mod='brinkscheckout'}" value="">
						</div>
						<div class="form-group">
							<input type="text" name="email" id="email" placeholder="{l s='Email(required)' mod='brinkscheckout'}" value="">
						</div>
						<div class="form-group">
							<input type="text" name="phone_number" id="phone_number" placeholder="{l s='Phone Number(required)' mod='brinkscheckout'}" value="">
						</div>
						<div class="form-group">
							<input type="text" name="website_url" id="website_url" placeholder="{l s='Website(required)' mod='brinkscheckout'}" value="">
						</div>
						<input type="hidden" name="campaign" id="campaign" value="{l s='Prestashop Module Configuration Page' mod='brinkscheckout'}">
						<input type="hidden" name="active" id="active" value="1">
						<p class="submitbtn"><input class="button" type="submit" name="" id="button" value="{l s='Start Now!' mod='brinkscheckout'}"></p>
					</form>
				</div>
            </div>
			
			<h5>{l s='For more information' mod='brinkscheckout'}</h5>
			<p class="mainbottomtext">{l s='Visit our' mod='brinkscheckout'} <a href="http://www.brinkscheckout.com/landing/prestashop?utm_source=PrestaShop&utm_medium=Partnership&utm_campaign=PrestaShop%20Configuration%20Page" target="_blank">{l s='website' mod='brinkscheckout'}</a> {l s='or call us at +1-804-289-9579' mod='brinkscheckout'}</p>
		</div>
	</div>  <!--End wrapper-->
	<div class="sticker">
		<img src="{$twocheckout_img_url}img/info.png"/>{l s='To start accepting payments, you will need to provide the information below. To get them, you need to sign up first:' mod='brinkscheckout'}
		<div id="button">
			<a href="http://www.brinkscheckout.com/landing/prestashop?utm_source=PrestaShop&utm_medium=Partnership&utm_campaign=PrestaShop%20Configuration%20Page" target="_blank">{l s='Sign Up' mod='brinkscheckout'}</a>
		</div>
	</div>
</div>
