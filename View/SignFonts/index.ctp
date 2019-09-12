<?php $this->Html->addCrumb(__('Sign Fonts'));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-font"></i><?php echo __('Sign Fonts');?></h4>
			</div>
			<div class="portlet-body">
				<div class="row-fluid">
					<div class="span6">
					</div>
					<div class="span6">
					<?php echo $this->Html->link('<i class="icon-plus"></i> ' . __('Add Font'), array('controller' => 'signFonts', 'action' => 'add'), array('class' => 'btn green right', 'escape' => false));?>	
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
					<?php if ($fonts) { ?>
						<?php foreach ($fonts as $f) { ?>
							<tr>
								<td><?php echo $this->Html->link($f['SignFont']['title'], array('controller' => 'signFonts', 'action' => 'edit', $f['SignFont']['id']));?></td>
								<td><?php echo $f['SignFont']['rta_code'];?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Edit'), array('controller' => 'signFonts', 'action' => 'edit', $f['SignFont']['id']), array('class' => 'btn mini yellow', 'escape' => false));?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-trash"></i> ' . __('Delete'), array('controller' => 'signFonts', 'action' => 'delete', $f['SignFont']['id']), array('class' => 'btn mini black', 'escape' => false));?></td>
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