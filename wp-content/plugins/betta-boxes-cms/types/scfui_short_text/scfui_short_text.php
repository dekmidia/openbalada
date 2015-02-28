<?php
class scfui_short_text extends scfui_type {
	function scfui_short_text() {
	}
	
	public function getName() {
		return 'Short Text';
	}
	
	public function showField($post, $field) {
		echo '<p>';
		echo '<label>'.$field['label'].'</label><br />';
		echo '<input size="50" type="text" name="scfui['.$field['slug'].']" value="'.($post->ID ? esc_attr(get_post_meta($post->ID, $field['slug'], true)) : '').'" />';
		echo '</p>';
	}
}

?>