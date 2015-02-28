<?php
class scfui_checkboxes extends scfui_type {
	function scfui_checkboxes() {
	}
	
	public function getName() {
		return 'Checkboxes';
	}
	
	public function showField($post, $field) {
		echo '<input type="hidden" name="scfui['.$field['slug'].'][__force_post]" value=1 />'; //this will force a post even if no options are selected
		$options = get_post_meta($post->ID, $field['slug'], true);
		echo '<p>';
		echo '<label>'.$field['label'].'</label><br />';
		$extra = unserialize($field['extra']);
		foreach ((array)$extra['options'] as $key=>$val) {
			echo '<input type="checkbox" name="scfui['.$field['slug'].']['.htmlspecialchars($val).']" value="'.htmlspecialchars($val).'" '.($options[$val] ? 'checked="checked"' : '').' /> '.htmlspecialchars($val).'<br />';
		}
		echo '</p>';
	}
	
	public function addField($cnt, $data=null) {
		if($data['extra']) { //if we have the extra key, its straight from the db, so lets turn it into what we want
			$value = implode("\n", $data['extra']['options']);
		}else{ //nope, just the POST data so it's formatted fine
			$value = $data['options'];
		}
		$html = '';
		$html .= '<label>Options, seperated by new lines</label><br />';
		$html .= '<span class="form-field"><textarea rows="6" name="fields['.$cnt.'][options]">'.htmlspecialchars($value).'</textarea></span>';
		
		return $html;
	}
	
	public function checkAddedField($err, $data) {
		if(!trim($data['options'])) {
			$err['no-options'] = 'Please enter at least 1 option';
		}
		$split = explode('<br />', nl2br($data['options']));
		
		$list = array();
		foreach ((array)$split as $key=>$val) {
			if($val = trim($val)) {
				if($list[$val]) {
					$err['duplicate-option'] = 'The option <strong>'.$val.'</strong> is duplicated in the list';
					break;
				}else{
					$list[$val] = $val;
				}
			}
		}
		return $err;
	}
	
	public function saveField($data) {
		$split = explode('<br />', nl2br($data['options']));
		
		$list = array();
		foreach ((array)$split as $key=>$val) {
			if(trim($val)) {
				$list[trim($val)] = trim($val);
			}
		}
		
		return serialize(array('options'=>$list));
	}
}

?>