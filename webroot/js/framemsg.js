$.valHooks.textarea = {
  get: function( elem ) {
      return elem.value.replace( /\r?\n/g, "\n" );
  } 
};

var Frames = function () {
	
	leddesigner = {};
	
	var _cursor, xa, ya;
	
	var loadBMPImage = function (img) {
		Frames.overlay();
		if (typeof img !== 'undefined') {
			$.ajax({
				url: _baseurl + 'files/frame_data/' + img + '.txt', 
				type: 'GET',
				success: function(framedata){
					$('.led').each(function(){
						$(this).prop('class', 'led');
					});
					var lines = framedata.split("\n");
					var cols = lines[0].split("|");
					for (var i = 0; i < lines.length; i++) {
						var line = lines[i].substring(0, lines[i].length);
						var pixel = line.split('|');
						for (var j = 0; j < cols.length; j++) {
							if (pixel[j] == '0,0,0' || pixel[j] == '#000') {
								$('#current_r' + i + 'c' + j).prop('class', 'led');
								$('#matrix_r' + i + 'c' + j).val(pixel[j]);
							}
			                else if (pixel[j] == '255,255,255' || pixel[j] == '#255255255') {
			                    $('#current_r' + i + 'c' + j).toggleClass('white');
			                    $('#matrix_r' + i + 'c' + j).val(pixel[j]);
			                }
			                else if (pixel[j] == '255,255,0' || pixel[j] == '#2552550') {
			                    $('#current_r' + i + 'c' + j).toggleClass('yellow');
			                    $('#matrix_r' + i + 'c' + j).val(pixel[j]);
			                }
			                else if (pixel[j] == '255,0,255' || pixel[j] == '#2550255') {
			                    $('#current_r' + i + 'c' + j).toggleClass('magenta');
			                    $('#matrix_r' + i + 'c' + j).val(pixel[j]);
			                }
			                else if (pixel[j] == '255,0,0' || pixel[j] == '#25500') {
			                    $('#current_r' + i + 'c' + j).toggleClass('red');
			                    $('#matrix_r' + i + 'c' + j).val(pixel[j]);
			                }
			                else if (pixel[j] == '0,255,255' || pixel[j] == '#0255255') {
			                    $('#current_r' + i + 'c' + j).toggleClass('cyan');
			                    $('#matrix_r' + i + 'c' + j).val(pixel[j]);
			                }
			                else if (pixel[j] == '0,255,0' || pixel[j] == '#02550') {
			                    $('#current_r' + i + 'c' + j).toggleClass('green');
			                    $('#matrix_r' + i + 'c' + j).val(pixel[j]);
			                }
			                else if (pixel[j] == '0,0,255' || pixel[j] == '#00255') {
			                    $('#current_r' + i + 'c' + j).toggleClass('blue');
			                    $('#matrix_r' + i + 'c' + j).val(pixel[j]);
			                }
			                else if (pixel[j] == '255,140,0' || pixel[j] == '#2551400') {
			                    $('#current_r' + i + 'c' + j).toggleClass('amber');
			                    $('#matrix_r' + i + 'c' + j).val(pixel[j]);
			                }
			                else if (pixel[j] == '255,165,0' || pixel[j] == '#2551650') {
			                    $('#current_r' + i + 'c' + j).toggleClass('orange');
			                    $('#matrix_r' + i + 'c' + j).val(pixel[j]);
			                }
			            }
			        }
		    },
		    cache: false
	    	}).promise().done(function(){
		    	Frames.removeoverlay();
		    });
		    
    	} else {
    		
    		var lines = $('#SignImageHeight').val();
			var cols = $('#SignImageWidth').val();
			for (var i = 0; i < lines; i++) {
				for (var j = 0; j < cols; j++) {
					var pixel = $('#matrix_r' + i + 'c' + j).val();
					if (pixel == '0,0,0' || pixel == '#000') {
						$('#current_r' + i + 'c' + j).prop('class', 'led');
					}
					else if (pixel == '255,255,255' || pixel == '#255255255') {
						$('#current_r' + i + 'c' + j).toggleClass('white');
					}
					else if (pixel == '255,255,0' || pixel == '#2552550') {
						$('#current_r' + i + 'c' + j).toggleClass('yellow');
					}
					else if (pixel == '255,0,255' || pixel == '#2550255') {
						$('#current_r' + i + 'c' + j).toggleClass('magenta');
					}
					else if (pixel == '255,0,0' || pixel == '#25500') {
						$('#current_r' + i + 'c' + j).toggleClass('red');
					}
					else if (pixel == '0,255,255' || pixel == '#0255255') {
						$('#current_r' + i + 'c' + j).toggleClass('cyan');
					}
					else if (pixel == '0,255,0' || pixel == '#02550') {
						$('#current_r' + i + 'c' + j).toggleClass('green');
					}
					else if (pixel == '0,0,255' || pixel == '#00255') {
						$('#current_r' + i + 'c' + j).toggleClass('blue');
					}
					else if (pixel == '255,140,0' || pixel == '#2551400') {
						$('#current_r' + i + 'c' + j).toggleClass('amber');
					}
					else if (pixel == '255,165,0' || pixel == '#2551650') {
						$('#current_r' + i + 'c' + j).toggleClass('orange');
					}
			    }
			}
			Frames.removeoverlay();
    	}
    	
    }
    
    var leddesigner = function() {
    	// set default (if there are any)
    	$('.textalign').removeClass('selected');
    	$('.editcolour').removeClass('selected');
    	$('.erasecolour').removeClass('selected');
    	
    	var fontalign = $('.fontalign').val();
    	$('.textalign').each(function(){
    		if ($(this).data('textalign') == fontalign){ $(this).toggleClass('selected'); }
    	});
    	var fontcolour = $('.fontcolour').val();
    	$('.editcolour').each(function(){
    		if ($(this).data('colour') == fontcolour){ $(this).toggleClass('selected'); }
    	});
    	
    	
    	// load event bindings
    	$('.editcolour').click(function(e){
    		e.preventDefault();
    		$('.editcolour').removeClass('selected');
    		$('.erasecolour').removeClass('selected');
    		$(this).toggleClass('selected');
    		$('.palette').val($(this).data('colcode')).data('colour', $(this).data('colour'));
    		$('#framepreview').prop('class', $(this).data('colour'));
    	});
    	$('.erasecolour').click(function(e){
    		e.preventDefault();
    		$('.editcolour').removeClass('selected');
    		$('.erasecolour').removeClass('selected');
    		$(this).toggleClass('selected');
    		$('.palette').val('0,0,0').data('colour', '');
    		$('#framepreview').prop('class', 'eraser');
    	});
    	$('.eraseall').click(function(e){
    		e.preventDefault();
    		clearGrid();
    		$('.yaxis').val(0);
			$('.xaxis').val(0);
    	});
    	$('.led').mousedown(function(e) {
    		if (e.which == 1) {
    			var cl = $('.palette').val();
	    		if (cl !== '') {
	    			$('#'+$(this).prop('id').replace('current', 'matrix')).val(cl);
	    			$(this).prop('class', 'led').toggleClass($('.palette').data('colour'));
	    		}
	    		$('.yaxis').val(parseInt($(this).data('yaxis')));
			    $('.xaxis').val(parseInt($(this).data('xaxis')));
			    if ($('#texteditor').hasClass('active')) {
			    	clearledcursor();
			    	ledcursor();
			    	$('.chr').val('');
			    }
    		}
    		if (e.which == 3) {
    			e.preventDefault();
    			$(this).prop('class', 'led');
    			$(this).find('input').val('0,0,0');
    		}       	
        }); 
        $('.led').live('contextmenu', function(){
        	return false;
        });
    	$('.dropdown-menu.font a').click(function(e){
    		e.preventDefault();
    		$('#SignImageFontsize').val($(this).data('fontsize'));
    		$('span.current-font').html($(this).html());
    	});
    	$('.dropdown-menu.colour a').click(function(e){
    		e.preventDefault();
    		$('.fontcolour').val($(this).data('fontcolour'));
    		$('.fontcolour').attr('data-rgb', $(this).data('rgbcode'));
    		$('span.current-colour').html($(this).html());
    	});
    	$('.editfontcolour').click(function(e){
    		e.preventDefault();
    		$('.fontcolour').val($(this).data('fontcolour'));
    		$('.fontcolour').attr('data-rgb', $(this).data('rgbcode'));
    		$('span.current-colour').html($(this).html());
    		if ($('#texteditor').hasClass('active')) {
			    clearledcursor();
			    ledcursor();
			}
    	});
    	$('.designertabs').click(function(e){
    		if ($(this).data('type') != 'text') {
    			clearledcursor();
    		}
    	});
    }
    
    var keyboard = function() {
    	$(document).bind('keypress', function(e){
		    if ($('#texteditor').hasClass('active')) {
		    	if ($(e.target).is('input, textarea')) {
            		return;   
        		}	
		        	clearledcursor();
		        	var font = $('#SignImageFontsize').val();
			    	var keycode =  e.keyCode ? e.keyCode : e.which;
			    	var chr = String.fromCharCode(keycode);
			    	//console.log(chr);
			    	var linespacer = parseInt($('.linespace').val());
			    	var chrspacer = parseInt($('.chrspace').val());
			    	var y = parseInt($('.yaxis').val());
			    	var x = parseInt($('.xaxis').val());
			    	y = y < 0 ? 0 : y; x = x < 0 ? 0 : x;
			    	var line = x;
			    	var chrHeight = 0;
			    	if (keycode === 13) {
			    		e.preventDefault();
			    		var chrHeight = parseInt(leddesigner.fonts.find('font[name='+font+']').attr('height'));
			    		y = 0;
			    		x = Math.ceil(x + parseInt(chrHeight) + linespacer);
			    		$('.yaxis').val(y);
			    		$('.xaxis').val(x);
			    	} else if (keycode === 8) {
			    		e.preventDefault();
			    		var counter = 0;
			    		var chrWidth = parseInt(leddesigner.fonts.find('font[name='+font+']').attr('width'));
		    			var chrHeight = parseInt(leddesigner.fonts.find('font[name='+font+']').attr('height'));
		    			var chr = $('.chr').val().substr(-1);
		    			var fontArray = leddesigner.fonts.find('font[name='+font+'] character[val="'+chr+'"]').text();
		    			if (fontArray === undefined || fontArray == '') {
		    				fontArray = leddesigner.fonts.find('font[name='+font+'] character[val="_"]').text();
		    			}
		    			y = Math.ceil(y - Math.ceil(fontArray.length / chrHeight));
		    			for (var k = 2; k < fontArray.length; k++) {
		    				if (x > signHeight - 1 || x < 0 || y > signWidth - 1 || y < 0) {
		                        // invalid
		                    } else {
								$('#current_r' + x + 'c' + y).prop('class', 'led');
								$('#matrix_r' + x + 'c' + y).val('0,0,0');
							} 
						    if (counter == (chrHeight - 1)) {
		                        y = parseInt(y) + 1;
		                        counter = -1;
		                        x = (-1 + parseInt(line));
		                    }
		                    counter = Math.ceil(counter + 1);
		                    x = Math.ceil(x + 1);
						}
						$('.yaxis').val(y - Math.ceil(fontArray.length / chrHeight) + chrspacer);
			    		$('.xaxis').val(x);
			    		var _chr = $('.chr').val();
			    		$('.chr').val(_chr.substr(0, (_chr.length - 1)));
			    	} else {
			    		if (keycode == 32) {
							e.preventDefault();
						}
			    		var signWidth = $('#SignImageWidth').val();
			    		var signHeight = $('#SignImageHeight').val();
				    	var colour = $('.fontcolour').val();
				    	var rgb = $('.fontcolour').attr('data-rgb');
				    	var fontArray = leddesigner.fonts.find('font[name='+font+'] character[val="'+chr+'"]').text();
		    			var chrWidth = leddesigner.fonts.find('font[name='+font+']').attr('width');
		    			var chrHeight = leddesigner.fonts.find('font[name='+font+']').attr('height');
		    			var counter = 0;
		    			for (var k = 2; k < fontArray.length; k++) {
		    				if (x > signHeight - 1 || x < 0 || y > signWidth - 1 || y < 0) {
		                        // invalid
		                    } else if (fontArray[k] == 0) {
								$('#current_r' + x + 'c' + y).prop('class', 'led');
								$('#matrix_r' + x + 'c' + y).val('0,0,0');
							} else {
								$('#current_r' + x + 'c' + y).toggleClass(colour);
								$('#matrix_r' + x + 'c' + y).val(rgb);
						    }
						    if (counter == chrHeight-1) {
		                        y = parseInt(y) + 1;
		                        counter = -1;
		                        x = $('.xaxis').val() - 1;
		                    }
		                    counter = counter + 1;
		                    x = Math.ceil(x + 1);
						}
						$('.yaxis').val(parseInt(y) + parseInt(chrspacer));
			    		$('.xaxis').val(x);
			    		$('.chr').val($('.chr').val() + chr);
					}
					ledcursor();
		    } 
		        
		});
    }
    
    var textinput = function(evt, txt) {
    	clearGrid();
    	var font = $('#SignImageFontsize').val();
    	var key = (evt.which) ? evt.which : evt.keyCode;
		var lines = 0;
		var signWidth = $('#SignImageWidth').val();
		var signHeight = $('#SignImageHeight').val();
		var strWidth = totalWidth(txt, font, lines);
		var centerAlign = Math.ceil(strWidth / 2);
		var chrHeight = 0;
		var y = 0;
		var x = 0;
		var align = $('.fontalign').val();
		if (align == "center") {
            var y = (signWidth / 2) - centerAlign;
        }
        else if (align == "left") {
            var y = 0;
        }
        else if (align == "right") {
            var y = (signWidth - strWidth);
        }
		var colour = $('.fontcolour').val();
		for (var i = 0; i < txt.length; i++) {
			chr = txt[i];
			if (chr.match(/\n/g)) {
				lines = lines + 1;
				strWidth = totalWidth(txt, font, lines);
				centerAlign = Math.ceil(strWidth / 2);
				x = Math.ceil((parseInt(chrHeight) * lines) + lines);
				if (align == "center") {
	                y = (signWidth / 2) - centerAlign;
	            }
	            else if (align == "left") {
	            	y = 0;
	            }
	            else if (align == "right") {
	                y = (signWidth - strWidth);
	            }
			} else {
    			var fontArray = leddesigner.fonts.find('font[name='+font+'] character[val="'+chr+'"]').text();
    			var chrWidth = leddesigner.fonts.find('font[name='+font+']').attr('width');
    			var chrHeight = leddesigner.fonts.find('font[name='+font+']').attr('height');
    			var counter = 0;
    			for (var k = 2; k < fontArray.length; k++) {
    				if (x > signHeight - 1 || x < 0 || y > signWidth - 1 || y < 0) {
                        // invalid
                    }
    				else if (fontArray[k] == 0) {
						$('#current_r' + x + 'c' + y).prop('class', 'led');
						$('#matrix_r' + x + 'c' + y).val('0,0,0');
					}
					else {
						if (colour == 'white') {
				        	$('#current_r' + x + 'c' + y).toggleClass('white');
				            $('#matrix_r' + x + 'c' + y).val('255,255,255');
				        }
				        else if (colour == 'yellow') {
				            $('#current_r' + x + 'c' + y).toggleClass('yellow');
				            $('#matrix_r' + x + 'c' + y).val('255,255,0');
				        }
				        else if (colour == 'magenta') {
				            $('#current_r' + x + 'c' + y).toggleClass('magenta');
				            $('#matrix_r' + x + 'c' + y).val('255,0,255');
				        }
				        else if (colour == 'red') {
				            $('#current_r' + x + 'c' + y).toggleClass('red');
				            $('#matrix_r' + x + 'c' + y).val('255,0,0');
				        }
				        else if (colour == 'cyan') {
				            $('#current_r' + x + 'c' + y).toggleClass('cyan');
				            $('#matrix_r' + x + 'c' + y).val('0,255,255');
				        }
				        else if (colour == 'green') {
				            $('#current_r' + x + 'c' + y).toggleClass('green');
				            $('#matrix_r' + x + 'c' + y).val('0,255,0');
				        }
				        else if (colour == 'blue') {
				            $('#current_r' + x + 'c' + y).toggleClass('blue');
				            $('#matrix_r' + x + 'c' + y).val('0,0,255');
				        }
				        else if (colour == 'default') {
				            $('#current_r' + x + 'c' + y).toggleClass('amber');
				            $('#matrix_r' + x + 'c' + y).val('255,140,0');
				        }
				        else if (colour == 'amber') {
				            $('#current_r' + x + 'c' + y).toggleClass('amber');
				            $('#matrix_r' + x + 'c' + y).val('255,140,0');
				        }
				        else if (colour == 'orange') {
				            $('#current_r' + x + 'c' + y).toggleClass('orange');
				            $('#matrix_r' + x + 'c' + y).val('255,165,0');
				        }
				    }
				    if (counter == chrHeight-1) {
                        y = y + 1;
                        counter = -1;
                        x = -1;
                        if (lines > 0) {
                        	x = Math.ceil(-1 + (parseInt(chrHeight) * lines) + lines);
                        }
                    }
                    counter = counter + 1;
                    x = Math.ceil(x + 1);
                }
    		}
		}
    }
    
    var clearGrid = function() {
    	Frames.overlay();
    	$('.led').each(function(){
			$(this).prop('class', 'led');
			$(this).find('input').val('0,0,0');
		}).promise().done(function(){
			$('.chr').val('');
			clearledcursor();
		    Frames.removeoverlay();
		});
    }
    
    var loadFonts = function() {
    	$.ajax({
    		url: _baseurl+'files/fontfile.xml',
    		dataType: 'xml',
    		success: function(xml) {
    			leddesigner.fonts = $(xml);
    		},
    		error: function(d) {
    			alert('Error loading XML data');
    		}
    	});
    }
    
    var totalWidth = function(text, font, lines) {
        var tw = 0;
        var chr;
        var txt = text.split(/\r\n|\r|\n/);
        for (var i = 0; i < txt[lines].length; i++) {
        	chr = txt[lines][i];
        	if (chr.match(/\n/g)) {
    		} else {
        		fontArray = leddesigner.fonts.find('font[name='+font+'] character[val="'+chr+'"]').text();
        		tw = Math.ceil(tw + parseInt(fontArray[1]));
        	}
        }
        return tw;
    }
    
    var ledcursor = function() {
    	var font = $('#SignImageFontsize').val();
	    var chrHeight = leddesigner.fonts.find('font[name='+font+']').attr('height');
	    ya = parseInt($('.yaxis').val());
	    xa = parseInt($('.xaxis').val());
	    var colour = $('.fontcolour').val();
	    _cursor = setInterval(function(){
	    	for (k = 0; k < chrHeight; k++) {
				$('#current_r' + xa + 'c' + ya).toggleClass(colour);
				xa = xa + 1;
			}
			ya = parseInt($('.yaxis').val());
			xa = parseInt($('.xaxis').val());
		}, 450);
    }
    
    var clearledcursor = function(){
    	clearInterval(_cursor);
	    var font = $('#SignImageFontsize').val();
		var chrHeight = leddesigner.fonts.find('font[name='+font+']').attr('height');
		var colour = $('.fontcolour').val();
	    for (k = 0; k < chrHeight; k++) {
			$('#current_r' + xa + 'c' + ya).prop('class', 'led');
			xa = xa + 1;
		}
    }
    
    var dragndrop = function() {
    	$( ".sortable" ).sortable({
			revert: true,
			cursor: 'move',
			update: function (){
				updateSortableOrder(".sortable");
			},
			stop: function(){
				if ($(this).hasClass('dropped')){
					$(this).sortable('cancel');
					$(this).removeClass('dropped');
				}
			}
		});
		$( ".frames" ).draggable({
			connectToSortable: ".sortable",
			revert: "invalid",
			helper: "clone"
		});
		$('.sortable').droppable({
			drop: function(e, ui) {
				ui.draggable.parent().addClass('dropped');
				
				if ($(ui.draggable).find('.inline-controls').length == 0){
					$(ui.draggable).find('.remimage').remove();
					var cnt = $('.schedule-frames .sortable .frames').length;
					var frmid = $(ui.draggable).find('img').data('frame-id');
					$(ui.draggable).append('<div class="inline-controls">'+$('.hidden').html()+'</div>');
					$(ui.draggable).find(':input').each(function(){
						$(this).attr('name', $(this).attr('name').replace('[]', '['+cnt+']'));
						var _id = $(this).attr('id');
						$(this).attr('id', _id+cnt);
					});
					$(ui.draggable).find('label').each(function(){
						var _id = $(this).attr('for');
						$(this).attr('for', _id+cnt);
					});
					$('<input>').attr({type: 'hidden', name: 'data[ScheduleFrame]['+cnt+'][frame_id]', value: frmid}).appendTo(ui.draggable);
					$('<input>').attr({type: 'hidden', id: 'frame_'+frmid, name: 'data[ScheduleFrame]['+cnt+'][ordering]', value: cnt}).appendTo(ui.draggable);
					$(ui.draggable).attr('id', 'frame_'+cnt+'_'+frmid);
					$('<button type="button" class="close" data-dismiss="alert"></button>').appendTo(ui.draggable);
					return true;
					/*
				} else if () {
					*/
				} else {
					return false;
				}
        	}
		});
		$('.remimage').click(function(e){
			e.stopPropagation();
			e.preventDefault(); 
			$.post(this.href, '', 'json').done(function(d){
    			var r = $.parseJSON(d); if (r.response == 1) {okMsg(r);	$('.sign-library').load(_baseurl+'signs/frames/'+$('#SignImageSignId').val()+' .sign-library >', function(){ Frames.removeoverlay(); dragndrop(); $('.selectPredefined, .selectCustom').click(function(){ loadBMPImage($(this).find('img').prop('alt'));});}); } if (r.response == 0) {errMsg(r); } Frames.removeoverlay();
			});
		});
		function updateSortableOrder(elm) {
			if (elm.parent().parent().attr('id') != 'ScheduleGetframesForm') {
			var order = $(elm).sortable('toArray');
			for (var key in order) {
				var val = order[key];
				var prt = val.split('_');
				jQuery('#frame_'+prt[2]).val(key);
			}
		}
		}
    }
    
    var saveframes = function() {
    	$('#saveframe').click(function(e){
    		e.preventDefault();
    		$('.control-group').each(function(){
    			$(this).removeClass('error');
    		});
    		$.post(this.href, $('.previewwrapper :input').serialize(), 'json').done(function(d){
    			var r = $.parseJSON(d); if (r.response == 1) {okMsg(r); $('.sign-library').load(_baseurl+'signs/frames/'+$('#SignImageSignId').val()+' .sign-library >', function(){ Frames.removeoverlay(); dragndrop(); $('.selectPredefined, .selectCustom').click(function(){ loadBMPImage($(this).find('img').prop('alt'));}); });} if (r.response == 0) {errMsg(r); Frames.removeoverlay(); } 
			});
    	}).promise();
    	$('#uploadframe').click(function(e){
    		e.preventDefault();
    		$('.control-group').each(function(){
    			$(this).removeClass('error');
    		});
    		$.post(this.href+'/sign_id:'+$('#SignImageSignId').val()+'/colours:'+$('#SignImageColours').val(), $('.previewwrapper :input[name*="matrix"]').serialize(), 'json').done(function(d){
    			var r = $.parseJSON(d); if (r.response == 1) {okMsg(r);	} if (r.response == 0) {errMsg(r); } Frames.removeoverlay();
			});
    	}).promise();
    	$('.reset').click(function(e){
    		e.preventDefault();
    		$('.control-group').each(function(){
    			$(this).removeClass('error');
    		});
    		$.post(this.href, '', 'json').done(function(d){
    			var r = $.parseJSON(d); if (r.response == 1) {okMsg(r);	} if (r.response == 0) {errMsg(r); } Frames.removeoverlay();
			});
    	}).promise();
    }
    
    var scheduleaction = function() {
    	$('#saveschedule').click(function(e){
			e.preventDefault();
			$.post(this.href, $('.newschedule #ScheduleFramesForm :input').serialize(), 'json').done(function(d){
				var r = $.parseJSON(d);
				if (r.response == 1) {
					okMsg(r);
					$('.sortable li').fadeOut('slow');
					$('.sortable').html('');
					$('.currentschedules').load(_baseurl+'schedules/sign/'+$('#ScheduleSignId').val()+' #currentschedulelist', function(){ schedulefunctions(); });
					$('.newschedule #ScheduleFramesForm :input').each(function(){if($(this).attr('id') != 'ScheduleSignId'){$(this).val('');}});
				} 
				if (r.response == 0) {
					errMsg(r)
				}
				Frames.removeoverlay();
			});
		});
		
    }
    
    var schedulefunctions = function() {
    	// save new schedule
    	$('.editschedule').click(function(e){
    		e.preventDefault();
    		$('.schedule-editor-form').slideUp('slow', function(){ $(this).remove(); });
    		var elm = $(this).parent();
    		$(this).append($('<div>').addClass('smlloading').addClass('grybg'));
    		$('<div>').load(this.href + ' .form-horizontal', function(){
    			App.init(); elm.slideDown('slow');	canceledit(); remframes(); 
    			$('.smlloading').remove();
    			var _dates = $('#ScheduleGetframesForm .date-range').val().split(' - ');
    			$('#ScheduleGetframesForm .date-range').daterangepicker({startDate: _dates[0], endDate: _dates[1]});
    			$('#ScheduleGetframesForm .timepicker-default').timepicker();
	        	$('#ScheduleGetframesForm .timepicker-24').timepicker({
		            minuteStep: 1,
		            showSeconds: false,
		            showMeridian: true,
		            defaultTime: $(this).val()
		        });
		        $('#ScheduleGetframesForm .sortable').sortable({
					revert: true,
					cursor: 'move',
					update: function (){
						$.post(_baseurl+'schedules/reorderframes', $('#ScheduleGetframesForm .sortable').sortable('serialize', { key: 'frames[]', attribute: 'data-id'})); 
						var order = $('#ScheduleGetframesForm .sortable').sortable('toArray');
						for (var key in order) {
							$('#'+order[key]+' :input[name*="ordering"]').val(key);
						}
					}
				});
				$('#ScheduleGetframesForm .saveschedule').click(function(e){
					e.preventDefault();
					$(this).append($('<div>').addClass('smlloading').addClass('bluebg'));
					$.post(this.href, $('#ScheduleGetframesForm :input').serialize(), 'json').done(function(d){
						var r = $.parseJSON(d);
						if (r.response == 1) {
							$('.schedule-editor-form').slideUp('slow', function(){ $(this).remove(); });
							okMsg(r);
						} 
						if (r.response == 0) {
							errMsg(r)
						}
						$('.smlloading').remove();
					});
				});
    		}).appendTo(elm).addClass('schedule-editor-form').slideDown('slow');
    	});
    	$('.uploadschedule').click(function(e){
    		e.preventDefault();
    		$(this).append($('<div>').addClass('smlloading').addClass('grnbg'));
    		$('.control-group').each(function(){
    			$(this).removeClass('error');
    		});
    		$.post(this.href, '', 'json').done(function(d){
    			var r = $.parseJSON(d); if (r.response == 1) {okMsg(r);	} if (r.response == 0) {errMsg(r); } $('.smlloading').remove();
			});
    	}).promise();
    	$('.delschedule').click(function(e){
    		e.preventDefault();
    		$(this).append($('<div>').addClass('smlloading').addClass('redbg'));
    		var _id = $(this).data('scheduleid');
    		$.post(this.href, '', 'json').done(function(d){
    			var r = $.parseJSON(d); if (r.response == 1) { $('li[data-schedule='+_id+']').fadeOut('slow', function(){ $('li[data-schedule='+_id+']').remove();});	} if (r.response == 0) {errMsg(r); } Frames.removeoverlay();
			});
    	}).promise();
    	function canceledit(){
    		$('.canceleditbtn').click(function(e){
    			e.preventDefault();
    			$('.schedule-editor-form').slideUp('slow', function(){ $(this).remove(); });
    		});
    	}
    	function remframes() {
		    $('.frames .close').click(function(e){
		    	e.preventDefault();
		    	$.post($(this).data('frameurl'), '', 'json').done(function(d){
		    		var r = $.parseJSON(d); 
		    		if (r.response == 1) { $(this).fadeOut('slow', function(){ $(this).remove();}); } if (r.response == 0) {errMsg(r); } 
		    		Frames.removeoverlay();
				});
		    });
		}
    }
    
    var resizeframe = function() {
    	$('.resizeframe .btn').click(function(e){
		    e.preventDefault();
    		$('.previewwrapper').load(this.href+'/width:'+$('#SignImageWidth').val()+'/height:'+$('#SignImageHeight').val()+' .previewwrapper .box', function(){ leddesigner(); Frames.removeoverlay();});
    	});
    }
    
    var errMsg = function(data) {
    	$('span.help-inline').remove();
    	$.gritter.add({
			title: 'ERROR!',
			text: data.msg,
			image: _baseurl+'img/fugue/24x24/cross.png',
			sticky: false
		});
    	$.each(data.data, function(d){
			for (fieldName in this) {
				var element = $("#" + d + ucfirst(fieldName));
				var _insert = $(document.createElement('span')).insertAfter(element);
				_insert.addClass('help-inline').text(this[fieldName][0]);
				element.parent().parent().addClass('error');
			}
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
    
    var ucfirst = function(string) {
    	return string.charAt(0).toUpperCase() + string.slice(1);
	}
	
	return {
	
		init: function () {
			$('.selectPredefined, .selectCustom').click(function(){
				loadBMPImage($(this).find('img').prop('alt'));
			});
		},
		
		admininit: function () {
			loadBMPImage($('.thumbnail').find('img').prop('alt'));
			leddesigner();
			keyboard();
			loadFonts();
			$('.selectPredefined, .selectCustom').click(function(e){
				loadBMPImage($(this).find('img').prop('alt')); 
			});
			resizeframe();
		},
		
		images: function () {
			loadBMPImage();
		},
		
		overlay: function () {
			$('.loadingdesigner').fadeIn();
        },

        removeoverlay: function () {
        	$('.loadingdesigner').fadeOut();
        },
        
        dragnsort: function () {
        	dragndrop();
        },
        
        usereditor: function () {
        	saveframes();
        	scheduleaction();
        	schedulefunctions();
        },
			
	};
}();