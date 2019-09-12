<?php echo $this->Html->docType(); ?>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $this->Xhtml->pagetitle($title_for_layout);?></title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<?php echo $this->Html->css(array('bootstrap.min', 'metro', 'bootstrap-responsive.min', 'style', 'style_responsive', 'style_default', 'uniform.default'));?>
	<?php echo $this->Html->css(array('//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css'));?>
	<?php $_company = $this->Session->read('Auth.User.Company'); ?>
	<?php if (!empty($_company['css'])){ echo $this->Html->css(array('/files/clients/' . $_company['css'])); } ?>
	<?php echo $this->fetch('css');?>
</head>
<body class="fixed-top">
	<div class="loadingdesigner"></div>
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<?php $_image = (empty($_company['logo'])) ? 'logo.png' : 'companies/' . $_company['logo']; 
				echo $this->Html->link($this->Resize->image($_image, 225, 42, true, array('alt' => '')), '/', array('class' => 'brand', 'escape' => false));?>
          	</div>
        </div>
    </div>
    <div class="page-container row-fluid">
    	<div class="page-content" style="margin-left:0;">
    		<div class="container-fluid">
				<?php echo $this->fetch('content');?>
			</div>
		</div>
	</div>
	<div class="footer">
		&copy; <?php echo date('Y');?> <?php echo Configure::read('MySite.site_name');?><br/><span class="tiny"><i class="icon-cogs"></i> <?php echo __('Version');?>: <?php echo $this->Xhtml->ver();?></span>&nbsp;<span class="tiny"><i class="icon-coffee"></i> <?php echo __('Build');?>: <?php echo Configure::version();?></span>
		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div>
<?php echo $this->Html->scriptBlock('var _baseurl = \'' . $this->webroot . '\';');?>
<?php echo $this->Html->script(array('jquery-1.8.3.min', 'breakpoints', 'bootstrap.min', 'jquery.blockui', 'jquery.uniform.min', 'app'));?>
<?php echo $this->fetch('script');?>
<!-- ie8 fixes --><!--[if lt IE 9]>
<?php echo $this->Html->script(array('excanvas', 'respond'));?>
<![endif]-->
<?php echo $this->Html->scriptBlock("
jQuery(document).ready(function() {
	App.init();
	$('.loadingdesigner').fadeOut();
});")?>
<?php echo $this->Xhtml->googleAnalytics();?>
</body>
</html>