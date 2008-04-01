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
 * Library class for transforming TCA columns information to FORM cObj-compatible data
 *
 * @author	Francois Suter (Cobweb) <support@cobweb.ch>
 * @package	TYPO3
 * @subpackage	tx_advancedform
 */
class tx_advancedform_tcatoforms extends tx_advancedform_helperbase {
	/**
	 * This method receives TCA-formatted information about a field and translates it into a FORM cObj-compatible syntax
	 *
	 * @param	string	$fieldName: name of the field
	 * @param	array	$columnData: TCA data from the "columns" section
	 * @param	mixed	$fieldValue: value to put in the field
	 *
	 * @return	string	FORM cObj configuration
	 */
	public function columnToForm($fieldName, $columnData, $fieldValue) {
		$fieldLabel = '';
		if (isset($columnData['label'])) $fieldLabel = $GLOBALS['LANG']->sL($columnData['label']);
		switch ($columnData['config']['type']) {
			case 'input':
				$formData = $this->input($fieldName, $fieldLabel, $columnData['config'], $fieldValue);
				break;
			case 'radio':
				$formData = $this->radio($fieldName, $fieldLabel, $columnData['config'], $fieldValue);
				break;
		}
		return $formData.' ||';
	}

	/**
	 * This method handles "input"-type TCA definitions
	 *
	 * @param	string	$name: name of the field
	 * @param	string	$label: label of the field (already localised)
	 * @param	array	$config: "config" part of the TCA for the field
	 * @param	mixed	$value: value of the field (optional)
	 *
	 * @return	string	FORM cObj configuration
	 */
	protected function input($name, $label, $config, $value = '') {
			// Write the label
		$formData = $label.' | ';
			// Add required marker
		if (!empty($config['required'])) $formData .= '*';
			// Define type based on "eval" property
		if (stristr($config['eval'], 'password')) {
			$type = 'password';
		}
		else {
			$type = 'input';
		}
		$formData .= $this->wrapPrefix($name).'='.$type;
		if (empty($config['size'])) {
			$formData .= ',20';
		}
		else {
			$formData .= ','.$config['size'];
		}
		if (!empty($config['max'])) $formData .= ','.$config['max'];
		if ($value !== '') $formData .= '|'.$value;
		return $formData;
	}

	/**
	 * This method handles "radio"-type TCA definitions
	 *
	 * @param	string	$name: name of the field
	 * @param	string	$label: label of the field (already localised)
	 * @param	array	$config: "config" part of the TCA for the field
	 * @param	mixed	$value: value of the field (optional)
	 *
	 * @return	string	FORM cObj configuration
	 */
	protected function radio($name, $label, $config, $value = '') {
			// Write the label
		$formData = $label.' | ';
			// Set field type
		$formData .= $this->wrapPrefix($name).'=radio | ';
			// Loop on the values and add them
		$counter = 0;
		foreach ($config['items'] as $anItem) {
			if ($counter > 0) $formData .= ',';
			$formData .= $GLOBALS['LANG']->sL($anItem[0]).'='.$anItem[1];
			$counter++;
		}
		if ($value !== '') $formData .= '|'.$value;
		return $formData;
	}
}
?>