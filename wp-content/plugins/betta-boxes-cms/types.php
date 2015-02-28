<?php
class scfui_type {
	function scfui_type() {
	}
	
	//can be used to hook into the admin_init hook
	function adminInits() {
	}
	
	public function getName() {
		return 'PLEASE DEFINE PUBLIC FUNCTION getName()';
	}

	//used to add extra options when creating/editing a custom field
	public function addField($data=null) {
	}
	
	//check field options for errs when adding/editing
	public function checkAddedField($err) {
		return $err;
	}
	
	//save the extra info from this->addField
	public function saveField($data) {
		return serialize(array());
	}

	//save the post_meta value
	public function saveCustomField($val) {
		return $val;
	}
}
?>