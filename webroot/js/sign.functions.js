var SignFunctions = function () {
	
	var querySign = function() {
		$('.updatestatusbtn').click(function(e){
			e.preventDefault();
			$.post(this.href, $('.portlet-body.recent :input').not('#ResetLevel').serialize(), 'json').done(function(d){
		    	var r = $.parseJSON(d); 
		    	if (r.response == 1) { 
		    		okMsg(r); 
		    		$.get(_baseurl+'signs/edit/'+$('#SignId').val(), function(data){
		    			var mymap = $(data).find('#map_canvas');
		    			$('#map_canvas').replaceWith(mymap);
		    			var myvolts = $(data).find('.batteryvoltage');
		    			$('.batteryvoltage').replaceWith(myvolts);
		    			showGoogleMap();
		    		});
		    	} 
		    	if (r.response == 0) {errMsg(r); } 
		    	SignFunctions.removeoverlay();
			});
		});
	}
	
	var resetSign = function() {
		$('.resetbtn').click(function(e){
			e.preventDefault();
			$.post(this.href, {'level': $('#ResetLevel').val()}, 'json').done(function(d){
		    	var r = $.parseJSON(d); 
		    	if (r.response == 1) { okMsg(r); } 
		    	if (r.response == 0) { errMsg(r); } 
		    	SignFunctions.removeoverlay();
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
			querySign();
			resetSign();
		},

		overlay: function () {
			$('.loadingdesigner').fadeIn();
        },

        removeoverlay: function () {
        	$('.loadingdesigner').fadeOut();
        },
			
	};
	
}();