(function($) {
	$.keyboard.keyboards.exemple	= [
		[
			// The simplest
			'a',
			
			// same as first one
			{text:'a',cap:'A'},
			
			// added some alternate glyphes
			{text:'a', alt:['à']},
			
			// same as previous one
			{text:'a', alt:['à'], cap: {text:'A', alt:['À']}},
			
			// name is added as [classPrefix:keyboard]-key-[name]
			// action function will be called and no print event will be triggered
			{text:'⇪',name:'capsLock',action:function(e){e.keyboard('capToggle',true); return false;}}
		]];
})(jQuery);