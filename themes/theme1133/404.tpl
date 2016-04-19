<div class="pagenotfound">
	<div class="img-404">
    	<img src="{$img_dir}/img-404.jpg" alt="{l s='Page not found'}" />
    </div>
	<h1>{l s='This page is not available'}</h1>
	<p>
		{l s='We\'re sorry, but the Web address you\'ve entered is no longer available.'}
	</p>
	<h3>{l s='To find a product, please type its name in the field below.'}</h3>
	
    <form action="{$link->getPageLink('search')|escape:'html':'UTF-8'}" method="post" class="std">
		<fieldset>
			<div>
				<label for="search_query">{l s='Search our product catalog:'}</label>
				<input id="search_query" name="search_query" type="text" class="form-control grey" />
                <button type="submit" name="Submit" value="OK" class="btn btn-default btn-sm"><span>{l s='Ok'}</span></button>
			</div>
		</fieldset>
	</form>
	<div class="buttons">
    	<a class="btn btn-default btn-md" href="{$base_dir}" title="{l s='Home'}">
    		<span>
        		<i class="fa fa-chevron-left left"></i>
        		{l s='Home page'}
     		</span>
    	</a>
	</div>
</div>
