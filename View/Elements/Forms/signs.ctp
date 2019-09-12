<?php echo $this->Html->css(array('datepicker', 'bootstrap-toggle-buttons', 'jquery.tagsinput'), null, array('block' => 'css'));?>
<?php echo $this->Html->script(array('bootstrap-datepicker-2', 'jquery.tagsinput.min', 'jquery.toggle.buttons'), array('inline' => false));?>
<?php echo $this->Form->create('Sign', array('class' => 'form-horizontal', 'type' => 'file')); ?>
<div class="row-fluid">
	<div class="span8">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-lightbulb"></i><?php echo __('Sign Information');?></h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body form">
				<?php echo $this->Form->input('name', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Sign Name'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
				<div class="control-group">
					<label class="control-label"><?php echo __('Enable');?></label>
					<div class="controls">
						<div class="warning-toggle-button toggle-button">
							<?php echo $this->Form->input('enabled', array('div' => false, 'class' => 'toggle', 'type' => 'checkbox', 'label' => false));?>
						</div>
					</div>
				</div>
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
		<div class="portlet box green">
			<div class="portlet-title">
				<h4><i class="icon-spinner"></i><?php echo __('Recent Information');?></h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body form">
				<p><strong><?php echo __('Current Location');?></strong>: </p>
				<div id="map_canvas" class="span12" style="height:300px;overflow:hidden;margin: 0 0 25px 0;"></div>
				<br class="clear-fix"/>
				<?php // echo $this->Html->link('<i class="icon-external-link"></i> ' . __('Query Sign'), '#', array('class' => 'btn yellow refreshbtn pull-right', 'escape' => false));?>
				<?php if (isset($this->data['Sign']['details']) && !empty($this->data['Sign']['details'])) { ?>
				<?php $xml = simplexml_load_string($this->data['Sign']['details']);?>
				<p><strong><?php echo __('Sign Status');?></strong>: <span class="sign-status"><?php echo $xml->status->{'hearbeat-poll'};?></span></p>
				<?php } ?>
				<p><strong><?php echo __('Battery');?></strong>: <span class="sign-status"><?php echo $this->data['Sign']['battery_voltage'];?></span></p>
				<br class="clear-fix"/>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span8">
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
</div>
<?php echo $this->Form->end();?>
<?php if (!empty($this->data['Sign']['lat']) && !empty($this->data['Sign']['lng'])) { ?>
	<?php $marker = array(
		'lat' => $this->data['Sign']['lat'], 
		'lng' => $this->data['Sign']['lng'],
		'content'=>'<h3>' . $this->data['Sign']['name'] . '</h3>',
	);?>
	<?php echo $this->Html->script($this->Googlemap->apiUrl(), array('inline' => false));?>
	<?php echo $this->Googlemap->map(array('div' => array('id' => 'map_canvas', 'inline' => false), 'lat' => $this->data['Sign']['lat'], 'lng' => $this->data['Sign']['lng'], 'zoom' => 15));?>
	<?php $this->Googlemap->addMarker($marker);?>
	<?php echo $this->Googlemap->script(array('inline' => false));?>
<?php } ?>