<?php

/**
 * Text input field that appends content onto the passed in string.
 *
 * @package forms
 * @subpackage fields-formattedinput
 */
class PrependAppendField extends TextField {
	/**
	 * @var String space seperated list of extra classes that will be added to the div containing both
	 * the input and the span
	 */
	protected $groupExtraClass;

	/**
	 * @var String the text that will be prepended/appended to the input value.
	 */
	protected $prependAppendText;

	/**
	 * @var String whether the field will append or prepend.
	 */
	protected $prependAppend;

	/**
	 * Returns an input field.
	 *
	 * @param string $name
	 * @param null|string $title
	 * @param string $value
	 * @param null|int $maxLength
	 * @param null|Form $form
	 */
	public function __construct($name, $prependAppend, $text, $title = null, $value = '', $maxLength = null, $form = null) {
		// Require field css
		$module_dir = basename(dirname(dirname(__DIR__)));
		Requirements::css($module_dir . '/css/forms/PrependAppendField.css');
		// If the second parameter is not valid, fallback to append functionality
		if($prependAppend == "append" || $prependAppend == "prepend"){
			$this->setPrependAppend($prependAppend);
		}else{
			$this->setPrependAppend("append");
		}
		// Set append text
		if($text){
			$this->setPrependAppendText($text);
		}
		parent::__construct($name, $title, $value, $maxLength, $form);
	}

	/**
	 * @param string
	 */
	public function setPrependAppendText($text) {
		$this->prependAppendText = $text;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPrependAppendText() {
		return $this->prependAppendText;
	}

	/**
	 * @param string
	 */
	public function setPrependAppend($text) {
		$this->prependAppend = $text;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPrependAppend() {
		return $this->prependAppend;
	}

	/**
	 * @param string
	 */
	public function setGroupExtraClass($classes) {
		$this->groupExtraClass = $classes;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getGroupExtraClass() {
		return $this->groupExtraClass;
	}

	/**
	 * {@inheritdoc}
	 */
	public function Type() {
		return 'PrependAppendField text';
	}

	// /**
	// * @return string
	// */
	// public function Field($properties = array()) {
	// 	$module_dir = basename(dirname(dirname(__DIR__)));
	// 	Requirements::css($module_dir . '/css/forms/PrependAppendField.css');
	// 	parent::Field($properties);
	// }

	/**
	 * {@inheritdoc}
	 */
	public function getAttributes() {
		if($this->getPrependAppend() == 'append'){
			$attrArray = array_merge(
				parent::getAttributes(),
				array(
					'value' => rtrim($this->Value(),$this->getPrependAppendText()),
					'maxlength' => '54',
				)
			);
		}else{
			$attrArray = array_merge(
				parent::getAttributes(),
				array(
					'value' => ltrim($this->Value(),$this->getPrependAppendText()),
					'maxlength' => '54',
				)
			);
		}
		return $attrArray;
	}
	/**
	* Returns the field value suitable for insertion into the data object.
	*
	* @return mixed
	*/
	public function dataValue() {
		if($this->getPrependAppend() == 'append'){
	   return $this->value . $this->getPrependAppendText();
	 }else{
		 return $this->getPrependAppendText() . $this->value;
	 }
	}

	/**
	 * Validates for valid characters.
	 *
	 * @param Validator $validator
	 *
	 * @return string
	 */
	public function validate($validator) {
		// Trim spaces
		$this->value = trim($this->value);
		// Replace spaces with hyphens
		$this->value = str_replace(" ", "-", $this->value);
		// Convert to lower case
		$lowercaseName = strtolower($this->Name);
		// Make sure the entered value doesn't contain invalid characters
		$pattern = "/^[a-zA-Z0-9-]+$/";
		if($this->value && !preg_match($pattern, $this->value)) {
			$validator->validationError(
				$this->name,
				_t('PrependAppendField.VALIDATION', 'Please only use letters, numbers, hyphens and spaces'),
				'validation'
			);
			return false;
		}

		return true;
	}
}

?>
