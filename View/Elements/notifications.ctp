<?php $notifications = array(); //$this->requestAction('notifications/recent');?>
	<li class="dropdown" id="header_notification_bar">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        	<i class="icon-warning-sign"></i>
			<?php if ($notifications) { ?>
        	<span class="badge"><?php echo count($notifications);?></span>
        	<?php } ?>
    	</a>
<?php if ($notifications) { ?>
		<ul class="dropdown-menu extended notification">
			<li><?php if (count($notifications) == 1) { ?>
				<p><?php echo __(sprintf('You have %d new notification', count($notifications)));?></p>
				<?php } else { ?>
				<p><?php echo __(sprintf('You have %d new notifications', count($notifications)));?></p>
				<?php } ?>
			</li>
		<?php foreach ($notifications as $n) { ?>
            <li>
            	<a href="<?php echo $this->Xhtml->link($n['Notification']);?>">
            	<?php switch ($n['Notification']['type']) { 
            		case 'success': 
            		echo '<span class="label label-success"><i class="icon-plus"></i></span>'; 
            		break; 
            		case 'important' : default: 
            		echo '<span class="label label-important"><i class="icon-bolt"></i></span>'; 
            		break; 
            		case 'warning': 
            		echo '<span class="label label-warning"><i class="icon-bell"></i></span>'; 
            		break; 
            		case 'info': 
            		echo '<span class="label label-info"><i class="icon-bullhorn"></i></span>'; 
            		break;  
            	} ?>
            	<?php echo $n['Notification']['summary'];?><br/>
                <span class="time"><?php echo $this->Time->timeAgoInWords($n['Notification']['created']);?></span>
                </a>
            </li>
        <?php } ?>
        	<li class="external">
				<?php echo $this->Html->link(__('See all notifications') . ' <i class="m-icon-swapright"></i>', array('controller' => 'notifications', 'action' => 'index'), array('escape' => false));?>
			</li>
    	</ul>
<?php } else { ?>
		<ul class="dropdown-menu extended notification">
			<li>
				<p><?php echo __('You have no new notifications');?></p>
			</li>
			<li class="external">
				<?php echo $this->Html->link(__('See all notifications') . ' <i class="m-icon-swapright"></i>', array('controller' => 'notifications', 'action' => 'index'), array('escape' => false));?>
			</li>
		</ul>
<?php } ?>
	</li>