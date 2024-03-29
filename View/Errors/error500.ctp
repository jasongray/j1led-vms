<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid page-500">
							<div class="span5 number">
								500
							</div>
							<div class="span7 details">
								<h3><?php echo $name; ?></h3>
								<p>
									<?php echo __('We are fixing it!');?><br />
									<?php echo __('Please come back in a while.');?><br />
								</p>
								<?php
								if (Configure::read('debug') > 0):
									echo $this->element('exception_stack_trace');
								endif;
								?>
							</div>
						</div>
					</div>
				</div>
