<?php echo $this->Html->css(array('framepreview', 'bootstrap-editor'), null, array('block' => 'css'));?>
<?php echo $this->Html->script(array('framemsg'), array('inline' => false));?>
<?php echo $this->Html->scriptBlock('
jQuery(document).ready(function() {
	Frames.admininit();
});', array('inline' => false));?>	

				
				<div class="tabbable tabbable-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a class="designertabs" href="#tab_1_1" data-toggle="tab" data-type="freedraw"><?php echo __('Free Draw');?></a></li>
						<li id="texteditor"><a class="designertabs" href="#tab_1_2" data-toggle="tab" data-type="text"><?php echo __('Free Text');?></a></li>
						<li><a class="designertabs" href="#tab_1_4" data-toggle="tab" data-type="textfixed"><?php echo __('Text Only');?></a></li>
						<?php /* <li><a class="designertabs" href="#tab_1_3" data-toggle="tab" data-type="shapes"><?php echo __('Shapes');?></a></li> */ ?>
					</ul>
					<div class="tab-content" style="overflow:visible;">
						<div class="tab-pane active" id="tab_1_1">
							<?php if (!empty($ledcolours)) { ?>
							<div class="control-group">
								<label class="control-label"><?php echo __('Colour Palette');?></label>
								<div class="controls">
									<ul class="wysihtml5-toolbar">
										<li>
											<div class="btn-group">
									<?php foreach ($ledcolours as $c) { ?>
										<?php echo $this->Html->link('<i class="icon-pencil"></i>', '#', array('title' => 'Select ' . $c['SignColour']['title'] . ' LED', 'class' => 'btn editcolour', 'escape' => false, 'style' => 'background:' . $c['SignColour']['hex_colour'] . ';', 'data-colcode' => $c['SignColour']['col_code'], 'data-colour' => strtolower($c['SignColour']['title'])));?>
										<?php $colours[] = $c['SignColour']['rta_code'].'='.$c['SignColour']['col_code'];?>
									<?php } ?>	
											</div>
										</li>
										<li><?php echo $this->Html->link('<i class="icon-eraser"></i>', '#', array('title' => 'Eraser', 'class' => 'btn erasecolour', 'escape' => false));?></li>
										<li><?php echo $this->Html->link(__('Clear All'), '#', array('title' => 'Erase All', 'class' => 'btn eraseall', 'escape' => false));?></li>
									</ul>
								</div>
							</div>
							<?php } ?>
						</div>
						<div class="tab-pane" id="tab_1_2">
							<div class="control-group">
								<label class="control-label"><?php echo __('Text Editor');?></label>
								<div class="controls">
									<ul class="wysihtml5-toolbar">
										<li class="dropdown"><a href="#" data-toggle="dropdown" class="btn dropdown-toggle"><i class="icon-font"></i>&nbsp;<span class="current-font">5x7 Proportional</span>&nbsp;<b class="caret"></b></a>
											<ul class="dropdown-menu font">
												<li><a href="javascript:;" data-fontsize="5X7">5x7</a></li>
												<li><a href="javascript:;" data-fontsize="4X6">4x6</a></li>
												<li><a href="javascript:;" data-fontsize="6X10">6x10</a></li>
												<li><a href="javascript:;" data-fontsize="6X16">6x16</a></li>
												<li><a href="javascript:;" data-fontsize="8X10">8x10</a></li>
												<li><a href="javascript:;" data-fontsize="8X16">8x16</a></li>
											</ul>
										</li>
										<?php /* NOT USING THIS AT THE MOMENT, MAYBE LATER??  ?>
										<li class="dropdown"><a href="#" data-toggle="dropdown" class="btn dropdown-toggle"><span class="current-colour"><?php echo __('Select colour...');?></span>&nbsp;<b class="caret"></b></a>
											<?php if (!empty($ledcolours)) { ?>
											<ul class="dropdown-menu colour">
												<?php foreach ($ledcolours as $c) { ?>
												<li><a href="javascript:;" data-fontcolour="<?php echo strtolower($c['SignColour']['title']);?>" data-hexcode="<?php echo $c['SignColour']['hex_colour'];?>" data-rgbcode="<?php echo $c['SignColour']['col_code'];?>"><i class="icon-sign-blank" style="color:<?php echo $c['SignColour']['hex_colour'];?>;"></i>&nbsp;<?php echo ucwords($c['SignColour']['title']);?></a></li>
												<?php } ?>
											</ul>
											<?php } ?>
										</li>
										<?php */ ?>
										<li><?php echo $this->Html->link(__('Clear All'), '#', array('title' => 'Erase All', 'class' => 'btn eraseall', 'escape' => false));?></li>
									</ul>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label"><?php echo __('Colour Palette');?></label>
								<div class="controls">
									<ul class="wysihtml5-toolbar">
										<li>
											<div class="btn-group">
									<?php foreach ($ledcolours as $c) { ?>
										<?php echo $this->Html->link('<i class="icon-font"></i>', '#', array(
										'title' => 'Select ' . $c['SignColour']['title'] . ' LED', 
										'class' => 'btn editfontcolour', 
										'escape' => false, 
										'style' => 'background:' . $c['SignColour']['hex_colour'] . ';', 
										'data-fontcolour' => strtolower($c['SignColour']['title']),
										'data-hexcode' => $c['SignColour']['hex_colour'], 
										'data-rgbcode' => $c['SignColour']['col_code']
										)
										);?>
									<?php } ?>	
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="tab_1_4">		
							<?php //echo $this->Form->input('text_input', array('class' => 'textinput span6', 'rows' => 4, 'label' => false, 'div' => false));?>
						</div>
					</div>
				</div>
				<div class="control-group framepreviewwrapper">
					<table id="framepreview" border="0">
						<tr>
							<td colspan="<?php echo $this->data['SignImage']['width'];?>" style="background-image: none; background-color: black"></td>
						</tr>
						<?php for ($h=0;$h<$this->data['SignImage']['height'];$h++){ ?>
						<tr align="center">
							<td style="background-image: none; background-color: black"></td>
							<?php for ($w=0;$w<$this->data['SignImage']['width'];$w++){?>
							<td id="current_r<?php echo $h;?>c<?php echo $w;?>" class="led" data-xaxis="<?php echo $h;?>" data-yaxis="<?php echo $w;?>"><?php echo $this->Form->hidden('matrix.'.$h.'.'.$w, array('id' => 'matrix_r'.$h.'c'.$w));?></td>
							<?php } ?>
							<td style="background-image: none; background-color: black"></td>
						</tr>
						<?php } ?>
						<tr>
							<td colspan="<?php echo $this->data['SignImage']['width'];?>" style="background-image: none; background-color: black"></td>
						</tr>
					</table>
					<?php echo $this->Form->hidden('palette', array('class' => 'palette'));?>
				</div>
				<?php echo $this->Form->hidden('colours', array('value' => implode('|', $colours)));?>
				<?php echo $this->Form->hidden('fontcolour', array('class' => 'fontcolour', 'value' => 'default', 'data-rgb' => '255,140,0'));?>
				<?php echo $this->Form->hidden('fontsize', array('class' => 'fontsize', 'value' => '5X7'));?>
				<?php echo $this->Form->hidden('x', array('class' => 'xaxis', 'value' => '0'));?>
				<?php echo $this->Form->hidden('y', array('class' => 'yaxis', 'value' => '0'));?>
				<?php echo $this->Form->hidden('linespace', array('class' => 'linespace', 'value' => '1'));?>
				<?php echo $this->Form->hidden('chrspace', array('class' => 'chrspace', 'value' => '1'));?>
				<?php echo $this->Form->hidden('chr', array('class' => 'chr'));?>