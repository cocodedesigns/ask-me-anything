<?php 
//Instantiate the new style

$this_style = new AmaStyle();

//HTML5 data attribute holds all style data. This is used to style the form when user comes back to edit.
echo "<input type='hidden' id='style_meta' data-meta='" . json_encode($mb->meta) . "'>";
?>
<div class="my_style_control">
	<div class="style_section">
		<h4>General Settings:</h4>
		<div class="row">
			<p>Fixed modal:</p>
			<div class="control">
				<?php 
					$mb->the_field('fixed_modal');
					$is_checked = ($mb->get_the_value() ? ' checked="checked"' : '');
				?>
				<input type="checkbox" name="<?php $mb->the_name(); ?>" value="1" <?php echo $is_checked; ?> data-node-map="modal_fixed">
			</div>
		</div>
		<div class="row color">
			<p>Background color: </p>
			<?php 
				$mb->the_field('bg_color'); 
				$default_val = ($mb->get_the_value() !== null ? $mb->get_the_value() : '#ffffff');
			?>
			<input type="text" name="<?php $mb->the_name(); ?>" value="<?php echo $default_val; ?>" class="custom_color_field" data-default-color="#ffffff" data-node-map="modal_bg">
		</div>
		<div class="row color">
			<p>Font color: </p>
			<?php 
				$mb->the_field('font_color_general'); 
				$default_val = ($mb->get_the_value() !== null ? $mb->get_the_value() : '#444444');
			?>
			<input type="text" name="<?php $mb->the_name(); ?>" value="<?php echo $default_val; ?>" class="custom_color_field" data-default-color="#444444" data-node-map="modal_font_color">
		</div>
		<div class="row">
			<p>Font family:</p>
			<div class="control">
				<?php 
					echo makeFontFamilySelect('general_font', $this_style, $mb);
				?>
			</div>
		</div>
		<div class="row">
			<p>Field alignment: </p>
			<?php $mb->the_field('general_alignment'); ?>
			<div class="control">
				<select name="<?php $mb->the_name(); ?>">
					<option value="left" <?php echo ($mb->get_the_value() === 'left' ? 'selected="selected"' : ''); ?>>Left</option>
					<option value="center" <?php echo ($mb->get_the_value() === 'center' ? 'selected="selected"' : ''); ?>>Center</option>
					<option value="right" <?php echo ($mb->get_the_value() === 'right' ? 'selected="selected"' : ''); ?>>Right</option>
				</select>
			</div>
		</div>
	</div>	
	<div class="style_section">
		<h4>Title:</h4>
		<div class="row color">
			<p>Font color: </p>
			<?php 
				$mb->the_field('font_color_title');
				$default_val = ($mb->get_the_value() !== null ? $mb->get_the_value() : '#444444');				
			?>
			<input type="text" name="<?php $mb->the_name(); ?>" value="<?php echo $default_val; ?>" class="custom_color_field" data-default-color="#444444" data-node-map="title">
		</div>
		<div class="row">
			<p>Font size: </p>
			<?php 
				$mb->the_field('font_size_title'); 
				$default_val = ($mb->get_the_value() !== null ? $mb->get_the_value() : '2');
			?>
			<input type="hidden" name="<?php $mb->the_name(); ?>" value="<?php echo $default_val; ?>">
			<div class="control" data-node-map="title">
				<a href="" class="size_down"></a>
				<a href="" class="size_up"></a>
			</div>
		</div>
		<div class="row">
			<p>Font style: </p>
			<div class="control">
				<?php echo makeFontStyleSelect('title_font_style', $mb); ?>
			</div>
		</div>
		<div class="row">
			<p>Font family:</p>
			<div class="control">
				<?php echo makeFontFamilySelect('title_font', $this_style, $mb); ?>
			</div>
		</div>
	</div>
	<div class="style_section">
		<h4>Field Labels:</h4>
		<div class="row">
			<p>Font size: </p>
			<?php 
				$mb->the_field('font_size_labels'); 
				$default_val = ($mb->get_the_value() !== null ? $mb->get_the_value() : '1');
			?>
			<input type="hidden" name="<?php $mb->the_name(); ?>" value="<?php echo $default_val; ?>">
			<div class="control" data-node-map="form_fields">
				<a href="" class="size_down"></a>
				<a href="" class="size_up"></a>
			</div>
		</div>
		<div class="row">
			<p>Font style: </p>
			<div class="control">
				<?php echo makeFontStyleSelect('labels_font_style', $mb); ?>
			</div>
		</div>
	</div>
	<div class="style_section">
		<h4>Submit Button:</h4>
		<div class="row color">
			<p>Font color: </p>
			<?php 
				$mb->the_field('font_color_submit'); 
				$default_val = ($mb->get_the_value() !== null ? $mb->get_the_value() : '#ffffff');
			?>
			<input type="text" name="<?php $mb->the_name(); ?>" value="<?php echo $default_val; ?>" class="custom_color_field" data-default-color="#ffffff" data-node-map="submit_button_font_color">
		</div>
		
		<div class="row color">
			<p>Button color: </p>
			<?php 
				$mb->the_field('button_color'); 
				$default_val = ($mb->get_the_value() !== null ? $mb->get_the_value() : '#444444');
			?>
			<input type="text" name="<?php $mb->the_name(); ?>" value="<?php echo $default_val; ?>" class="custom_color_field" data-default-color="#444444" data-node-map="submit_button_color">
		</div>
		<div class="row">
			<p>Button text: </p>
			<?php 
				$mb->the_field('button_text');
				$default_val = ($mb->get_the_value() !== null ? $mb->get_the_value() : 'Submit');				
			?>
			<div class="control">
				<input type="text" name="<?php $mb->the_name();?>" value="<?php echo $default_val; ?>" data-node-map="submit_btn">
			</div>
		</div>
		<div class="row">
			<p>Font size: </p>
			<?php 
				$mb->the_field('font_size_submit'); 
				$default_val = ($mb->get_the_value() !== null ? $mb->get_the_value() : '1.25');
			?>
			<input type="hidden" name="<?php $mb->the_name(); ?>" value="<?php echo $default_val; ?>">
			<div class="control" data-node-map="submit_btn">
				<a href="" class="size_down"></a>
				<a href="" class="size_up"></a>
			</div>
		</div>
		
		<div class="row">
			<p>Font style: </p>
			<div class="control">
				<?php echo makeFontStyleSelect('button_font_style', $mb); ?>
			</div>
		</div>
		
		<div class="row">
			<p>Button alignment: </p>
			<?php $mb->the_field('button_alignment'); ?>
			<div class="control">
				<select name="<?php $mb->the_name(); ?>">
					<option value="left" <?php echo ($mb->get_the_value() === 'left' ? 'selected="selected"' : ''); ?>>Left</option>
					<option value="center" <?php echo ($mb->get_the_value() === 'center' ? 'selected="selected"' : ''); ?>>Center</option>
					<option value="right" <?php echo ($mb->get_the_value() === 'right' ? 'selected="selected"' : ''); ?>>Right</option>
				</select>
			</div>
		</div>
	</div>
</div>
<div id="live_style_preview">
	<div id="modal" data-node-map="modal_bg">
		<h1 data-node-map="title">Your Form Title</h1>
		<div data-node-map="form_fields">
			<div class="field_wrap">
				<label for="field_one">A text field</label>
				<input type="text" id="field_one">
			</div>
			<div class="field_wrap">
				<label for="field_two">Another text field</label>
				<input type="text" id="field_two">
			</div>
			<div class="field_wrap">
				<label for="radio">Please select one option</label>
				<div class="wrap">
					<input name="radio" id="rad_1" type="radio"> <label for="rad_1">Choice One</label>
				</div>
				<div class="wrap">
					<input name="radio" id="rad_2" type="radio"> <label for="rad_2">Choice Two</label>
				</div>
				<div class="wrap">
					<input name="radio" id="rad_3" type="radio"> <label for="rad_3">Choice Three</label>
				</div>
			</div>
			<div class="field_wrap">
				<label for="field_three">A select box</label>
				<select id="field_three">
					<option value="value one">Select value one</option>
					<option value="value two">Select value two</option>
					<option value="value three">Select value three</option>
					<option value="value four">Select value four</option>
				</select>
			</div>
			<div class="field_wrap">
				<label for="field_four">Email Address</label>
				<input type="text" id="field_four">
			</div>
			<div class="field_wrap">
				<label for="field_five">What's your question?</label>
				<textarea id="field_five"></textarea>
			</div>
		</div>
		<div data-node-map="button_alignment">
			<button class="ladda-button" data-node-map="submit_btn">Submit</button>
		</div>
	</div>
</div>