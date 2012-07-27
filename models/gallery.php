<?php
class SatelliteGallery extends SatelliteDbHelper {
	var $table;
	var $model = 'Gallery';
	var $controller = "galleries";
	var $plugin_name = SATL_PLUGIN_NAME;
	var $data = array();
	var $errors = array();
	var $fields = array(
		'id'			=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'title'			=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'description'		=>	"TEXT",
		'image'			=>	"VARCHAR(75) NOT NULL DEFAULT ''",
		'type'			=>	"VARCHAR(40) NOT NULL DEFAULT ''",
                'caption_disable'       =>      "BOOLEAN NOT NULL DEFAULT FALSE",
		'order'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'		=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'		=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'			=>	"PRIMARY KEY  (`id`)",
	);
	function SatelliteGallery($data = array()) {
		global $wpdb;
                
		//$this -> table = $wpdb -> prefix . strtolower($this -> pre) . "_" . $this -> controller;
                $this -> table = $wpdb -> prefix . "satl_" . $this -> controller;
		$this -> check_table($this -> model);
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = $dval;
			}
		}
	
		return true;
	}
	function defaults() {
		$defaults = array(
                    'order'		=>	0,
                    'created'		=>	SatelliteHtmlHelper::gen_date(),
                    'modified'          =>	SatelliteHtmlHelper::gen_date(),
		);
		
		return $defaults;
	}
	function validate($data = null) {
		$this -> errors = array();
	
		if (!empty($data)) {
			$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
			
			foreach ($data as $dkey => $dval) {
				$this -> data -> {$dkey} = stripslashes($dval);
			}
			
			extract($data, EXTR_SKIP);
			
			if (empty($title)) { $this -> errors['title'] = __('Please enter a title', SATL_PLUGIN_NAME); }
			//if (empty($description)) { $this -> errors['description'] = __('Please fill in a description', SATL_PLUGIN_NAME); }
			if (empty($type)) { $this -> errors['type'] = __('Please select a gallery type', SATL_PLUGIN_NAME); }
			//if (empty($section)) { $section = '1'; }
			
			elseif ($type == "customslides") {
			} 
                        elseif ($type == "wordpressimages") {
			}
		} else {
			$this -> errors[] = __('No data was posted', SATL_PLUGIN_NAME);
		}
		return $this -> errors;
	}
        function latestSection() {
            global $wpdb;
            $this -> table = $wpdb -> prefix . "satl_galleries";
            $latest = $this -> find(null,'id');
            return $latest -> id;
        }
        
}
?>