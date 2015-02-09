<?php 
class AmaWidget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'ama_widget', // Base ID
			__('Ask Me Anything'), // Name
			array('description' => __('Customize the link or button that opens the modal window.'),) // Args
		);

		$ama_base_path = plugin_dir_path(__FILE__) . '/ask_me_anything.php';
		wp_enqueue_script('ask_me_anything_scripts', plugins_url('../js/ama_admin_scripts.js', $ama_base_path), array('wp-color-picker'), false, true);
		wp_enqueue_style('wp-color-picker');
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
		$title = apply_filters('widget_title', $instance['title'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) ){
			echo $args['before_title'] . $title . $args['after_title'];
		}

		if (!empty($instance['body'])) {
			echo '<p>' . nl2br($instance['body']) . '</p>';
			echo '<button class="ama_trigger" data-modal-target="' . $instance['form_id'] . '" style="color:' . $instance['button_text_color'] . '; background:' . $instance['button_color'] . ';">' . $instance['button_text'] . '</button>';
		}

		echo $args['after_widget'];
		new AmaForm($instance['form_id']);
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		$title = (isset($instance['title']) ? $instance['title'] : __('Ask Me Anything'));
		$button_text = (isset($instance['button_text']) ? $instance['button_text'] : __('Open Modal'));
		$forms = getUserForms();
		?>
		<?php if (!empty($forms)) {?>
		<p>
			<label for="<?php echo $this->get_field_id('form_id'); ?>"><?php _e('Choose a form:'); ?></label> 
			<select class="widefat" id="<?php echo $this->get_field_id('form_id'); ?>" name="<?php echo $this->get_field_name('form_id'); ?>">
			<?php 
				foreach ($forms as $form) {
					echo '<option value="' . $form->ID. '" ' . ((int)$instance['form_id'] === $form->ID ? 'selected="selected"' : ''). '>' . $form->post_title . '</option>';
				}
			?>
			</select>
		</p>
		<?php }  else { ?>
		<p id="ama_info">You haven't created any forms yet!<br><a href="post-new.php?post_type=ama_post">Create your first form &raquo;</a></p>
		<p>&nbsp;</p>
		<?php return; } ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('body'); ?>"><?php _e('Body:'); ?><br><small>(this can be some informative message that comes before the modal button)</small></label>
			<textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('body'); ?>" name="<?php echo $this->get_field_name('body'); ?>"><?php echo (!empty($instance['body']) ? esc_attr($instance['body']) : ''); ?></textarea>
		</p>
		<hr>
		<p class="ama_modal_launch_btn_wrap">
			<?php 
				$styles = 'style="color:' . $instance['button_text_color'] . '; background:' . $instance['button_color'] . ';"';
			?>
			<label for=""><?php _e('Button preview:'); ?></label> 
			<button class="ama_modal_launch_btn" id="preview_button_<?php echo $this->number; ?>" <?php echo $styles; ?>><?php echo (!empty($button_text) ? esc_attr($button_text) : 'Open Modal'); ?></button>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('button_text'); ?>"><?php _e('Button text:'); ?></label> 
			<input class="widefat" id="button_text_<?php echo $this->number; ?>" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo (!empty($button_text) ? esc_attr($button_text) : 'Open Modal'); ?>" data-node-map="button_text">
		</p>
		<div class="row color">
			<p><?php _e('Button color:'); ?> </p>
			<input type="text" id="<?php echo $this->get_field_id('button_color'); ?>" name="<?php echo $this->get_field_name('button_color'); ?>" value="<?php echo $instance['button_color']; ?>" class="custom_color_field_widget" data-node-map="button_color_<?php echo $this->number; ?>" data-default-color="#E3E3E3">
		</div>
		<div class="row color">
			<p><?php _e('Button text color:'); ?> </p>
			<input type="text" id="<?php echo $this->get_field_id('button_text_color'); ?>" name="<?php echo $this->get_field_name('button_text_color'); ?>" value="<?php echo $instance['button_text_color']; ?>" class="custom_color_field_widget" data-node-map="button_text_color_<?php echo $this->number; ?>" data-default-color="#333333">
		</div>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$attributes = array('form_id','title', 'body', 'button_color', 'button_text_color', 'button_text');
		foreach ($attributes as $value) {
			$instance[$value] = (!empty($new_instance[$value])) ? strip_tags( $new_instance[$value]) : '';
		}
		return $instance;
	}
}
?>