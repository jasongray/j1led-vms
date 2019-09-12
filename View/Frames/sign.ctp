<?php echo $this->Html->css(array('framepreview'), null, array('block' => 'css'));?>
<?php echo $this->Html->script(array('framemsg'), array('inline' => false));?>
<?php echo $this->Html->scriptBlock('
jQuery(document).ready(function() {
	Frames.init();
});', array('inline' => false));?>			
					<div class="row-fluid">
						<div class="span3">
							<div class="portlet box blue">
								<div class="portlet-title">
									<h4><i class="icon-book"></i><?php echo __('Sign Library');?></h4>
									<div class="tools">
										<a href="javascript:;" class="collapse"></a>
									</div>
								</div>
								<div class="portlet-body">
									<div class="tabbable tabbable-custom">
										<ul class="nav nav-tabs">
											<li class="active"><a href="#tab_1_1" data-toggle="tab">Predefined Imgs</a></li>
											<li><a href="#tab_1_2" data-toggle="tab">Custom Imgs</a></li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="tab_1_1">
												<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
													<?php if (!empty($frames)) { ?>
													<ul class="feeds">
													<?php foreach($frames as $f) { ?>
														<li class="selectPredefined"><?php echo $this->Html->image('frames/'.$f['SignImage']['image'], array('alt' => $f['SignImage']['image']));?> <?php echo $f['SignImage']['name'];?></li>
													<?php } ?>
													</ul>
													<?php } ?>
												</div>
											</div>
											<div class="tab-pane active" id="tab_1_2">
												<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="span6">
							<div class="portlet box blue">
								<div class="portlet-title">
									<h4><i class="icon-desktop"></i><?php echo __('Sign Messages');?></h4>
									<div class="tools">
										<a href="javascript:;" class="collapse"></a>
									</div>
								</div>
								<div class="portlet-body previewwrapper">
									<?php if (!empty($s['SignType'])) { ?>
									<table id="framepreview" border="0">
										<tr>
											<td colspan="<?php echo $s['SignType']['width'];?>" style="background-image: none; background-color: black"></td>
										</tr>
										<?php for ($h=0;$h<$s['SignType']['height'];$h++){ ?>
										<tr align="center">
											<td style="background-image: none; background-color: black"></td>
											<?php for ($w=0;$w<$s['SignType']['width'];$w++){?>
											<td id="current_r<?php echo $h;?>c<?php echo $w;?>" class="led"></td>
											<?php } ?>
											<td style="background-image: none; background-color: black"></td>
										</tr>
										<?php } ?>
										<tr>
											<td colspan="<?php echo $s['SignType']['width'];?>" style="background-image: none; background-color: black"></td>
										</tr>
									</table>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="span3">
							<div class="portlet box blue">
								<div class="portlet-title">
									<h4><i class="icon-cog"></i><?php echo __('Diagnostics');?></h4>
									<div class="tools">
										<a href="javascript:;" class="collapse"></a>
									</div>
								</div>
								<div class="portlet-body">
									
								</div>
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span12">
							<?php // pr($s);?>
						</div>
					</div>