<?php
/*
Plugin Name: Betta Boxes CMS
Plugin URI: http://shauno.co.za/wordpress/betta-boxes-cms/
Description: Easily add custom fields to any post type to turn your WordPress site into a powerful CMS
Version: 1.1.5
Author: Shaun Alberts
Author URI: http://shauno.co.za
*/

// generic stop direct call
if(preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) {die('You are not allowed to call this page directly.');}

class bettaBoxesCMS { //might as well contain it in a class
	public $adminUrl, $pluginUrl, $pluginPath; //public so the type classes can access this
	private $types = array();
	
	//construct
	function bettaBoxesCMS() {
		register_activation_hook(__FILE__, array(&$this, 'dbUpgrade'));
		
		add_action('admin_init', array(&$this, 'adminInits'));
		add_action('admin_menu', array(&$this, 'adminMenus'));
		
		$this->adminUrl = get_admin_url().'options-general.php?';
		
		$d = explode('/', str_replace('\\', '/', dirname(__FILE__)));
		$dir = array_pop($d);
		$this->pluginUrl = WP_PLUGIN_URL.'/'.$dir.'/';
		$this->pluginPath = WP_PLUGIN_DIR.'/'.$dir.'/';
	}
	
	//build / update tables - not really an API
	function dbUpgrade() {
		global $wpdb;
		
		$table_name = $wpdb->prefix.'scfui_boxes';
		$sql = 'CREATE TABLE '.$table_name.' (
		id BIGINT NOT NULL AUTO_INCREMENT,
		type VARCHAR(255) NOT NULL,
		title VARCHAR(255) NOT NULL,
		context VARCHAR(255) NULL,
		priority VARCHAR(255) NULL,
		added_by BIGINT NOT NULL DEFAULT 0,
		date_added DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00",
		edited_by BIGINT NOT NULL DEFAULT 0,
		date_edited DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00",
		deleted BIGINT NOT NULL DEFAULT 0,
		deleted_by BIGINT NOT NULL DEFAULT 0,
		date_deleted DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00",
		UNIQUE KEY id (id)
		);';
		require_once(ABSPATH.'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		//changing encodings retroactively. My bad..
		$wpdb->query('ALTER TABLE '.$table_name.' CHARSET utf8;');
		$wpdb->query('ALTER TABLE '.$table_name.' MODIFY title varchar(255) CHARSET utf8;');
		
		
		$table_name = $wpdb->prefix.'scfui_fields';
		$sql = 'CREATE TABLE '.$table_name.' (
		id BIGINT NOT NULL AUTO_INCREMENT,
		scfui_boxes_id BIGINT NOT NULL,
		label VARCHAR(255) NOT NULL,
		slug VARCHAR(255) NOT NULL,
		type VARCHAR(255) NOT NULL,
		priority BIGINT NOT NULL DEFAULT 0,
		extra TEXT NULL,
		added_by BIGINT NOT NULL DEFAULT 0,
		date_added DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00",
		edited_by BIGINT NOT NULL DEFAULT 0,
		date_edited DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00",
		deleted BIGINT NOT NULL DEFAULT 0,
		deleted_by BIGINT NOT NULL DEFAULT 0,
		date_deleted DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00",
		UNIQUE KEY id (id)
		);';
		require_once(ABSPATH.'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		//changing encodings retroactively. My bad..
		$wpdb->query('ALTER TABLE '.$table_name.' CHARSET utf8;');
		$wpdb->query('ALTER TABLE '.$table_name.' MODIFY label varchar(255) CHARSET utf8;');
		$wpdb->query('ALTER TABLE '.$table_name.' MODIFY extra TEXT CHARSET utf8;');
  }
  
	// APIs {
		function loadTypes() {
			if(!$this->types) {
				require_once($this->pluginPath.'types.php');
				$d = dir($this->pluginPath.'types/');
				while (false !== ($entry = $d->read())) {
					if(is_dir($d->path.$entry) && $entry != '.' && $entry != '..' && substr($entry,0,5) == 'scfui') { //only 'scfui' folders
						include_once($d->path.$entry.'/'.$entry.'.php');
						$this->types[$entry] = new $entry();
					}
				}
				$d->close();
			}
		}
		
  	function checkSlug($slug) {
  		return preg_match('/^[a-z0-9\_\-]+$/i', $slug);
  	}

  	function saveCustomField($post_id) {
  		if(isset($_POST['scfui'])){
  			foreach ($_POST['scfui'] as $slug=>$val){
  				if(isset($val['__force_post']) && is_array($val['__force_post']) && $val['__force_post'] == 1) { //be sure it's an array, or beware unsetting strings
  					unset($val['__force_post']);
  				}
  				$field = $this->getField(array('slug'=>$slug));
  				$value = $this->types[$field['type']]->saveCustomField($val);
  				add_post_meta($post_id, $slug, $value, true) or update_post_meta($post_id, $slug, $value);
  			}
  		}
  	}

  	//Boxes
  	function createBox($config) {
  		global $wpdb, $current_user;
      get_currentuserinfo();
      
      if(!trim($config['title'])) {
  			return false;
  		}
  		
  		if(!$config['type']) {
  			return false;
  		}
  		
  		if(!isset($config['context'])) {
  			$config['context'] = 'advanced';
  		}
  		if(!isset($config['priority'])) {
  			$config['priority'] = 'default';
  		}

  		$save = array();
  		$save['title'] = $config['title'];
  		$save['type'] = $config['type'];
  		$save['context'] = $config['context'];
  		$save['priority'] = $config['priority'];
  		$save['added_by'] = $current_user->ID;
  		$save['date_added'] = date('Y-m-d H:i:s', time());
  		
  		$format = array(
  			'%s',
  			'%s',
  			'%s',
  			'%s',
  			'%d',
  			'%s'
  			);
  		
  		if($wpdb->insert($wpdb->prefix.'scfui_boxes', $save, $format)) {
  			$bid = $wpdb->insert_id;
  			return $bid;
  		}else{
  			return false;
  		}
  	}
  	
  	function updateBox($config) {
  		global $wpdb, $current_user;
      get_currentuserinfo();
      
      if(!$config['id'] || !is_numeric($config['id'])) {
      	return false;
      }
        		  		
  		if(!$config['type']) {
  			return false;
  		}
  		
  		$save = array();
  		$save['title'] = $config['title'];
  		$save['type'] = $config['type'];
  		$save['edited_by'] = $current_user->ID;
  		$save['date_edited'] = date('Y-m-d H:i:s', time());
  		
  		$format = array(
  			'%s',
  			'%s',
  			'%d',
  			'%s'
  			);
  		
  		$where = array('id'=>$config['id']);
  		$whereFormat = array('%d');
  		
  		if($wpdb->update($wpdb->prefix.'scfui_boxes', $save, $where, $format, $whereFormat)) {
  			return $config['id'];
  		}else{
  			return false;
  		}
  	}
  	
  	function getBoxesList($config=array()) {
  		global $wpdb;
  		
  		//check if allowing deleted records to show
  		if(!$config['allowdeleted']) {
  			$where = $where ? '('.$where.') AND ' : '';
  			$where .= 'boxes.deleted = 0';
  		}
  		
  		//build the query
  		$qry  = 'SELECT boxes.*';
  		$qry .= ' FROM '.$wpdb->prefix.'scfui_boxes AS boxes';
  		if($where) {$qry .= ' WHERE '.$where;}
  		//$qry .= ' GROUP BY boxes.id ';
  		$order = $config['order'] ? $config['order'] : 'date_added DESC';
  		$qry .= ' ORDER BY '.$wpdb->escape($order);
  		
  		if(($list = $wpdb->get_results($qry, ARRAY_A)) !== false) {
  			if($config['getfields']) {
  				foreach ((array)$list as $key=>$val) {
						$list[$key]['fields'] = $this->getFieldsList(array('where'=>'scfui_boxes_id = '.$wpdb->escape($val['id'])));
					}
  			}
  			return $list;
  		}else{
  			return array();
  		}
  	}
  	
  	function getBox($config=array()) {
  		global $wpdb;
  		
  		if($config['id'] && is_numeric($config['id'])) {
  			$where = 'boxes.id = '.$wpdb->escape($config['id']);
  		}else{
  			return false;
  		}
  		
  		//check if allowing deleted records to show
  		if(!$config['allowdeleted']) {
  			$where = $where ? '('.$where.') AND ' : '';
  			$where .= 'boxes.deleted = 0';
  		}
  		
  		//build the query
  		$qry  = 'SELECT boxes.*';
  		$qry .= ' FROM '.$wpdb->prefix.'scfui_boxes AS boxes';
  		if($where) {$qry .= ' WHERE '.$where;}
  		//$qry .= ' GROUP BY boxes.id ';
  		
  		if(($box = $wpdb->get_row($qry, ARRAY_A)) !== false) {
  			if($config['getfields']) {
  				$box['fields'] = $this->getFieldsList(array('where'=>'scfui_boxes_id = '.$wpdb->escape($box['id'])));
  			}
  			return $box;
  		}else{
  			return array();
  		}
  	}
  	
  	function deleteBox($config) {
  		global $wpdb, $current_user;
      get_currentuserinfo();
      
      if(!$config['id'] || !is_numeric($config['id'])) {
      	return false;
      }
      
      if(!$box = $this->getBox(array('id'=>$config['id'], 'getfields'=>true))) { //gotta get it
      	return false;
      }
      
  		$save = array();
  		$save['deleted_by'] = $current_user->ID;
  		$save['date_deleted'] = date('Y-m-d H:i:s', time());
  		$save['deleted'] = 1;
  		
  		$format = array(
  			'%d',
  			'%s',
  			'%d'
  			);
  		
  		$where = array('id'=>$box['id']);
  		$whereFormat = array('%d');
  		
  		if($wpdb->update($wpdb->prefix.'scfui_boxes', $save, $where, $format, $whereFormat)) {
  			foreach ((array)$box['fields'] as $key=>$val) {
					$this->deleteField(array('id'=>$val['id'], 'delete_data'=>$config['delete_data']));
				}
  			return true;
  		}else{
  			return false;
  		}
  	}
  	
  	
  	//Fields
  	function getCustomFieldForm($type, $cnt, $data=array()) {
  		$html = '';
  		if($data['id']) {
  			$html .= '<input type="hidden" name="fields['.$cnt.'][id]" value="'.htmlspecialchars($data['id']).'" />';
  		}
  		$html .= '<input type="hidden" name="fields['.$cnt.'][type]" value="'.htmlspecialchars($type).'" />';
  		$html .= '<input type="hidden" name="fields['.$cnt.'][type]" value="'.htmlspecialchars($type).'" />';
  		$html .= '<table class="form-table">';
  		$html .= '<tbody>';
  		
  		$html .= '<tr class="form-field">';
  		$html .= '<th scope="row"><label for="data_label">Label <span class="description">(required)</span></label></th>';
  		$html .= '<td><input type="text" id="data_label" name="fields['.$cnt.'][label]" value="'.htmlspecialchars($data['label']).'" /></td>';
  		$html .= '</tr>';
  		
  		//called 'slug' in the code, labeled as 'meta key' here as it's more user descriptive
  		$html .= '<tr class="form-field">';
  		$html .= '<th scope="row"><label for="data_slug">Meta Key <span class="description">(required)</span></label></th>';
  		$html .= '<td><input type="text" id="data_slug" name="fields['.$cnt.'][slug]" value="'.htmlspecialchars($data['slug']).'" '.($data['id'] ? 'readonly="readonly"' : '').' /><br />';
  		if($data['id']) {
  			$html .= '<span class="description">You cannot edit the meta key, as there may already be data linked to it</span>';
  		}else{
  			$html .= '<span class="description">Use a-z, 0-9, underscores and hyphens</span>';
  		}
  		$html .= '</td>';
  		$html .= '</tr>';
  		
  		if(method_exists($this->types[$type], 'addField')) {
  			$html .= '<tr class="data_extra">';
  			$html .= '<td></td>';
  			$html .= '<td>';
  			$html .= $this->types[$type]->addField($cnt, $data);
  			$html .= '</td>';
  			$html .= '</tr>';
  		}
  		
  		$html .= '</tbody>';
  		$html .= '</table>';
  		
  		return $html;
  	}
  	
  	function createField($config) {
  		global $wpdb, $current_user;
      get_currentuserinfo();
  		if(!is_numeric($config['scfui_boxes_id']) && $config['scfui_boxes_id']) {
  			return false;
  		}
  		
  		if(!trim($config['label'])) {
  			return false;
  		}
  		
  		if(!$this->checkSlug($config['slug'])) {
  			return false;
  		}
  		
  		if(!$this->types[$config['type']]) {
  			return false;
  		}
  		
  		$save = array();
  		$save['scfui_boxes_id'] = $config['scfui_boxes_id'];
  		$save['label'] = $config['label'];
  		$save['slug'] = $config['slug'];
  		$save['type'] = $config['type'];
  		$save['extra'] = $config['extra'];
  		$save['priority'] = $config['priority'] ? $config['priority'] : 0;
  		$save['added_by'] = $current_user->ID;
  		$save['date_added'] = date('Y-m-d H:i:s', time());
  		
  		$format = array(
  			'%d',
  			'%s',
  			'%s',
  			'%s',
  			'%s',
  			'%d',
  			'%d',
  			'%s'
  			);
  		
  		if($wpdb->insert($wpdb->prefix.'scfui_fields', $save, $format)) {
  			$fid = $wpdb->insert_id;
  			return $fid;
  		}else{
  			return false;
  		}
  	}
  	
  	function getFieldsList($config=array()) {
  		global $wpdb;
  		
  		//check if allowing deleted records to show
  		if(!$config['allowdeleted']) {
  			$where = $where ? '('.$where.') AND ' : '';
  			$where .= 'fields.deleted = 0';
  		}

  		if($config['where']) {
  			$where = $where ? '('.$where.') AND ' : '';
  			$where .= $config['where'];
  		}
  		
  		//build the query
  		$qry  = 'SELECT fields.*';
  		$qry .= ' FROM '.$wpdb->prefix.'scfui_fields AS fields';
  		if($where) {$qry .= ' WHERE '.$where;}
  		$order = $config['order'] ? $config['order'] : 'fields.priority ASC, fields.date_added DESC';
  		$qry .= ' ORDER BY '.$wpdb->escape($order);
  		
  		if(($list = $wpdb->get_results($qry, ARRAY_A)) !== false) {
  			return $list;
  		}else{
  			return array();
  		}
  	}

  	function getField($config) {
  		global $wpdb;
  		
  		if($config['id'] && is_numeric($config['id'])) {
  			$where = 'fields.id = '.$wpdb->escape($config['id']);
  		}else if($config['slug']) {
  			$where = 'fields.slug = "'.$wpdb->escape($config['slug']).'"';
  		}else{
  			return false;
  		}
  		
  		//check if allowing deleted records to show
  		if(!$config['allowdeleted']) {
  			$where = $where ? '('.$where.') AND ' : '';
  			$where .= 'fields.deleted = 0';
  		}
  		
  		//build the query
  		$qry  = 'SELECT fields.*';
  		$qry .= ' FROM '.$wpdb->prefix.'scfui_fields AS fields';
  		$qry .= ' WHERE '.$where;
  		
  		if(($field = $wpdb->get_row($qry, ARRAY_A)) !== false) {
  			return $field;
  		}else{
  			return array();
  		}
  	}

  	function deleteLinkedFields($config) {
  		global $wpdb;
      
  		if(!is_numeric($config['scfui_boxes_id'])) {
  			return false;
  		}
  		
  		if($wpdb->query('DELETE FROM '.$wpdb->prefix.'scfui_fields WHERE scfui_boxes_id = "'.$wpdb->escape($config['scfui_boxes_id']).'"')) {
  			return true;
  		}else{
  			return false;
  		}
  	}

  	function deleteField($config) {
  		global $wpdb, $current_user;
      get_currentuserinfo();
      
      if(!$config['id'] || !is_numeric($config['id'])) {
      	return false;
      }
      
      if(!$field = $this->getField(array('id'=>$config['id']))) { //gotta get it
      	return false;
      }
        		
  		$save = array();
  		$save['deleted_by'] = $current_user->ID;
  		$save['date_deleted'] = date('Y-m-d H:i:s', time());
  		$save['deleted'] = 1;
  		
  		$format = array(
  			'%d',
  			'%s',
  			'%d'
  			);
  		
  		$where = array('id'=>$field['id']);
  		$whereFormat = array('%d');
  		
  		if($wpdb->update($wpdb->prefix.'scfui_fields', $save, $where, $format, $whereFormat)) {
  			if($config['delete_data']) {
  				//sorry, gonna get out the table manually, as getting all posts then looping through is retarded and... well... retarded
  				$meta = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'postmeta WHERE meta_key = "'.$wpdb->escape($field['slug']).'"', ARRAY_A);
  				foreach ((array)$meta as $key=>$val) {
						$wpdb->query('DELETE FROM '.$wpdb->prefix.'postmeta WHERE meta_id = '.$wpdb->escape($val['meta_id']));
					}

  			}
  			return true;
  		}else{
  			return false;
  		}
  	}
  	
  	// JSON APIs
  	function ajax_getTypesList() {
  		$json = new stdClass;
  		
  		$json->html = '';
  		$json->html .= '<select class="scfui-types-select">'; //classed not id as there may be more than 1
  		$json->html .= '<option value="">Choose Custom Field Type</option>';
  		foreach ((array)$this->types as $type=>$val) {
				$json->html .= '<option value="'.$type.'">'.$val->getName().'</option>';
			}
  		$json->html .= '</select>';
  		
  		$json->success = true;
  		
  		echo json_encode($json);
  		exit;
  	}
  	
  	function ajax_customFieldForm() {
  		$json = new stdClass;

  		if($form = $this->getCustomFieldForm($_GET['type'], $_GET['count'])) {
  			$json->success = true;
  			$json->html = $form;
  			$json->type_name = $this->types[$_GET['type']]->getName();
  		}else{
  			$json->success = false;
  		}
  		
  		echo json_encode($json);
  		exit;
  	}
	// }
	
	// Admin Side Functions {
		function adminInits() {
			$this->loadTypes();
			
			$boxes = $this->getBoxesList(array('getfields'=>true));
			
  		foreach ((array)$boxes as $key=>$val) {
  			add_meta_box('scfui-'.$val['id'], $val['title'], array(&$this, 'showMetaBox'), $val['type'], $val['context'], $val['priority'], array('box'=>$val));
			}
			
			add_action('save_post', array(&$this, 'saveCustomField'));
			
			//run any custom inits for the types
			foreach ((array)$this->types as $className=>$type) {
  			$type->adminInits();
  		}
  		
  		//add some js to the add/edit meta boxes
  		if($_GET['page'] == 'betta-boxes' && ($_GET['action'] == 'add-new-box' || $_GET['action'] == 'edit-box')) {
  			wp_enqueue_script('scfui-add-box', plugins_url('/js/add-box.js', __FILE__), array('jquery-ui-sortable'));
  		}
		}
		
		function showMetaBox($post, $args) {
			global $wpdb;
  		$fields = $this->getFieldsList(array('where'=>'scfui_boxes_id = '.$wpdb->escape($args['args']['box']['id'])));
  		foreach ((array)$fields as $key=>$val) {
  			$field = $this->types[$val['type']];
  			$field->showField($post, $val);
			}
  	}
		
		function adminMenus() {
			$pluginPage = add_options_page('Betta Boxes CMS', 'Betta Boxes', 'manage_options', 'betta-boxes', array(&$this, 'adminHome'));
			//add_action('admin_head-'.$pluginPage, array(&$this, 'adminHead'));
		}
		
		function adminHead() {
			//return; //_GET[noheader] (manual include of 'wp-admin/admin-header.php' seems no not run the hook required to call this: wp-admin/admin-header.php)
			/*
			echo '<script>
			var scfui_plugin_url = "'.$this->pluginUrl.'";
			var scfui_admin_url = "'.$this->adminUrl.'page='.$_GET['page'].'";
			</script>';
			
			echo "\n"; //can't hurt :)
			*/
  	}

		function adminHome() {
			switch($_GET['action']) {
			case 'add-new-box'	:	$this->adminAddBox();	break;
			case 'edit-box'	:	$this->adminAddBox($_GET['id']);	break;
			case 'get-types-list'	:	$this->ajax_getTypesList();	break;
			case 'custom-field-form'	:	$this->ajax_customFieldForm();	break;
			case 'delete-field'	:	$this->adminDeleteField($_GET['id']);	break;
			case 'delete-box'	:	$this->adminDeleteBox($_GET['id']);	break;
			default : $this->adminListBoxes(); break;
			}
  	}

  	function adminListBoxes() {
  		$boxes = $this->getBoxesList(array('getfields'=>true));
  		$types = get_post_types(array(), false);
  		
  		echo '<div class="wrap">';
  		echo '<h2>Meta Boxes <a href="'.$this->adminUrl.'page='.$_GET['page'].'&action=add-new-box" class="add-new-h2">Add New</a></h2>';
  		
  		/*
  		if(isset($_GET['deleted'])) { //the key is there
  			echo '<div class="updated">';
  			if($_GET['deleted']) {
  				echo '<p>Meta box deleted successfully</p>';
  			}else{
  				echo '<p>There was a problem deleting the meta box</p>';
  			}
  			echo '</div>';
  		}
  		*/
  		
  		if($boxes) {
  			echo '<table class="widefat">';
  			echo '<thead>';
  			echo '<tr>';
  			echo '<th>Title</th>';
  			echo '<th>Show on</th>';
  			echo '<th>No. Fields</th>';
  			echo '</tr>';
  			echo '</thead>';
  			echo '<tfoot>';
  			echo '<tr>';
  			echo '<th>Title</th>';
  			echo '<th>Show on</th>';
  			echo '<th>No. Fields</th>';
  			echo '</tr>';
  			echo '</tfoot>';
  			echo '<tbody>';
  			$cnt = 0;
  			foreach ((array)$boxes as $key=>$val) {
  				echo '<tr class="'.(($cnt % 2 == 0) ? 'alternate' : '').'">';
  				echo '<td>';
  				echo '<strong>'.htmlspecialchars($val['title']).'</strong>';
  				echo '<div class="row-actions">';
  				echo '<a href="'.$this->adminUrl.'page='.$_GET['page'].'&action=edit-box&id='.$val['id'].'">Edit</a> | ';
  				echo '<span class="delete"><a href="'.$this->adminUrl.'page='.$_GET['page'].'&action=delete-box&id='.$val['id'].'">Delete</a></span>';
  				echo '</div>';
  				echo '</td>';
  				echo '<td>'.$types[$val['type']]->labels->name.'</td>';
  				echo '<td>'.count($val['fields']).'</td>';
  				echo '</tr>';
  				$cnt++;
  			}
  			echo '</tbody>';
        echo '</table>';
  		}else{
  			echo '<p>No Meta Boxes setup yet. Click <a href="'.$this->adminUrl.'page='.$_GET['page'].'&action=add-new-box">Add New</a> to create one.</p>';
  		}
  		echo '</div>';
  	}
  	
  	function adminAddBox($edit=null) {
  		$types = get_post_types(array(), false);
  		
  		if($edit && is_numeric($edit)) {
  			$data = (array)$this->getBox(array('id'=>$edit, 'getfields'=>true));
  		}
  		
  		if($_POST['data']) {
  			$_POST['data'] = stripslashes_deep($_POST['data']);
  			if($_POST['fields']) {$_POST['fields'] = stripslashes_deep($_POST['fields']);}
  			
  			$err = array();
  			
  			if(!trim($_POST['data']['title'])) {
  				$err['title'] = 'Please enter a title';
  			}
  			
  			if(!$_POST['data']['type']) {
  				$err['type'] = 'Please select the post type to show this meta box on';
  			}
  			
  			foreach ((array)$_POST['fields'] as $key=>$val) {
  				if(!$this->types[$val['type']]) {
  					continue;
  				}
  				
  				$fieldsErr = array();
  				if(!trim($val['label'])) {
  					$fieldsErr['label'] = 'Please enter a label';
  				}
  				
  				if($this->checkSlug($val['slug'])) {
  					if($exists = $this->getField(array('slug'=>$val['slug'], 'allowdeleted'=>true))) {
  						if($exists['id'] != $val['id']) {
  							if($exists['deleted']) {
  								$fieldsErr['exists'] = 'The meta key <strong>'.$val['slug'].'</strong> was created and deleted already. You cannot duplicate even deleted slugs.';
  							}else{
  								$fieldsErr['exists'] = 'The meta key <strong>'.$val['slug'].'</strong> exists already';
  							}
  						}
  					}
  				}else{
  					$fieldsErr['slug'] = 'Please enter a valid meta key';
  				}
  				
  				//check for failer conditions on the selected field type
  				$fieldsErr = $this->types[$val['type']]->checkAddedField($fieldsErr, $val);
  				
  				if($fieldsErr) {
  					$_POST['fields'][$key]['err'] = $fieldsErr;
  					if(trim($val['label'])) {
  						$err['field-err-'.$key] = 'The <strong>'.$this->types[$val['type']]->getName().'</strong> custom field <strong>'.$val['label'].'</strong> has errors';
  					}else{
  						$err['field-err-'.$key] = 'An un-named <strong>'.$this->types[$val['type']]->getName().'</strong> custom field has errors';
  					}
  				}
				}
  			
  			if(!$err) {
  				$save = array(
  					'title'=>$_POST['data']['title'],
  					'type'=>$_POST['data']['type']
  					);
  				
  				if($data['id']) {
  					$save['id'] = $data['id'];
  					if($saved = $this->updateBox($save)) {
  						$this->deleteLinkedFields(array('scfui_boxes_id'=>$save['id']));
  						
  						$priority = 10;
  						foreach ((array)$_POST['fields'] as $key=>$val) {
  							$save = array(
  								'scfui_boxes_id'=>$data['id'],
  								'label'=>$val['label'],
  								'slug'=>$val['slug'],
  								'type'=>$val['type'],
  								'priority'=>$priority,
  								'extra'=>$this->types[$val['type']]->saveField($val)
  								);
  							
  							$this->createField($save);
  							$priority+=10;
							}
  						
  						wp_redirect($this->adminUrl.'page='.$_GET['page']);
  					}else{
  						$err['save-failed'] = 'There was a problem saving this item to the database, please try again in a moment.';
  					}
  				}else{
  					if($saved = $this->createBox($save)) {
  						$priority = 10;
  						foreach ((array)$_POST['fields'] as $key=>$val) {
  							$save = array(
  								'scfui_boxes_id'=>$saved,
  								'label'=>$val['label'],
  								'slug'=>$val['slug'],
  								'type'=>$val['type'],
  								'priority'=>$priority,
  								'extra'=>$this->types[$val['type']]->saveField($val)
  								);
  							
  							$this->createField($save);
  							$priority+=10;
							}
  						
  						wp_redirect($this->adminUrl.'page='.$_GET['page']);
  					}else{
  						$err['save-failed'] = 'There was a problem saving this item to the database, please try again in a moment.';
  					}
  				}
  			}
  			
  			if (isset($_GET['noheader'])) {require_once(ABSPATH.'wp-admin/admin-header.php');} //replace the header if we need output...
				
  			$data = array_merge((array)$data, (array)$_POST['data']);
  			$data['fields'] = $_POST['fields']; //dont merge, its a numberic indexed array!
  		}
  		
  		echo '<script>
			var scfui_plugin_url = "'.$this->pluginUrl.'";
			var scfui_admin_url = "'.$this->adminUrl.'page='.$_GET['page'].'";
			</script>';
			
  		echo '<link rel="stylesheet" href="'.$this->pluginUrl.'css/add-box.css" type="text/css" media="all" />';
  		echo '<div class="wrap">';
  		  		
  		if($data['id']) {
  			echo '<h2>Edit Meta Box</h2>';
  		}else{
  			echo '<h2>Add New Meta Box</h2>';
  		}
  		
  		if($_GET['deleted']) { //the key is there
  			echo '<div class="updated">';
  			echo '<p>Custom field deleted successfully</p>';
  			echo '</div>';
  		}
  		
  		if($err) {
  			echo '<div class="error">';
  			foreach ((array)$err as $key=>$val) {
					echo '<p><strong>ERROR:</strong> '.$val.'</p>';
				}
  			echo '</div>';
  		}
  		
  		if(!$data['id']) {
  			echo '<p>Create a new meta box linked to existing post types. Once the meta box has been created, you will be able to add custom fields to it.</p>';
  		}
  		
  		echo '<noscript>';
  		echo '<div class="error"><p>You need JavaScript enabled to use this. Please enable JavaScript and refresh the page.</p></div>';
  		echo '</noscript>';
  		
  		$url = $this->adminUrl.'page='.$_GET['page'].'&action='.$_GET['action'].'&noheader=true';
  		if($data['id']) {
  			$url .= '&id='.$data['id'];
  		}
  		
  		echo '<form method="POST" action="'.$url.'">';
  		echo '<table class="form-table">';
  		echo '<tbody>';
  		
  		echo '<tr class="form-field">';
  		echo '<th scope="row"><label for="data_title">Title <span class="description">(required)</span></label></th>';
  		echo '<td><input type="text" id="data_title" name="data[title]" value="'.htmlspecialchars($data['title']).'" /></td>';
  		echo '</tr>';
  		
  		echo '<tr>';
  		echo '<th scope="row"><label for="data_type">Show on Post Types <span class="description">(required)</span></label></th>';
  		echo '<td>';
  		echo '<select id="data_type" name="data[type]">';
  		echo '<option value="0">Choose Post Type</option>';
  		foreach ((array)$types as $key=>$type) {
  			if($type->show_ui) {
  				echo '<option value="'.$key.'" '.($data['type'] == $key ? 'selected="selected"' : '').'>'.$type->labels->name.'</option>';
  			}
  		}
  		echo '</td>';
  		echo '</tr>';
  		echo '</tbody>';
  		
  		echo '<tbody>';
  		
  		echo '<tr class="form-field">';
  		echo '<th scope="row"><label for="">Custom Fields<br /><span class="description">(Drag to re-order)</span></label></th>';
  		echo '<td>';
  		echo '<div id="scfui-fields-container">';
  				echo '<ul id="scfui-fields-list">'; //
  					$cnt = 0;
  					foreach ((array)$data['fields'] as $key=>$val) {
  						if($val['extra'] && is_string($val['extra'])) {
  							if(($extra = unserialize($val['extra'])) !== false) {
  								$val['extra'] = $extra;
  							}
  						}
  						echo '<li>';
  						
  						
  						echo '<div class="metabox-holder">';
  							echo '<div class="postbox">';
  								if($val['id']) {
  									echo '<div class="handlediv">';
  									echo '<a href="'.$this->adminUrl.'page='.$_GET['page'].'&action=delete-field&id='.$val['id'].'" class="scfui-field-delete" title="Delete custom field"><img = src="'.$this->pluginUrl.'images/delete.png" /></a>';
  									echo '</div>';
  								}else{
  									echo '<div class="handlediv">';
  									echo '<a href="#" class="scfui-field-delete"><img title="Delete custom field" src="'.$this->pluginUrl.'images/delete.png" /></a>';
  									echo '</div>';
  								}
  							
  								echo '<h3 class="hndle"><span>'.$this->types[$val['type']]->getName().'</span></h3>';
  								echo '<div class="inside">';
  									if($val['err']) {
  										echo '<div class="scfui-error">';
  										foreach ((array)$val['err'] as $inlineErr) {
  											echo '<p><strong>ERROR:</strong> '.$inlineErr.'</p>';
  										}
  										echo '</div>';
  									}
  									
  									echo $this->getCustomFieldForm($val['type'], $cnt, $val);
  								echo '</div>';
  							echo '</div>';
  						echo '</div>';
  						
  						echo '</li>';
  						$cnt++;
						}
  				echo '</ul>';
  				
  				echo '<a id="scfui-add-field" class="button-secondary" href="#" title=>Add Field</a>';
  			echo '</div>';
  		echo '</td>';
  		echo '</tr>';
  		
  		echo '</tbody>';
  		
  		echo '</table>';
  		
  		echo '<p class="submit">';
  		echo '<input type="submit" value="Save Meta Box " class="button-primary" name="createmetabox">';
  		echo '</p>';
  		
  		echo '</div>';
  		
  		//echo '<script src="'.$this->pluginUrl.'js/add-box.js"></script>';
  	}
  	
  	function adminDeleteField($delete) {
  		if(is_numeric($delete) && $delete) {
  			$field = $this->getField(array('id'=>$delete));
  		}
  		
  		if($field && $_POST['data']) {
  			$err = array();
  			if($gone = $this->deleteField(array('id'=>$field['id'], 'delete_data'=>$_POST['data']['delete_data']))) {
  				wp_redirect($this->adminUrl.'page='.$_GET['page'].'&action=edit-box&id='.$field['scfui_boxes_id'].'&deleted=1');
  			}else{
  				$err['delete-failed'] = 'There was a problem deleting the field. Please try again in a moment';
  			}
  			
				if (isset($_GET['noheader'])) {require_once(ABSPATH.'wp-admin/admin-header.php');} //replace the header if we need output...
  		}
  		
  		echo '<div class="wrap">';
  		echo '<h2>Delete Custom Field</h2>';
  		
  		if($err) {
  			echo '<div class="error">';
  			foreach ((array)$err as $key=>$val) {
					echo '<p><strong>ERROR:</strong> '.$val.'</p>';
				}
  			echo '</div>';
  		}

  		if($field) {
  			echo '<p>';
  			echo 'You are choosing to delete the following custom field: <strong>'.htmlspecialchars($field['label']).'</strong>';
  			echo '</p>';
  			
  			$url = $this->adminUrl.'page='.$_GET['page'].'&action='.$_GET['action'].'&id='.$_GET['id'].'&noheader=true';
  			echo '<form method="post" action="'.$url.'">';
  			echo '<fieldset>';
  			echo '<p><legend>What should be done with any data saved for this custom field</legend></p>';
  			
  			echo '<ul style="list-style:none;">';
  			echo '<li><label><input type="radio" checked="checked" value="1" name="data[delete_data]">Delete all data linked to all custom field.</label></li>';
  			
  			echo '<li><input type="radio" value="0" name="data[delete_data]""><label>Keep all linked data</label></li>';
  			echo '</ul>';
  			echo '</fieldset>';
  			
  			echo '<p class="submit">';
  			echo '<input type="submit" value="Confirm Deletion" class="button-primary" id="submit" name="submit"> ';
  			echo '<a href="'.$this->adminUrl.'page='.$_GET['page'].'&action=edit-box&id='.$field['scfui_boxes_id'].'" class="button-secondary">Back</a>';
  			echo '</p>';
  		}else{
  			echo '<p>There was a problem getting the correct field to delete. Please try again in a moment.</p>';
  		}
  		echo '</div>';
  	}
  	
  	function adminDeleteBox($delete) {
  		if(is_numeric($delete) && $delete) {
  			$box = $this->getBox(array('id'=>$delete, 'getfields'=>true));
  		}
  		
  		if($box && $_POST['data']) {
  			$err = array();
  			if($gone = $this->deleteBox(array('id'=>$box['id'], 'delete_data'=>$_POST['data']['delete_data']))) {
  				wp_redirect($this->adminUrl.'page='.$_GET['page']);
  			}else{
  				$err['delete-failed'] = 'There was a problem deleting the meta box. Please try again in a moment';
  			}
				if (isset($_GET['noheader'])) {require_once(ABSPATH.'wp-admin/admin-header.php');} //replace the header if we need output...
  		}

  		
  		echo '<div class="wrap">';
  		echo '<h2>Delete Meta Box</h2>';
  		
  		if($err) {
  			echo '<div class="error">';
  			foreach ((array)$err as $key=>$val) {
					echo '<p><strong>ERROR:</strong> '.$val.'</p>';
				}
  			echo '</div>';
  		}
  		
  		if($box) {
  			echo '<p>';
  			echo 'You are choosing to delete the meta box <strong>'.htmlspecialchars($box['title']).'</strong> that has the following custom fields:<br />';
  			foreach ((array)$box['fields'] as $key=>$val) {
					echo ' - '.$val['label'].' ('.$this->types[$val['type']]->getName().')<br />';
				}
  			echo '</p>';
  			
  			$url = $this->adminUrl.'page='.$_GET['page'].'&action='.$_GET['action'].'&id='.$_GET['id'].'&noheader=true';
  			echo '<form method="post" action="'.$url.'">';
  			echo '<fieldset>';
  			echo '<p><legend>What should be done with any data saved for any of the custom fields</legend></p>';
  			
  			echo '<ul style="list-style:none;">';
  			echo '<li><label><input type="radio" checked="checked" value="1" name="data[delete_data]">Delete all data linked to all these custom fields.</label></li>';
  			
  			echo '<li><input type="radio" value="0" name="data[delete_data]""><label>Keep all linked data</label></li>';
  			echo '</ul>';
  			echo '</fieldset>';
  			
  			echo '<p class="submit">';
  			echo '<input type="submit" value="Confirm Deletion" class="button-primary" id="submit" name="submit"> ';
  			echo '<a href="'.$this->adminUrl.'page='.$_GET['page'].'&action=edit-box&id='.$field['scfui_boxes_id'].'" class="button-secondary">Back</a>';
  			echo '</p>';
  		}else{
  			echo '<p>There was a problem getting the correct meta box to delete. Please try again in a moment.</p>';
  		}
  		echo '</div>';

  	}
	// }
}
global $scfui;
$scfui = new bettaBoxesCMS();
?>