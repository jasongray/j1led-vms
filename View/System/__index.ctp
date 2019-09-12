				<div class="row-fluid">
					<div class="span6">
						<!-- BEGIN PROGRESS BARS PORTLET-->
						<div class="portlet box green">
							<div class="portlet-title">
								<h4><i class="icon-cogs"></i>System Information</h4>
							</div>
							<div class="portlet-body">
								<?php echo $ver;?>
							</div>
						</div>
					</div>
					<div class="span6">
						<!-- BEGIN PROGRESS BARS PORTLET-->
						<div class="portlet box green">
							<div class="portlet-title">
								<h4><i class="icon-cogs"></i>Updates</h4>
							</div>
							<div class="portlet-body">
								<div class="progress-wrapper"></div>
								<?php echo $this->Html->link('Download Update 2.6', array('controller' => 'system', 'action' => 'downloadUpdate', '2.6'), array('class' => 'downloadupdate btn btn-mini purple'));?>
							</div>
						</div>
					</div>
				</div>
<?php echo $this->Html->scriptBlock(
"$(document).ready(function(){
	$('.downloadupdate').click(function(e){
		$('.progress').remove();
		$('#progressFrame').remove();
		e.preventDefault();
		var url = $(this).prop('href');
		/*$('<iframe>', { src: url, id:  'progressFrame', frameborder: 0, scrolling: 'no'}).appendTo('.progress-wrapper');*/
		$('.progress-wrapper').after('<div class=\"progress progress-striped progress-success\"><div style=\"width: 0%;\" class=\"bar\"></div></div>');
		$.ajax({
			xhr: function() {
	            var xhr = new window.XMLHttpRequest();
	            xhr.addEventListener('progress', function(e) {
	                if (e.lengthComputable) {
	                    $('.bar').css('width', '' + (100 * e.loaded / e.total) + '%');
	                }
	            });
	            return xhr;
	        }, 
		    url: url,
			action: 'GET',
			complete: function(response, status, xhr){
				$('progress').slideUp();
			}
		});
	});
});

function updateProgress(n) {
	$('.bar').prop('style', 'width:'+n+'%');
}", array('inline' => false));?>