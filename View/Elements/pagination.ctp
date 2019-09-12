<?php echo $this->Html->css(array('DT_bootstrap'), null, array('block' => 'css'));?>
<div class="row-fluid">
	<div class="span6">
		<?php echo $this->Paginator->counter(array('format' => __('Showing {:start} to {:current} of {:count} entries', true)));?>
	</div>
	<div class="span6">
		<div class="dataTables_paginate paging_bootstrap pagination">
			<ul>
				<?php echo $this->Paginator->prev('← ' . __('Prev'), array('tag' => 'li', 'escape' => false), null, array('tag' => 'li', 'class' => 'prev disabled', 'disabledTag' => 'a'));?>
				<?php echo $this->Paginator->numbers(array('tag' => 'li', 'class' => false, 'currentTag' => 'a', 'currentClass' => 'active', 'separator' => false));?>
				<?php echo $this->Paginator->next(__('Next') . ' →', array('tag' => 'li', 'escape' => false), null, array('tag' => 'li', 'class' => 'next disabled', 'disabledTag' => 'a'));?>
			</ul>
		</div>
	</div>
</div>
