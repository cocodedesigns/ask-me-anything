<?php
$form_mb = new Ama_WPAlchemy_MetaBox(array
(
	'id' => 'ama_form_meta',
	'title' => 'Configure Question Form',
	'types' => array('ama_post'), // added only for pages and to custom post type "ama_post"
	'context' => 'normal', // same as above, defaults to "normal"
	'priority' => 'high', // same as above, defaults to "high"
	'template' => plugin_dir_path(__FILE__) . 'question_form_meta.php'
));

$style_mb = new Ama_WPAlchemy_MetaBox(array
(
	'id' => 'ama_form_style',
	'title' => 'Configure Form Style',
	'types' => array('ama_styles'), // added only for pages and to custom post type "ama_styles"
	'context' => 'normal', // same as above, defaults to "normal"
	'priority' => 'high', // same as above, defaults to "high"
	'template' => plugin_dir_path(__FILE__) . 'question_style_meta.php'
));
?>