This extension aimed to bring improvements to the FORM object. It is no longer developed since
the FORM object was improved until TYPO3 4.5. As of TYPO3 4.6 it was replaced entirely.

Nested wrapping for radio buttons, for example, which could not be achieved before TYPO3 4.3,
can now be achieved with the following TypoScript:

tt_content.mailform.20 {
	RADIO.layout = <li>###LABEL### <ol><li>###FIELD###</li></ol></li>
	radioWrap.wrap = <label>|</label></li><li>
}

This extension further aimed at providing a library to convert TCA field definitions to
FORM syntax. This effort has been dropped.
