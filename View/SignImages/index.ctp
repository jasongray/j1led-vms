<?php $this->Html->addCrumb(__('Image Library'));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-check-empty"></i><?php echo __('Frame Images');?></h4>
			</div>
			<div class="portlet-body">
				<div class="row-fluid">
					<div class="span6">
					</div>
					<div class="span6">
					<?php echo $this->Html->link('<i class="icon-plus"></i> ' . __('Add Image'), array('controller' => 'signImages', 'action' => 'add'), array('class' => 'btn green right', 'escape' => false));?>	
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
					<?php if ($images) { ?>
						<?php foreach ($images as $s) { ?>
							<tr>
								<td><?php echo $this->Html->link($s['SignImage']['name'], array('controller' => 'signImages', 'action' => 'edit', $s['SignImage']['id']));?></td>
								<td><?php if (!empty($s['SignImage']['image'])){ echo $this->Html->link($this->Resize->image('frames/'. str_replace('.bmp', '.png', $s['SignImage']['image']), 50, 50, true, array('alt' => '')), array('controller' => 'signImages', 'action' => 'edit', $s['SignImage']['id']), array('escape' => false)); }?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Edit'), array('controller' => 'signImages', 'action' => 'edit', $s['SignImage']['id']), array('class' => 'btn mini yellow', 'escape' => false));?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-trash"></i> ' . __('Delete'), array('controller' => 'signImages', 'action' => 'delete', $s['SignImage']['id']), array('class' => 'btn mini black', 'escape' => false));?></td>
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