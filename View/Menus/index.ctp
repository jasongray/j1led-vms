<?php $this->Html->addCrumb(__('Menus'));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-client"></i><?php echo __('Menus');?></h4>
			</div>
			<div class="portlet-body">
				<div class="row-fluid">
					<div class="span6">
					</div>
					<div class="span6">
					<?php echo $this->Html->link('<i class="icon-plus"></i> ' . __('Add Menu'), array('controller' => 'menus', 'action' => 'add'), array('class' => 'btn green right', 'escape' => false));?>	
					</div>
				</div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th class="hidden-phone" class="icon">Id</th>
							<th class="icon hidden-phone">Published</th>
							<th><?php echo $this->Paginator->sort('title', __('Menu Name'));?></th>
							<th class="hidden-phone"><?php echo $this->Paginator->sort('unique', __('Unique Name'));?></th>
							<th><?php echo __('Menu Items');?></th>
							<th class="hidden-phone"><?php echo $this->Paginator->sort('created');?></th>
							<th class="hidden-phone"><?php echo $this->Paginator->sort('modified');?></th>
							<th class="hidden-phone" colspan="2" style="width:170px;"><?php echo __('Actions');?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ($menus) { ?>
						<?php foreach ($menus as $m) { ?>
							<tr>
								<td class="hidden-phone"><?php echo $this->Html->link($m['Menu']['id'], array('controller' => 'menus', 'action' => 'edit', $m['Menu']['id']));?></td>
								<td class="hidden-phone"><?php if($m['Menu']['published'] == 0){$_er=' dark-grey';}else{$_er=' green';} ?><i class="icon-circle<?php echo $_er;?>"</i></td>
								<td><?php echo $this->Html->link($m['Menu']['title'], array('controller' => 'menus', 'action' => 'edit', $m['Menu']['id'])); ?></td>
								<td class="hidden-phone"><?php echo $m['Menu']['unique']; ?></td>
								<td><?php echo $this->Html->link($this->Html->image('fugue/24x24/application-sidebar.png', array('alt'=>'Items')), array('controller' => 'menuItems', 'action' => 'index', 'menu_id' => $m['Menu']['id']), array('escape' => false));?></td>
								<td class="hidden-phone"><?php echo $this->Time->niceShort($m['Menu']['created']);?></td>
								<td class="hidden-phone"><?php echo $this->Time->niceShort($m['Menu']['modified']);?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Edit'), array('controller' => 'menus', 'action' => 'edit', $m['Menu']['id']), array('class' => 'btn mini yellow', 'escape' => false));?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-trash"></i> ' . __('Delete'), array('controller' => 'menus', 'action' => 'delete', $m['Menu']['id']), array('class' => 'btn mini black', 'escape' => false));?></td>
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