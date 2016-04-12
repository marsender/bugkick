<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="<?php
	echo Yii::app()->minScript->generateUrl(array(
		'/css/form.css',
		'/js/plug-in/chosen/chosen/chosen.css',
		'/js/plug-in/iPhone-checkbox/style.css',
		'/themes/bugkick_theme/css/main.css',
		'/themes/bugkick_theme/css/dev.css',
		'/themes/bugkick_theme/css/buttons.css',
		'/css/round.css',
		'/js/plug-in/flash-message/css/flash-message.css',
		'/js/plug-in/jGrowl/jquery.jgrowl.css',
		'/js/bootstrap/css/bootstrap.css',
		'/css/colortip.css',
		'/themes/bugkick_theme/css/plug-in/imageset/imageset.css'
	));
	?>" />
<?php
	$lookAndFeel = $this->lookAndFeel();
	if (!empty($lookAndFeel)) {
?>
	<link id="style_look_and_feel" rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/body/<?php echo $lookAndFeel->css_file; ?>" />
<?php } ?>
<?php
				/*
				 <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js"></script>
				 <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.js"></script>
				 */
?>
<!-- FIX for most of unsuported css features in IE8 and bellow -->
<!--[if lt IE 8]>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bugkick_theme/js/ie-fixes/IE9.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bugkick_theme/js/ie-fixes/ie7-squish.js"></script>
<![endif]-->

<!-- End of IE fix -->
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
	<title><?php echo html_entity_decode(CHtml::encode($this->pageTitle)); ?></title>
	<?php if (Yii::app()->params['trackClickEvents']) { MixPanel::instance()->registerTracking(); } ?>
</head>
<body>
    <?php
				echo CHtml::openTag('span', array(
					'id' => 'user_data',
					'style' => 'display:none;'
				));

				$currentProject = Project::getCurrent();

				//register jquery-ui css(fix for case when no projects, design of popups becomes broken)
				if (empty($currentProject)) {
					$cssCoreUrl = Yii::app()->getClientScript()->getCoreScriptUrl();
					Yii::app()->getClientScript()->registerCssFile($cssCoreUrl . '/jui/css/base/jquery-ui.css');
				}
				//END fix


				$userId = Yii::app()->user->id;
				$projectId = empty($currentProject) ? 0 : $currentProject->project_id;
				echo CJSON::encode(array(
					'user_id' => $userId,
					'project_id' => $projectId
				));
				echo CHtml::closeTag('span');
				?>
<?php

				$controllerId = $this->getId();
				$actionId = $this->getAction()->getId();
				if (User::checkHotkeyPreference()) {
					if (!Yii::app()->user->isGuest) {
						Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/app-hotkeys.js');
						//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/app-hotkeys.min.js');
					}
					if ($controllerId == 'bug' && $actionId == 'view') {
						Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/ticket-hotkeys.js');
						//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/ticket-hotkeys.min.js');
					}
				}
				?>
<?php $projectsData = $this->getProjectsData(); ?>
<div id="main-wrapper">
		<div id="header">
			<div class="wrapper">
<?php
//Yii::app()->cache->flush();
$isGlobalAdmin = User::isGlobalAdmin();
$currentCompanyID = Company::current();
$project = Project::getCurrent();
$projectID = empty($project) ? 0 : $project->project_id;
$cacheSettings = array(
	'duration' => (Yii::app()->user->getState('clearCompanyCache') == 1) ? 0 : 3000,
	'varyByExpression' => "'company_{$currentCompanyID}_project_{$projectID}'",
	'varyByRoute' => false,
        /*'dependency'=>array(
            'class'=>'system.caching.dependencies.CExpressionDependency',
            'expression'=>"'$currentCompanyID'",
        ),*/
    );
if ($this->beginCache('site_header_cache', $cacheSettings)) {
	$this->widget('SiteHeader');
	$this->endCache();
}
?>
<?php

if (!Yii::app()->user->isGuest) :
	if ($projectsData['selected']['project_id'] > 0) {
		//echo '<span id="project_title">' . Yii::t('main', 'Current project') . ': ' . $projectsData['selected']['name'] . '</span>';
		echo '<span id="project_title"><a href="#" onclick="return switchToProject(' . $projectsData['selected']['project_id'] . ');" class="project-url">' . Yii::t('main', 'Current project') . ': ' . $projectsData['selected']['name'] . '</a></span>';
	}
	?>

    <div class="top_tab has_menu">
					<span class="hi"><?php echo Yii::t('main', 'Hi') ?>,</span> <span
						class="name"><?php echo Helper::truncateString(Yii::app()->user->name, 20); ?></span><span
						class="menu-arrow"></span>
					<ul class="sub_menu">
						<li><?php echo CHtml::link(Yii::t('main', 'Admin panel'), Yii::app()->createAbsoluteUrl('/settings'), array('id'=>'view_profile')) ?></li>
            <?php
	/*
	 <li><?php echo CHtml::link(Yii::t('main', 'View Profile'), Yii::app()->createAbsoluteUrl('/user/view'), array('id'=>'view_profile')) ?></li>
	 <li><?php echo CHtml::link(Yii::t('main', 'Settings'), Yii::app()->createAbsoluteUrl('/settings'), array('id'=>'settings')) ?></li>
	 */
	?>
            <?php /*<li><?php echo CHtml::link(Yii::t('main', 'Dashboard'), Yii::app()->createAbsoluteUrl('/site/dashboard'), array('id'=>'dashboard')) ?></li>*/ ?>
        <?php
	/*
	 <?php if ($controllerId =='bug' && $actionId =='index') { ?>
	 <li><?php echo CHtml::link(Yii::t('main', 'Calendar'), Yii::app()->createAbsoluteUrl('#'), array('id'=>'showCalendar')) ?></li>
	 <?php } else {?>
	 <li><?php echo CHtml::link(Yii::t('main', 'Calendar'), Yii::app()->createAbsoluteUrl('bug', array('show'=>'calendar')), array('id'=>'calendar')) ?></li>
	 <?php }?>
	 */
	?>
<?php if ($isGlobalAdmin) { ?>
            <li><?php echo CHtml::link(Yii::t('main', 'User admin'), Yii::app()->createAbsoluteUrl('/admin'), array('id'=>'admin-panel')) ?></li>
<?php } ?>
            <li><?php echo CHtml::link(Yii::t('main', 'Help'), Yii::app()->createAbsoluteUrl('/help'), array('id'=>'show-help')) ?></li>
						<li><?php
	echo CHtml::link(Yii::t('main', 'Logout'), Yii::app()->createUrl('site/logout', array(
		'token' => $this->request->csrfToken
	)), array(
		'id' => 'logout'
	))?></li>
					</ul>
				</div>
				<!-- Projects dropdown-->
				<div class="top_tab has_menu">
					<a href="<?php echo Yii::app()->createUrl('/project')?>"
						class="project-link">
<?php
	echo Yii::t('main', 'Projects');
	//echo ($projectsData['selected']['project_id']>0)? '<span id="view-project-link-'.$projectsData['selected']['project_id'] .'">'. Helper::truncateString($projectsData['selected']['name'], 20) . '</span>' : Yii::t('main', 'Projects');
	?>
            <span class="menu-arrow"></span>
					</a>
					<ul class="sub_menu projects-container">
            <?php
	if (is_array($projectsData['data']))
		foreach ($projectsData['data'] as $key => $value) {
			?>
                <li id="project-item-<?php echo $key?>"><a href="#"
							onclick="return switchToProject(<?php echo $key; ?>);"
							class="project-url"><?php echo Helper::truncateString($value, 25); ?></a>
						</li>
            <?php } ?>
            <li class="project-item"><a
							href="<?php echo $this->createUrl('/project'); ?>"
							class="new-project-icon"><?php echo Yii::t('main','All projects'); ?></a>
						</li>
					</ul>
				</div>

    		<div class="top_tab summary_tickets">
					<a href="<?php echo $this->createUrl('/bug/summaryTickets'); ?>"
						title="<?php echo Yii::t('main', 'Summary tickets'); ?>"></a>
				</div>
    <div class="top_tab t_separator"></div>

<?php
	$form = $this->beginWidget('CActiveForm', array(
		'action' => $this->createUrl('/project/choose'),
		'htmlOptions' => array(
			'name' => 'choseProjectForm'
		)
	));
	?>
    <input type="hidden" id="menu_project_id" name="menu_project_id"
					value="<?php echo ($projectsData['selected']['project_id']>0); ?>">
<?php $this->endWidget(); ?>
<!-- end of Projects dropdown-->
<?php
	/*
	 <div class="top_tab calendar-tab">
	 <?php echo CHtml::link(
	 CHtml::image(Yii::app()->theme->baseUrl.'/images/icons/cal.png'),
	 Yii::app()->createUrl('/bug',array('show'=>'calendar')),array('title'=>'Calendar')) ?>
	 </div>
	 */
	?>
<?php if(isset($projectsData['selected']['archived']) && $projectsData['selected']['archived']!=1): ?>
    <div class="top_tab new_ticket"><?php echo CHtml::link(Yii::t('main', 'New ticket'), Yii::app()->createAbsoluteUrl('#'), array('id'=>'createBug')) ?></div>
<?php endif; ?>
<?php endif; ?>
			<div class="clear"></div>

			</div>
			<!-- .wrapper -->
		</div>
		<!-- #header -->
		<div id="content">
        <?php //$this->renderPartial('application.views.site._menu'); ?>
        <?php $this->renderPartial('application.views.site._flash'); ?>
        <?php echo $content; ?>
        <?php

								if (!Yii::app()->user->isGuest && !empty(Yii::app()->user->company_id)) {
									$this->widget('BugCreate');
									$this->widget('Help');
								}
								?>
        <div class="clear"></div>
		</div>
		<!-- #content -->

		<!-- footer -->
<?php if(!Yii::app()->user->isGuest): ?>
    <div class="footer-wrapper" id="footer-wrapper">
			<div class="footer-inner" id="footer-inner">
				<p class="copyright">BugKick &copy; <?php echo date('Y'); ?></p>
				<ul class="footer-info" id="footer-info">
					<li><span>
                        	<?php if (isset($this->currentView) && $this->currentView == 'closed') { ?>
                            <a
							href="<?php echo Yii::app()->createUrl('/bug'); ?>" title="Open"><?php echo Yii::t('main', 'Display opened tickets'); ?></a>
                          <?php
	}
	else {
		?>
                            <a
							href="<?php echo Yii::app()->createUrl('/bug/closed'); ?>"
							title="Closed"><?php echo Yii::t('main', 'Display closed tickets'); ?></a>
                          <?php } ?>
                            <!-- <span class="delimiter">|</span> -->
					</span></li>
                 <?php if (!($controllerId == 'bug' && $actionId == 'view')) { ?>
                    <li><span> <a
							href="<?php echo $this->createUrl('settings/exportTickets'); ?>"
							target="_blank" id="export_tickets"><?php echo Yii::t('main', 'Export tickets'); ?></a>
							<!-- <span class="delimiter">|</span> -->
					</span></li>
                 <?php } ?>
                 <?php if (Yii::app()->params['showForum']) { ?>
                    <li><span> <a
							href="<?php echo Yii::app()->createUrl('forum')?>" title="Forum"><?php echo Yii::t('main', 'Forum'); ?></a>
					</span></li>
                <?php } ?>
                    <li><span> <a href="#"
							onclick="$('#shortcuts').css('display', 'block'); return false;"
							class="show_shortcuts fr"><?php echo Yii::t('main', 'Keyboard shortcuts')?></a>
					</span></li>
                <?php
	/*?>
	 <li>
	 <span>
	 User: <a href="<?php echo Yii::app()->createUrl('user/view')?>" title="View Profile"><?php echo Yii::app()->user->name ?></a>
	 </span>
	 </li>
	 <?php */
	?>
                <?php
	/*
	 <li>
	 <span>
	 <a href="<?php echo Yii::app()->createUrl('site/logout', array('token'=>$this->request->csrfToken))?>" title="Logout"><?php echo Yii::t('main', 'Logout'); ?></a>
	 </span>
	 </li>
	 */
	?>
            </ul>
			</div>
		</div>
<?php endif; ?>
 <!-- footer -->
<?php
/*
 <!--	Ajax loading	-->
 <!--<div id="ajaxLoading"><div></div></div>-->
 <!--	Ajax loading END	-->
 */
?>
<?php echo $this->renderPartial('application.views.account._shortcut'); ?>
</div>
 <?php /* Scripts, moved from TOP: */ ?>
 <script type="text/javascript"
		src="<?php
		echo Yii::app()->minScript->generateUrl(array(
			'/js/plug-in/store.js/store+json2.min.js',
			'/js/bugkick/base.min.js',
			'/js/plug-in/moment/moment.min.js',
			'/js/bugkick/mouseselection.js',
			'/js/bugkick/bug/create.js',
			'/js/bugkick/bug/list.js',
			'/js/bugkick/comment/comment.js',
			'/js/bugkick/plugins/imageset.js',
			'/js/console.min.js',
			'/js/plug-in/flash-message/js/flash-message.min.js',
			'/js/plug-in/jGrowl/jquery.jgrowl_minimized.js'
		))
		//'/js/jquery.caret.1.02.min.js'
		;
		?>"></script>
	<?php
	/* <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/console.min.js"></script>
	 <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/plug-in/flash-message/js/flash-message.min.js"></script>
	 <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/plug-in/jGrowl/jquery.jgrowl_minimized.js"></script>
	 */
	?>
	<?php if(Yii::app()->params['node']['notifications']['turned-on']) { ?>
	<?php /*<!--<script type="text/javascript" src="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>:27000/socket.io/socket.io.js"></script>--> */ ?>
    <script type="text/javascript">
    	var notificationsPort = <?php echo Yii::app()->params['node']['notifications']['port']; ?>;
    	var baseUrl = <?php echo Yii::app()->getBaseUrl(); ?>;
    </script>
	<script type="text/javascript"
		src="https://<?php echo Yii::app()->request->serverName; ?>:<?php echo Yii::app()->params['node']['notifications']['port'] . Yii::app()->getBaseUrl(); ?>/socket.io/socket.io.js"></script>
	<script type="text/javascript"
		src="<?php echo Yii::app()->request->baseUrl; // notifications.min.js ?>/js/notifications.js"></script>
	<?php } ?>
    <script type="text/javascript"
		src="<?php
		echo Yii::app()->minScript->generateUrl(array(
			'/js/plug-in/chosen/chosen/chosen.jquery.min.js',
			'/js/plug-in/iPhone-checkbox/jquery/iphone-style-checkboxes.min.js',
			'/js/plug-in/jquery-form/jquery.form.min.js',
			'/js/bootstrap/bootstrap.js',
			'/js/common.min.js',
			'/js/shortcut.min.js',
			'/js/colortip.min.js',
			'/js/plug-in/jquery-scroll/jquery.mousewheel.js',
			'/js/plug-in/jquery-scroll/jquery.jscrollpane.min.js',
			'/js/filter-scroll.js'
		)) //uncomment to have auto-resizing filters
;
		?>"></script>
<?php
/* <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/plug-in/chosen/chosen/chosen.jquery.min.js"></script>
 <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/plug-in/iPhone-checkbox/jquery/iphone-style-checkboxes.min.js"></script>
 <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/plug-in/jquery-form/jquery.form.min.js"></script> */
?>
<?php /* <script type="text/javascript" src="--><?php echo Yii::app()->request->baseUrl; ?><!--/js/lib/bkscreen.min.js"></script>*/?>
<?php /* <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap/bootstrap.js"></script> */ ?>
<?php /* <link type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap/css/bootstrap.css" rel="stylesheet" /> */ ?>
<?php

/* <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/common.js"></script>
 <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/shortcut.min.js"></script>
 <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/colortip.min.js"></script> */
?>
<?php /*    <link type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/colortip.css" rel="stylesheet" /> */?>
<?php /* End of scripts, moved from TOP */ ?>
<script type="text/javascript">
    var _bugKickKey = '<?php echo Yii::app()->params['bugkickApiSettings']['apiKey']; ?>',
        _bugKickPID = '<?php echo Yii::app()->params['bugkickApiSettings']['projectID']; ?>',
        _widgetStyle = '322';
    (function(d) {
        var s = d.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = ('https:' == d.location.protocol ? 'https://' : 'http://')
            + '<?php echo Yii::app()->params['bugkickApiSettings']['scriptURL']; ?>';
        d.getElementsByTagName('head')[0].appendChild(s);
    })(document);
</script>
<?php
/*<script type="text/javascript">
 (function() {
 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
 })();
 </script>*/
?>

</body>
</html>