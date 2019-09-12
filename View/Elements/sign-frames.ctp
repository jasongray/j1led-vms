<?php if(!empty($frames)) { ?>
<?php echo $this->Html->script(array('jquery.cycle'), array('inline' => false));?>
<div class="frameshow">
	<?php foreach($frames as $f) { ?>
		<?php echo $this->Resize->image('frames/'. str_replace('.bmp', '.png', $f['ScheduleFrame']['image']), 150, 150, true, array('alt' => $f['ScheduleFrame']['image'], 'data-duration' => $f['ScheduleFrame']['duration'], 'data-transition' => $f['ScheduleFrame']['transition']));?>
	<?php } ?>
</div>
<?php echo $this->Html->scriptBlock("
$(function() { 
    $('.frameshow').cycle({ 
        fx:     'fade', 
        speed:  'slow', 
        timeoutFn: function(curr, next, opts, fwd) {
        	var timeout = parseInt($(opts.elements[opts.currSlide]).data('duration')) * 1000;
        	if(isNaN(timeout) || timeout == 0) {
        		timeout = 2000;
        	}
        	return timeout;
    	}
    }); 
});
", array('inline' => false));?>
<?php } ?>