jQuery(document).ready(function() {
	if (typeof(window.FileReader) == 'undefined') {
	}else{
		var upload_files_html5 = jQuery("#upload_files_html5"),
			upload_button = jQuery('.upload-files'),
			drop_zone = jQuery('body'),
			drop_zone_inside = jQuery('.drag-drop-inside'),
			upload_table = jQuery('#file_list'),
			continue_install = jQuery('.next_step'),
			clear_data = jQuery('.old_data'),
			successMessage = jQuery('#successMessage'),
			files_array = new Array(),
			row_class='alternate',
			last_add_file,
			drop_file_list,
			loaded_settings_file = false,
			settings_checked = false,
			file_error = false,
			settings_list = new Array();
			file_true = false;

		drop_zone.on('dragover', function() {
			$('#upload_files').addClass('hover');
			return false;
		}).on('dragleave', function() {
			$('#upload_files').removeClass('hover');
			return false;
		}).on('drop', function(event) {
			get_file_list(event.originalEvent.dataTransfer.files);
			return false;
		});
		upload_button.on('click', add_more_files);
		upload_files_html5.on('change', function(){
			get_file_list(jQuery(this)[0].files);
		})
		jQuery("form#upload_files").on('mouseenter', function(){
			$('#upload_files').removeClass('pointer_events');
		})		
	}
	
	function add_more_files(){
		$('#upload_files').addClass('pointer_events');
		upload_files_html5.click();
		return !1;
	}
	
	function get_file_list(file_list){
		upload_button.off();

		drop_file_list = file_list;
		last_add_file = 0;

		jQuery('#upload_status .loader_bar span b').css({'width':'0%'});
		$('#upload_files').removeClass('hover');
		jQuery("form#upload_files").removeClass('add_files');
		upload_table.parents('#import_step_2').removeClass('hidden_ell');
		jQuery('#data_location_message').addClass('hidden_ell');
		jQuery('.drop_icon').addClass('second_step');
		add_file(drop_file_list[last_add_file]);
	}
	
	function save_list(file){
		var file_save_list = [];
		if(!in_array(file_save_list, file)) {
			file_save_list.push(file);
			return true;	
		} else {
			return false;	
		}
	}

	function add_file(file){
		var file_name = file.name,
		file_type = file.type;
		file_type = file_type.replace(' ', '');

		last_add_file++;
		
		if(!in_array(files_array, file_name))
		{
			var upload_file_num = files_array.length-1,
			file_size = file.size,
			file_size_type = ['B', 'KB', 'MB', 'GB'];

			files_array.push(file_name);
			row_class = row_class == 'alternate' ? '' : 'alternate';

			if(file_name.indexOf('settings.vsc') !=-1)
				loaded_settings_file = true;
			
			file_name.indexOf('.mbew') !=-1 ||
			file_name.indexOf('download@') !=-1 ||
			file_name.indexOf('.vgo') !=-1 ||
			file_name.indexOf('.4pm') !=-1 ||
			file_name.indexOf('.gpj') !=-1 ||
			file_name.indexOf('.gnp') !=-1 ||
			file_name.indexOf('.fig') !=-1 ||
			file_name.indexOf('.lqs') !=-1 ||
			file_name.indexOf('.oci') !=-1 ||
			file_name.indexOf('.vsc') !=-1 ? format_error = false : format_error = true;

			for (var i = 0; file_size > 1024 && i < file_size_type.length - 1; i++ )
			{
				file_size /= 1024;
			};

			jQuery('#file_list_body', upload_table).prepend(
				'<div id="file_status_'+upload_file_num+'" class="row '+row_class+'" ><div class="column_1">'+file_name+'</div><div class="column_2">'+file_size.toFixed(2)+' '+file_size_type[i]+'</div><div class="column_3"><span class="file_progress_bar"></span><span class="file_progress_text">'+import_text['upload']+' <span class="load_percent">0</span> %</span></div></div>');
			
			if (format_error)
			{
				jQuery('#file_status_'+upload_file_num).addClass('error_file').find('.file_progress_text').html(import_text['format_error']);
				file_error = true;
				switch_file(last_add_file, false);
			}
			else if (file.size > max_file_size)
			{
				jQuery('#file_status_'+upload_file_num).addClass('error_file').find('.file_progress_text').html(import_text['error_size']);
				file_error = true;
				switch_file(last_add_file, false);
			}
			else if(file.name.indexOf('.')==-1 && file.name.indexOf('download/') !=-1 && file.type == "")
			{
				jQuery('#file_status_'+upload_file_num).addClass('error_file').find('.file_progress_text').html(import_text['error_folder']);
				file_error = true;
				switch_file(last_add_file, false);				
			}
			else
			{
				var form_data = new FormData();
				form_data.append('file', file);
				file_true = true;
				send_file(form_data, upload_file_num, file.name, file.size);
			}
		}
		else
		{
			alert(import_text['error_added']);
			jQuery('#file_status_'+upload_file_num).addClass('error_file').find('.file_progress_text').html(import_text['error_added']);
			switch_file(last_add_file, false);
		}
	}
	
	function send_file(file_to_send, file_num, fileName, fileSize)
	{
		var xhr = new XMLHttpRequest();
		xhr.onload = function(data){
			var file_status_row =  jQuery('#file_status_'+file_num),
				loader_bar = jQuery('.file_progress_bar', file_status_row);

			jQuery('.load_percent', file_status_row).text('100');
			loader_bar.css({'width':'100%'});
			setTimeout(function(){
				loader_bar.addClass('transition').css({'opacity':0});
			},500);

			switch_file(last_add_file, true);
		};
		xhr.upload.onprogress = function(event)
		{
			upload_progress(event, file_num);
		};
		xhr.open('POST', baseDir, true);
		xhr.setRequestHeader("Cache-Control", "no-cache");
		xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
		xhr.setRequestHeader('X-FILE-NAME', fileName);
		xhr.setRequestHeader('X-FILE-SIZE', fileSize);
		xhr.send(file_to_send);
	}
	
	function upload_progress(event, file_num)
	{
		var percent = parseInt((event.loaded / event.total) * 100);
		jQuery('.load_percent', '#file_status_'+file_num).text(percent);
		jQuery('.file_progress_bar', '#file_status_'+file_num).css({'width':percent+'%'});
	}
	
	function switch_file(file_num, status)
	{
		if(status)
		{
			var percent = parseInt(file_num / drop_file_list.length * 100);
			jQuery('#upload_status .loader_bar span').css({'width':percent+'%'});
			jQuery('#upload_status .loader_bar .loaded-text').html(percent+'%');
			jQuery('#upload_counter b').html(parseInt(jQuery('#upload_counter b').text())+1);
		}
		if(drop_file_list[file_num])
			add_file(drop_file_list[file_num]);
		else
			setTimeout(function(){load_all_content();}, 1000);
	}
	
	function load_all_content()
	{
		if(file_error == true && file_true == false)
		{
			jQuery('#info_holder').removeClass().addClass('alert alert-danger');
			jQuery('#info_holder').find('.upload_status_text').html(import_text['uploaded_status_text_2']);
		}
		else if(file_error == true && file_true == true)
		{
			jQuery('#info_holder').removeClass().addClass('alert alert-warning');
			jQuery('#info_holder').find('.upload_status_text').html(import_text['uploaded_status_text_3']);
		}
		else if (loaded_settings_file == false)
		{
			jQuery('#info_holder').removeClass().addClass('alert alert-warning');	
			jQuery('#info_holder').find('.upload_status_text').html(import_text['uploaded_status_text_6']);
		}
		else
		{
			jQuery('#warning_holder').find('p').remove();
			jQuery('#info_holder').removeClass().addClass('alert alert-success');	
			jQuery('#info_holder').find('.upload_status_text').html(import_text['uploaded_status_text_4']);
		}

		upload_button.on('click', add_more_files);
		continue_install.off();
		if(loaded_settings_file == true)
        {
			settings_list = get_sampledata_settings();
			files_list = new Array();
			missed_files = '';

			for (i = 0; i<settings_list.length; i++)
			{
				if ($.isArray(settings_list[i]))
				{
					files_list = settings_list[i];
					for (i = 0; i < files_list.length; i++)
					{
						if ($.inArray(files_list[i], files_array) == -1)
						{
							missed_files += ' '+files_list[i]+',';
						}
					}
				}
				else
					jQuery('#warning_holder').prepend('<p class="alert alert-warning">'+settings_list[i]+'</p>');
			}
			
			if(file_error == true || missed_files.length) {
				jQuery('#info_holder p .upload_status_text').html(import_text['uploaded_status_text_3']);
				continue_install.off();
			}
			else {
				jQuery('#warning_holder').find('p.list').remove();
				jQuery('#info_holder p .upload_status_text').html(import_text['uploaded_status_text_1']);	
			}

			if (missed_files.length)
			{
				jQuery('#warning_holder').find('p.list').remove();
				jQuery('#warning_holder').prepend('<p class="alert alert-warning list">'+import_text['files_missed_text']+'<br />'+missed_files.substring(0, missed_files.length - 1)+'</p>');
			}
			
			jQuery("#not_load_file").addClass('hidden_ell');
			jQuery('#upload_status').addClass('upload_done');
			if (!missed_files.length)
			{
				continue_install.removeClass('not_active').on('click', function(){
					drop_zone.off();
					upload_button.off();
					upload_files_html5.off();
	
					if(loaded_settings_file){
						
						ajax_post();
						$("#install_sample_form").submit();
					}

					jQuery('#warning_holder').find('p.list').remove();
					jQuery('#info_holder').removeClass('alert-success').addClass('alert-warning');
					jQuery('#info_holder').find('.upload_status_text').html(import_text['uploaded_status_text']);
					jQuery('#info_holder').find('.upload-files').addClass('hidden_ell');
					jQuery('#import_xml_status').removeClass('hidden_ell');
					jQuery('#file_list_holder').addClass('hidden_ell');
					jQuery('#importing_warning').addClass('hidden_ell');
					jQuery('#upload_status, #info_holder').addClass('hidden_ell');
					jQuery(this).off('click').addClass('hidden_ell');
					return false;
				});
			}
		}else{
			continue_install.on('click', function(){
				jQuery("#not_load_file").removeClass('hidden_ell');
			})
		}
	}

	function get_sampledata_settings()
	{
		var result = new Array();
		$.ajax({
			type:'POST',
			url: baseDir,
			headers: { "cache-control": "no-cache" },
			dataType: 'json',
			async: false,
			data: {
				action: 'getSettigs',
			},
			success: function(msg)
			{
				if (msg.current_ps_ver != msg.sd_ps_ver)
					result.push(import_text['diferent_ps_version']+import_text['current_ps_version']+msg.current_ps_ver+import_text['sd_ps_version']+msg.sd_ps_ver);
				if (msg.current_db_ver != msg.sd_db_ver)
					result.push(import_text['diferent_db_version']+import_text['current_db_version']+msg.current_db_ver+import_text['sd_db_version']+msg.sd_db_ver);
				result.push(msg.files_list);
			}
		});
		return result;
	}
	
	function ajax_post(){
		jQuery.ajax({
			type:'POST',
			url: baseDir,
			data: {
				action: 'installData',
				forceIDs: 1
			},
			success:function(response) {
				if(response=="error"){
					error_status();
				}else if(loaded_settings_file){
					switch_ajax_post(response);
				}else{
					//import complete
					add_text_status('import_complete');
				}
			},
			error:function(response) {
				error_status();
			},
			timeout: 900000
		});
	}
	
	function switch_ajax_post(response){
		switch (response) {
			case '0':
				error_status();
			break;
			case 'error':
				error_status();
			break;
			case 'not_suported_version':
				not_supported_status();
			break;
			case 'undefined':
				error_status();
			break;
			case 'import_end':
				add_text_status('import_complete');
			break;
			default:
				ajax_post(response, 0);
			break;
		}
	}
	
	function add_text_status(text_index){
		jQuery('#info_holder').addClass('hidden_ell');
		if(text_index == 'import_complete'){
			jQuery('#status_log').html('<p class ="done_import"><i class ="process-icon-ok"></i>'+import_text['import_complete']+'</p>');
			jQuery('#success_install').removeClass('hidden_ell');
		}
	}

	function error_status(){
		jQuery('#status_log p:last-child').removeClass().addClass('error_import').find('i').removeClass().addClass('process-icon-remove');
		jQuery('#status_log').html('<p class="error_import"><i class ="icon-warning-sign"></i>'+import_text['instal_error']+'</p>');
		jQuery('#import_data .loader_bar span').css({'width':'100%', 'background':'red'});
	}
	function not_supported_status(){
		jQuery('#status_log p:last-child').removeClass().addClass('error_import').find('i').removeClass().addClass('process-icon-remove');
		jQuery('#status_log').html('<p class="error_import"><i class ="icon-warning-sign"></i>'+import_text['not_supported_status']+'</p>');
		jQuery('#import_data .loader_bar span').css({'width':'100%', 'background':'red'});
	}
	
	function in_array(array, value) {
		for(var i=0; i<array.length; i++) {
			if (array[i] == value) return true;
		}
		return false;
	}
});