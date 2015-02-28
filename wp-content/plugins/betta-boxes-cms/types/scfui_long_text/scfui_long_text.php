<?php
class scfui_long_text extends scfui_type {
	function scfui_long_text() {
	}
	
	public function getName() {
		return 'Long Text';
	}
	
	public function showField($post, $field) {
		$value = get_post_meta($post->ID, $field['slug'], true);
		
		echo '<p>';
		echo '<label>'.$field['label'].'</label><br />';
		echo '<textarea cols="50" rows="5" name="scfui['.$field['slug'].']">'.($post->ID ? esc_attr($value) : '').'</textarea>';
		echo '</p>';
	}
}

?>