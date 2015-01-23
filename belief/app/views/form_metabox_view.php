<?php include(dirname( __FILE__ ) . '../classes/form/form_metabox_templates.php'); ?>

<header class="mbox-header">
	Fill this Form Page with a series of HTML & form elements. You can add / remove and reorder any of the elements on this page. Hover over the title to drag and re-order elements. <b>Do not forget</b> to publish this post when finished!
</header>

<main class="clearfix mbox-main">
	<table id="form-pages-table" class="form-table cmb_metabox">
		
		<?php
			$callbacks = array(
				"kfp_section" => "sectionTemplate",
				"kfp_description" => "descriptionTemplate",
				"kfp_text" => "textInputTemplate",
				"kfp_textarea" => "textareaInputTemplate",
				"kfp_upload" => "uploadInputTemplate",
				"kfp_upload_unlimited" => "uploadUnlimitedInputTemplate",
				"kfp_radios" => "radioInputTemplate",
				"kfp_checkboxes" => "checkboxInputTemplate",
				"kfp_select" => "selectInputTemplate"
				);


		  $kerf_form_data = get_post_meta($post->ID, '_kerf_form_data', true);
		  $kerf_form_data = json_decode($kerf_form_data);

		  $rows = "";

		  $counter = 0;
		  foreach($kerf_form_data as $rowID => $obj) {
			  $rowElements = array();
		  	if ( is_object($obj) ) {
		  		foreach($obj as $id => $value) {
				  	$type = explode("-",$id);

					  $baseType = preg_replace('/[0-9]/','',$type[1]);
			  		$rowElements[$baseType] = htmlspecialchars( urldecode($value) );
				  }

				  $templateFun = $callbacks[$type[0]];
				  if ( method_exists('Metabox_Templates', $templateFun)) {
					  Form_Metabox_Templates::$templateFun("row", $counter, $rowElements);
				  }

				  if ($counter == 0 ) {
						$rows = $rows . "row" . $counter;
				  } else {
						$rows = $rows . ",row" . $counter;
				  }
		  	  $counter++;
		  	}
		  }


		?>

		<?php Form_Metabox_Templates::sectionTemplate(); ?>

		<?php Form_Metabox_Templates::descriptionTemplate(); ?>

		<?php Form_Metabox_Templates::textInputTemplate(); ?>

		<?php Form_Metabox_Templates::textareaInputTemplate(); ?>

		<?php Form_Metabox_Templates::uploadInputTemplate(); ?>

		<?php Form_Metabox_Templates::uploadUnlimitedInputTemplate(); ?>
		
		<?php Form_Metabox_Templates::radioInputTemplate(); ?>

		<?php Form_Metabox_Templates::checkboxInputTemplate(); ?>

		<?php Form_Metabox_Templates::selectInputTemplate(); ?>

		
	</table>
	<script>
		var addListenersToPremadeRows = function( formResponder ) {
			for (var i=0; i < <?php echo $counter; ?>; i++) {
				formResponder.addListeners( i );
			}
		}
	</script>

	<input type="hidden" id="starting_counter" value="<?php echo $counter; ?>">
	<input type="hidden" name="kerf_form_elements_order" value="<?php echo $rows; ?>">
	<input type="hidden" name="json_data" id="json_data">
</main>
<footer class="mbox-footer">
	<table>
		<tr>
			<td class="button-activators">
				<a href="javascript:void(0);" class="inactive-add button-primary" style="display:none"> Hide Edit </a>
				<a href="javascript:void(0);" class="active-add button-primary"> +/- Form Element </a>
			</td>
			<td>
				<span id='element-type-selector' style="display:none">
					<label>
						Element to Add:
					</label>
					<select id="element-add-selection">
						<option value=''>- Select -</option>
						<option value='clonableTRSectionTemplate'>New Section</option>
						<option value='clonableTRDescriptionTemplate'>New Description</option>
						<option value='clonableTRTextTemplate'>New Element: Input Text</option>
						<option value='clonableTRTextareaTemplate'>New Element: Input Textarea</option>
						<option value='clonableTRUploadTemplate'>New Element: Input Upload</option>
						<option value='clonableTRUploadUnlimitedTemplate'>New Element: Input Unlimited Upload</option>
						<option value='clonableTRRadioTemplate'>New Element: Input Radio</option>
						<option value='clonableTRCheckboxesTemplate'>New Element: Input Checkboxes</option>
						<option value='clonableTRSelectTemplate'>New Element: Dropdown Select</option>
					</select>
				</span>
			</td>
		</tr>
	</table>
</footer>