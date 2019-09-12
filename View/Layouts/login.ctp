<?php echo $this->Html->docType(); ?>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $this->Xhtml->pagetitle($title_for_layout);?></title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<?php echo $this->Html->css(array('bootstrap.min', 'metro', 'style', 'style_responsive', 'style_default', 'uniform.default'));?>
	<?php echo $this->Html->css(array('//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css'));?>
	<?php echo $this->fetch('css');?>
</head>
<body class="login">
	<div class="loadingdesigner"></div>
	<div class="logo">
		
	</div>
	<div class="content">
		<?php echo $this->fetch('content');?>
	</div>
<?php echo $this->Html->script(array('jquery-1.8.3.min', 'bootstrap.min', 'jquery.uniform.min', 'jquery.blockui', 'app'));?>
<?php echo $this->Html->scriptBlock("
jQuery(document).ready(function() {
	App.initLogin();
	$('.loadingdesigner').fadeOut();
});")?>
<?php echo $this->fetch('script');?>
<?php echo $this->Xhtml->googleAnalytics();?>
</body>
</html>