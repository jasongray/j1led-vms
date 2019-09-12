<?php $this->Html->addCrumb(__('Companies'));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-client"></i><?php echo __('Companies');?></h4>
			</div>
			<div class="portlet-body">
				<div class="row-fluid">
					<div class="span6">
					</div>
					<div class="span6">
					<?php echo $this->Html->link('<i class="icon-plus"></i> ' . __('Create Company'), array('controller' => 'companies', 'action' => 'add'), array('class' => 'btn green right', 'escape' => false));?>	
					</div>
				</div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('name', __('Company Name'));?></th>
							<th class="hidden-phone"><?php echo __('Contact Person');?></th>
							<th><?php echo __('Phone');?></th>
							<th class="hidden-phone"><?php echo $this->Paginator->sort('created');?></th>
							<th class="hidden-phone"><?php echo $this->Paginator->sort('modified');?></th>
							<th class="hidden-phone" colspan="2" style="width:170px;"><?php echo __('Actions');?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ($companies) { ?>
						<?php foreach ($companies as $u) { ?>
							<tr>
								<td><?php echo $this->Html->link($u['Company']['name'], array('controller' => 'companies', 'action' => 'edit', $u['Company']['id']));?></td>
								<td class="hidden-phone"><?php echo $u['Company']['contact'];?></td>
								<td><?php echo $u['Company']['phone'];?></td>
								<td class="hidden-phone"><?php echo $this->Time->niceShort($u['Company']['created']);?></td>
								<td class="hidden-phone"><?php echo $this->Time->niceShort($u['Company']['modified']);?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Edit'), array('controller' => 'companies', 'action' => 'edit', $u['Company']['id']), array('class' => 'btn mini yellow', 'escape' => false));?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-trash"></i> ' . __('Delete'), array('controller' => 'companies', 'action' => 'delete', $u['Company']['id']), array('class' => 'btn mini black', 'escape' => false));?></td>
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