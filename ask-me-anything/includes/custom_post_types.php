<?php 
/* This file contains all custom post types to be registered */
function createPostTypeAma() {
	register_post_type('ama_post',
		array(
			'labels' => array(
				'menu_name' => __('Ask Me Anything'),
				'name' => __('Manage Forms'),
				'singular_name' => __('Ask Me Anything'),
				'all_items' => __('Manage Forms'),
				'add_new' => __('New Form'),
				'add_new_item' => __('New Form'),
				'edit_item' => __('Edit Form'),
			),
		'public' => true,
		'has_archive' => false,
		'exclude_from_search' => true,
		'menu_icon' => 'dashicons-format-status',
		'supports'	=> array('title')
		)
	);
}

function createPostTypeAmaStyles() {
	register_post_type('ama_styles',
		array(
			'labels' => array(
				'menu_name' => __('Ask Me Anything'),
				'name' => __('Manage Styles'),
				'singular_name' => __('Ask Me Anything'),
				'all_items' => __('Manage Styles'),
				'add_new' => __('New Style'),
				'add_new_item' => __('New Style'),
				'edit_item' => __('Edit Style'),
			),
		'public' => true,
		'has_archive' => false,
		'exclude_from_search' => true,
		'supports'	=> array('title'),
		'show_in_menu' => 'edit.php?post_type=ama_post'
		)
	);
}

function createPostTypeAmaQuestions() {
	register_post_type('ama_questions',
		array(
			'labels' => array(
				'menu_name' => __('Ask Me Anything'),
				'name' => __('Manage Questions'),
				'singular_name' => __('Ask Me Anything'),
				'all_items' => __('Manage Questions'),
				'edit_item' => __('Answer Question'),
			),
		'public' => true,
		'has_archive' => false,
		'exclude_from_search' => true,
		'supports'	=> array('editor'),
		'show_in_menu' => 'edit.php?post_type=ama_post'
		)
	);
}
?>