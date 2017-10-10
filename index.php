<?php
	/*
	Plugin Name:    Admin Columns - Filtering repeater fields
	Plugin URI:     https://kamilgrzegorczyk.com
	Description:    Handling filtering for custom repeater fields
	Version:        1.0
	Author:         Kamil Grzegorczyk
	Author URI:     https://kamilgrzegorczyk.com
	*/

	//Registering the column for free version of the plugin. You won't be able to use filtering though!
	add_action( 'ac/column_types', function ( AC_ListScreen $list_screen ) {

		// Use the type: 'post', 'user', 'comment' or 'media'.
		if ( 'post' === $list_screen->get_group() ) {
			require_once plugin_dir_path( __FILE__ ) . 'ac-column-assigned_products.php';
			$list_screen->register_column_type( new AC_Column_Assigned_Products() );
		}
	});

	//Registering the column for PRO version of the plugin
	add_action( 'acp/column_types', function ( AC_ListScreen $list_screen ) {

		// Use the type: 'post', 'user', 'comment' or 'media'.
		if ( 'post' === $list_screen->get_group() ) {
			require_once plugin_dir_path( __FILE__ ) . 'ac-column-assigned_products.php';
			require_once plugin_dir_path( __FILE__ ) . 'acp-column-assigned_products.php';
			$list_screen->register_column_type( new ACP_Column_Assigned_Products );
		}
	});
