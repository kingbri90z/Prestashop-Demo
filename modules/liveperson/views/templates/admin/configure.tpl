{**
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
 *}


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script type='text/javascript' src='https://connect-community.s3.amazonaws.com/letagv3/js/numeric.js'></script>

<script>

$(document).ready(function(){

$(".id_input").numeric()

})
</script>

</script>

<style type="text/css">
#container *{
padding:0;
margin:0;
font-weight: 400;
/* 300-light 400-normal 600-semibold 700-bold 900-black*/
font-family:'Open Sans', sans-serif;
box-sizing:content-box;
}

#container img{
border:0;
}

#container p{
margin:0;
}

#container{
width:1024px;
position:relative;
margin:auto;
}

#container .middle_section{
clear:left;
float:left;
margin-top:115px;
width:100%;
}

#container .middle_title{
text-align:center;
color:#152128;
font-size:45px;
font-weight:300;
}

#container .middle_subtitle{
font-size:18px;
color:#404040;
text-align:center;
margin-top:15px;
}

#container .middle_boxes{
position:relative;
margin:40px auto auto;
}

#container .box_inner{
float:left;
width:33%;
border-left:1px solid #d9d9d9;
border-right:1px solid #d9d9d9;
padding-top:24px;
padding-bottom:23px;
}

#container .box_image, #container .box_title, #container .box_text{
text-align:center;
margin:auto;
}

#container .box_image{
display:block;
}

#container .box_title{
margin-top:26px;
color:#5ab7dc;
font-size:23px;
width:266px;
}

#container .box_text{
margin-top:12px;
color:#545454;
font-size:18px;
width:266px;
}

#container .bottom_section{
clear:left;
float:left;
margin-top:83px;
padding:69px 0 82px 0;
background:#f7f7f7;
width:100%;
}

#container .bottom_title{
color:#4b4b4b;
font-size:45px;
text-align:center;
}

#container .bottom_subtitle{
margin-top:11px;
color:#404040;
font-size:30px;
text-align:center;
}

#container .bottom_sublink{
color:#59badf;
}

#container .bottom_button{
color:#5ab7dc;
border:3px solid #5ab7dc;
border-radius:5px;
padding:12px 0;
text-align:center;
margin:0px auto auto;
font-size:30px;
text-decoration:none;
display:block;
width:294px;
}

#container .footer{
height:112px;
background:#0a1c24;
float:left;
width:100%;
}

#container .top_section{
clear:left;
float:left;
width:100%;
height:540px;
background:url({$module_dir|escape:'htmlall':'UTF-8'}/img/banner1024.jpg) no-repeat;
}

#container .top_logo{
float:left;
margin-left:70px;
margin-top:45px;
}

#container .top_left{
clear:left;
float:left;
width:365px;
margin-top:109px;
}

#container .top_right{
float:left;
margin-left:50px;
margin-top:40px;
width:466px;
}

#container .top_title{
font-size:45px;
color:#ffffff;
font-weight:300;
}

#container .top_subtitle{
font-size:18px;
color:#ffffff;
margin-top:2px;
}

#container .id_input{
float:left;
margin-top:10px;
font-weight:300;
font-size:20px;
color:#ffffff;
background:none;
border:3px solid #dbe9ef;
border-radius:5px;
padding:12px 5px;
text-align:center;
width:285px;
height:auto;
}

#container .id_input::-webkit-input-placeholder {
   color: #ffffff;
}

#container .id_input:-moz-placeholder { 
   color: #ffffff;  
}

#container .id_input::-moz-placeholder {  
   color: #ffffff;  
}

#container .id_input:-ms-input-placeholder {  
   color: #ffffff;  
}

#container .connect_btn{
float:left;
margin-top:10px;
margin-left:-4px;
background:#ffffff;
border:3px solid #ffffff;
color:#489dc3;
font-size:30px;
border-top-right-radius:5px;
border-bottom-right-radius:5px;
padding:5px 8px;
text-decoration:none;
}

#container .connect_btn.full {
	border-radius:5px;
	margin-top:10px;
}


#container .top_text{
clear:left;
float:left;
margin-left:4px;
margin-top:25px;
color:#ffffff;
font-size:24px;
font-weight:600;
font-style:italic;
}

#container .top_text_link{
margin-left:10px;
color:#ffffff;
font-size:30px;
font-style:normal;
text-decoration:underline;
}

.alert {
  width: 1024px;
  margin: auto;
  margin-bottom: 30px;
  margin-top:40px;
  font-size:16px;
}

.bootstrap .alert:before {
  font-size: 40px !important;
}

</style>

<div id="container" >

<div class="top_section">
	<img class="top_logo" src="{$module_dir|escape:'htmlall':'UTF-8'}/img/logo.png" />
	<div class="top_left">
		<img src="{$module_dir|escape:'htmlall':'UTF-8'}/img/main_img.png" />
	</div>
	<div class="top_right">
		<p class="top_title">Get Started Below</p>
		
		
		
		<form id="configuration_form" style = "margin:30px 15px 15px 0;" class="defaultForm form-horizontal liveperson" action="{$link|escape:'htmlall':'UTF-8'}" method="post" enctype="multipart/form-data" novalidate="">
		<p class="top_subtitle">Connect Your LiveEngage Account:</p>
			<input type="hidden" name="submitliveperson" value="1">
			<input name="LP_SITEID" id="LP_SITEID" value="{$lp_site_id|escape:'htmlall':'UTF-8'}" class="id_input" type="text" placeholder="LiveEngage SiteID" onfocus="this.placeholder = ''" onblur="this.placeholder = 'LiveEngage Site ID'" />
		{if ($lp_site_id > "0")}
			<input type = "submit" class="connect_btn" value = "Save" />
		{else}
			<input type = "submit" class="connect_btn" value = "Connect" />	
		{/if}
		<div style = "clear:both"></div>
		</form>
		{if ($lp_site_id > "0")}
		<p class="top_text">Your account is connected!</p>
		{else}
		
		<p class="top_subtitle" style = "margin-top:40px">Don't have a LiveEngage Account?</p>
		 <a class="connect_btn full" target = "_blank" href="http://roia.biz/im/n/5aayvq1BAAGhLUMAABTTZjEAQgABrAk-A/">Sign Up for Free</a>
		{/if}
	</div>
</div>

<div class="middle_section">

<p class="middle_title">LiveEngage Helps Convert Site Visitors <br />And Increase Sales</p>
<p class="middle_subtitle">Live chat, targeted offers, and messaging for your PrestaShop store.</p>

<div class="middle_boxes">
	<div class="box_inner" style="border:0">
		<img class="box_image" src="{$module_dir|escape:'htmlall':'UTF-8'}/img/icon_cart.jpg" />
		<p class="box_title">Sell Directly to Visitors</p>
		<p class="box_text">By engaging your visitors with targeted offers based on their individual behavior, you can increase conversion rates by as much as 25%</p>
	</div>
	<div class="box_inner">
		<img class="box_image" src="{$module_dir|escape:'htmlall':'UTF-8'}/img/icon_monitor.jpg" />
		<p class="box_title">Offer Real-Time Support</p>
		<p class="box_text">Giving your customers access to 24/7, real-time help not only decreases your bounce rate, but it increases their engagement too.</p>
	</div>
	<div class="box_inner" style="border:0">
		<img class="box_image" src="{$module_dir|escape:'htmlall':'UTF-8'}/img/icon_body.jpg" />
		<p class="box_title">Find Your Brand's Voice</p>
		<p class="box_text">Live chat with a real person helps foster meaningful relationships with customers and gives your business more personality.</p>
	</div>
</div>


</div>

{if ($lp_site_id <= "0")}
<div class="bottom_section">
	<a class="bottom_button" href="http://roia.biz/im/n/5aayvq1BAAGhLUMAABTTZjEAQgABrAk-A/" target = "_blank">Sign Up For Free</a>
</div>
{/if}



</div>



<!-- Open Sans -->
<script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Open+Sans:300,400,700,600:latin' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>




	
