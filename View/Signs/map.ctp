<?php $this->Html->addCrumb(__('Signs'));?>
<?php $this->Paginator->options(array('url' => $this->Paginator->params()));?>
<div class="row-fluid">
	<div class="span8">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-map-marker"></i><?php echo __('Map');?></h4>
			</div>
			<div class="portlet-body map-body">
				<div id="map_canvas" class="span12"></div>
				<?php echo $this->Html->script($this->Googlemap->apiUrl(), array('inline' => false));?>
				<?php echo $this->Googlemap->map(array('div' => array('id' => 'map_canvas', 'inline' => false), 'autoCenter' => true));?>
				<br class="clear-fix"/>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-map-marker"></i><?php echo __('Sign List');?></h4>
				<div class="tools">
					<a href="javascript:;" class="accordian-toggle"><i class="icon-plus"></i> View All</a>
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body map-list">
			<?php if (!empty($signs)) { ?>
				<div id="accordion1" class="accordion">
			<?php for ($i=0;$i<count($signs);$i++) { ?>
				<?php $s = $signs[$i]; ?>
					<div class="accordion-group">
						<div class="accordion-heading">
							<?php echo $this->Html->link($s['Sign']['name'], '#collapse_'.$i, array('class' => 'accordion-toggle collapsed', 'data-toggle' => 'collapse'));?>
						</div>
						<div id="collapse_<?php echo $i;?>" class="accordion-body collapse" data-sign="sign-<?php echo $s['Sign']['id'];?>">
							<div class="accordion-inner" data-inner="sign-<?php echo $s['Sign']['id'];?>">
								<div class="row-fluid heading">
									<div class="span12">
										<h3><?php echo $s['Sign']['name'];?></h3>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span5">
										<div class="desc-mini">
										<?php echo $this->element('sign-frames-map', array('s' => $s));?>
										</div>
									</div>
									<div class="span7">
										<?php echo $this->Html->link('<i class="icon-edit"></i> ' . __('Edit Content'), array('controller' => 'signs', 'action' => 'frames', $s['Sign']['id']), array('class' => 'btn blue mini', 'escape' => false));?>
										<ul class="unstyled">
											<li><strong><?php echo __('Status');?>:</strong> <?php if (!empty($xml)){ echo $this->Xhtml->badgeme($xml->status->{'hearbeat-poll'}, 'OK'); }?></li>
											<li><strong><?php echo __('Battery');?>:</strong> <?php if (!empty($s['Sign']['battery_voltage'])){ echo $this->Xhtml->batteryalert($s['Sign']['battery_voltage']);} ?></li>
										</ul>
										
										<?php if (!empty($s['Sign']['lng']) && !empty($s['Sign']['lat'])){ $this->Googlemap->addMarker(array('lat' => $s['Sign']['lat'], 'lng' => $s['Sign']['lng'], 'id' => 'sign-'.$s['Sign']['id'], 'ajax' => true)); } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
			<?php } ?>
				</div>
<?php echo $this->Googlemap->script(array('inline' => false));?>
<?php echo $this->Html->scriptBlock("
function load_content(map, infowindow, marker, id) { 
	infowindow.setContent($('.accordion-body[data-sign=\"'+id+'\"]').html());
	infowindow.open(map, marker);
}
$(document).ready(function() {
	$('.accordian-toggle').on('click', function() {
		if($(this).html() == '<i class=\"icon-plus\"></i> View All') {
	    	$('.accordion-body.collapse:not(.in)').each(function (index) {
	            $(this).collapse('toggle');
	        });
	        $(this).html('<i class=\"icon-minus\"></i> Hide All');
	    } else {
	        $(this).html('<i class=\"icon-plus\"></i> View All');
	        $('.accordion-body.collapse.in').each(function (index) {
	            $(this).collapse('toggle');
	        });
	    }
	    return false;
	});
});", array('inline' => false));?>
			<?php } else { ?>
				<div class="alert alert-block alert-error fade in">
					<button data-dismiss="alert" class="close" type="button"></button>
					<p><?php echo __('There are no signs assigned to you as yet.');?></p>
				</div>
			<?php } ?>
			<?php echo $this->element('pagination');?>
			</div>
		</div>
	</div>
</div>