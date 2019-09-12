<?php if (Configure::read('MySite.breadcrumbs') == 1) {?>
<?php echo $this->Html->getCrumbList(array(
	'class' => 'breadcrumb',
	'separator' => '<span class="icon-angle-right"></span>'
	), array(
    'text' => '<i class="icon-home"></i> ' . __('Home'),
    'url' => array('controller' => 'clients', 'action' => 'dashboard', 'admin' => false, 'plugin' => false),
    'escape' => false
));?>
<?php } ?>