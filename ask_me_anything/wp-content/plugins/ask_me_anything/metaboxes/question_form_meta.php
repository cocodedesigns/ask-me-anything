<?php
	global $pagenow;
	//If the post has already been saved, show shortcode box info
	if ($pagenow === 'post.php') {
?>
<div id="code_copy">
    <table>
        <tbody>
            <tr>
                <td>
                    <div class="wrapper">
                    	<select name="change_shortcode" id="change_shortcode" class="alignright">
                    		<option value="form">Form Shortcode</option>
                    		<option value="discussion">Discussion Shortcode</option>
                    	</select>
                        <h3>Shortcode</h3>
                        <div id="shortcode_copy_form">
                        	<p>Copy and paste this shortcode into a page or post to display the modal link within the post content.
							<br>
							Replace <strong>CLICK ME</strong> with anything you want to have trigger the modal window.</p>
							<pre>
								<p>[ama_form id="<?php echo $post->ID; ?>"]CLICK ME![/ama_form]</p>
							</pre>	
                        </div>
                        <div id="shortcode_copy_discussion">
                        	<p>Copy and paste this shortcode into a page or post to display all published questions and answers for this form.</p>
							<pre>
								<p>[ama_discussion id="<?php echo $post->ID; ?>"]</p>
							</pre>	
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?php } ?>
<div class="my_meta_control">
	<p id="ama_info">All forms will have two default fields that cannot be removed. They capture the email address and the question being asked. They will be appended to the end of your form.</p>
	<hr>
	<h4>Select Theme</h4>
	<p>Choose a saved theme or <a href="post-new.php?post_type=ama_styles">make a new one</a>.</p>
	<?php 
		$metabox->the_field('theme_style'); 
		$custom_styles = getUserStyles();
	?>
	<select name="<?php $metabox->the_name(); ?>">
		<option value="0" <?php echo ((int)$metabox->get_the_value() === 0 ? 'selected="selected"' : ''); ?>>Default</option>
		<?php 
			if (!empty($custom_styles)) { 
				echo '<optgroup label="Your Themes">';
				foreach ($custom_styles as $theme) {
					echo '<option value="' . $theme->ID. '" ' . ((int)$metabox->get_the_value() === $theme->ID ? 'selected="selected"' : ''). '>' . (empty($theme->post_title) ? 'No Title' : $theme->post_title) . '</option>';
				}
				echo '</optgroup>';
			}
		?>
	</select>
	
	<h4>Notification Email</h4>
	<p>Send an email notification when a question is submitted.</p>
	<?php $mb->the_field('notification_email'); ?>
	<input type="checkbox" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="1" <?php echo ($mb->get_the_value() === '1' ? 'checked' : ''); ?>>
	<label for="<?php $mb->the_name(); ?>">
		Send Email to <strong><?php echo get_option('admin_email');?></strong>
	</label>
	
	<h4>Success Action</h4>
	<p>Choose what happens to the user when a question is submitted.</p>
	<?php $mb->the_field('redirect'); ?>
	<input type="radio" name="<?php $mb->the_name(); ?>" id="redirect" value="redirect" <?php echo ($mb->get_the_value() === 'redirect') ?' checked="checked"' : ''; ?>>
	<label for="redirect">Redirect to page or post</label>
	
	<input type="radio" name="<?php $mb->the_name(); ?>" id="redirect_url" value="redirect_url"<?php echo ($mb->get_the_value() === 'redirect_url') ?' checked="checked"' : ''; ?>>
	<label for="redirect_url">Redirect to external URL</label>
	
	<input type="radio" name="<?php $mb->the_name(); ?>" id="no_redirect" value="no_redirect"<?php echo ($mb->get_the_value() === 'no_redirect') ?' checked="checked"' : ''; ?>>
	<label for="no_redirect">Don't redirect</label>

	
	<div id="redirect_page_post">
		<h4>Choose a page or post</h4>
		<?php 
			$posts_array = get_posts(array('post_per_page' => 999999999, 'post_type' => array('post', 'page')));
			if (!empty($posts_array)) {
		?>
		<select name="<?php $mb->the_name('redirect_page_post'); ?>">
			<?php foreach($posts_array as $inner){?>
			<option value="<?php echo $inner->ID; ?>" <?php echo ($mb->get_the_value('redirect_page_post') == $inner->ID ? 'selected="selected"' : ''); ?>><?php echo $inner->post_title;?></option>
			<?php } ?>
		</select>
		<?php } else {
			echo '<p>You don\'t have any posts or pages to redirect to!</p>';
		}?>
	</div>
	
	<div id="redirect_external">
		<h4>Choose a URL to redirect to</h4>
		<input type="text" id="redirect_external_url" name="<?php $mb->the_name('redirect_external_url'); ?>" value="<?php echo $mb->get_the_value('redirect_external_url');?>">
	</div>
	
	<div class="captcha">
		<?php $mb->the_field('captcha'); ?>
		<input type="checkbox" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="1" <?php echo ($mb->get_the_value() === '1' || $pagenow === 'post-new.php' ? 'checked' : ''); ?>>
		<label for="<?php $mb->the_name(); ?>">Use hidden CAPTCHA</label>
	</div>
		
	<h4>Form Fields</h4>
	<p>Add fields to your question form below. Drag and drop the fields to change the order on your form.</p>
	<?php 
		$fields_key = 'fields';
		while($mb->have_fields_and_multi($fields_key)): ?>
	<?php $mb->the_group_open(); ?>
		<?php $mb->the_field('field_type'); ?>
		<select name="<?php $mb->the_name(); ?>" data-id="select_type">
			<option value="">--Field Type--</option>
			<option value="text" <?php echo ($mb->get_the_value() === 'text' ? 'selected="selected"' : ''); ?>>Text</option>
			<option value="radio" <?php echo ($mb->get_the_value() === 'radio' ? 'selected="selected"' : ''); ?>>Radio</option>
			<option value="checkbox" <?php echo ($mb->get_the_value() === 'checkbox' ? 'selected="selected"' : ''); ?>>Checkbox</option>
			<option value="select" <?php echo ($mb->get_the_value() === 'select' ? 'selected="selected"' : ''); ?>>Select Dropdown</option>
			<option value="textarea" <?php echo ($mb->get_the_value() === 'textarea' ? 'selected="selected"' : ''); ?>>Textarea</option>
			<option value="url" <?php echo ($mb->get_the_value() === 'url' ? 'selected="selected"' : ''); ?>>Website URL</option>
			<option value="phone" <?php echo ($mb->get_the_value() === 'phone' ? 'selected="selected"' : ''); ?>>Phone Number</option>
		</select>
		<a href="" class="toggle_fields open"></a>
		<a href="" class="dodelete button fr">Remove Field</a>
		<div class="field_container type_text">
			<?php $mb->the_field('text_field_title'); ?>
			<label for="<?php $mb->the_name(); ?>">Field Label</label>
			<input type="text" name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php echo $mb->get_the_value();?>">
			
			<?php $mb->the_field('type_text_required'); ?>
			<input type="checkbox" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="1" <?php echo ($mb->get_the_value() === '1' ? 'checked' : ''); ?>>
			<label for="<?php $mb->the_name(); ?>">Required</label>
		</div>

		<div class="field_container type_radio">
			<?php $mb->the_field('radio_field_title'); ?>
			<label for="<?php $mb->the_name(); ?>">Field Label</label>
			<input type="text" name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php echo $mb->get_the_value();?>">
			
			<?php $mb->the_field('type_radio_required'); ?>
			<input type="checkbox" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="1" <?php echo ($mb->get_the_value() === '1' ? 'checked' : ''); ?>>
			<label for="<?php $mb->the_name(); ?>">Required</label>
			
			<?php $mb->the_field('type_radio_textarea'); ?>
			<div class="nl">
				<label for="<?php $mb->the_name(); ?>">
					Each selection option choice should be on a new line. Format each choice as <strong>key|value</strong> pairs, where <strong>value</strong> is what you're showing the user and <strong>key</strong> is what is captured when the form is submitted. <small class="example">(show example)</small>
				</label>
				<textarea name="<?php $mb->the_name(); ?>" value="<?php echo $mb->get_the_value(); ?>"><?php echo $mb->get_the_value(); ?></textarea>
			</div>
		</div>
		
		<div class="field_container type_checkbox">
			<?php $mb->the_field('checkbox_field_title'); ?>
			<label for="<?php $mb->the_name(); ?>">Field Label</label>
			<input type="text" name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php echo $mb->get_the_value();?>">
			
			<?php $mb->the_field('type_checkbox_required'); ?>
			<input type="checkbox" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="1" <?php echo ($mb->get_the_value() === '1' ? 'checked' : ''); ?>>
			<label for="<?php $mb->the_name(); ?>">Required</label>
			
			<?php $mb->the_field('type_checkbox_textarea'); ?>
			<div class="nl">
				<label for="<?php $mb->the_name(); ?>">
					Each selection option choice should be on a new line. Format each choice as <strong>key|value</strong> pairs, where <strong>value</strong> is what you're showing the user and <strong>key</strong> is what is captured when the form is submitted. <small class="example">(show example)</small>
				</label>
				<textarea name="<?php $mb->the_name(); ?>" value="<?php echo $mb->get_the_value(); ?>"><?php echo $mb->get_the_value(); ?></textarea>
			</div>
		</div>
		
		<div class="field_container type_select">
			<?php $mb->the_field('select_field_title'); ?>
			<label for="<?php $mb->the_name(); ?>">Field Label</label>
			<input type="text" name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php echo $mb->get_the_value();?>">
			
			<?php $mb->the_field('type_select_required'); ?>
			<input type="checkbox" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="1" <?php echo ($mb->get_the_value() === '1' ? 'checked' : ''); ?>>
			<label for="<?php $mb->the_name(); ?>">Required</label>
			
			<div class="nl">
				<?php $mb->the_field('type_select_textarea'); ?>
				<label for="<?php $mb->the_name(); ?>">
					Each selection option choice should be on a new line. Format each choice as <strong>key|value</strong> pairs, where <strong>value</strong> is what you're showing the user and <strong>key</strong> is what is captured when the form is submitted. <small class="example">(show example)</small>
				</label>
				<textarea name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php echo $mb->get_the_value(); ?>"><?php echo $mb->get_the_value(); ?></textarea>
			</div>
		</div>
		
		<div class="field_container type_textarea">
			<?php $mb->the_field('textarea_field_title'); ?>
			<label for="<?php $mb->the_name(); ?>">Field Label</label>
			<input type="text" name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php echo $mb->get_the_value();?>">
			
			<?php $mb->the_field('type_textarea_required'); ?>
			<input type="checkbox" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="1" <?php echo ($mb->get_the_value() === '1' ? 'checked' : ''); ?>>
			<label for="<?php $mb->the_name(); ?>">Required</label>
		</div>
		
		<div class="field_container type_url">
			<?php $mb->the_field('url_field_title'); ?>
			<label for="<?php $mb->the_name(); ?>">Field Label</label>
			<input type="text" name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php echo $mb->get_the_value();?>">
			
			<div class="nl">
				<?php $mb->the_field('type_url_required'); ?>
				<input type="checkbox" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="1" <?php echo ($mb->get_the_value() === '1' ? 'checked' : ''); ?>>
				<label for="<?php $mb->the_name(); ?>">Required</label>
				
				<?php $mb->the_field('type_url_validate'); ?>
				<input type="checkbox" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="1" <?php echo ($mb->get_the_value() === '1' ? 'checked' : ''); ?>>
				<label for="<?php $mb->the_name(); ?>">Validate URL</label>
			</div>
		</div>
		
		<div class="field_container type_phone">
			<?php $mb->the_field('phone_field_title'); ?>
			<label for="<?php $mb->the_name(); ?>">Field Label</label>
			<input type="text" name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php echo $mb->get_the_value();?>">
			
			<div class="nl">
				<?php $mb->the_field('type_phone_required'); ?>
				<input type="checkbox" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="1" <?php echo ($mb->get_the_value() === '1' ? 'checked' : ''); ?>>
				<label for="<?php $mb->the_name(); ?>">Required</label>
				
				<?php $mb->the_field('type_phone_validate'); ?>
				<input type="checkbox" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="1" <?php echo ($mb->get_the_value() === '1' ? 'checked' : ''); ?>>
				<label for="<?php $mb->the_name(); ?>">Validate Phone Number <small>(US Only)</small></label>
			</div>
		</div>
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>

	<div id="field_actions">
		<p class="fl">
			<a href="#" class="docopy-<?php echo $fields_key; ?> button">Add New Field</a>
		</p>
		<p class="fr">
			<a href="#" class="dodelete-<?php echo $fields_key; ?> button remove_all">Remove All Fields</a>
		</p>
	</div>
	
</div>