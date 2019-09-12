<?php if(!empty($s['ScheduleFrame'])) { ?>
<?php echo $this->Html->script(array('jquery.cycle'), array('inline' => false));?>
<div class="frameshow" style="margin:0 auto;display:block;">
	<?php foreach($s['ScheduleFrame'] as $f) { ?>
		<?php echo $this->Resize->image('frames/'. str_replace('.bmp', '.png', $f['image']), 150, 150, true, array('alt' => $f['image'], 'data-duration' => $f['duration'], 'data-transition' => $f['transition']));?>
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
<?php } elseif (!empty($s['SignType']['image'])){ ?>
<?php echo $this->Resize->image('signtypes/'. $s['SignType']['image'], 150, 150, false, array('alt' => '', 'style' => 'margin:0 auto;display:block;')); ?>
<?php } ?>