<?php $attr = array(); ?>
<?php $attr = !empty($m['Module']['idclass'])? array_merge(array('id' => $m['Module']['idclass']), $attr): $attr;?>
<?php $attr = !empty($m['Module']['class'])? array_merge(array('class' => $m['Module']['class']), $attr): $attr;?>
<?php if ($m['Module']['show_title']) { ?>
<?php $hdr = (!empty($m['Module']['header']))? $m['Module']['header']: 'h2';?>
<?php echo $this->Html->tag($hdr, $m['Module']['title'], $m['Module']['header_class']);?>
<?php } ?>
<?php echo $this->Menu->create($m['Module']['menu_id'], $attr);?>