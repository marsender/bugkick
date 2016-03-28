<?php /* @var $this BKForumController */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/bootstrap/css/bootstrap.min.css" />
    <link href="<?php echo $this->assetsUrl; ?>/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="<?php echo $this->assetsUrl; ?>/css/style.css" rel="stylesheet">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array(Yii::app()->baseUrl . '/site/index')),
				array('label'=>'Forum', 'url'=>array(Yii::app()->baseUrl . '/forum')),
				array('label'=>'About', 'url'=>array(Yii::app()->baseUrl . '/site/page', 'view'=>'about')),
				array('label'=>'Contact', 'url'=>array(Yii::app()->baseUrl . '/site/contact')),
				array('label'=>'Login', 'url'=>array(Yii::app()->baseUrl . '/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array(Yii::app()->baseUrl . '/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by BugKick.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->
<script type="text/javascript" src="<?php echo $this->assetsUrl; ?>/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>