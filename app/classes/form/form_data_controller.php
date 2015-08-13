<?php 

/**
 * Template Model to create html form elements given data, and sessions 
 * 
 */
class Form_Data_Controller {
	public $rawdata;
	public $rawsession;
	private $tags;
	private $files;

	/**
	 * Constructor for form data
	 * @param Array $data    associated array of values
	 * @param Json_array $session persisted storage via cookie/server
	 */
	public function __construct( $data, $session ) {
		$this->rawdata = $data;
		$this->rawsession = $session;
		$this->processData();
	}

	/**
	 * Create a unique identifier for a given element
	 * @param  String $text reference name for that object
	 * @return String       Unique Identifier
	 */
	public function createTagFromText( $text ) {
		$inputTag = str_replace(' ', '_', $text);
		$inputTag = preg_replace('/[^A-Za-z0-9\_]/', '', $inputTag);
		if ( !isset($this->tags) ) {
			$this->tags = array();	
		}

		for ($i = 1; $i < 20; $i++) {
			if (!in_array($inputTag, $this->tags) && $i == 1 ) {
				break;
			} else if ( !in_array($inputTag, $this->tags) ) {
				$inputTag .= $i;
				break;
			}
		}
		array_push($this->tags, $inputTag);
		return strtolower($inputTag);
	}

	/**
	 * Template: Creates a section Title
	 * @param  array $data    Associated Array of dAta
	 * @param  Int $counter row counter
	 * @return String          HTML appendable string
	 */
	public function sectionCreate($data, $counter) {
		$value = $data['desc'.$counter];
		return '<h2>' . $value . '</h2>';
	}

	/**
	 * Template: Creates a Description on the page
	 * @param  array $data    Associated Array of dAta
	 * @param  Int $counter row counter
	 * @return String          HTML appendable string
	 */
	public function descriptionCreate($data, $counter) {
		$value = $data['desc'.$counter];
		return '<div class="description-text">' . $value . '</div>';
	}

	/**
	 * Template: Creates an input text
	 * @param  array $data    Associated Array of dAta
	 * @param  Int $counter row counter
	 * @return String          HTML appendable string
	 */
	public function inputTextCreate($data, $counter) {
		$tag = ($data['title'.$counter] !== "") ? $data['title'.$counter] : 'text';
		$theTag = $this->createTagFromText($tag);
		$sessionValue = ( isset($this->rawsession[$theTag]) ) ? $this->rawsession[$theTag] : '';
		$defaultValue = $data['default'.$counter];
		$required = $data['required'.$counter] ? 'required' : '';
		$requiredText = $data['required'.$counter] ? '<span class="required-text">*</span>' : '';

		$returnString = '<h3>' . $data['title'.$counter] . $requiredText .'</h3>';
		$returnString .= '<p class="input-description">' . $data['desc'.$counter] . '</p>';
		$returnString .= '<table class="element-table"><tr>'; 
		$returnString .= '<td>'; 

		$returnString .= "<input name='" . $theTag . "' ";

		switch($data['type'.$counter]) {
			case 'phone':
				$returnString .= 'class="phone-validation ' . $required .' persist"';
				break;
			case 'email':
				$returnString .= 'class="email-validation ' . $required .' persist"';
				break;
			default:
				$returnString .= 'class="persist ' . $required .'"';
				break;
		}
		$returnString .= ' type="text" value="' . $sessionValue . '" placeholder="' . $defaultValue .'">';
		$returnString .= '</td></tr></table>';

		return $returnString;
	}

	/**
	 * Template: Creates textarea element
	 * @param  array $data    Associated Array of dAta
	 * @param  Int $counter row counter
	 * @return String          HTML appendable string
	 */
	public function inputTextareaCreate($data, $counter) {
		$tag = ($data['title'.$counter] !== "") ? $data['title'.$counter] : 'textarea';
		$theTag = $this->createTagFromText($tag);
		$sessionValue = ( isset($this->rawsession[$theTag]) ) ? $this->rawsession[$theTag] : "";
		$defaultValue = $data['default'.$counter];
		$required = $data['required'.$counter] ? 'required' : '';
		$requiredText = $data['required'.$counter] ? '<span class="required-text">*</span>' : '';


		$returnString = '<h3>' . $data['title'.$counter] . $requiredText .'</h3>';
		$returnString .= '<p class="input-description">' . $data['desc'.$counter] . '</p>';
		$returnString .= '<textarea name="' . $theTag . '" class="persist ' . $required .'" placeholder="' . $defaultValue . '">' . $sessionValue . '</textarea>';
		return $returnString;
	}

	/**
	 * Template: Creates a single upload field
	 * @param  array $data    Associated Array of dAta
	 * @param  Int $counter row counter
	 * @return String          HTML appendable string
	 */
	public function inputUploadCreate($data, $counter) {
		$tag = ($data['desc'.$counter] !== "") ? $data['desc'.$counter] : 'upload'.$counter;
		$theTag = $this->createTagFromText($tag);
		$sessionValue = ( isset($this->rawsession[$theTag]) ) ? $this->rawsession[$theTag] : "";

		$returnString = '<p class="input-description">' . $data['desc'.$counter] . '</p>';



		if ( isset($this->rawsession[$theTag]) && $this->rawsession[$theTag] != "") {

			$returnString .= '<div class="stored-file"><a href="javascript:void(0);" class="remove-stored-file">x</a>
					<input type="text" class="persist" name="' . $theTag . '" value="'. $this->rawsession[$theTag] . '" readonly></div>';

		} else {

			$returnString .= '<table class="element-table uploader"><tr>'; 
			$returnString .= '<td>';
			$returnString .= '<input name="' . $theTag . '"  type="file" data-progress="upload-' . $theTag . '" class="store persist file-upload">';
			$returnString .= '</td><td>';

			$returnString .= '<div class="uploader-progress" id="upload-' . $theTag . '"></div>';
			
			$returnString .= '</td></tr></table>';

		}


		return $returnString;
	}

	/**
	 * Template: Creates an unlimited amount of uploads field
	 * @param  array $data    Associated Array of dAta
	 * @param  Int $counter row counter
	 * @return String          HTML appendable string
	 */
	public function inputUploadUnlimitedCreate($data, $counter) {
		$tag = ($data['desc'.$counter] !== "") ? $data['desc'.$counter] : 'upload'.$counter;
		$theTag = $this->createTagFromText($tag);
		$returnString = "";
		$index = '';
		$joiner = '';
		$preInput = false;

		if ( isset($this->rawsession[$theTag])) {
			if ( $this->rawsession[$theTag] !== "") {
				if ( !isset($this->files)) {
					$this->files = array();
					array_push($this->files, $this->rawsession[$theTag]);
				}

				$returnString .= '<h3>Files:</h3>';
				$returnString .= '<div class="stored-file"><a href="javascript:void(0);" class="remove-stored-file">x</a>
					<input type="text" class="persist" name="' . $theTag.$joiner.$index . '" value="'. $this->rawsession[$theTag] . '" readonly></div>';
				$preInput = true;
			}

			$joiner = '-';
			$index = 1;
			while ( isset($this->rawsession[$theTag.$joiner.$index]) ) {
				
				$value = $this->rawsession[$theTag.$joiner.$index];

				if ( $value !== "") {
					if (!$preInput) {
						$returnString .= '<h3>Files:</h3>';
					}
					if ( !isset($this->files)) {
						$this->files = array();
					}

					if ( !in_array($value, $this->files)) {
						array_push($this->files,$value);

						$returnString .= '<div class="stored-file"><a href="javascript:void(0);" class="remove-stored-file">x</a> 
							<input type="text" class="persist" name="' . $theTag.$joiner.$index . '" value="'. $value . '" readonly></div>';
						$preInput = true;
					}
				}

				$index++;
			}
			$returnString .= '<div class="after-files-clear"></div>';
		}

		if (!$preInput) {
			$index = '';
			$joiner = '';
		}

		$returnString .= '<p class="input-description">' . $data['desc'.$counter] . '</p>';
		$returnString .= '<table class="element-table uploader cloneable-upload-wrapper"><tr id="cloneable-upload" data-loc="' . $theTag . $joiner . $index . '">'; 
		$returnString .= '<td >';
		$returnString .= '<input  class="store persist file-upload" data-progress="upload-' . $theTag . $joiner . $index . '" name="' . $theTag . $joiner . $index . '"  type="file">';
		$returnString .= '</td><td>';
		$returnString .= '<div class="uploader-progress" id="upload-' . $theTag . $joiner . $index . '"></div>';

		$returnString .= '</td></tr></table>'; 
		$returnString .= '<input type="button" class="more-files-button" value="Add More Files">';
		return $returnString;
	}

	/**
	 * Template: Creates input radio section
	 * @param  array $data    Associated Array of dAta
	 * @param  Int $counter row counter
	 * @return String          HTML appendable string
	 */
	public function inputRadiosCreate($data, $counter) {
		$tag = ($data['title'.$counter] !== "") ? $data['title'.$counter] : 'radios';
		$theTag = $this->createTagFromText($tag);
		$sessionValue = ( isset($this->rawsession[$theTag]) ) ? $this->rawsession[$theTag] : "";
		$required = $data['required'.$counter] ? 'required' : '';
		$items = explode(",",$data['items'.$counter]);
		$requiredText = $data['required'.$counter] ? '<span class="required-text">*</span>' : '';

		$returnString = '<h3>' . $data['title'.$counter] . $requiredText .'</h3>';
		$returnString .= "<ul class='form-ul'>";
		foreach ($items as &$item) {
			$itemTag = preg_replace("/[^A-Za-z0-9 ]/", '', $item);
			$imgID = str_replace("-","",$itemTag);
			$imgID = str_replace(" ","",$imgID).$counter;
			$returnString .= "<li class='option-li'>";

			$returnString .= '<div id="' . $imgID . '" class="hover-image">';
			$returnString .= '<img src="' . $data[$imgID] . '">';
			$returnString .= '</div>';

			$returnString .= "<div class='input-wrapper' ><input name='" . $theTag . "' ";
			$returnString .= ( $sessionValue === $item ) ? "checked " : ""; 
			$returnString .= "type='radio' class='persist ". $required ."' value='". $item ."'>";
			$returnString .= "<label id='" . $theTag . "LABEL' for='" . $theTag . "'>".$item."</label></div>";

			$returnString .= "</li>";
		}
		$returnString .= "</ul>";

		return $returnString;
	}

	/**
	 * Template: Creates checkbox area section
	 * @param  array $data    Associated Array of dAta
	 * @param  Int $counter row counter
	 * @return String          HTML appendable string
	 */
	public function inputCheckboxesCreate($data, $counter) {
		$tag = ($data['title'.$counter] !== "") ? $data['title'.$counter] : 'checkboxes';
		$theTag = $this->createTagFromText($tag);
		$sessionValue = ( isset($this->rawsession[$theTag]) ) ? $this->rawsession[$theTag] : "";
		$required = $data['required'.$counter] ? 'required' : '';
		$items = explode(",",$data['items'.$counter]);
		$requiredText = $data['required'.$counter] ? '<span class="required-text">*</span>' : '';

		$returnString = '<h3>' . $data['title'.$counter] . $requiredText .'</h3>';
		$returnString .= "<ul class='form-ul'>";
		foreach ($items as &$item) {
			$imgID = str_replace("-","",$item);
			$imgID = str_replace(" ","",$imgID).$counter;

			$returnString .= "<li class='option-li'>";

			$returnString .= '<div id="' . $imgID . '" class="hover-image">';
			$returnString .= '<img src="' . $data[$imgID] . '">';
			$returnString .= '</div>';

			$returnString .= "<div class='input-wrapper' ><input name='" . $theTag . "' ";
			$returnString .= ( $sessionValue === $item ) ? "checked='checked' " : ""; 
			$returnString .= "type='checkbox' class='persist ". $required ."'  value='". $item ."'>";
			$returnString .= "<label id='" . $theTag . "LABEL' for='" . $theTag . "'>".$item."</label></div></li>";
		}
		$returnString .= "</ul>";

		return $returnString;
	}

	/**
	 * Template: Creates an select/option element
	 * @param  array $data    Associated Array of dAta
	 * @param  Int $counter row counter
	 * @return String          HTML appendable string
	 */
	public function inputSelectCreate($data, $counter) {
		$tag = ($data['title'.$counter] !== "") ? $data['title'.$counter] : 'dropdown';
		$theTag = $this->createTagFromText($tag);
		$sessionValue = ( isset($this->rawsession[$theTag]) ) ? $this->rawsession[$theTag] : "";
		$required = $data['required'.$counter] ? 'required' : '';
		$items = explode(",",$data['items'.$counter]);
		
		$returnString = '<h3 style="display: inline-block">' . $data['title'.$counter] . '</h3>';
		$returnString .= "<select name='" . $theTag . "' class='form-select persist'>";
		$returnString .= "<option>- Select -</option>";
		foreach ($items as &$item) {
			$selected = ( $sessionValue === $item ) ? "selected='selected' " : "";
			$returnString .= "<option " . $selected . " value=" . $item . "''>".$item."</option>";
		}
		$returnString .= "</select>";
		
		return $returnString;
	}

	/**
	 * Defines the callbacks given key form identifiers
	 * @param  [type] $elemName [description]
	 * @return [type]           [description]
	 */
	public function callbacks( $elemName ) {
		switch( $elemName ) {
			case 'kfp_section': 
				return 'sectionCreate';
			case 'kfp_description':
				return 'descriptionCreate';
			case 'kfp_text':
				return 'inputTextCreate';
			case 'kfp_textarea':
				return 'inputTextareaCreate';
			case 'kfp_upload':
				return 'inputUploadCreate';
			case 'kfp_upload_unlimited':
				return 'inputUploadUnlimitedCreate';
			case 'kfp_radios':
				return 'inputRadiosCreate';
			case 'kfp_checkboxes':
				return 'inputCheckboxesCreate';
			case 'kfp_select':
				return 'inputSelectCreate';
		}
	}

	/**
	 * Process the Data and return or print 
	 * @param  BOOL $echo   true: print, false: just return
	 * @return String     Output of the resulting templates from the data
	 */
	public function processData($echo) {
		$kerf_form_data = json_decode($this->rawdata);
		$rows = "";
		$content = "";

		$counter = 0;
		foreach($kerf_form_data as $rowID => $obj) {
		  	$rowElements = array();
			if ( is_object($obj) ) {
				$content .= "<section>";
				$callback = '';
				$data = array();
				foreach($obj as $id => $value) {
					$type = explode("-",$id);
					$thisCallback = $this->callbacks($type[0]);
					if ($callback == '') {
						$callback = $thisCallback;
					}
					if(is_callable(array($this, $thisCallback))){
						$data[$type[1]] = htmlspecialchars( urldecode($value) );
					}
				}

			    $content .= $this->$callback($data, $counter );
				$content .= '</section>';
				$counter++;
			}
		}

		if ($echo) {
			echo $content;
		}
		return $content;
	}
}
?>