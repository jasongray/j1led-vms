<?php $this->Html->addCrumb(__('User Groups'));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-group"></i><?php echo __('User Groups');?></h4>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-advance table-hover">
					<thead>
						<tr>
							<th><?php echo __('Group Name');?></th>
							<th colspan="2" class="table-actions"><?php echo __('Actions');?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ($groups) { ?>
						<?php foreach ($groups as $g) { ?>
							<tr>
								<td class="highlight"><?php echo $this->Html->link($g['Group']['name'], array('controller' => 'groups', 'action' => 'edit', $g['Group']['id']));?></td>
								<td><?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Edit'), array('controller' => 'groups', 'action' => 'edit', $g['Group']['id']), array('class' => 'btn mini yellow', 'escape' => false));?></td>
								<td><?php echo $this->Html->link('<i class="icon-trash"></i> ' . __('Delete'), array('controller' => 'groups', 'action' => 'delete', $g['Group']['id']), array('class' => 'btn mini black', 'escape' => false));?></td>
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