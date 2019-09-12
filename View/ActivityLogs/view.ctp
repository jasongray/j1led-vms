<?php $this->Html->addCrumb(__('Log Entries'), array('controller' => 'activityLogs', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Log Entry').' #'.$log['ActivityLog']['id']);?>
<?php echo $this->Html->css(array('bootstrap-toggle-buttons', 'jquery.tagsinput'), null, array('block' => 'css'));?>
<?php echo $this->Html->script(array('jquery.tagsinput.min', 'jquery.toggle.buttons'), array('inline' => false));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="<?php echo $this->Xhtml->iconme($log['ActivityLog']['description']);?>"></i><?php echo __('Log entry ');?> #<?php echo $log['ActivityLog']['id'];?></h4>
			</div>
			<div class="portlet-body form">
				<div class="row-fluid">
					<?php $label = (!empty($log['ActivityLog']['type']))? 'label-'.$log['ActivityLog']['type']: '';?>
					<div class="span3">
						<p><?php echo __('Log Entry');?></p>
						<p><?php echo __('Created');?></p>
						<p><?php echo __('User');?></p>
						<p><?php echo __('Company');?></p>
						<p><?php echo __('IP Address');?></p>
					</div>
					<div class="span9">
						<p><?php if($log['ActivityLog']['type'] != 'error') echo $log['ActivityLog']['description'];?></p>
						<p><?php echo $this->Time->timeAgoInWords($log['ActivityLog']['created']);?></p>
						<p><?php if (!empty($log['User']['firstname']) && !empty($log['User']['surname'])) { 
							$name = $log['User']['firstname'] . ' ' . $log['User']['surname'];
						}else {
							$name = $log['User']['username'];
						}
						echo $this->Html->link($name, array('controller' => 'users', 'action' => 'edit', $log['User']['id']));
						?></p>
						<p><?php if (!empty($log['Company']['name'])) { 
							echo $this->Html->link($log['Company']['name'], array('controller' => 'companies', 'action' => 'edit', $log['Company']['id']));
						}?></p>
						<p><?php echo $log['ActivityLog']['ipaddr'];?></p>
					</div>
				</div>
				<?php if ($log['ActivityLog']['type'] == 'error') { ?>
				<div class="row-fluid">
					<?php echo $this->Html->tag('pre', $log['ActivityLog']['description']);?>
				</div>
				<?php } ?>
				<?php if (!empty($sign)) { ?>
				<hr/>
				<div class="row-fluid">
						<div class="span3">
							<p><?php echo __('Sign Name');?></p>
							<p><?php echo __('Sign Type');?></p>
							<p><?php echo __('Registration');?></p>
							<p><?php echo __('Location');?></p>
						</div>
						<div class="span9">
							<p><?php echo $this->Html->link($sign['Sign']['name'], array('controller' => 'signs', 'action' => 'edit', $sign['Sign']['id']));?></p>
							<p><?php echo $sign['SignType']['name'];?></p>
							<p><?php echo $sign['Sign']['registration'];?></p>
							<p><?php echo $sign['Sign']['location'];?></p>
						</div>
				</div>
				<?php } ?>
				<div class="form-actions">
				<?php
					echo $this->Form->hidden('id');
					echo $this->Html->link(__('Cancel'), array('controller' => 'activityLogs', 'action' => 'cancel'), array('class' => 'btn black'));
					if($editable){
						echo $this->Html->link(__('Delete'), array('controller' => 'activityLogs', 'action' => 'delete', $log['ActivityLog']['id']), array('class' => 'btn red'));
					}
				?>	
				</div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
</div>