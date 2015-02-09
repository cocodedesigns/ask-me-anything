<?php 
/**
 * Retuns JSON encoded results to the caller ajax function. In this case, the client side AMA forms
 * @return [NA] [see wp_send_json: http://codex.wordpress.org/Function_Reference/wp_send_json]
 */
function submitClientForm() {
	//Break the payload into an array
	parse_str($_POST['payload'], $post_array);

	//Either spam or some other funky stuff going on with the post data. Exit here.
	//Note to future self :: 'g0A_egax3f-u' is the spam input field name
	if (empty($post_array) || $post_array['g0A_egax3f-u'] !== '') {
		wp_send_json(false);
	}

	foreach ($post_array as $key => $value) {
		if(is_array($value)) {
			continue;
		}
		$post_array[$key] = wp_strip_all_tags($value);
	}

	//Process the form
	//Move submission meta data into a new array for later use
	$submit_actions = array(
		'redirect_type'			=>		$post_array['redirect_type'],
		'redirect_to_post'		=>		$post_array['redirect_to_post'],
		'redirect_external_url'	=>		$post_array['redirect_external_url'],
		'notify_admin'			=>		$post_array['notify_admin']
	);

	//Unset submission meta data before we add this post that are not from the user input
	unset(
		$post_array['g0A_egax3f-u'],
		$post_array['redirect_type'],
		$post_array['redirect_to_post'],
		$post_array['redirect_external_url'],
		$post_array['notify_admin']
	);

	$post_args = array(
	  'post_title'    	=>	$post_array['email'],
	  'post_status'   	=>	'draft',
	  'post_type'	  	=>	'ama_questions',
	);	

	//Insert the post into the database as draft until admin answers it
	$new_post = wp_insert_post($post_args, true);
	if (!is_wp_error($new_post)) {
		//Where do we send the user after submit?
		$return_array = array();
		if ($submit_actions['redirect_type'] === 'redirect') {
			//Page or post
			$return_array['redirect'] = get_the_permalink($submit_actions['redirect_to_post']);
		} else if ($submit_actions['redirect_type'] === 'redirect_url') {
			//External URL
			$return_array['redirect'] = $submit_actions['redirect_external_url'];
		} else {
			//Nowhere
			$return_array['redirect'] = false;
		} 

		if (!empty($submit_actions['notify_admin'])) {
			// Send the admin mail
			questionSubmissionNotification($post_array, $new_post);
		}

		//Add user input form fields as meta data to this post
		foreach ($post_array as $meta_key => $meta_value) {
			if (!empty($meta_value)) {
				add_post_meta($new_post, $meta_key, $meta_value);
			}
		}
	} else {
		echo $new_post->get_error_message();
	}
	wp_send_json($return_array);
}
?>