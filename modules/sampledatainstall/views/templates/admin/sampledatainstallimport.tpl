<script type="text/javascript">
	var baseDir = '{$actions.baseDir}';
	var import_text = new Array(),
	max_file_size = '{$actions.max_file_size}';
	SDI_show_message = 0;

	import_text['error_upload']		= "{l s='Upload Error' mod='sampledatainstall'}";
	import_text['error_size']		= "{l s='The file is too big!' mod='sampledatainstall'}";
	import_text['error_type']		= "{l s='Wrong file type!' mod='sampledatainstall'}";
	import_text['error_folder']		= "{l s='Folders can not be uploaded!' mod='sampledatainstall'}";
	import_text['format_error']		= "{l s='Wrong file! Only sample data files can be used!' mod='sampledatainstall'}";
	import_text['error_added']		= "{l s='File already added!' mod='sampledatainstall'}";
	import_text['uploading']		= "{l s='Uploading' mod='sampledatainstall'}";
	import_text['upload']			= "{l s='Upload' mod='sampledatainstall'}";
	import_text['upload_complete']	= "{l s='Upload Complete' mod='sampledatainstall'}";
	import_text['item']				= "{l s='item' mod='sampledatainstall'}";
	import_text['items']			= "{l s='items' mod='sampledatainstall'}";
	import_text['uploaded_status_text']= "{l s='Sample data installing. It can take some time. You can drink some tea and eat a croissant.' mod='sampledatainstall'}";
	import_text['uploaded_status_text_1']= "{l s='Well done! Upload complete. Please click Continue Install button to proceed.' mod='sampledatainstall'}";
	import_text['uploaded_status_text_2']= "{l s='Files are not uploaded.' mod='sampledatainstall'}";
	import_text['uploaded_status_text_3']= "{l s='Not all files are successfully uploaded.' mod='sampledatainstall'}";
	import_text['uploaded_status_text_4']= "{l s='Files successfully uploaded.' mod='sampledatainstall'}";
	import_text['uploaded_status_text_5']= "{l s='Not all files are successfully uploaded. Please click Continue Install button to proceed.' mod='sampledatainstall'}";
	import_text['uploaded_status_text_6']= "{l s='Settings file is not loaded.' mod='sampledatainstall'}";

	import_text['import_complete']= "{l s='Sample data installation complete' mod='sampledatainstall'}";
	import_text['instal_error']= "{l s='Sample data installation failed' mod='sampledatainstall'}";
	import_text['not_supported_status']= "{l s='This sample data is not compatible with your store.' mod='sampledatainstall'}";


	import_text['diferent_ps_version']= "{l s='Your Prestashop and the sample data versions are different. ' mod='sampledatainstall'}";
	import_text['diferent_db_version']= "{l s='Your database and the sample data database versions are different. ' mod='sampledatainstall'}";
	import_text['current_ps_version']= "{l s=' Your Prestashop version: ' mod='sampledatainstall'}";
	import_text['sd_ps_version']= "{l s=' Sample data version: ' mod='sampledatainstall'}";
	import_text['current_db_version']= "{l s=' Your database version: ' mod='sampledatainstall'}";
	import_text['sd_db_version']= "{l s=' Sample data database version: ' mod='sampledatainstall'}";
	import_text['files_missed_text']= "{l s='Some file(s) is(are) missed : ' mod='sampledatainstall'}";
</script>
<div class="bootstrap" id="data_location_message">
	<div class="alert alert-danger">
        <p>{l s='Please note! Intalling demo store data will completely replace your store content. All products, module settings, pages and configurations will be replaced. Make sure to create store database backup before sample data installation.' mod='sampledatainstall'}</p>
    </div>
    <div class="alert alert-warning">
        <p>{l s='Theme sample data files are located in sources/sample_data.zip archive of your template directory' mod='sampledatainstall'}</p>
    </div>
</div>
<div class="panel">
    <!-- drag drop form -->
    <form enctype="multipart/form-data" method="post" action="" id="upload_files">
        <div id="area-drag-drop">
            <div class="drag-drop-inside">
            	<div class="drop_icon"></div>
                <h6 class="drop_heading">{l s='Please Drop all needed files here to import sample data' mod='sampledatainstall'}</h6>
                <p>{l s='or' mod='sampledatainstall'}</p>
                <p class="drag-drop-buttons">
                    <button class="upload-files new-btn btn btn-danger btn-lg" type="button" class="button">{l s='Browse local files' mod='sampledatainstall'}</button>
                    <input id="upload_files_html5" style="visibility: hidden; width: 0; height: 0; overflow: hidden; margin:0;" type="file" multiple>
                </p>
                <p class="max-upload-size">
                	{l s='Maximum file size:' mod='sampledatainstall'}{$actions.max_file_size_text} <br />
                    {l s='You can change it in your server settings.' mod='sampledatainstall'}
                </p>
                {if ($actions.output)}
                	<div class="alert alert-warning">
                    	{l s='Caution! Some of your server settings do not meet the requirements for installing the sample data. Please, consult with your hosting provider on how to increase the required values.' mod='sampledatainstall'}
                    </div>
                    <table id="server_settings" class='table text-left'>
                    	<thead>
                        	<tr>
                        		<th>{l s='Server Settings' mod='sampledatainstall'}</th>
                            	<th class="text-center">{l s='Current' mod='sampledatainstall'}</th>
                                <th class="text-center">{l s='Required' mod='sampledatainstall'}</th>
                            </tr>
                        </thead>
                        <tbody>
                        	{$actions.output}
                        </tbody>
                    </table>
                {/if}
            </div>
        </div>
    </form>
    
    <!-- end drag drop form -->
    <div id="import_step_2" class="hidden_ell">
    <!-- file_list -->
        <div id="file_list_holder">
            <div id="file_list">
                <div id="file_list_header">
                    <div class='row'>
                        <div class="column_1">{l s='File name' mod='sampledatainstall'}</div>
                        <div class="column_2">{l s='File size' mod='sampledatainstall'}</div>
                        <div class="column_3 text-center">{l s='Uploaded file:' mod='sampledatainstall'} 
                            <span id="upload_counter">
                                <b>0</b>
                            </span>
                            <span class="items_name">{l s='item' mod='sampledatainstall'}</span>
                        </div>
                    </div>
                </div>
                <div id="file_list_body"></div>
            </div>
        </div>
        <div id="import_xml_status" class="hidden_ell">
            <div id="status_log">
                <p><i class ="loader"></i>{l s='Installing demo store. You\'ll like it!' mod='sampledatainstall'}<span class="loader-info">{l s='It can take some time. You can drink some tea and eat a croissant.' mod='sampledatainstall'}</span></p>
            </div>
        </div>
    <!-- end file_list -->
        <div id="import_status" class="clearfix">
            <div id='upload_status'>
                <div class="loader_bar">
                	<strong class="loaded-text">0%</strong>
                    <span class='transition_2'></span>
                </div>
            </div>
            <div id="info_holder" class="hidden_ell">
                <p>
                    <span class="upload_status_text">0%</span>
                    <a class="upload-files btn btn-info" href="#">{l s='Add More Files' mod='sampledatainstall'}</a>
                    <a class="button button-primary not_active next_step btn btn-success" href="javascript:void(0);" id="submit_install">{l s='Continue Install' mod='sampledatainstall'}</a>
                    <span id="not_load_file" class="hidden_ell">{l s='Missing dump.sql file.' mod='sampledatainstall'}</span>
                </p>
            </div>
            <div id="warning_holder"></div>
        </div>
    </div>
</div>
<div class="alert alert-success hidden_ell" id="success_install">
	<p class="clearfix">{l s='Installation is now complete! For correct work of store you need to go to regenerate thumbnails and select the option to create thumbnails.' mod='sampledatainstall'}
    {l s='To jump, click on the button below' mod='sampledatainstall'}
    <button type="submit" onclick="window.location ='{$actions.regenerateDir}'" class="btn btn-primary pull-right" id="regenerate_go">{l s='Go to regenerate page' mod='sampledatainstall'}</button></p>
</div>