CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		// { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		// { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		// { name: 'paragraph', groups: [ 'blocks', 'align', 'bidi', 'paragraph' ] },
		// { name: 'links', groups: [ 'links' ] },
		// { name: 'tools', groups: [ 'tools' ] },
		// '/',
		// { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles'] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		'/',
		// { name: 'others', groups: [ 'others' ] },
		// { name: 'about', groups: [ 'about' ] }
	];
	config.extraPlugins = 'pastebase64';
	config.removeButtons = 'ShowBlocks,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,HorizontalRule,Image,Flash,Find,Replace,Save,NewPage,ExportPdf,Preview,Print,Templates,About,CreateDiv,Blockquote,Language,BidiRtl,BidiLtr,Font,Format';
};