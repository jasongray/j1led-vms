<?php echo $this->Form->input('name', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Name'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('width', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('LED Width'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('height', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('LED Height'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('maxtrix', array('div' => 'control-group', 'class' => 'm-wrap small', 'options' => array('5x7' => '5 x 7', '5x8' => '5 x 8'), 'empty' => '', 'label' => array('text' => __('Font LED maxtrix'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('chrspace', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('Character Spacing'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('linespace', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('Line Spacing'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<div class="control-group">
	<label class="control-label"><?php echo __('Has Annulus');?></label>
	<div class="controls">
		<?php echo $this->Form->input('annulus', array('div' => false, 'label' => array('text' => '', 'class' => 'checkbox'), 'type' => 'checkbox'));?>
	</div>
</div>
<div class="control-group">
	<label class="control-label"><?php echo __('Has Conspic');?></label>
	<div class="controls">
		<?php echo $this->Form->input('conspic', array('div' => false, 'label' => array('text' => '', 'class' => 'checkbox'), 'type' => 'checkbox'));?>
	</div>
</div>
<?php echo $this->Form->input('protocol', array('div' => 'control-group', 'class' => 'm-wrap small', 'options' => array('strict' => 'Strict', 'relaxed' => 'Relaxed', 'xml' => 'XML'), 'empty' => '', 'label' => array('text' => __('SP003 Compliance'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<hr/>
<?php echo $this->Form->input('colour_option', array('div' => 'control-group', 'class' => 'm-wrap small', 'options' => array('single' => 'Single', 'penta' => 'Penta'), 'empty' => '', 'label' => array('text' => __('LED Types'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('SignColour', array('div' => 'control-group', 'class' => 'chosen span6 pentacolours', 'multiple' => 'multiple', 'data-placeholder' => __('Select the default colours of the sign'), 'label' => array('text' => __('Sign Colours'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('SignColourOverlay', array('div' => 'control-group', 'class' => 'chosen span6 overlaycolours', 'multiple' => 'multiple', 'data-placeholder' => __('Select the overlay colours of the sign'), 'options' => $overlayColours, 'label' => array('text' => __('Overlay Colours'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<div class="form-actions">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('label' => __('Save'), 'class'=>'btn green', 'div' => false)); 
	echo $this->Html->link(__('Cancel'), array('controller' => 'signTypes', 'action' => 'cancel'), array('class' => 'btn black'));
	if(!empty($this->data['SignType']['id'])){
		echo $this->Html->link(__('Delete'), array('controller' => 'signTypes', 'action' => 'delete', $this->data['SignType']['id']), array('class' => 'btn red'));
	}
?>	
</div>
<?php echo $this->Html->scriptBlock("
$(document).ready(function(){
	$('#SignTypeColourOption').change(function(){
		var method = $(this).val();
		if (method == 'single') {
			$('#SignColourOverlaySignColourOverlay').val('').trigger('liszt:updated').parent().parent().hide();
			$('#SignColourSignColour').attr({'multiple' : false}).val('').trigger('liszt:updated');
		}
		if (method == 'penta') {
			$('#SignColourOverlaySignColourOverlay').val('').trigger('liszt:updated').parent().parent().show();
			$('#SignColourSignColour').attr({'multiple' : 'multiple'}).val('').trigger('liszt:updated');
		}
		return false;
	});
});", array('inline' => false));?>