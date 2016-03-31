<?php $this->beginContent('//layouts/main'); ?>
<div id="main">
    <!-- <div class="main_top"></div> -->
<!--    <div class="main_middle">-->
        <?php $this->renderPartial('application.views.site._menu'); ?>
        <?php echo $content; ?>

<!--    </div>-->
    <!-- .main_middle -->
    <!-- <div class="main_bottom"></div> -->
</div>

<?php
	$userCurrent = User::current();
	$isGlobalAdmin = isset($userCurrent) && $userCurrent->isGlobalAdmin();
	$isCompany = !Yii::app()->user->isGuest && !empty(Yii::app()->user->company_id);
	$settingsMenu = $isCompany && (($this->getId() == 'settings') || (($this->getId() == 'user') && ($this->getAction()->getId() == 'view')));
	$bugFilter = $isCompany && ($this->getId() == 'bug') && ($this->getAction()->getId() != 'view');
	$createProject = $isGlobalAdmin && $isCompany && ($this->getId() == 'project') && ($this->getAction()->getId() != 'people');
	if ($settingsMenu || $bugFilter || $createProject) {
?>
<div id="sidebar"<?php if ($bugFilter) echo ' class="float-filters"';?>>
    <!-- <div class="sidebar_top"></div> -->
    <div class="sidebar_middle">
        <?php if ($settingsMenu) $this->widget('SettingsMenu'); ?>
        <?php if ($bugFilter) $this->widget('BugFilter'); ?>
        <?php if ($createProject) { ?>
        	<a id="createProjectBtn" class="bkButtonBlueSmall normal"
          	href="<?php echo $this->createUrl('project/create'); ?>">
            <?php echo Yii::t('main', 'Add new project'); ?>&nbsp;
          	<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/cross.png" alt=""/>
        	</a>
        <?php } ?>
        <?php echo $this->clips['sidebar']; ?>
        <?php
        $module = (isset(Yii::app()->getController()->module)) ? Yii::app()->getController()->module->getName() : '';
        if ($module == 'admin') {
            $this->beginWidget('zii.widgets.CPortlet');
            $this->widget('zii.widgets.CMenu', array(
                'id'=>'right_menu',
                'items' => $this->menu,
                'htmlOptions' => array('class' => 'operations'),
            ));
            $this->endWidget();
        }
        ?>
    </div>
    <?php
    $siteSetting = SiteSettings::getBugkickSettings();
    if ($siteSetting->invites_module
            && ($this->getId() == 'bug')
            && ($this->getAction()->getId() != 'view')){
        echo CHtml::openTag('div', array('class'=>'sidebar_middle'));
        $this->widget('InvitePeople');
        echo CHtml::closeTag('div');
    }
    ?>
    <!-- .sidebar_middle -->
    <!-- <div class="sidebar_bottom"></div> -->
</div><!-- sidebar -->
<?php } ?>
<?php $this->endContent(); ?>