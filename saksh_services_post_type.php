<?php

// Register Custom Post Type
function saksh_service_post_type() {

	$labels = array(
		'name'                  => _x( 'Services', 'Post Type General Name', 'saksh' ),
		'singular_name'         => _x( 'Service', 'Post Type Singular Name', 'saksh' ),
		'menu_name'             => __( 'Saksh Services', 'saksh' ),
		'name_admin_bar'        => __( 'Post Type', 'saksh' ),
		'archives'              => __( 'Item Archives', 'saksh' ),
		'attributes'            => __( 'Item Attributes', 'saksh' ),
		'parent_item_colon'     => __( 'Parent Item:', 'saksh' ),
		'all_items'             => __( 'All Items', 'saksh' ),
		'add_new_item'          => __( 'Add New Item', 'saksh' ),
		'add_new'               => __( 'Add New', 'saksh' ),
		'new_item'              => __( 'New Item', 'saksh' ),
		'edit_item'             => __( 'Edit Item', 'saksh' ),
		'update_item'           => __( 'Update Item', 'saksh' ),
		'view_item'             => __( 'View Item', 'saksh' ),
		'view_items'            => __( 'View Items', 'saksh' ),
		'search_items'          => __( 'Search Item', 'saksh' ),
		'not_found'             => __( 'Not found', 'saksh' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'saksh' ),
		'featured_image'        => __( 'Featured Image', 'saksh' ),
		'set_featured_image'    => __( 'Set featured image', 'saksh' ),
		'remove_featured_image' => __( 'Remove featured image', 'saksh' ),
		'use_featured_image'    => __( 'Use as featured image', 'saksh' ),
		'insert_into_item'      => __( 'Insert into item', 'saksh' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'saksh' ),
		'items_list'            => __( 'Items list', 'saksh' ),
		'items_list_navigation' => __( 'Items list navigation', 'saksh' ),
		'filter_items_list'     => __( 'Filter items list', 'saksh' ),
	);
	$args = array(
		'label'                 => __( 'Service', 'saksh' ),
		'description'           => __( 'Post Type Description', 'saksh' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'services', $args );

}
add_action( 'init', 'saksh_service_post_type', 0 );