<?php $this->Html->addCrumb(__('My Signs'), array('controller' => 'signs', 'action' => 'index'));?>
<?php $this->Html->addCrumb($s['Sign']['name'], array('controller' => 'signs', 'action' => 'edit', $s['Sign']['id']));?>
<?php $this->Html->addCrumb(__('Sign Dashboard'));?>
<?php echo $this->Html->css(array('bootstrap-chosen', 'bootstrap-toggle-buttons', 'jquery.tagsinput', 'bootstrap-editor', 'daterangepicker', 'timepicker', 'jquery.gritter'), null, array('block' => 'css'));?>
<?php echo $this->Html->script(array('chosen.jquery.min', 'jquery.tagsinput.min', 'jquery.toggle.buttons', 'jquery-ui.min', 'date', 'daterangepicker', 'timepicker', 'jquery.gritter.min'), array('inline' => false));?>
<div class="row-fluid">	
	<div class="span2">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-book"></i><?php echo __('Sign Library');?></h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="tabbable tabbable-custom sign-library">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_5_1" data-toggle="tab"><?php echo __('Predefined');?></a></li>
						<li><a href="#tab_5_2" data-toggle="tab"><?php echo __('Custom');?></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_5_1">
							<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
							<?php if (!empty($predefined)) { ?>
								<ul class="feeds">
									<?php foreach($predefined as $f) { ?>
									<li class="frames selectPredefined"><?php echo $this->Html->image('frames/'.$f['SignImage']['image'], array('alt' => $f['SignImage']['image'], 'data-frame-id' => $f['SignImage']['id']));?> <?php echo $f['SignImage']['name'];?></li>
									<?php } ?>
								</ul>
							<?php } ?>
							</div>
						</div>
						<div class="tab-pane" id="tab_5_2">
							<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
							<?php if (!empty($custom)) { ?>
								<ul class="feeds">
									<?php foreach($custom as $f) { ?>
									<li class="frames selectCustom"><?php echo $this->Html->image('frames/'.$f['SignImage']['image'], array('alt' => $f['SignImage']['image'], 'data-frame-id' => $f['SignImage']['id']));?> <?php echo $f['SignImage']['name'];?> <?php echo $this->Html->link('<i class="icon-remove icon-large icon-white"></i>', array('controller' => 'signimages', 'action' => 'delete', $f['SignImage']['id']), array('class' => 'btn micro red remimage', 'escape' => false));?></li>
									<?php } ?>
								</ul>
							<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="span8 previewwrapper">
		<div class="portlet box yellow">
			<div class="portlet-title">
				<h4><i class="icon-pencil"></i><?php echo __('Designer');?></h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body form">
				<?php echo $this->Form->create('SignImage', array('class' => 'form-horizontal', 'type' => 'file')); ?>
				<?php echo $this->element('Forms/signimage-designer');?>
				<?php echo $this->Form->hidden('company_id', array('value' => $this->Session->read('Auth.User.company_id')));?>
				<?php echo $this->Form->hidden('SignType', array('value' => $s['Sign']['sign_type_id']));?>
				<?php echo $this->Form->hidden('sign_id', array('value' => $s['Sign']['id']));?>
				<?php echo $this->Form->input('name', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Frame Name'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
				<div class="form-actions">
					<?php echo $this->Html->link(__('Save Frame'), array('controller' => 'signImages', 'action' => 'ajaxadd'), array('class' => 'btn orange', 'id' => 'saveframe', 'escape' => false));?>
					<?php echo $this->Html->link(__('Upload Frame'), array('controller' => 'signImages', 'action' => 'ajaxupload'), array('class' => 'btn green', 'id' => 'uploadframe', 'escape' => false));?>
					<?php echo $this->Html->link(__('Finish Editing'), array('controller' => 'signs', 'action' => 'cancel', $s['Sign']['id']), array('class' => 'btn blue', 'id' => 'finishediting', 'escape' => false));?>
				</div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
	<div class="span2">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-book"></i><?php echo __('Sign Diagnostics');?></h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body">
				<?php if (!empty($frames)) { ?>
				<?php echo $this->element('sign-frames', array(compact('frames')));?>
				<?php } ?>
				<p><strong><?php echo __('Trailer Rego');?></strong> <span class="sign-status"><?php echo $s['Sign']['registration'];?></span></p>
				<?php if (!empty($customlabels)) { ?>
				<?php foreach ($customlabels as $l) { ?>
				<p><strong><?php echo $l['CustomLabel']['text'];?></strong> <span class="sign-status"><?php echo $l['CustomField']['value'];?></span></p>
				<?php } ?>
				<?php } ?>
				<p><strong><?php echo __('Battery Voltage');?></strong> <span class="sign-status"><?php echo $this->Xhtml->batteryalert($s['Sign']['battery_voltage']);?></span></p>
				<p><strong><?php echo __('Frame Capacity');?></strong></p>
				<?php $totalframes = 95; $percentframes = round(($count['ScheduleFrame']['frame_count'] / $totalframes) * 100, 2); ?>
				<?php if ($percentframes >= 100 || $percentframes >= 85) { 
					$frameclass = 'progress-danger';
				} else if ($percentframes < 85 && $percentframes > 65) {
					$frameclass = 'progress-warning';
				} else if ($percentframes < 65 ) {
					$frameclass = 'progress-success';
				} ?>
				<div class="progress <?php echo $frameclass;?>">
					<div class="bar" style="width:<?php echo $percentframes;?>%;"></div>
				</div>
				<span class="progress-text"><?php echo __('%s of %s', $count['ScheduleFrame']['frame_count'], $totalframes);?></span>
				<?php $totalmsgs = 95; $percentmsgs = round(($count['ScheduleFrame']['message_count'] / $totalmsgs) * 100, 2); ?>
				<?php if ($percentmsgs >= 100 || $percentmsgs >= 85) { 
					$msgclass = 'progress-danger';
				} else if ($percentmsgs < 85 && $percentmsgs > 65) {
					$msgclass = 'progress-warning';
				} else if ($percentmsgs < 65 ) {
					$msgclass = 'progress-success';
				} ?>
				<p><strong><?php echo __('Message Capacity');?></strong></p>
				<div class="progress <?php echo $msgclass;?>">
					<div class="bar" style="width:<?php echo $percentmsgs;?>%;"></div>
				</div>
				<span class="progress-text"><?php echo __('%s of %s', $count['ScheduleFrame']['message_count'], $totalmsgs);?></span>
				<?php $totalschs = 255; $percentschs = round(($count['ScheduleFrame']['schedule_count'] / $totalschs) * 100, 2); ?>
				<?php if ($percentschs >= 100 || $percentschs >= 85) { 
					$schsclass = 'progress-danger';
				} else if ($percentschs < 85 && $percentschs > 65) {
					$schsclass = 'progress-warning';
				} else if ($percentschs < 65 ) {
					$schsclass = 'progress-success';
				} ?>
				<p><strong><?php echo __('Schedule Capacity');?></strong></p>
				<div class="progress <?php echo $schsclass;?>">
					<div class="bar" style="width:<?php echo $percentschs;?>%;"></div>
				</div>
				<span class="progress-text"><?php echo __('%s of %s', $count['ScheduleFrame']['schedule_count'], $totalschs);?></span>
				<?php if ($editable) { 
					echo $this->Html->link(__('Edit Sign') . ' <i class="m-icon-swapright m-icon-white"></i>', array('controller' => 'signs', 'action' => 'edit', $s['Sign']['id']), array('class' => 'btn green', 'escape' => false));
				} ?>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span2">
		<div class="portlet box purple">
			<div class="portlet-title">
				<h4><i class="icon-book"></i><?php echo __('Help');?></h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body">
				<ol>
					<li><?php echo __('Give the schedule a title.');?></li>
					<li><?php echo __('Add in date ranges for the schedule to run.');?></li>
					<li><?php echo __('Select a time for the schedule to run.');?></li>
					<li><?php echo __('Click and drag the frames to the message area.');?></li>
					<li><?php echo __('Click and drag the frames to resort them into the order you want.');?></li>
				</ol>
			</div>
		</div>
	</div>
	<div class="span10">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-book"></i><?php echo __('Message Schedule');?></h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="tabbable tabbable-custom">
					<ul class="nav nav-tabs">
							<li class="active"><a href="#tab_3_1" data-toggle="tab"><?php echo __('Create New Schedule');?></a></li>
							<li><a href="#tab_3_2" data-toggle="tab"><?php echo __('Saved Schedules');?></a></li>
							<li><a href="#tab_3_3" data-toggle="tab"><?php echo __('Current Sign Schedules');?></a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active newschedule" id="tab_3_1">
								<?php echo $this->element('schedule-form', array(compact('s')));?>
							</div>
							<div class="tab-pane currentschedules" id="tab_3_2">
								<?php echo $this->element('schedule-list', array(compact('schedules')));?>
							</div>
							<div class="tab-pane schedules" id="tab_3_3">
								<div class="reset-holder">
									<?php echo $this->Html->link(__('Clear Schedules') . ' <i class="icon-magic"></i>', array('controller' => 'signs', 'action' => 'ajaxclear', $s['Sign']['id']), array('class' => 'btn mini orange reset align-right', 'escape' => false));?>
								</div>
								<?php echo $this->element('schedule-list', array('schedules' => $uploadedschedules));?>
							</div>
						</div>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->scriptBlock('
jQuery(document).ready(function() {
	Frames.dragnsort();
	Frames.usereditor();
});', array('inline' => false));?>	