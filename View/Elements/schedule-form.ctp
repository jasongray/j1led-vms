								<?php echo $this->Form->create('Schedule', array('class' => 'form-horizontal')); ?>
								<?php echo $this->Form->input('Schedule.title', array('div' => 'control-group', 'class' => 'm-wrap large', 'label' => array('text' => __('Title'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
								<div class="control-group">
									<label class="control-label"><?php echo __('Select Date Range');?></label>
									<div class="controls">
										<div class="input-append" style="float:left;">
											<?php echo $this->Form->input('Schedule.daterange', array('div' => '', 'class' => 'm-wrap m-ctrl-medium date-range', 'label' => '', 'between' => '', 'after' => '<span class="add-on"><i class="icon-calendar"></i></span>', 'id' => 'ScheduleDaterange2'));?>
										</div>
										<?php echo $this->Form->input('Schedule.starttime', array('div' => '', 'class' => 'm-wrap small timepicker-24', 'label' => array('text' => __('Start Time'), 'class' => 'control-label'), 'between' => '', 'after' => '', 'style' => 'float:left;', 'id' => 'ScheduleStarttime2'));?>
										<?php echo $this->Form->input('Schedule.endtime', array('div' => '', 'class' => 'm-wrap small timepicker-24', 'label' => array('text' => __('End Time'), 'class' => 'control-label'), 'between' => '', 'after' => '', 'style' => 'float:left;', 'id' => 'ScheduleEndtime2'));?>
										<?php if (isset($s['Sign']['id']) && !empty($s['Sign']['id'])) { ?>
										<?php echo $this->Form->hidden('Schedule.sign_id', array('value' => $s['Sign']['id']));?>
										<?php } else { ?>
										<?php echo $this->Form->hidden('Schedule.sign_id');?>
										<?php } ?>
									</div>
								</div>
								<div class="controls">
									<?php if(empty($this->data['Schedule']['id'])) { ?>
									<?php echo $this->Html->link(__('Save Schedule') . ' <i class="m-icon-swapright m-icon-white"></i>', array('controller' => 'schedules', 'action' => 'add'), array('class' => 'btn red right', 'id' => 'saveschedule', 'escape' => false));?>
									<?php } else { ?>
									<?php echo $this->Html->link(__('Save Schedule'), array('controller' => 'schedules', 'action' => 'edit', $this->data['Schedule']['id']), array('class' => 'btn mini blue left saveschedule', 'escape' => false));?>
									<?php echo $this->Html->link(__('Cancel'), array('controller' => 'schedules', 'action' => 'cancel'), array('class' => 'btn mini canceleditbtn', 'escape' => false));?>
									<?php } ?>
								</div>
								<div class="controls schedule-frames feeds">
									<ul class="sortable" style="padding:20px;">
										<?php if(isset($this->data['ScheduleFrame']) && !empty($this->data['ScheduleFrame'])){ ?>
											<?php for($i=0;$i<count($this->data['ScheduleFrame']);$i++) { ?>
											<?php $f = $this->data['ScheduleFrame'][$i]; ?>
											<li class="frames ui-draggable" style="display: list-item;" id="frame_<?php echo $i;?>_<?php echo $f['frame_id'];?>" data-id="id_<?php echo $f['id'];?>">
												<div class="wrapper img">
												<?php echo $this->Html->image('frames/'.$f['image'], array('alt' => $f['name'], 'data-frame-id' => $f['frame_id']));?>
												</div>
												<div class="wrapper name">
												<?php echo $f['name'];?>									
												</div>
												<div class="wrapper input">
												<?php echo $this->Form->input('ScheduleFrame.'.$i.'.duration', array('div' => '', 'class' => 'm-wrap xsmall frameduration', 'label' => array('text' => __('Frame Duration'), 'class' => 'control-label'), 'between' => '', 'after' => '<span class="help-inline">'.__('in seconds (xx.xx)').'</span>', 'value' => $f['duration']));?>
												</div>
												<?php echo $this->Form->hidden('ScheduleFrame.'.$i.'.id', array('value' => $f['id']));?>
												<?php echo $this->Form->hidden('ScheduleFrame.'.$i.'.sign_id', array('value' => $f['sign_id']));?>
												<?php echo $this->Form->hidden('ScheduleFrame.'.$i.'.frame_id', array('value' => $f['frame_id']));?>
												<?php echo $this->Form->hidden('ScheduleFrame.'.$i.'.ordering', array('value' => $f['ordering']));?>
												<button class="close" type="button" data-frameurl="<?php echo $this->Html->url(array('controller' => 'schedules', 'action' => 'removeframe', $f['id']));?>"></button>
											</li>
											<?php } ?>
										<?php } ?>
									</ul>
								</div>
								<?php if(!empty($this->data['Schedule']['id'])) { ?>
								<?php echo $this->Form->hidden('Schedule.id');?>
								<?php } ?>
								<?php echo $this->Form->end();?>
								<div class="hidden" style="display:none;">
									<?php echo $this->Form->input('ScheduleFrame..duration', array('div' => '', 'class' => 'm-wrap small', 'label' => array('text' => __('Frame Duration'), 'class' => 'control-label'), 'between' => '', 'after' => ''));?>
									<?php echo $this->Form->hidden('ScheduleFrame..sign_id', array('value' => $s['Sign']['id']));?>
								</div>
								
<?php echo $this->Html->scriptBlock("
$(document).ready(function() {
		if (jQuery().daterangepicker) {
			$('.date-range').daterangepicker();
        }
        
        if (jQuery().timepicker) {
        	$('.timepicker-default').timepicker();
        	$('.timepicker-24').timepicker({
	            minuteStep: 1,
	            showSeconds: false,
	            showMeridian: true
	        });
        }
});
", array('inline' => false));?>