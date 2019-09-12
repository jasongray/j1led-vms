<?php $this->Html->addCrumb(__('Sign Colours'));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-leaf"></i><?php echo __('Sign Colours');?></h4>
			</div>
			<div class="portlet-body">
				<div class="row-fluid">
					<div class="span6">
					</div>
					<div class="span6">
					<?php echo $this->Html->link('<i class="icon-plus"></i> ' . __('Add Colour'), array('controller' => 'signColours', 'action' => 'add'), array('class' => 'btn green right', 'escape' => false));?>	
					</div>
				</div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th><?php echo __('Name');?></th>
							<th><?php echo __('RTA Code');?></th>
							<th class="hidden-phone" colspan="2"><?php echo __('Actions');?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ($colours) { ?>
						<?php foreach ($colours as $c) { ?>
							<tr>
								<td><?php echo $this->Html->link($c['SignColour']['title'], array('controller' => 'signColours', 'action' => 'edit', $c['SignColour']['id']));?></td>
								<td><?php echo $c['SignColour']['rta_code'];?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Edit'), array('controller' => 'signColours', 'action' => 'edit', $c['SignColour']['id']), array('class' => 'btn mini yellow', 'escape' => false));?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-trash"></i> ' . __('Delete'), array('controller' => 'signColours', 'action' => 'delete', $c['SignColour']['id']), array('class' => 'btn mini black', 'escape' => false));?></td>
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