<?php $this->Html->addCrumb(__('Sign Types'));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-group"></i><?php echo __('Signs');?></h4>
			</div>
			<div class="portlet-body">
				<div class="row-fluid">
					<div class="span6">
					</div>
					<div class="span6">
					<?php echo $this->Html->link('<i class="icon-plus"></i> ' . __('Add Sign'), array('controller' => 'signTypes', 'action' => 'add'), array('class' => 'btn green right', 'escape' => false));?>	
					</div>
				</div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th><?php echo __('Name');?></th>
							<th><?php echo __('Image');?></th>
							<th class="hidden-phone" colspan="2"><?php echo __('Actions');?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ($signs) { ?>
						<?php foreach ($signs as $s) { ?>
							<tr>
								<td><?php echo $this->Html->link($s['SignType']['name'], array('controller' => 'signTypes', 'action' => 'edit', $s['SignType']['id']));?></td>
								<td><?php if (!empty($s['SignType']['image'])){ echo $this->Html->link($this->Resize->image('signtypes/'. $s['SignType']['image'], 50, 50, false, array('alt' => '')), array('controller' => 'signTypes', 'action' => 'edit', $s['SignType']['id']), array('escape' => false)); }?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Edit'), array('controller' => 'signTypes', 'action' => 'edit', $s['SignType']['id']), array('class' => 'btn mini yellow', 'escape' => false));?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-trash"></i> ' . __('Delete'), array('controller' => 'signTypes', 'action' => 'delete', $s['SignType']['id']), array('class' => 'btn mini black', 'escape' => false));?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					</tbody>
				</table>
				<?php echo $this->element('pagination');?>
			</div>
		</div>
	</div>
</div>