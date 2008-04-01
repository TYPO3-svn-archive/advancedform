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

/**
 * Base class for other FORM helper classes
 *
 * @author	Francois Suter (Cobweb) <support@cobweb.ch>
 * @package	TYPO3
 * @subpackage	tx_advancedform
 */
class tx_advancedform_helperbase {
	protected $extensionPrefix = '';

	/**
	 * This method is used to defined a prefix to be applied to each field name
	 * E.g. if passed "tx_myext_pi1", every field name will be wrapped with tx_myext_pi1[|]
	 *
	 * @param	string	$prefix: Prefix
	 *
	 * @return	void
	 */
	public function setPrefix($prefix) {
		if (!empty($prefix)) $this->extensionPrefix = $prefix;
	}

	/**
	 * This method wraps the defined prefix around the given string
	 *
	 * @param	string	$string: Strin to wrap
	 *
	 * @return	string	The wrapped string
	 */
	protected function wrapPrefix($string) {
		if (empty($string)) {
			return '';
		}
		else {
			if (empty($this->extensionPrefix)) {
				return $string;
			}
			else {
					// If the field name doesn't contain [ (e.g. like in "wishlist[]"), just wrap it
				$bracket = strpos($string, '[');
				if ($bracket === false) {
					return $this->extensionPrefix.'['.$string.']';
				}
					// The field name contains square brackets. Wrap must be done only on first part of string
				else {
					$firstPart = substr($string, 0, $bracket);
					$secondPart = substr($string, $bracket);
					$wrappedString = $this->extensionPrefix.'['.$firstPart.']'.$secondPart;
					return $wrappedString;
				}
			}
		}
	}
}
?>