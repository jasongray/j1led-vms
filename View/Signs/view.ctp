<?php $this->Html->addCrumb(__('Signs'), array('controller' => 'signs', 'action' => 'index'));?>
<?php $this->Html->addCrumb($sign['Sign']['name']);?>
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
				<table class="table table-striped table-hover">
					<tbody>
						<tr>
							<th><?php echo __('Sign Name');?></th>
							<td><?php echo $sign['Sign']['name'];?></td>
						</tr>
						<tr>
							<th><?php echo __('Address');?></th>
							<td><?php echo $sign['Sign']['address'];?></td>
						</tr>
						<tr>
							<th><?php echo __('Trailer Registration');?></th>
							<td><?php echo $sign['Sign']['registration'];?></td>
						</tr>
						<tr>
							<th><?php echo __('Battery Voltage');?></th>
							<td><?php echo $this->Xhtml->batteryalert($sign['Sign']['battery_voltage']);?></td>
						</tr>
						<?php if (!empty($customlabels)) { ?>
						<?php foreach ($customlabels as $l) { ?>
						<tr>
							<th><?php echo $l['CustomLabel']['text'];?></th>
							<td><?php echo $l['CustomField']['value'];?></td>
						</tr>
						<?php } ?>
						<?php } ?>
					</tbody>
				</table>
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
				<p><strong><?php echo __('Current Message');?></strong>: </p>
				<?php if (!empty($frames)) { ?>
				<?php echo $this->element('sign-frames', array(compact('frames')));?>
				<?php } ?>
				<p><strong><?php echo __('Current Location');?></strong>: </p>
				<div id="map_canvas" class="span12" style="height:300px;overflow:hidden;margin: 0 0 25px 0;float:none;"></div>
			</div>
		</div>
	</div>
</div>
<?php if (!empty($sign['Sign']['lat']) && !empty($sign['Sign']['lng'])) { ?>
	<?php $marker = array(
		'lat' => $sign['Sign']['lat'], 
		'lng' => $sign['Sign']['lng'],
		'content'=>'<h3>' . $sign['Sign']['name'] . '</h3>',
	);?>
	<?php echo $this->Html->script($this->Googlemap->apiUrl(), array('inline' => false));?>
	<?php echo $this->Googlemap->map(array('div' => array('id' => 'map_canvas', 'inline' => false), 'lat' => $sign['Sign']['lat'], 'lng' => $sign['Sign']['lng'], 'zoom' => 16));?>
	<?php $this->Googlemap->addMarker($marker);?>
	<?php echo $this->Googlemap->script(array('inline' => false));?>
<?php } ?>