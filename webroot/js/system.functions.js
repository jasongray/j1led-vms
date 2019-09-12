var System = function () {
	
	var dofunctions = function() {
		$('.databasetables a').click(function(e){
			e.preventDefault();
			$.post(this.href, '', 'json').done(function(d){
		    	var r = $.parseJSON(d); 
		    	if (r.response == 1) { okMsg(r); 
		    		$.get(_baseurl+'system', function(data){
		    			var newtable = $(data).find('.databasetables');
		    			$('.databasetables').replaceWith(newtable);
		    			dofunctions();
		    		});
		    	} 
		    	if (r.response == 0) { errMsg(r); } 
		    	System.removeoverlay();
			});
		});
	}
	
	var errMsg = function(data) {
    	$.gritter.add({
			title: 'ERROR!',
			text: data.msg,
			image: _baseurl+'img/fugue/24x24/cross.png',
			sticky: false
		});
    }
    
    var okMsg = function(data) {
    	$.gritter.add({
			title: 'SUCCESS!',
			text: data.msg,
			image: _baseurl+'img/fugue/24x24/tick.png',
			sticky: false
		});
    }
	
	return {
	
		init: function () {
			dofunctions();
		},

		overlay: function () {
			$('.loadingdesigner').fadeIn();
        },

        removeoverlay: function () {
        	$('.loadingdesigner').fadeOut();
        },
			
	};
	
}();