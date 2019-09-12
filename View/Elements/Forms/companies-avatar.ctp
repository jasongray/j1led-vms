<div class="fileupload-new thumbnail">
<?php if (!empty($this->data['Company']['logo'])) {
	echo $this->Resize->image('companies/'. $this->data['Company']['logo'], 300, 100, false, array('alt' => ''));
}?>
</div>
<?php if (!empty($this->data['Company']['logo'])) {
	echo $this->Html->link('<i class="icon-trash"></i> ' . __('Remove Image'), array('controller' => 'clients', 'action' => 'removeLogo', $this->data['Company']['id']), array('escape' => false));
}?>
<?php echo $this->Form->input('Image.file', array('type' => 'file', 'label' =>  __('Company Logo')));?>
<?php echo __('Max file size is')?> : <?php echo $this->Number->toReadableSize($this->Xhtml->maxfilesize());?>
<hr/>
<div class="fileupload-new">
<?php if (!empty($this->data['Company']['css'])) {
	echo __('Current CSS file:') . $this->data['Company']['css'];
}?>
</div>
<?php if (!empty($this->data['Company']['css'])) {
	echo $this->Html->link('<i class="icon-trash"></i> ' . __('Remove File'), array('controller' => 'clients', 'action' => 'removeCss', $this->data['Company']['id']), array('escape' => false));
}?>
<?php echo $this->Form->input('Css.file', array('type' => 'file', 'label' =>  __('CSS File')));?>
<?php echo __('Max file size is')?> : <?php echo $this->Number->toReadableSize($this->Xhtml->maxfilesize());?>