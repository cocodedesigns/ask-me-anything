<?php 
/* This file contains all the actions */
add_action('init', 'createPostTypeAma');
add_action('init', 'createPostTypeAmaStyles');
add_action('init', 'createPostTypeAmaQuestions');
add_action('admin_bar_menu', 'removeAdminToolbarLink', 999);
add_action('admin_init', 'removeAdminSubmenuLinks');
add_action('admin_head', 'removeAdminAddNewButton');
add_action('widgets_init', 'registerAllWidgets');
add_action('admin_enqueue_scripts', 'adminAmaScriptsAndStyles');
add_action('wp_ajax_nopriv_submitClientForm', 'submitClientForm');
add_action('wp_ajax_submitClientForm', 'submitClientForm');
add_action('edit_form_after_title', 'formatSubmissionPost');
add_action('manage_ama_questions_posts_custom_column', 'manageAmaQuestionColumns', 10, 2);
add_action('manage_ama_post_posts_custom_column', 'manageAmaFormColumns', 10, 2);
add_action('admin_menu', 'FAQPage');
?>