<?php 
class AmaForm {
	private $form_id;
	private $cache;
	private $mustache;
	static $scripts_loaded = false;
	
	function __construct($form_id) {
		$this->form_id = $form_id;
		$this->cache = new Filecache();
		$this->mustache = new Mustache_Engine(array(
		    'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/')
		));
		$this->renderForm();
	}
	
	/**
	 * Add required scripts and styles to the document
	 * @param  boolean 		$custom_styles	 If custom styles are required for this form
	 * @return NA       	
	 */
	public function enqueueScriptsAndStyles($custom_styles = false) {
		//Only enqueue base scripts and styles on the first instance
		if (AmaForm::$scripts_loaded === false) {
			$ama_base_path = plugin_dir_path(__FILE__) . '/ask_me_anything.php';
			wp_enqueue_script('ama_jquery_validate', '//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js', array('jquery'), '1.13.0', true);
			wp_enqueue_script('ama_client_scripts', plugins_url('../js/ama_client_scripts.js', $ama_base_path), array('jquery', 'ama_jquery_validate'), false, true);
			wp_enqueue_style('ama_client_styles', plugins_url('../css/ama_client_base_styles.css', $ama_base_path));
			
			//Add the page overlay div once
			echo '<div id="ama_page_overlay"></div>';
			//Scripts have been written to the page
			AmaForm::$scripts_loaded = true;
		}

		//Adding custom styles
		if ($custom_styles !== false) {
			$this->cache->set('ama_' . $this->form_id . $custom_styles . '_styles.css', $custom_styles);
			file_put_contents(__DIR__ . '/../css/ama_client_styles_' . $this->form_id . '.css', $this->cache->get('ama_' . $this->form_id . $custom_styles . '_styles.css'));
			wp_register_style('ama_client_styles_form_' . $this->form_id, plugins_url('ask_me_anything/css/ama_client_styles_' . $this->form_id . '.css'));
			wp_enqueue_style('ama_client_styles_form_' . $this->form_id);
		}
	}
	
	/**
	 * Get all data about how to display and style this form
	 *
	 * @param	NA
	 * @return	Array	An array containing all the form details
	 */
	public function getFormData() {
		//Get form field data
		$form_field_data = get_post_meta($this->form_id, 'ama_form_meta', true);
		$form_field_data['form_id'] = $this->form_id;
		$form_field_data['close_icon'] = plugins_url('', __FILE__) . '/../images/icon_close.png';

		//Is this a real form?
		if(empty($form_field_data)) {
			echo 'Invalid Ask Me Anything form ID!';
			return;
		}
		
		//Get form style data
		$form_styles = get_post_meta($form_field_data['theme_style'], 'ama_form_style', true);
		
		//Add the title
		$form_field_data = array('title' => get_the_title($this->form_id)) + $form_field_data;
		
		//Assume this form has not style associated with it
		//Add submit button text
		$form_field_data['submit_button_text'] = 'Submit';

		//Convert form styles into CSS properties
		$form_css = false;
		
		if ($form_styles !== false) {
			$form_field_data = array('submit_button_text' => $form_styles['button_text']) + $form_field_data;

			//Convert form styles into CSS properties
			$form_css = $this->_convertKeysToCSS($form_styles);
		}


		//Before we add markup to our form fields, append email and question static form values
		//This really sucks, and should be fixed up in later revisions to be configurable
		$form_field_data['fields'][] = array(
			'field_type'	=>	'email',
			'field_title'	=>	'Email Address',
		);
		$form_field_data['fields'][] = array(
			'field_type'	=>	'question',
			'field_title'	=>	'What\'s your question',
		);

		$form_data = array(
			'data' => $this->_addMustacheLambdas($form_field_data),
			'css' => $form_css
		);
		//dd($form_field_data);
		return $form_data;
	}
	
	/**
	 * Creates and appends the markup for this form
	 *
	 * @param	Array 		$form_data_arr	An array holding both field and style data
	 * @return	String 		NA 				Writes the modal window markup to the page
	 */
	public function renderForm() {
		$form_data_arr = $this->getFormData();
		$this->enqueueScriptsAndStyles($form_data_arr['css']);

		$modal_template = $this->mustache->loadTemplate('modal');

		echo $modal_template->render($form_data_arr['data']);
	}
	
	/**
	 * Add lambda filtering functions to field types so we render the correct form field type
	 *
	 * @param	Array 		$form_data_arr		An array holding field data
	 * @return	Array 		$form_data_arr		An array with HTML formatting for the fields
	 */
	private function _addMustacheLambdas($form_data_arr) {
		foreach ($form_data_arr['fields'] as $key => $value) {
			//Keep track of the index key as well
			$form_data_arr['fields'][$key]['idx'] = $key;
			
			//Mark required fields
			$required_flag = '';
			foreach ($value as $arr_key_name => $val) {
				if (strpos($arr_key_name, '_required') !== false) {
					$required_flag = 'required';
					break;
				}
			}

			switch($form_data_arr['fields'][$key]['field_type']){
				case 'text':
					$form_data_arr['fields'][$key]['field_title'] = $form_data_arr['fields'][$key]['text_field_title'];
					$form_data_arr['fields'][$key]['field_input'] = '<input type="text" value="" name="' . sanitize_title($form_data_arr['fields'][$key]['field_title']) . '" id="form_field_' . $key . '" ' . $required_flag . '>';
				break;
				case 'textarea':
					$form_data_arr['fields'][$key]['field_title'] = $form_data_arr['fields'][$key]['textarea_field_title'];
					$form_data_arr['fields'][$key]['field_input'] = '<textarea value="" id="form_field_' . $key . '" name="' . sanitize_title($form_data_arr['fields'][$key]['field_title']) . '" ' . $required_flag .'></textarea>';
				break;
				case 'select':
					$form_data_arr['fields'][$key]['field_title'] = $form_data_arr['fields'][$key]['select_field_title'];

					//Select options
					$options = explode(PHP_EOL, $form_data_arr['fields'][$key]['type_select_textarea']);
					$form_data_arr['fields'][$key]['field_input'] = function() use ($key, $options, $form_data_arr, $required_flag){
						$input = '
							<div class="wrap">
								<select name="' . sanitize_title($form_data_arr['fields'][$key]['field_title']) . '" id="form_field_' . $key . '" ' . $required_flag . '>';
						foreach ($options as $id => $option) {
							$option_key = explode('|', $option)[0];
							$option_value = explode('|', $option)[1];
							$input .= '<option value="' . trim($option_key) . '">' . trim($option_value) . '</option>';
						}
						$input .= '
								</select>
							</div>';
						return $input;
					};
				break;
				case 'checkbox':
					$form_data_arr['fields'][$key]['field_title'] = $form_data_arr['fields'][$key]['checkbox_field_title'];

					//Checkbox options
					$options = explode(PHP_EOL, $form_data_arr['fields'][$key]['type_checkbox_textarea']);
					
					$form_data_arr['fields'][$key]['field_input'] = function() use ($key, $options, $form_data_arr, $required_flag){
						$input = '';
						foreach ($options as $id => $option) {
							$option_key = explode('|', $option)[0];
							$option_value = explode('|', $option)[1];
							$field_title = sanitize_title($form_data_arr['fields'][$key]['field_title']);
							$input .= '
								<div class="wrap">
									<input name="' . $field_title . '[]" id="opt_' . $id. '_key_'. $key .'_' . $field_title . '" type="checkbox" value="' . trim($option_key) . '" ' . $required_flag . '>
									<label for="opt_' . $id. '_key_'. $key .'_' . $field_title . '">' . trim($option_value) . '</label>
								</div>';
						}
						return $input;
					};
				break;
				case 'radio':
					$form_data_arr['fields'][$key]['field_title'] = $form_data_arr['fields'][$key]['radio_field_title'];
					
					//Radio options
					$options = explode(PHP_EOL, $form_data_arr['fields'][$key]['type_radio_textarea']);
					
					$form_data_arr['fields'][$key]['field_input'] = function() use ($key, $options, $form_data_arr, $required_flag){
						$input = '';
						foreach ($options as $id => $option) {
							$option_key = explode('|', $option)[0];
							$option_value = explode('|', $option)[1];
							$input .= '
								<div class="wrap">
									<input name="' . sanitize_title($form_data_arr['fields'][$key]['field_title']) . '" id="rad_' . $id. '_key_'. $key .'" type="radio" value="' . trim($option_key) . '" ' . $required_flag . '>
									<label for="rad_' . $id. '_key_'. $key .'">' . trim($option_value) . '</label>
								</div>';
						}
						return $input;
					};
				break;
				case 'phone':
					//Add class if phone needs to be validated
					$validate_phone = (isset($form_data_arr['fields'][$key]['type_phone_validate']) ? 'valid_phone' : '');
					$form_data_arr['fields'][$key]['field_title'] = $form_data_arr['fields'][$key]['phone_field_title'];
					$form_data_arr['fields'][$key]['field_input'] = '<input type="text" value="" name="' . sanitize_title($form_data_arr['fields'][$key]['field_title']) . '" id="form_field_' . $key . '" ' . $required_flag . ' class="' . $validate_phone . '">';
				break;
				case 'url':
					$form_data_arr['fields'][$key]['field_title'] = $form_data_arr['fields'][$key]['url_field_title'];
					$form_data_arr['fields'][$key]['field_input'] = '<input type="url" value="" name="' . sanitize_title($form_data_arr['fields'][$key]['field_title']) . '" id="form_field_' . $key . '" ' . $required_flag . '>';
				break;

				//Static field that will not change
				case 'email':
					$form_data_arr['fields'][$key]['field_input'] = '<input type="email" value="" name="email" id="form_field_' . $key . '" required>';
				break;

				//Static field that will not change
				case 'question':
					$form_data_arr['fields'][$key]['field_input'] = '<textarea value="" id="form_field_' . $key . '" name="' . sanitize_title($form_data_arr['fields'][$key]['field_title']) . '" required></textarea>';
				break;
			}
		}
		return $form_data_arr;
	}

	/**
	 * Given an array of style keys, this returns a well formatted array with inline CSS styles for the modal
	 * @param  	Array 	$style_keys 	An array holding the base values for this style. Take from get_post_meta() on the ama_form_style post type
	 * @return 	String 	$custom_css	    Custom CSS styles to be used for this modal window
	 */
	private function _convertKeysToCSS($style_keys) {
		$custom_css = '';
		//Position the close modal icon
		$close_icon_alignment = ($style_keys['general_alignment'] === 'right' ? 'left' : 'right');
		foreach ($style_keys as $key => $value) {
			switch($key){
				case 'fixed_modal':
					$custom_css .= '.ama_modal_window[data-id="' . $this->form_id . '"]{position:fixed; left: 50%; margin-left:-327px; top:10%;}';
				break;
				case 'bg_color':
					$custom_css .= '.ama_modal_window[data-id="' . $this->form_id . '"]{background:' . $value . '; font-family:' . $style_keys['general_font'] . '; text-align:' . $style_keys['general_alignment'] . '; color:' . $style_keys['font_color_general'] . ';} .ama_modal_window[data-id="' . $this->form_id . '"] input, .ama_modal_window[data-id="' . $this->form_id . '"] select, .ama_modal_window[data-id="' . $this->form_id . '"] textarea{font-family: ' . $style_keys['general_font'] . ';} .ama_modal_window[data-id="' . $this->form_id . '"] .close_ama_modal{' . $close_icon_alignment . ':1em; border:none; box-shadow:none;}';
				break;
				case 'title_font':
					//Break apart font weight and style
					if (strpos($style_keys['title_font_style'], '_') !== false) {
						$font_weight = explode('_', $style_keys['title_font_style'])[0];
						$font_style = explode('_', $style_keys['title_font_style'])[1];
					} else {
						$font_weight = $font_style = $style_keys['title_font_style'];
					}
					$custom_css .= '.ama_modal_window[data-id="' . $this->form_id . '"] h1 {font-family:' . $value . '; font-size:' . $style_keys['font_size_title'] . 'em; font-style:' . $font_style . '; font-weight:' . $font_weight . '; color:' . $style_keys['font_color_title'] . ';}';
				break;
				case 'font_size_labels':
					//Break apart font weight and style
					if (strpos($style_keys['labels_font_style'], '_') !== false) {
						$font_weight = explode('_', $style_keys['labels_font_style'])[0];
						$font_style = explode('_', $style_keys['labels_font_style'])[1];
					} else {
						$font_weight = $font_style = $style_keys['labels_font_style'];
					}
					$custom_css .= '.ama_modal_window[data-id="' . $this->form_id . '"] label{font-size: ' . $style_keys['font_size_labels'] . 'em;' . ' font-style:' . $font_style . '; font-weight:' . $font_weight . ';}';
				break;
				case 'font_color_submit':
					//Break apart font weight and style
					if (strpos($style_keys['button_font_style'], '_') !== false) {
						$font_weight = explode('_', $style_keys['button_font_style'])[0];
						$font_style = explode('_', $style_keys['button_font_style'])[1];
					} else {
						$font_weight = $font_style = $style_keys['button_font_style'];
					}
					$custom_css .= '.ama_modal_window[data-id="' . $this->form_id . '"] .ladda-button{font-family: ' . $style_keys['general_font'] . '; font-size: ' . $style_keys['font_size_submit'] . 'em;' . ' color: ' . $style_keys['font_color_submit'] . '; background:' . $style_keys['button_color'] . '; ' . ' font-style:' . $font_style . '; font-weight:' . $font_weight . ';} .ama_modal_window[data-id="' . $this->form_id . '"] #submit_btn_wrap{text-align: ' . $style_keys['button_alignment'] . '}';
				break;
			}
		}
		
		//If custom Google fonts are in use, include them on the page
		if ($style_keys['general_font'] !== 'serif' || $style_keys['general_font'] !== 'sans-serif') {
			wp_enqueue_style('ama_general_font_' . $this->form_id, 'http://fonts.googleapis.com/css?family=' . $style_keys['general_font'] . '');
		}
		
		if ($style_keys['title_font'] !== 'serif' || $style_keys['title_font'] !== 'sans-serif') {
			wp_enqueue_style('ama_title_font_' . $this->form_id, 'http://fonts.googleapis.com/css?family=' . $style_keys['title_font'] . '');
		}
		return $custom_css;
	}
}
?>