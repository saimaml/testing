﻿
if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
	CKEDITOR.tools.enableHtml5Elements( document );
CKEDITOR.config.height = 150;
CKEDITOR.config.width = 'auto';
var initSample = ( function() {
	var wysiwygareaAvailable = isWysiwygareaAvailable(),
		isBBCodeBuiltIn = !!CKEDITOR.plugins.get( 'bbcode' );
	return function() {
		var editorElement = CKEDITOR.document.getById( 'editor' );
		if ( isBBCodeBuiltIn ) {
			editorElement.setHtml(
				'This is a text block. You can use it to add text to your template.'
			);
		}
		if ( wysiwygareaAvailable ) {
			CKEDITOR.replace( 'editor' );
		} else {
			editorElement.setAttribute( 'contenteditable', 'true' );
			CKEDITOR.inline( 'editor' );
		}
	};
	function isWysiwygareaAvailable() {
		if ( CKEDITOR.revision == ( '%RE' + 'V%' ) ) {
			return true;
		}
		return !!CKEDITOR.plugins.get( 'wysiwygarea' );
	}
} )();

