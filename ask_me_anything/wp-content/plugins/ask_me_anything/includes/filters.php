<?php 
/* This file contains all the filters */
add_filter('wp_mail_content_type', 'setHtmlEmailType');
add_filter('wp_insert_post_data', 'answerQuestionFilter', '99');
add_filter('manage_edit-ama_questions_columns', 'editAmaQuestionColumns');
add_filter('manage_edit-ama_post_columns', 'editAmaPostColumns');
add_filter('manage_edit-ama_questions_sortable_columns', 'amaQuestionsSortableColumns');
add_filter('wp_link_query_args', 'removeCustomPostTypesFromTinyMCELinkBuilder');
?>