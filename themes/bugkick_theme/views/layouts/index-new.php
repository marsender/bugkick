<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<link rel="shortcut icon"
	href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" />

<?php
$cssCoreUrl = Yii::app()->getClientScript()->getCoreScriptUrl();
Yii::app()->getClientScript()->registerCssFile($cssCoreUrl . '/jui/css/base/jquery-ui.css');
?>
	<link rel="stylesheet" type="text/css" href="<?php
	echo Yii::app()->minScript->generateUrl(array(
		'/js/plug-in/chosen/chosen/chosen.css',
		'/themes/bugkick_theme/css/reset.css',
		'/themes/bugkick_theme/css/jqueryui-accordion-reset.css',
		'/themes/bugkick_theme/css/homepage-layout.css',
		'/css/form.css',
		'/themes/bugkick_theme/css/plug-in/prettyphoto/prettyphoto.css',
		'/themes/bugkick_theme/css/buttons.css'
	));
	?>" />
<?php
$wantGoogleApi = false;
if ($wantGoogleApi) {
	echo GoogleApi::init(null, true), CHtml::script(CGoogleApi::load('jquery') . CGoogleApi::load('jqueryui'));
}
else {
	echo '<script type="text/javascript" src="' . Yii::app()->request->baseUrl . '/js/jquery.js"></script>' . "\n";
	echo '<script type="text/javascript" src="' . Yii::app()->request->baseUrl . '/js/jquery-ui.js"></script>' . "\n";
}
$csrfToken = Yii::app()->request->csrfToken;
echo "
<script>
	var YII_CSRF_TOKEN='{$csrfToken}';
	var _gaq = _gaq || [];
	_gaq.push(
    ['_setAccount', 'UA-30674401-1'],
    ['_trackPageview']
	);
</script>
";
?>
	<?php /*<title>BugKick - Landing Page</title>*/ ?>
	<title><?php echo html_entity_decode(CHtml::encode($this->pageTitle)); ?></title>
	<?php if (Yii::app()->params['trackClickEvents']) { MixPanel::instance()->registerTracking(); } ?>
</head>
<body>
	<div id="main-wrapper">
		<div id="header">
			<div class="wrapper">
				<a href="<?php echo Yii::app()->createAbsoluteUrl('/') ?>"
					title="<?php echo Yii::t('main', 'Home page'); ?>"><h1 id="logo"><?php echo Yii::t('main', 'Login'); ?></h1></a>
				<div id="landing-nav">
					<ul>
            <?php if(Yii::app()->params['showBugkickHomePage'] && !($this->getId() == 'site' && $this->getAction()->getId() == 'index')) { ?>
				    <li id="back-to-home"><a
							href="<?php echo Yii::app()->homeUrl ?>"
							title="Go back to the home page" class="buttonLandingStyle no-bg"><<
								Back to the homepage</a></li>
            <?php }else{ ?>
				    <li><a href="<?php echo $this->createUrl('/registration'); ?>"
							title="Sign Up" class="buttonLandingStyle green"><?php echo Yii::t('main', 'Sign up'); ?></a></li>
						<li><a href="<?php echo $this->createUrl('/site/login'); ?>"
							title="Sign In" class="buttonLandingStyle no-bg"><?php echo Yii::t('main', 'Login'); ?></a></li>
            <?php } ?>
				</ul>
				</div>
				<div class="clear"></div>
			</div>
			<!-- .wrapper -->
		</div>
		<!-- #header -->
		<div id="content">
    	<?php echo $content; ?>
    </div>
		<div class="footer-wrapper" id="footer-wrapper">
			<div class="footer-inner" id="footer-inner">
				<p class="copyright">
					<a href="https://github.com/marsender/bugkick">BugKick &copy; 2013</a>
				</p>
<?php
/*    <div class="footer-info" id="footer-info">
					       <a href="<?php echo $this->createUrl('/site/login'); ?>" title="Sign In to BugKick"><?php echo Yii::t('main', 'Login'); ?> >></a>
					       </div> */
?>
        </div>
		</div>
	</div>
	<script type="text/javascript"
		src="<?php
		echo Yii::app()->minScript->generateUrl(array(
			'/js/plug-in/chosen/chosen/chosen.jquery.min.js',
			'/themes/bugkick_theme/js/home/jquery-prettyphoto.js'
		));
		?>"></script>
	<!--
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
<script type="text/javascript"  src="<?php echo Yii::app()->baseUrl; ?>/js/home/jquery-prettyphoto.js"></script>
-->
	<script type="text/javascript">
    (function($){
/*        $('a[rel^="prettyPhoto"]').prettyPhoto({
            overlay_gallery: false,
            social_tools: ''
        });

        $('.ui-accordion').accordion({
            active: false,
            autoHeight: false,
            collapsible: true
        });
*/
        $('.chzn-select').chosen();
    })(jQuery);
</script>
<?php /* <script type="text/javascript">
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>*/ ?>
</body>
</html>