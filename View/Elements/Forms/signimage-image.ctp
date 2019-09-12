<div class="fileupload-new thumbnail">
<?php if (!empty($this->data['SignImage']['image'])) {
	echo $this->Resize->image('frames/'. str_replace('.bmp', '.png', $this->data['SignImage']['image']), 100, 100, true, array('alt' => $this->data['SignImage']['image']));
}?>
</div>
<?php /*if (!empty($this->data['SignImage']['image'])) {
	echo $this->Html->link('<i class="icon-trash"></i> ' . __('Remove Image'), array('controller' => 'signimages', 'action' => 'removeFrame', $this->data['SignImage']['id']), array('escape' => false));
}*/?>
<?php echo $this->Form->input('Image.file', array('type' => 'file', 'label' => __('Image')));?>
<p><?php echo __('Max file size is')?> : <?php echo $this->Number->toReadableSize($this->Xhtml->maxfilesize());?></p>
<p><?php echo __('Generally images 48 x 28 are a good fit.'); ?></p><?php  ?>