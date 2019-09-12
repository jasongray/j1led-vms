<?php echo $this->Html->css(array('datepicker', 'bootstrap-toggle-buttons', 'jquery.tagsinput', 'jquery.gritter'), null, array('block' => 'css'));?>
<?php echo $this->Html->script(array('bootstrap-datepicker-2', 'jquery.tagsinput.min', 'jquery.toggle.buttons', 'jquery.gritter.min', 'sign.functions'), array('inline' => false));?>
<?php echo $this->Html->scriptBlock('
jQuery(document).ready(function() {
	SignFunctions.init();
});', array('inline' => false));?>	
<?php echo $this->Form->create('Sign', array('class' => 'form-horizontal', 'type' => 'file')); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-lightbulb"></i><?php echo __('Sign Information');?></h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body form">
				<?php echo $this->Form->input('name', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Sign Name'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
				<?php echo $this->Form->input('sign_type_id', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Sign Type'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>', 'empty' => ''));?>
				<?php echo $this->Form->input('company_id', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'empty' => '', 'label' => array('text' => __('Company'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
				<div class="control-group">
					<label class="control-label"><?php echo __('Enable');?></label>
					<div class="controls">
						<div class="warning-toggle-button toggle-button">
							<?php echo $this->Form->input('enabled', array('div' => false, 'class' => 'toggle', 'type' => 'checkbox', 'label' => false));?>
						</div>
					</div>
				</div>
				<?php echo $this->Form->input('me_id', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('MessageEngine ID'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>', 'type' => 'text'));?>
				<?php echo $this->Form->input('address', array('div' => 'control-group', 'class' => 'm-wrap large', 'label' => array('text' => __('Address'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
				<div class="control-group">
                    <label class="control-label"> </label>
                    <div class="controls">
                    	<?php echo $this->Form->input('geocodeme', array('div' => false, 'label' => array('text' => __('GeoCode this address?'), 'class' => 'checkbox'), 'type' => 'checkbox'));?>
                    </div>
                </div>
				<?php echo $this->Form->input('location', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Depot'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
				<?php echo $this->Form->input('registration', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('Trailer Registration'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
				<div class="form-actions">
				<?php
					echo $this->Form->hidden('id');
					echo $this->Form->submit('Save', array('label' => __('Save'), 'class'=>'btn green', 'div' => false)); 
					echo $this->Html->link(__('Cancel'), array('controller' => 'signs', 'action' => 'cancel'), array('class' => 'btn black'));
					if(!empty($this->data['Sign']['id'])){
						echo $this->Html->link(__('Delete'), array('controller' => 'signs', 'action' => 'delete', $this->data['Sign']['id']), array('class' => 'btn red'));
					}
				?>	
				</div>
			</div>
		</div>
	</div>
		<div class="span4">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-rss"></i><?php echo __('Communications');?></h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body form">
				<div class="tabbable tabbable-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab_1_1"><?php echo __('Sim Details');?></a></li>
						<li><a data-toggle="tab" href="#tab_1_2"><?php echo __('TCP/IP');?></a></li>
						<li><a data-toggle="tab" href="#tab_1_3"><?php echo __('Serial');?></a></li>
						<?php /* <li><a data-toggle="tab" href="#tab_1_4"><?php echo __('GEO Fence');?></a></li> */ ?>
					</ul>
					<div class="tab-content">
						<div id="tab_1_1" class="tab-pane active">
							<?php echo $this->Form->input('imei', array('div' => 'control-group', 'class' => 'm-wrap medium', 'label' => array('text' => __('IMEI'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
							<?php echo $this->Form->input('sim', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('SIM Number'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
							<?php echo $this->Form->input('sim_pin', array('div' => 'control-group', 'class' => 'm-wrap xsmall', 'label' => array('text' => __('SIM PIN'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
						</div>
						<div id="tab_1_2" class="tab-pane">
							<?php echo $this->Form->input('Tcpip.host', array('div' => 'control-group', 'class' => 'm-wrap large', 'label' => array('text' => __('Host'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
							<?php echo $this->Form->input('Tcpip.port', array('div' => 'control-group', 'class' => 'm-wrap xsmall', 'label' => array('text' => __('Port'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
							<?php echo $this->Form->input('Tcpip.id', array('type' => 'hidden'));?>
						</div>
						<div id="tab_1_3" class="tab-pane">
							<?php echo $this->Form->input('Serial.baudrate', array('div' => 'control-group', 'class' => 'm-wrap medium', 'label' => array('text' => __('BAUD Rate'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
							<?php echo $this->Form->input('Serial.comport', array('div' => 'control-group', 'class' => 'm-wrap xsmall', 'label' => array('text' => __('Com Port'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
							<?php echo $this->Form->input('Serial.id', array('type' => 'hidden'));?>
						</div>
						<?php /* ?>
						<div id="tab_1_4" class="tab-pane">
							<div class="control-group">
								<label class="control-label"><?php echo __('Enable');?></label>
								<div class="controls">
									<div class="info-toggle-button toggle-button">
										<?php echo $this->Form->input('geo_fence_enable', array('div' => false, 'class' => 'toggle', 'type' => 'checkbox', 'label' => false));?>
									</div>
								</div>
							</div>
							<?php echo $this->Form->input('geo_fence_radius', array('div' => 'control-group', 'class' => 'm-wrap medium', 'label' => array('text' => __('Geo Fence Radius'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
							<?php echo $this->Form->hidden('geo_fence_enable_value', array('value' => $this->data['Sign']['geo_fence_enable']));?>
							<?php echo $this->Form->hidden('geo_fence_radius_value', array('value' => $this->data['Sign']['geo_fence_radius']));?>
						</div>
						<?php */ ?>
					</div>
					<hr/>
					<?php echo $this->Form->input('firmware_ver', array('div' => 'control-group', 'class' => 'm-wrap medium', 'label' => array('text' => __('Firmware Version'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
					<div class="control-group">
                    	<label class="control-label"><?php echo __('High Gain Antenna Installed');?></label>
                        <div class="controls">
                        	<?php echo $this->Form->input('high_gain_antenna', array('div' => false, 'label' => array('text' => '', 'class' => 'checkbox'), 'type' => 'checkbox'));?>
                        </div>
                    </div>
					<?php echo $this->Form->input('poll_duration', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('Poll Duration'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
				</div>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="portlet box green">
			<div class="portlet-title">
				<h4><i class="icon-spinner"></i><?php echo __('Recent Information');?></h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body form recent">
				<p><strong><?php echo __('Current Location');?></strong>: </p>
				<div id="map_canvas" class="span12" style="height:300px;overflow:hidden;margin: 0 0 25px 0;" data-lat="<?php echo $this->data['Sign']['lat'];?>" data-lng="<?php echo $this->data['Sign']['lng'];?>"></div>
				<br class="clear-fix"/>
				<div class="control-group">
					<label class="control-label"><?php echo __('Battery Voltage');?></label>
					<div class="controls batteryvoltage">
						<?php if (!empty($this->data['Sign']['battery_voltage'])){ echo $this->Xhtml->batteryalert($this->data['Sign']['battery_voltage']);} ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo __('GEO Fence Enable');?></label>
					<div class="controls">
						<div class="info-toggle-button toggle-button">
							<?php echo $this->Form->input('geo_fence_enable', array('div' => false, 'class' => 'toggle', 'type' => 'checkbox', 'label' => false));?>
						</div>
					</div>
				</div>
				<?php echo $this->Form->input('geo_fence_radius', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('Geo Fence Radius'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<?php echo $this->Html->link('<i class="icon-external-link"></i> ' . __('Update Status'), array('controller' => 'signs', 'action' => 'querySign', $this->data['Sign']['me_id']), array('class' => 'btn yellow updatestatusbtn mini right', 'escape' => false));?>
						<?php echo $this->Form->hidden('geo_fence_enable_value', array('value' => $this->data['Sign']['geo_fence_enable']));?>
						<?php echo $this->Form->hidden('geo_fence_radius_value', array('value' => $this->data['Sign']['geo_fence_radius']));?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo __('Reset Sign');?></label>
					<div class="controls">
						<?php echo $this->Html->link('<i class="icon-external-link"></i> ' . __('Send Reset'), array('controller' => 'signs', 'action' => 'ajaxreset', $this->data['Sign']['id']), array('class' => 'btn red resetbtn mini right', 'escape' => false));?>
						<?php echo $this->Form->input('Reset.level', array('div' => false, 'label' => false, 'class' => 'm-wrap small', 'options' => array('00' => '0', '01' => '1', '02' => 2, '03' => 3, '255' => 255), 'empty' => ''));?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">

	<div class="span4">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-wrench"></i><?php echo __('Custom Fields');?></h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body form">
				<?php if (!empty($customlabels)) { ?>
				<?php for ($i=0;$i<count($customlabels);$i++) { ?>
				<?php $f = $customlabels[$i];?>
				<?php echo $this->Form->input('CustomField.'.$i.'.value', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => $f['CustomLabel']['text'], 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
				<?php echo $this->Form->hidden('CustomField.'.$i.'.company_id', array('value' => $this->data['Sign']['company_id']));?>
				<?php echo $this->Form->hidden('CustomField.'.$i.'.sign_id', array('value' => $this->data['Sign']['id']));?>
				<?php echo $this->Form->hidden('CustomField.'.$i.'.custom_label_id', array('value' => $f['CustomLabel']['id']));?>
				<?php echo $this->Form->hidden('CustomField.'.$i.'.id');?>
				<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-calendar"></i><?php echo __('Current Message');?></h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body form">
			<?php if (!empty($frames)) { ?>
			<?php echo $this->element('sign-frames');?>
			<?php echo $this->Html->link(__('Edit Message'), array('controller' => 'signs', 'action' => 'frames', $this->data['Sign']['id']), array('class' => 'btn green'));?>
			<?php } else if (!empty($this->data['Sign']['id'])) {?>
			<?php echo $this->Html->link(__('Add Message'), array('controller' => 'signs', 'action' => 'frames', $this->data['Sign']['id']), array('class' => 'btn green'));?>
			<?php } ?>
			<hr/>
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
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-calendar"></i><?php echo __('Company Hire Dates');?></h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body form">
			<?php if (!empty($contracts)) { ?>
			<?php echo $this->element('contract-table');?>
			<?php } ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="portlet box grey">
			<div class="portlet-title">
				<h4><i class="icon-rss"></i><?php echo __('Sign Communication Log');?></h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body form">
				<?php echo $this->Form->input('details', array('div' => 'control-group', 'class' => 'm-wrap span12', 'rows' => 10, 'label' => array('text' => null, 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>
<?php if (!empty($this->data['Sign']['lat']) && !empty($this->data['Sign']['lng'])) { ?>
	<?php $marker = array(
		'lat' => "$('#map_canvas').data('lat')", 
		'lng' => "$('#map_canvas').data('lng')",
		'content'=>'<h3>' . $this->data['Sign']['name'] . '</h3>',
	);?>
	<?php echo $this->Html->script($this->Googlemap->apiUrl(), array('inline' => false));?>
	<?php echo $this->Googlemap->map(array('div' => array('id' => 'map_canvas', 'inline' => false), 'lat' => "$('#map_canvas').data('lat')", 'lng' => "$('#map_canvas').data('lng')", 'zoom' => 15));?>
	<?php $this->Googlemap->addMarker($marker);?>
	<?php echo $this->Googlemap->script(array('inline' => false));?>
<?php } ?>