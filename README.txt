The advancedform extension is designed to be part of the discussion regarding the revamping of the FORM cObj in TYPO3 4.3 (hopefully). There's no documentation provided besides the notes in this document.

- Using the advancedform rendering

Basically the pi1 plugin contains a copy of tslib_content::FORM(). This makes it possible to experiment changes in the FORM() method without breaking everything.

To use this modified method instead of the normal FORM object, just use the following TypoScript:

tt_content.mailform.20 = USER_INT
tt_content.mailform.20.userFunc = tx_advancedform_pi1->main
tt_content.mailform.20.includeLibs = typo3conf/ext/advancedform/pi1/class.tx_advancedform_pi1.php

- What's different in advancedform rendering

Modifications that have been introduced until now are:

** clean up of the "accessibility" property (useless if a good markup is provided). As of this writing done only for the radio buttons
** correction of rendering limitations for radio buttons:
*** radioWrap (stdWrap) now wraps the radion button and its label
*** radioLabelWrap (stdWrap) new property for wrapping the label of a radio button
*** "radio_id" new value available inside radioLabelWrap for using inside the "for" attribute of the <label> tag
** allow the use of type-specific stdWrap configurations:
*** e.g. for a submit button, SUBMIT.fieldWrap will be used if defined, else fieldWrap is used. Same for labelWrap

- Additional libraries

lib/class.tx_advancedform_formelements.php is a class designed to help generate form elements using the FORM syntax
lib/class.tx_advancedform_tcatoforms.php is a class designed to generate FORM syntax from TCA data

For examples of usage, refer to http://wiki.typo3.org/index.php/Form_Structure_for_TYPO3_4.3#Helper_libraries