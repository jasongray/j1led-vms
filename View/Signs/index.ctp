<?php //$this->Paginator->options(array('url' => $this->passedArgs)); ?>
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
							<th><?php echo $this->Paginator->sort('company_id', __('Company'));?></th>
							<th><?php echo __('Status');?></th>
							<th><?php echo __('Voltage');?></th>
							<th class="hidden-phone"><?php echo $this->Paginator->sort('location', __('Location'));?></th>
							<th class="hidden-phone" colspan="3"><?php echo __('Actions');?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($signs as $s) { ?>
							<tr>
								<?php $btnclass = ($s['Sign']['locked'] == 1 && $s['Sign']['locked_by'] != $this->Session->read('Auth.User.id'))? ' disabled': ''; ?>
								<td><?php echo $s['Sign']['name']; ?></td>
								<td><?php echo $s['Company']['name'];?></td>
								<td class="hidden-phone">
									<?php if ($s['Sign']['locked'] == 1 && $s['Sign']['locked_by'] != $this->Session->read('Auth.User.id')) { ?>
										<?php $link1 = '#';?>
										<?php $link2 = '#';?>
										<?php $link3 = '#';?>
										<i class="icon-lock icon-large red"></i>
									<?php } else { ?>
										<?php $link1 = array('controller' => 'signs', 'action' => 'frames', $s['Sign']['id']);?>
										<?php $link2 = array('controller' => 'signs', 'action' => 'edit', $s['Sign']['id']);?>
										<?php $link3 = array('controller' => 'signs', 'action' => 'delete', $s['Sign']['id']);?>
										<?php if ($s['Sign']['enabled'] == 0){$_er=' dark-grey';}else{$_er=' green';} ?><i class="icon-circle<?php echo $_er;?>"</i>
									<?php } ?>
								</td>
								<td><?php if (!empty($s['Sign']['battery_voltage'])){ echo $this->Xhtml->batteryalert($s['Sign']['battery_voltage']);} ?></td>
								<td class="hidden-phone"><?php echo $s['Sign']['location'];?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Edit Content'), $link1, array('class' => 'btn mini blue'.$btnclass, 'escape' => false));?></td>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Sign Details'), $link2, array('class' => 'btn mini yellow'.$btnclass, 'escape' => false));?></td>
								<?php if ($editable) { ?>
								<td class="hidden-phone"><?php echo $this->Html->link('<i class="icon-trash"></i> ' . __('Delete'), $link3, array('class' => 'btn mini black'.$btnclass, 'escape' => false));?></td>
								<?php } else { ?>
								<td class="hidden-phone">&nbsp;</td>
								<?php } ?>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php echo $this->element('pagination');?>
				<?php }  ?>
			</div>
		</div>
	</div>
</div>