<?php
class scfui_date extends scfui_type {
	function scfui_date() {
	}
	
	public function getName() {
		return 'Date Picker';
	}
	
	public function showField($post, $field) {
		global $scfui;
		
		echo '<p>';
		echo '<label>'.$field['label'].'</label><br />';
		echo '<input id="scfui_'.$field['slug'].'" size="10" type="text" name="scfui['.$field['slug'].']" value="'.($post->ID ? esc_attr(get_post_meta($post->ID, $field['slug'], true)) : '').'" />';
		echo '<img id="scfui_button_'.$field['slug'].'" src="'.$scfui->pluginUrl.'types/'.__CLASS__.'/images/scfui_date_calendar.png" />';
		echo '</p>';
		
		echo '<link rel="stylesheet" href="'.$scfui->pluginUrl.'types/'.__CLASS__.'/css/wc-calendar.css" type="text/css" media="all" />';
		echo '<script src="'.$scfui->pluginUrl.'types/'.__CLASS__.'/js/wc-calendar.js"></script>';
		echo '<script>
		jQuery(document).ready(function() {
				wcCalendar.init({
						field: "scfui_'.$field['slug'].'",
						button: "scfui_button_'.$field['slug'].'",
						fieldAsButton: true
				});
		});
		</script>';
	}
}

?>