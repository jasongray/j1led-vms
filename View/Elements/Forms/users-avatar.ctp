<div style="width: 200px; height: 200px;" class="fileupload-new thumbnail">
<?php if (!empty($this->data['User']['image'])) {
	echo $this->Resize->image('users/'. $this->data['User']['image'], 200, 200, false, array('alt' => ''));
}?>
</div>
<?php if (!empty($this->data['User']['image'])) {
	echo $this->Html->link('<i class="icon-trash"></i> ' . __('Remove Image'), array('controller' => 'users', 'action' => 'removeAvatar', $this->data['User']['id']), array('escape' => false));
}?>
<?php echo $this->Form->input('Image.file', array('type' => 'file', 'label' => __('User Image')));?>
<?php echo __('Max file size is')?> : <?php echo $this->Number->toReadableSize($this->Xhtml->maxfilesize());?>