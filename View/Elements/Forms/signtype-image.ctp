<div style="width: 200px; height: 200px;" class="fileupload-new thumbnail">
<?php if (!empty($this->data['SignType']['image'])) {
	echo $this->Resize->image('signtypes/'. $this->data['SignType']['image'], 200, 200, false, array('alt' => ''));
}?>
</div>
<?php if (!empty($this->data['SignType']['image'])) {
	echo $this->Html->link('<i class="icon-trash"></i> ' . __('Remove Image'), array('controller' => 'signTypes', 'action' => 'removeImage', $this->data['SignType']['id']), array('escape' => false));
}?>
<?php echo $this->Form->input('Image.file', array('type' => 'file', 'label' => __('Image')));?>
<?php echo __('Max file size is')?> : <?php echo $this->Number->toReadableSize($this->Xhtml->maxfilesize());?>