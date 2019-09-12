<?php echo $this->Form->input('name', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Name'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('address', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Address'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('contact', array('div' => 'control-group', 'class' => 'm-wrap meduim', 'label' => array('text' => __('Contact person'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('phone', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('Phone'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('mobile', array('div' => 'control-group', 'class' => 'm-wrap small', 'label' => array('text' => __('Mobile'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>'));?>
<?php echo $this->Form->input('default_view', array('div' => 'control-group', 'class' => 'm-wrap', 'label' => array('text' => __('Default View'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>', 'options' => array('list' => 'List', 'grid' => 'Grid', 'map' => 'Map'), 'empty' => '')); ?>
<?php echo $this->Form->input('image_view', array('div' => 'control-group', 'class' => 'm-wrap', 'label' => array('text' => __('Show Images'), 'class' => 'control-label'), 'between' => '<div class="controls">', 'after' => '</div>', 'options' => array('default' => 'Default', 'no-image' => 'No Image', 'map' => 'Map', 'frames' => 'Msg Frame'), 'empty' => '')); ?>
<hr/>
<div class="control-group">
	<label class="control-label"><?php echo __('Custom sign labels');?></label>
	<div class="controls">
		<div class="input-append">
			<?php echo $this->Form->input('CustomLabel..text', array('div' => false, 'label' => false, 'type' => 'text', 'class' => 'originallabel m-wrap small'));?>
			<span class="add-on"><i class="icon-plus addlabel" style="cursor:pointer;"></i></span>
		</div>
		<span class="help-inline"><?php echo __('Type a label and click the plus sign to add it');?></span>
	</div>
</div>
<div class="control-group label-list">
	<div class="controls">
	<?php if(!empty($this->data['CustomLabel'])) { ?>
	<?php for($i=0;$i<count($this->data['CustomLabel']);$i++) { ?>
		<?php $l = $this->data['CustomLabel'][$i];?>
		<div class="input-append">
			<?php echo $this->Form->input('CustomLabel.'.$i.'.text', array('div' => false, 'label' => false, 'type' => 'text', 'class' => 'm-wrap small customlabels', 'data-customlabel-id' => $l['id'], 'value' => $l['text']));?>
			<?php echo $this->Form->hidden('CustomLabel.'.$i.'.id')?>
			<span class="add-on"><i class="icon-minus removelabel" style="cursor:pointer;"></i></span>
		</div>
	<?php } ?>
	<?php } ?>
	</div>
</div>
<div class="form-actions">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('label' => __('Save'), 'class'=>'btn green', 'div' => false)); 
	echo $this->Html->link(__('Cancel'), array('controller' => 'companies', 'action' => 'cancel'), array('class' => 'btn black'));
	if(!empty($this->data['Company']['id'])){
		echo $this->Html->link(__('Delete'), array('controller' => 'companies', 'action' => 'delete', $this->data['Company']['id']), array('class' => 'btn red'));
	}
?>	
</div>
<?php echo $this->Html->scriptBlock("
$(document).ready(function(){
	$('.addlabel').click(function(e) {
		e.preventDefault();
		var newelm = $('#CustomLabelText').parent().clone().appendTo('.label-list .controls');
		newelm.find('input').prop('id', false).prop('class', 'm-wrap small customlabels');
		newelm.find('i').attr('class', 'icon-minus removelabel');
		$('#CustomLabelText').val('');
		removelabel();
	});
	function fadeout(e) {
		e.fadeOut('slow', function(){ $(this).remove();});
	}
	function changetext() {
		$('.customlabels').change(function(e) {
			e.preventDefault();
			var inp = $(this).attr('data-customlabel-id');
			$.ajax({
				url: _baseurl+'customLabels/ajaxupdate/'+inp,
				type: 'post',
				dataType: 'html',
				data: {'id': inp, 'text': $(this).val()},
				complete: function(x, s){
					if (s != 'success'){
						alert('Error updateing record');
					}
				}
			});
		});
	}
	function removelabel() {
		$('.removelabel').click(function(e) {
			e.preventDefault();
			var elm = $(this).parent().parent();
			var inp = $(this).parent().parent().find('input').attr('data-customlabel-id');
			if (inp) { 
				$.ajax({
					url: _baseurl+'customLabels/ajaxdelete/'+inp,
					dataType: 'html',
					complete: function(x, s){
						if (s == 'success'){
							fadeout(elm);
						} else {
							return;
						}
					}
				});
			}
			fadeout(elm);
		});
	}
	removelabel();
	changetext();
});", array('inline' => false));?>