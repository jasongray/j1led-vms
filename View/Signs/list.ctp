<?php $this->Html->addCrumb(__('Signs'));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-th-list"></i><?php echo __('Signs');?></h4>
			</div>
			<div class="portlet-body">
				<?php if (!empty($signs)) { ?>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('name', __('Sign'));?></th>
							<?php if (!empty($labels)) { ?>
							<?php foreach ($labels as $l) { ?>
							<th><?php echo $l['CustomLabel']['text'];?></th>
							<?php } ?>
							<?php } ?>
							<th class="hidden-phone"><?php echo __('Status');?></th>
							<th class="hidden-phone"><?php echo __('Voltage');?></th>
							<th class="hidden-phone"><?php echo $this->Paginator->sort('location', __('Depot'));?></th>
							<?php if ($editable) { ?>
							<th class="hidden-phone" colspan="2"><?php echo __('Actions');?></th>
							<?php } else { ?>
							<th>&nbsp;</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($signs as $s) { ?>
							<?php $xml = simplexml_load_string($s['Sign']['details']);?>
							<tr>
								<td><?php if ($editable) { echo $this->Html->link($s['Sign']['name'], array('controller' => 'signs', 'action' => 'edit', $s['Sign']['id'])); } else { echo $this->Html->link($s['Sign']['name'], array('controller' => 'signs', 'action' => 'view', $s['Sign']['id'])); }?></td>
								<?php if (!empty($labels)) { ?>
								<?php foreach ($labels as $l) { ?>
								<?php foreach ($s['CustomField'] as $f) { ?>
								<?php if ($f['custom_label_id'] == $l['CustomLabel']['id']) { ?>
								<td><?php echo $f['value'];?></td>
								<?php } else { ?>
								<td>&nbsp;</td>
								<?php } ?>
								<?php } ?>
								<?php } ?>
								<?php } ?>
								<td class="hidden-phone"><?php if (!empty($xml)){ echo $this->Xhtml->badgeme($xml->status->{'hearbeat-poll'}, 'OK'); }?></td>
								<td class="hidden-phone"><?php if (!empty($s['Sign']['battery_voltage'])){ echo $this->Xhtml->batteryalert($s['Sign']['battery_voltage']);} ?></td>
								<td class="hidden-phone"><?php echo $s['Sign']['location'];?></td>
								<?php if ($editable) { ?>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Edit'), array('controller' => 'signs', 'action' => 'frames', $s['Sign']['id']), array('class' => 'btn mini yellow', 'escape' => false));?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-trash"></i> ' . __('Delete'), array('controller' => 'signs', 'action' => 'delete', $s['Sign']['id']), array('class' => 'btn mini black', 'escape' => false));?></td>
								<?php } else { ?>
								<td class="hidden-phone"><?php echo $this->Html->link(__('View Details'), array('controller' => 'signs', 'action' => 'view', $s['Sign']['id']), array('class' => 'btn mini green', 'escape' => false)); ?></td>
								<?php } ?>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php echo $this->element('pagination');?>
				<?php } else { ?>
				<div class="alert alert-block alert-error fade in">
					<button data-dismiss="alert" class="close" type="button"></button>
					<p><?php echo __('There are no signs assigned to you as yet.');?></p>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>