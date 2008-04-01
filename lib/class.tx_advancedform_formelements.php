<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Francois Suter (Cobweb) <support@cobweb.ch>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(t3lib_extMgm::extPath('advancedform', 'lib/class.tx_advancedform_helperbase.php'));

/**
 * Library class for helping create form fields in the syntax of the FORM cObj
 *
 * @author	Francois Suter (Cobweb) <support@cobweb.ch>
 * @package	TYPO3
 * @subpackage	tx_advancedform
 */
class tx_advancedform_formelements extends tx_advancedform_helperbase {

	/**
	 * This method is a generic wrapper for the individual element-generating methods
	 * to use when the field type is not predefined (for example, inside a loop generating various fields)
	 *
	 * @param	string	$fieldType: name of the field
	 * @param	string	$fieldLabel: label of the field
	 * @param	string	$fieldName: name of the field
	 * @param	mixed	$fieldValue: value of the field (optional, defaults to '')
	 * @param	boolean	$fieldRequired: set to true if field is required (optional, defaults to false)
	 * @param	array	$fieldOptions: key-value pairs of other parameters for the field (optional, defaults to '')
	 *
	 * @return	string	FORM syntax for the field
	 */
	public function addElement($fieldType, $fieldName, $fieldLabel = '', $fieldValue = '', $fieldRequired = false, $fieldOptions = '') {
		$formElement = '';
		switch ($fieldType) {
			case 'hidden':
				$formElement = $this->addHidden($fieldName, $fieldValue);
				break;
			case 'text':
				$formElement = $this->addText($fieldLabel, $fieldName, $fieldValue, $fieldRequired, $fieldOptions);
				break;
			case 'radio':
				$formElement = $this->addRadioButton($fieldLabel, $fieldName, $fieldOptions['options']);
				break;
			default:
				$formElement = 'Undefined field type: '.$fieldType;
				break;
		}
		return $formElement;
	}

	/**
	 * This method returns the syntax for a hidden field
	 *
	 * @param	string	$fieldName: name of the field
	 * @param	mixed	$fieldValue: value of the field
	 *
	 * @return	string	FORM syntax for the field
	 */
	public function addHidden($fieldName, $fieldValue) {
		$formElement = ' | '.($this->wrapPrefix($fieldName)).' = hidden |'.$fieldValue.' ||';
		return $formElement;
	}

	/**
	 * This method returns the syntax for a single-line text field
	 *
	 * @param	string	$fieldLabel: label of the field
	 * @param	string	$fieldName: name of the field
	 * @param	array	$fieldValue: value of the field (optional, defaults to '')
	 * @param	boolean	$fieldRequired: set to true if field is required (optional, defaults to false)
	 * @param	array	$fieldOptions: key-value pairs of other possible parameters (e.g. size, maxlength, etc.) (optional, defaults to '')
	 *
	 * @return	string	FORM syntax for the field
	 */
	public function addText($fieldLabel, $fieldName, $fieldValue = '', $fieldRequired = false, $fieldOptions = '') {
		$formElement = $fieldLabel.' | '.(($fieldRequired) ? '*' : '').($this->wrapPrefix($fieldName)).' = input';
		if (is_array($fieldOptions)) {
			if (isset($fieldOptions['size'])) $formElement .= ','.$fieldOptions['size'];
			if (isset($fieldOptions['maxlength'])) $formElement .= ','.$fieldOptions['maxlength'];
		}
		$formElement .= '| ';
		if ($fieldValue !== '') $formElement .= $fieldValue.' |';
		return $formElement;
	}

	/**
	 * This method returns the syntax for a radio button
	 *
	 * @param	string	$fieldLabel: label of the radio button group
	 * @param	string	$fieldName: name of the field
	 * @param	array	$options: value-label pairs for all options in the radio button group
	 *					(if label is '', value is used instead of label)
	 *
	 * @return	string	FORM syntax for the field
	 */
	public function addRadioButton($fieldLabel, $fieldName, $options) {
		$formElement = $fieldLabel.' | '.($this->wrapPrefix($fieldName)).' = radio |';
		$formOptions = '';
		if (is_array($options)) {
			$counter = 0;
			foreach ($options as $value => $label) {
				if ($counter > 0) $formElement .= ',';
				
				$formElement .= (($label === '') ? $value : $label).'='.$value;
				$counter++;
			}
		}
		$formElement .= ' ||';
		return $formElement;
	}
}
?>