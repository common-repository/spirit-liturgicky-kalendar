<?php

//Register Widget
add_action('widgets_init', 'tsslk_register_lit_kalendar_widget');

function tsslk_register_lit_kalendar_widget()	{
	
	register_widget('tsslk_lit_kalendar_widget');
}

class tsslk_lit_kalendar_widget extends WP_Widget {
 //process our new widget

	public function __construct() {
		$widget_ops = array(
		'classname' => 'tsslk_lit_kalendar_widget',
		'description' => 'Liturgický kalendár');
		parent::__construct('tsslk_lit_kalendar_widget', 'Liturgický kalendár', $widget_ops);
	}

	public function form($instance) {
	// widget form in admin dashboard
	}

	public function update($new_instance, $old_instance) {
	// save widget options
	}
	
	public function widget($args, $instance) {
		
		//Function to retrieve block UI
		tsslk_get_block_code();
	}
}