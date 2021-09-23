/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		
		'/',
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] },
		
	];

	config.removeButtons = 'Save,NewPage,Preview,Templates,Find,Replace,SelectAll,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Flash,Language';

	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced;link:upload';

	// adding new font(DM Sans) to editor
	//config.contentsCss = '/databroker/css/app.css';
	config.contentsCss = WEBSITE_URL+'/js/plugins/ckeditor_full/fonts.css';
	config.font_names = 'DM Sans' + config.font_names;
	config.font_defaultLabel = 'DM Sans';
	config.extraPlugins = 'wordcount,notification';
	config.wordcount = {
		// Whether or not you want to show the Paragraphs Count
		showParagraphs: true,

		// Whether or not you want to show the Word Count
		showWordCount: false,
	
		// Whether or not you want to show the Char Count
		showCharCount: true,
	
		// Whether or not you want to count Spaces as Chars
		countSpacesAsChars: true,
	
		// Whether or not to include Html chars in the Char Count
		countHTML: false,
		
		// Maximum allowed Word Count, -1 is default for unlimited
		maxWordCount: -1,
	
		// Maximum allowed Char Count, -1 is default for unlimited
		maxCharCount: 3500,
	};
};
