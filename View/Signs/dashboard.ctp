					<div class="row-fluid">
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat blue">
								<div class="visual">
									<i class="icon-user"></i>
								</div>
								<div class="details">
									<div class="number"><?php echo $client_count;?></div>
									<div class="desc"><?php echo __('Companies');?></div>
								</div>
								<?php echo $this->Html->link(__('View more').' <i class="m-icon-swapright m-icon-white"></i>', array('controller' => 'companies', 'action' => 'index', 'plugin' => false, 'admin' => false), array('escape' => false, 'class' => 'more'));?>
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat green">
								<div class="visual">
									<i class="icon-desktop"></i>
								</div>
								<div class="details">
									<div class="number"><?php echo $sign_count;?></div>
									<div class="desc"><?php echo __('Active Signs');?></div>
								</div>
								<?php echo $this->Html->link(__('View more').' <i class="m-icon-swapright m-icon-white"></i>', array('controller' => 'signs', 'action' => 'index', 'plugin' => false, 'admin' => false), array('escape' => false, 'class' => 'more'));?>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6  fix-offset" data-desktop="span3">
							<div class="dashboard-stat purple">
								<div class="visual">
									<i class="icon-globe"></i>
								</div>
								<div class="details">
									<div class="number"><?php echo $this->Number->toPercentage($user_count, 2);?></div>
									<div class="desc"><?php echo __('Client Usage');?></div>
								</div>
								<?php echo $this->Html->link(__('View more').' <i class="m-icon-swapright m-icon-white"></i>', array('controller' => 'users', 'action' => 'index', 'plugin' => false, 'admin' => false), array('escape' => false, 'class' => 'more'));?>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat yellow">
								<div class="visual">
									<i class="icon-bar-chart"></i>
								</div>
								<div class="details">
									<div class="number"><?php echo $contract_count;?></div>
									<div class="desc"><?php echo __('Active Contracts');?></div>
								</div>
								<?php echo $this->Html->link(__('View more').' <i class="m-icon-swapright m-icon-white"></i>', array('controller' => 'contracts', 'action' => 'index', 'plugin' => false, 'admin' => false), array('escape' => false, 'class' => 'more'));?>						
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<?php if (!empty($log)) { ?>
						<div class="span6">
							<div class="portlet paddingless">
								<div class="portlet-title line">
									<h4><i class="icon-bell"></i><?php echo __('Activity Log');?></h4>
									<div class="tools">
										<a href="javascript:;" class="collapse"></a>
									</div>
								</div>
								<div class="portlet-body">
									<ul class="feeds">
										<?php foreach ($log as $l) { ?>
										<li>
											<div class="col1">
												<div class="cont">
													<div class="cont-col1">
														<?php $label = (!empty($l['ActivityLog']['type']))? 'label-'.$l['ActivityLog']['type']: '';?>
														<div class="label <?php echo $label;?>">
															<i class="<?php echo $this->Xhtml->iconme($l['ActivityLog']['description']);?>"></i>
														</div>
													</div>
													<div class="cont-col2">
														<div class="desc">
															<?php if(preg_match('/(\bsign\b)/', $l['ActivityLog']['description'], $m)) { 
																if(preg_match('/\((\d+)\)/', $l['ActivityLog']['description'], $m)) {
																	$l['ActivityLog']['description'] = preg_replace('/\((\d+)\)/', '(' . _('Sign id') . ': '  . $this->Html->link($m[1], array('controller' => 'signs', 'action' => 'edit', $m[1])) . ')', $l['ActivityLog']['description']);
																}
															;}?>
															<?php if($l['ActivityLog']['type'] == 'error' || $l['ActivityLog']['type'] == 'debug') echo substr($l['ActivityLog']['description'], 0, 50) . ' ' . $this->Html->link(__('View log') . ' <i class="icon-share-alt"></i>', array('controller' => 'activityLogs', 'action' => 'view', $l['ActivityLog']['id']), array('escape' => false, 'class' => 'btn mini')); else echo substr($l['ActivityLog']['description'], 0, 80);?> 
															<?php if(!empty($l['User']['username'])){ echo '(' . _('User id') . ': ' . $this->Html->link($l['User']['username'], array('controller' => 'users', 'action' => 'edit', $l['User']['id'])) . ')'; }?>
														</div>
													</div>
												</div>
											</div>
											<div class="col2">
												<div class="date"><?php echo $this->Time->timeAgoInWords($l['ActivityLog']['created']);?></div>
											</div>
										</li>
										<?php } ?>
									</ul>
									<?php echo $this->Html->link(__('View all log entries') . ' <i class="icon-double-angle-right"></i>', array('controller' => 'activityLogs', 'action' => 'index'), array('escape' => false));?>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>