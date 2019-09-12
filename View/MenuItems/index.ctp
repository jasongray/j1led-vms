<?php $this->Html->addCrumb(__('Menus'), array('controller' => 'menus', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Menu Items'));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-client"></i><?php echo __('Menu Items');?></h4>
			</div>
			<div class="portlet-body">
				<div class="row-fluid">
					<div class="span6">
					</div>
					<div class="span6">
					<?php echo $this->Html->link('<i class="icon-plus"></i> ' . __('Add Menu Item'), array('controller' => 'menuItems', 'action' => 'add', 'menu_id' => $this->passedArgs['menu_id']), array('class' => 'btn green right', 'escape' => false));?>	
					</div>
				</div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th class="icon hidden-phone">Id</th>
							<th><?php echo $this->Paginator->sort('title', __('Menu Name'));?></th>
							<th class="hidden-phone"><?php echo __('Default');?></th>
							<th class="icon hidden-phone">Published</th>
							<th colspan="2">Ordering</th>
							<th class="hidden-phone"><?php echo $this->Paginator->sort('created');?></th>
							<th class="hidden-phone"><?php echo $this->Paginator->sort('modified');?></th>
							<th class="hidden-phone" colspan="2" style="width:170px;"><?php echo __('Actions');?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ($menuItems) { ?>
						<?php $i = 0; ?>
						<?php foreach ($menuItems as $m) { ?>
							<tr>
								<td class="hidden-phone"><?php echo $this->Html->link($m['MenuItem']['id'], array('controller' => 'menuItems', 'action' => 'edit', $m['MenuItem']['id'], 'menu_id' => $this->passedArgs['menu_id']));?></td>
								<td><?php echo $this->Html->link($m['MenuItem']['treename'], array('controller' => 'menuItems', 'action' => 'edit', $m['MenuItem']['id'], 'menu_id' => $this->passedArgs['menu_id']), array('escape' => false)); ?></td>
								<td class="hidden-phone"><?php if($m['MenuItem']['default'] == 1){ echo $this->Html->image('fugue/16x16/home.png', array('alt'=>'Default'));}?></td>	
								<td class="hidden-phone"><?php if($m['MenuItem']['published'] == 0){$_er=' dark-grey';}else{$_er=' green';} ?><i class="icon-circle<?php echo $_er;?>"</i></td>
								<td><?php if($i != 0){ echo $this->Html->link('<i class="icon-arrow-up"></i>', array('controller' => 'menuItems', 'action' => 'orderup', $m['MenuItem']['id'], 'menu_id' => $this->passedArgs['menu_id']), array('escape'=>false));}?></td>
		<td><?php if($i < count($menuItems) - 1){ echo $this->Html->link('<i class="icon-arrow-down"></i>', array('controller' => 'menuItems', 'action' => 'orderdown', $m['MenuItem']['id'], 'menu_id' => $this->passedArgs['menu_id']), array('escape'=>false));}?></td>
								<td class="hidden-phone"><?php echo $this->Time->niceShort($m['MenuItem']['created']);?></td>
								<td class="hidden-phone"><?php echo $this->Time->niceShort($m['MenuItem']['modified']);?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Edit'), array('controller' => 'menuItems', 'action' => 'edit', $m['MenuItem']['id'], 'menu_id' => $this->passedArgs['menu_id']), array('class' => 'btn mini yellow', 'escape' => false));?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-trash"></i> ' . __('Delete'), array('controller' => 'menuItems', 'action' => 'delete', $m['MenuItem']['id'], 'menu_id' => $this->passedArgs['menu_id']), array('class' => 'btn mini black', 'escape' => false));?></td>
							</tr>
						<?php $i++; ?>
						<?php } ?>
					<?php } ?>
					</tbody>
				</table>
				<?php echo $this->element('pagination');?>
			</div>
		</div>
	</div>
</div>