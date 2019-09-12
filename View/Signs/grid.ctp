<?php $this->Html->addCrumb(__('Signs'));?>
<?php global $s;?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-th-large"></i><?php echo __('Signs');?></h4>
			</div>
			<div class="portlet-body">
				<?php if (!empty($signs)) { ?>
					<?php for ($i=0;$i<count($signs);$i++) { ?>
						<?php $s = $signs[$i]; ?>
						<?php $xml = simplexml_load_string($s['Sign']['details']);?>
						<?php if ($i==0) { ?>
				<div class="row-fluid">
						<?php } ?>
					<div class="span3">
						<div class="grid-table">
							<h3><?php echo $s['Sign']['name'];?></h3>
							<?php if (!empty($s['Contract'])){ ?>
							<div class="desc">
								<h5><?php echo $s['Contract']['title'];?></h5>
								<?php if ($this->Xhtml->dateBetween($s['Contract']['on_hire_date'], $s['Contract']['off_hire_date'])) { ?>
								<span class="badge badge-info"><?php echo $this->Time->niceShort($s['Contract']['on_hire_date']);?></span> - 
								<span class="badge badge-info right"><?php echo $this->Time->niceShort($s['Contract']['off_hire_date']);?></span>
								<?php } else { ?>
								<span class="badge"><?php echo $this->Time->niceShort($s['Contract']['on_hire_date']);?></span> - 
								<span class="badge"><?php echo $this->Time->niceShort($s['Contract']['off_hire_date']);?></span>
								<?php } ?>
							</div>
							<?php } ?>
							<div class="desc">
								<?php echo $this->element('sign-frames-grid', array('s' => $s));?>
							</div>
							<ul class="unstyled">
								<li><strong><?php echo __('Status');?>:</strong> <?php if (!empty($xml)){ echo $this->Xhtml->badgeme($xml->status->{'hearbeat-poll'}, 'OK'); }?></li>
								<li><strong><?php echo __('Battery');?>:</strong> <?php if (!empty($s['Sign']['battery_voltage'])){ echo $this->Xhtml->batteryalert($s['Sign']['battery_voltage']);} ?></li>
							</ul>
							<div class="rate">								
								<?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Edit Content'), array('controller' => 'signs', 'action' => 'frames', $s['Sign']['id']), array('class' => 'btn blue left', 'escape' => false));?>
							<?php if ($editable) { ?>
								<?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Sign Details'), array('controller' => 'signs', 'action' => 'edit', $s['Sign']['id']), array('class' => 'btn yellow right', 'escape' => false));?>
							<?php } ?>
							</div>
						</div>
						<br class="clear-fix"/>
					</div>
						<?php if (($i+1) % 4 == 0) { ?>
				<br class="clear-fix"/>			
				</div>
				<div class="row-fluid">
						<?php } ?>
					<?php } ?>
				<?php } else { ?>
				<div class="alert alert-block alert-error fade in">
					<button data-dismiss="alert" class="close" type="button"></button>
					<p><?php echo __('There are no signs assigned to you as yet.');?></p>
				</div>
				<?php } ?>
				</div>
				<?php echo $this->element('pagination');?>
			</div>
		</div>
	</div>
</div>