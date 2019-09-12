				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th><?php echo __('Company');?></th>
							<th><?php echo __('Contract');?></th>
							<th><?php echo __('On Hire');?></th>
							<th><?php echo __('Off Hire');?></th>
						</tr>
					</thead>
					<tbody>
				<?php foreach ($contracts as $c) { ?>
					<tr>
						<td><?php echo $c['Company']['name'];?></td>
						<td><?php echo $c['Contract']['title'];?></td>
						<?php if ($this->Xhtml->dateBetween($c['Contract']['on_hire_date'], $c['Contract']['off_hire_date'])) { ?>
						<td><span class="badge badge-important"><?php echo $this->Time->niceShort($c['Contract']['on_hire_date']);?></span></td>
						<td><span class="badge badge-important"><?php echo $this->Time->niceShort($c['Contract']['off_hire_date']);?></span></td>
						<?php } else { ?>
						<td><span class="badge"><?php echo $this->Time->niceShort($c['Contract']['on_hire_date']);?></span></td>
						<td><span class="badge"><?php echo $this->Time->niceShort($c['Contract']['off_hire_date']);?></span></td>
						<?php } ?>
					</tr>
				<?php } ?>
					</tbody>
				</table>