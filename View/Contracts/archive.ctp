<?php $this->Html->addCrumb(__('Contracts'), array('controller' => 'contracts', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Archived Contracts'));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-file-alt"></i><?php echo __('Archived Contracts');?></h4>
			</div>
			<div class="portlet-body">
				<div class="row-fluid">
					<div class="span6">
					</div>
					<div class="span6">
					</div>
				</div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('company_id', __('Company'));?></th>
							<th class="hidden-phone"><?php echo __('Contract');?></th>
							<th><?php echo $this->Paginator->sort('sign_id', __('Sign'));?></th>
							<th><?php echo $this->Paginator->sort('on_hire_date', __('On Hire'));?></th>
							<th><?php echo $this->Paginator->sort('off_hire_date', __('Off Hire'));?></th>
							<th colspan="2" class="hidden-phone" style="width:170px;"><?php echo __('Actions');?></th>
						</tr>
					</thead>
					<tbody>
				<?php foreach ($contracts as $c) { ?>
					<tr>
						<td><?php echo $c['Company']['name'];?></td>
						<td class="hidden-phone"><?php echo $c['Contract']['title'];?></td>
						<td><?php echo $c['Sign']['name'];?></td>
						<?php if ($this->Xhtml->dateBetween($c['Contract']['on_hire_date'], $c['Contract']['off_hire_date'])) { ?>
						<td><span class="badge badge-important"><?php echo $this->Time->niceShort($c['Contract']['on_hire_date']);?></span></td>
						<td><span class="badge badge-important"><?php echo $this->Time->niceShort($c['Contract']['off_hire_date']);?></span></td>
						<?php } else { ?>
						<td><span class="badge"><?php echo $this->Time->niceShort($c['Contract']['on_hire_date']);?></span></td>
						<td><span class="badge"><?php echo $this->Time->niceShort($c['Contract']['off_hire_date']);?></span></td>
						<?php } ?>
						<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Edit'), array('controller' => 'contracts', 'action' => 'edit', $c['Contract']['id']), array('class' => 'btn mini yellow', 'escape' => false));?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-trash"></i> ' . __('Delete'), array('controller' => 'contracts', 'action' => 'delete', $c['Contract']['id']), array('class' => 'btn mini black', 'escape' => false));?></td>
					</tr>
				<?php } ?>
					</tbody>
				</table>
				<?php echo $this->element('pagination');?>
			</div>
		</div>
	</div>
</div>