<?php
class scfui_html_text extends scfui_type {
	private $tinyDefault = array();
	
	function scfui_html_text() {
	}
	
	function adminInits() {
		add_filter('tiny_mce_before_init', array($this, 'tinyMceInit'));
	}
	
	function tinyMceInit($initArray) {
		$this->tinyDefault = $initArray;
		return $initArray;
	}
	
	public function getName() {
		return 'HTML Text (WYSIWYG)';
	}
	
	public function showField($post, $field) {
		$value = get_post_meta($post->ID, $field['slug'], true);
		
		$extra = unserialize($field['extra']);
		
		if($extra['use_wp_editor'] && version_compare(get_bloginfo('version'), '3.3', '>=')) { //wp_editor() is only available from WP 3.3
			echo '<p>';
			echo '<label>'.$field['label'].'</label><br />';
			wp_editor($value, 'scfui'.$field['slug'], array('textarea_name'=>'scfui['.$field['slug'].']', ));
			echo '</p>';
		}else{
			$extra = unserialize($field['extra']);
			$buttons = $extra['buttons'];
			
			echo '<p>';
			echo '<label>'.$field['label'].'</label><br />';
			echo '<textarea class="scfui_'.$field['slug'].'" rows="20" cols="40" name="scfui['.$field['slug'].']">'.esc_attr($value).'</textarea>';
			echo '</p>';
			
			echo '<script>
			jQuery(document).ready(function() {
				tinyMCE.init({
					// General options
					mode : "specific_textareas",
					editor_selector : "scfui_'.$field['slug'].'",
					width: 760,
					theme : "advanced",
					
					// Theme options
					theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,cut,copy,paste,pasteword,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,code",
					theme_advanced_buttons2 : "",
					theme_advanced_buttons3 : "",
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_statusbar_location : "bottom",
					theme_advanced_resizing : true
				});
			});
			</script>';
		}
	}

	public function addField($cnt, $data=null) {
		if($data['extra']) { //if we have the extra key, its straight from the db, so lets turn it into what we want
			$use_editor = $data['extra']['use_wp_editor'];
		}else{ //nope, just the POST data so it's formatted fine
			$use_editor = $data['use_wp_editor'];
		}
		
		$editor_disabled = 'disabled="disabled"';
		if(version_compare(get_bloginfo('version'), '3.3', '>=')) { //wp_editor() is only available from WP 3.3
			$editor_disabled = '';;
		}
		
		$html = '<input id="scfui_use_wp_editor_'.$cnt.'" name="fields['.$cnt.'][use_wp_editor]" style="width:20px;" type="checkbox" value="1" '.($use_editor ? 'checked="checked"' : '').' '.$editor_disabled.' />';
		$html .= '<label for="scfui_use_wp_editor_'.$cnt.'">';
		$html .= 'Use wp_editor() <span class="description">(Available from WordPress 3.3. See <a href="http://codex.wordpress.org/Function_Reference/wp_editor" target="_blank">here</a> for more info)</span>';
		$html .= '</label>';
		
		return $html;
		
		/* was considering adding customisation for the editor buttons, but I think wp_editor() is better. Prove me wrong? {
			$buttons = array();
			$buttons['bold'] = 'bold';
			$buttons['italic'] = 'italic';
			$buttons['underline'] = 'underline';
			$buttons['strikethrough'] = 'strikethrough';
			$buttons['justifyleft'] = 'justifyleft';
			$buttons['justifycenter'] = 'justifycenter';
			$buttons['justifyright'] = 'justifyright';
			$buttons['justifyfull'] = 'justifyfull';
			$buttons['bullist'] = 'bullist';
			$buttons['numlist'] = 'numlist';
			$buttons['outdent'] = 'outdent';
			$buttons['indent'] = 'indent';
			$buttons['cut'] = 'cut';
			$buttons['copy'] = 'copy';
			$buttons['paste'] = 'paste';
			$buttons['undo'] = 'undo';
			$buttons['redo'] = 'redo';
			$buttons['link'] = 'link';
			$buttons['unlink'] = 'unlink';
			$buttons['image'] = 'image';
			$buttons['cleanup'] = 'cleanup';
			$buttons['help'] = 'help';
			$buttons['code'] = 'code';
			$buttons['hr'] = 'hr';
			$buttons['removeformat'] = 'removeformat';
			$buttons['formatselect'] = 'formatselect';
			$buttons['fontselect'] = 'fontselect';
			$buttons['fontsizeselect'] = 'fontsizeselect';
			$buttons['styleselect'] = 'styleselect';
			$buttons['sub'] = 'sub';
			$buttons['sup'] = 'sup';
			$buttons['forecolor'] = 'forecolor';
			$buttons['backcolor'] = 'backcolor';
			$buttons['forecolorpicker'] = 'forecolorpicker';
			$buttons['backcolorpicker'] = 'backcolorpicker';
			$buttons['charmap'] = 'charmap';
			$buttons['visualaid'] = 'visualaid';
			$buttons['anchor'] = 'anchor';
			$buttons['newdocument'] = 'newdocument';
			$buttons['blockquote'] = 'blockquote';
			
			if(!$selected) {
				$selected[0] = 'bold, italic, underline, strikethrough, |, cut, copy, paste, pasteword, bullist, numlist, |, outdent, indent, blockquote, |, undo, redo, |, link, unlink, anchor, image, code';
				$selected[1] = '';
				$selected[2] = '';
			}
			
			
			$html = '';
			$html .= '<label>Editor buttons</label><br />';
			$html .= '<span class="form-field">';
			$html .= '<input type="text" name="fields['.$cnt.'][buttons][0]" value="'.htmlspecialchars($selected[0]).'" />';
			$html .= '<input type="text" name="fields['.$cnt.'][buttons][1]" value="'.htmlspecialchars($selected[1]).'" />';
			$html .= '<input type="text" name="fields['.$cnt.'][buttons][2]" value="'.htmlspecialchars($selected[2]).'" />';
			$html .= '</span>';
			
			return $html;
		} */
	}
	
	public function saveField($data) {
		return serialize(array('use_wp_editor'=>$data['use_wp_editor']));
	}
}

?>