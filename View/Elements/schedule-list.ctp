								<?php if (!empty($schedules)) { ?>
								<ul id="currentschedulelist" class="feeds">
									<?php foreach($schedules as $s) { ?>
									<li class="selectSchedule" data-schedule="<?php echo $s['Schedule']['id'];?>">
										<?php echo $this->Html->link($s['Schedule']['title'], array('controller' => 'schedules', 'action' => 'getframes', $s['Schedule']['id']), array('class' => 'editschedule btn mini'));?>
										<?php if ($s['Schedule']['end'] < time()) { ?><span class="btn mini red"><i class="icon-time icon-large"></i> <?php echo __('Expired');?></span><?php } ?>
										<?php echo $this->Html->link('<i class="icon-trash"></i>', array('controller' => 'schedules', 'action' => 'delete', $s['Schedule']['id']), array('class' => 'btn mini red right delschedule', 'data-scheduleid' => $s['Schedule']['id'], 'escape' => false));?>
											
										<?php echo $this->Html->link('<i class="icon-upload"></i> ' . __('Upload Schedule'), array('controller' => 'schedules', 'action' => 'ajaxupload', $s['Schedule']['id']), array('class' => 'btn mini green right uploadschedule', 'escape' => false));?>
									</li>
									<?php } ?>
								</ul>
								<?php } ?>