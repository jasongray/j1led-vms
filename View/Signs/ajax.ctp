<?php $this->Html->addCrumb(__('Signs'));?>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-th-large"></i><?php echo __('Signs');?></h4>
			</div>
			<div class="portlet-body">
				<?php if ($s) { ?>
					<div class="span3">
						<div id="sign-info" class="grid-table">
							<h3><?php echo $s['Sign']['name'];?></h3>
							<?php if (!empty($s['Contract'])){ ?>
							<div class="desc">
								<h5><?php echo $s['Contract']['title'];?></h5>
								<?php if ($this->Xhtml->dateBetween($s['Contract']['on_hire_date'], $s['Contract']['off_hire_date'])) { ?>
								<span class="badge badge-important"><?php echo $this->Time->niceShort($s['Contract']['on_hire_date']);?></span> - 
								<span class="badge badge-important right"><?php echo $this->Time->niceShort($s['Contract']['off_hire_date']);?></span>
								<?php } else { ?>
								<span class="badge"><?php echo $this->Time->niceShort($s['Contract']['on_hire_date']);?></span> - 
								<span class="badge"><?php echo $this->Time->niceShort($s['Contract']['off_hire_date']);?></span>
								<?php } ?>
							</div>
							<?php } ?>
							<div class="desc">
								<?php if (!empty($s['SignType']['image'])){ echo $this->Resize->image('signtypes/'. $s['SignType']['image'], 150, 150, false, array('alt' => '', 'style' => 'margin:0 auto;display:block;')); }?>
								<?php // might show frame images here also.... ?>
							</div>
							<ul class="unstyled">
								<li><?php echo __('Status');?>: <?php if($s['Sign']['enabled'] == 0){$_er=' dark-grey';}else{$_er=' green';} ?><i class="icon-circle<?php echo $_er;?>" style="margin:0;"></i></li>
								<li><?php echo __('Location');?>: <?php echo $s['Sign']['location'];?></li>
							</ul>
							<div class="rate">
								<?php if ($editable) { echo $this->Html->link(__('Edit') . ' <i class="m-icon-swapright m-icon-white"></i>', array('controller' => 'signs', 'action' => 'edit', $s['Sign']['id']), array('class' => 'btn green', 'escape' => false)); } else { echo $this->Html->link(__('View Details') . ' <i class="m-icon-swapright m-icon-white"></i>', array('controller' => 'signs', 'action' => 'view', $s['Sign']['id']), array('class' => 'btn green', 'escape' => false)); };?>
							</div>
						</div>
						<br class="clear-fix"/>
					</div>
				<?php } else { ?>
				<div class="alert alert-block alert-error fade in">
					<button data-dismiss="alert" class="close" type="button"></button>
					<p><?php echo __('There are no signs assigned to you as yet.');?></p>
				</div>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>