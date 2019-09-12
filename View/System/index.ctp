<?php echo $this->Html->css(array('jquery.gritter'), null, array('block' => 'css'));?>
<?php echo $this->Html->script(array('jquery.gritter.min', 'system.functions'), array('inline' => false));?>				
				<div class="row-fluid">
					<div class="span6">
						<div class="portlet box green">
							<div class="portlet-title">
								<h4><i class="icon-cogs"></i><?php echo __('Change Log');?></h4>
							</div>
							<div class="portlet-body">
								<?php echo __('Version');?> <?php echo $ver;?>
								<pre>
								<?php echo $changelog;?>
								</pre>
							</div>
						</div>
					</div>
					<?php /* ?>
					<div class="span6">
						<!-- BEGIN PROGRESS BARS PORTLET-->
						<div class="portlet box green">
							<div class="portlet-title">
								<h4><i class="icon-cogs"></i>Updates</h4>
							</div>
							<div class="portlet-body">
								<div class="progress-wrapper"></div>
								<?php echo $this->Html->link('Download Update 2.6', array('controller' => 'system', 'action' => 'downloadUpdate', '2.6'), array('class' => 'downloadupdate btn btn-mini purple'));?>
							</div>
						</div>
					</div>
					<?php */ ?>
					<div class="span6">
						<div class="portlet box green">
							<div class="portlet-title">
								<h4><i class="icon-table"></i><?php echo __('Table Status');?></h4>
							</div>
							<div class="portlet-body">
								<?php echo $this->Html->link(_('Backup Database'), array('controller' => 'system', 'action' => 'backupDB'), array('class' => 'btn btn-navbar right'));?>
								<table class="table table-striped databasetables">
									<thead>
									<tr>
										<th><?php echo __('Table Name');?></th>
										<th><?php echo __('Rows');?></th>
										<th><?php echo __('Actions');?></th>
										<th><?php echo __('Collation');?></th>
										<th><?php echo __('Size');?></th>
										<th><?php echo __('Overhead');?></th>
									</tr>
									</thead>
									<tbody>
									<?php foreach ($tables as $t) { ?> 
									<tr>
										<td><?php echo $t['Name'];?></td>
										<td><?php echo $t['Rows'];?></td>
										<td><?php echo $this->Html->link('<i class="icon icon-trash"></i>', array('controller' => 'system', 'action' => 'emptyTable', 'table' => $t['Name']), array('escape' => false));?></td>
										<td><?php echo $t['Collation'];?></td>
										<td><?php echo $this->Number->toReadableSize($t['Index_length']);?></td>
										<?php if ($t['Data_free'] > 0) { ?>
										<td><span class="badge badge-warning"><?php echo $this->Number->toReadableSize($t['Data_free']);?> <?php echo $this->Html->link('<i class="icon icon-magic"></i>', array('controller' => 'system', 'action' => 'optimiseTable', 'table' => $t['Name']), array('escape' => false));?></span></td>
										<?php } else { ?>
										<td>-</td>
										<?php } ?>
									</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
<?php echo $this->Html->scriptBlock('
jQuery(document).ready(function() {
	System.init();
});', array('inline' => false));?>	