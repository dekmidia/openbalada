jQuery(document).ready(function() {
		jQuery('#scfui-add-field').click(function(e) {
				var fieldCnt = parseInt(jQuery('#scfui-fields-list li').size());
				
				var html = '';
				html += '<li class="'+(fieldCnt % 2 ? '' : 'odd')+'">';
				html += '<div class="scfui-field-new-loading">Loading... <img src="'+scfui_plugin_url+'images/loading.gif" /></div>';
				html += '</li>';
				
				jQuery('#scfui-fields-list').append(html);
				
				var $li = jQuery('#scfui-fields-list:last-child');
				
				$li = jQuery('#scfui-fields-list li:last-child');
				
				jQuery.ajax({
						url: scfui_admin_url+'&action=get-types-list&noheader=1',
						dataType: 'json',
						data: '',
						success: function(data, textStatus, jqXHR) {
							if(data.success) {
								$li.html(data.html);
								
								//attach the change event to the type select
								$li.find('select.scfui-types-select').change(function() {
										$this = jQuery(this);
										$li = $this.parents('li');
										var fieldCnt = parseInt(jQuery('#scfui-fields-list li').size()) - 1;
										
										jQuery.ajax({
												url: scfui_admin_url+'&action=custom-field-form&noheader=1&type='+$this.attr('value')+'&count='+fieldCnt,
												dataType: 'json',
												data: '',
												beforeSend: function(jqXHR, settings) {
													$this.attr('disabled', true);
												},
												success: function(data, textStatus, jqXHR) {
													if(data.success) {
														var html = '';
														
														
														html += '<div class="metabox-holder">';
														html += '<div class="postbox">';
														html += '<div class="handlediv">';
														html += '<a href="#" class="scfui-field-delete" title="Delete custom field"><img src="'+scfui_plugin_url+'images/delete.png" /></a>';
														html += '</div>';
														html += '<h3 class="hndle"><span>'+data.type_name+'</span></h3>';
														html += '<div class="inside">';
														html += data.html;
														html += '</div>';
														html += '</div>';
														html += '</div>';
														
														$li.html(html);
													}else{
														$li.html('There was a problem getting the form, please try again in a moment.');
														$li.delay(2500).fadeOut();
													}
												}
										});
								});
								
								//bind onchange event to selecting a new custom field type (live, keeps updated with new DOM elements)
								$li('a.scfui-field-delete').click(function(e) {
										if(jQuery(this).attr('href') == '#') {
											if(confirm('Are you sure you want to delete this field? There is no data linked to it yet.')) {
												$li = jQuery(this).parents('li');
												$li.fadeOut('fast', function() {
														$li.remove();
												});
											}
											e.preventDefault();
										}
								});

							}else{
								$li.html('There was a problem getting the possible types, please try again in a moment.');
								$li.delay(2500).fadeOut();
							}
						}
				});
				
				e.preventDefault();
		});
		
		jQuery("#scfui-fields-list").sortable({
				handle: 'h3.hndle',
				placeholder: 'scfui-field-placeholder',
				forcePlaceholderSize: true
		});
});