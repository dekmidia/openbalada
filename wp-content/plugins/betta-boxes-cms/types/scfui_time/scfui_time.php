<?php
class scfui_time extends scfui_type {
	function scfui_time() {
	}
	
	public function getName() {
		return 'Time';
	}
	
	public function showField($post, $field) {
		$time = explode(':', get_post_meta($post->ID, $field['slug'], true));
		
		echo '<p>';
		echo '<label>'.$field['label'].'</label><br />';
		
		echo '<select name="scfui['.$field['slug'].'][hour]">';
		for($h=0; $h<24; $h++) {
			echo '<option value="'.$h.'" '.($time[0] == $h ? 'selected="selected"' : '').'>'.str_pad($h, 2, '0', STR_PAD_LEFT).'</option>';
		}
		echo '</select>';
		echo ' : ';
		echo '<select name="scfui['.$field['slug'].'][min]">';
		for($m=0; $m<60; $m++) {
			echo '<option value="'.$m.'" '.($time[1] == $m ? 'selected="selected"' : '').'>'.str_pad($m, 2, '0', STR_PAD_LEFT).'</option>';
		}
		echo '</select>';
		echo ' : ';
		echo '<select name="scfui['.$field['slug'].'][sec]">';
		for($s=0; $s<60; $s++) {
			echo '<option value="'.$s.'" '.($time[2] == $s ? 'selected="selected"' : '').'>'.str_pad($s, 2, '0', STR_PAD_LEFT).'</option>';
		}
		echo '</select>';
		
		echo '</p>';
	}
	
	//save the post_meta value
	public function saveCustomField($val) {
		return str_pad($val['hour'], 2, '0', STR_PAD_LEFT).':'.str_pad($val['min'], 2, '0', STR_PAD_LEFT).':'.str_pad($val['sec'], 2, '0', STR_PAD_LEFT);
	}

}

?>