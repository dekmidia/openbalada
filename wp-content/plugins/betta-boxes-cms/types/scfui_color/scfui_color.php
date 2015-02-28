<?php
class scfui_color extends scfui_type {
	function scfui_color() {
	}
	
	public function getName() {
		return 'Color Picker';
	}
	
	public function showField($post, $field) {
		global $scfui;
		
		echo '<p>';
		echo '<label>'.$field['label'].'</label><br />';
		echo '<input class="color {required:false}" id="scfui_'.$field['slug'].'" size="10" type="text" name="scfui['.$field['slug'].']" value="'.($post->ID ? esc_attr(get_post_meta($post->ID, $field['slug'], true)) : '').'" />';
		echo '<img id="scfui_button_'.$field['slug'].'" src="'.$scfui->pluginUrl.'types/'.__CLASS__.'/images/scfui_color_picker.png" />';
		echo '</p>';
		echo '<script src="'.$scfui->pluginUrl.'types/'.__CLASS__.'/js/jscolor.js"></script>';
	}
}

?>