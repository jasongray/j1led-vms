<?php $this->Html->addCrumb(__('Log Entries'));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-group"></i><?php echo __('Log Entries');?></h4>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-advance table-hover">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th><?php echo __('Log Entry');?></th>
							<th><?php echo __('Created');?></th>
							<th colspan="2" class="table-actions">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php if ($activity) { ?>
						<?php foreach ($activity as $l) { ?>
							<tr>
								<td class="highlight"><?php $label = (!empty($l['ActivityLog']['type']))? 'label-'.$l['ActivityLog']['type']: '';?>
									<span class="label <?php echo $label;?>">
										<i class="<?php echo $this->Xhtml->iconme($l['ActivityLog']['description']);?>"></i>
									</span>
								</td>
								<td><?php if(preg_match('/(\bsign\b)/', $l['ActivityLog']['description'], $m)) { 
									if(preg_match('/\((\d+)\)/', $l['ActivityLog']['description'], $m)) {
										$l['ActivityLog']['description'] = preg_replace('/\((\d+)\)/', '(' . _('Sign id') . ': '  . $this->Html->link($m[1], array('controller' => 'signs', 'action' => 'edit', $m[1])) . ')', $l['ActivityLog']['description']);
									}
								;}?>
								<?php echo substr($l['ActivityLog']['description'], 0, 100); ?> 
								<?php if(!empty($l['User']['username'])){ echo '(' . _('User id') . ': ' . $this->Html->link($l['User']['username'], array('controller' => 'users', 'action' => 'edit', $l['User']['id'])) . ')'; }?></td>
								<td><?php echo $this->Time->timeAgoInWords($l['ActivityLog']['created']);?></td>
								<td><?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('View'), array('controller' => 'activityLogs', 'action' => 'view', $l['ActivityLog']['id']), array('class' => 'btn mini yellow', 'escape' => false));?></td>
								<?php if ($editable) { ?>
								<td><?php echo $this->Html->link('<i class="icon-trash"></i> ' . __('Delete'), array('controller' => 'activityLogs', 'action' => 'delete', $l['ActivityLog']['id']), array('class' => 'btn mini black', 'escape' => false));?></td>
								<?php } else { ?>
								<td>&nbsp;</td>
								<?php } ?>
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