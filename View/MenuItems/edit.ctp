<?php $this->Html->addCrumb(__('Menus'), array('controller' => 'menus', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Menu Items'), array('controller' => 'menuItems', 'action' => 'index', 'menu_id' => $this->passedArgs['menu_id']));?>
<?php $this->Html->addCrumb(__('Edit Menu Item'));?>
<?php echo $this->element('Forms/menu-items');?>