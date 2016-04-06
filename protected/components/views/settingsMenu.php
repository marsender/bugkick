<?php
$isAdmin = User::isAdmin();
$isGlobalAdmin = User::isGlobalAdmin();
?>
<ul id="right_menu">
	<li><?php echo CHtml::link(Yii::t('main','Preferences'), CHtml::normalizeUrl(array('settings/')),
        ($controllerId == 'settings' && $actionId == 'index')? array('class'=>'active') : array()
    ) ?></li>
	<li><?php echo CHtml::link(Yii::t('main','Notifications'), CHtml::normalizeUrl(array('settings/emailPreferences')),
         ($controllerId == 'settings' && $actionId == 'emailPreferences')? array('class'=>'active') : array()
    ) ?></li>
	<li><?php echo CHtml::link(Yii::t('main','Last activity'), CHtml::normalizeUrl(array('user/view')),
         ($controllerId == 'user' && $actionId == 'view')? array('class'=>'active') : array()
    ) ?></li>
<?php
	if ($isAdmin) {
?>
	<li><?php echo CHtml::link(Yii::t('main','Edit labels'), CHtml::normalizeUrl(array('settings/labelListing')),
         ($controllerId == 'settings' && $actionId == 'labelListing')? array('class'=>'active') : array()
    ) ?></li>
	<li><?php echo CHtml::link(Yii::t('main','Edit status'), CHtml::normalizeUrl(array('settings/statusListing')),
         ($controllerId == 'settings' && $actionId == 'statusListing')? array('class'=>'active') : array()
    ) ?></li>
	<li><?php echo CHtml::link(Yii::t('main','Edit groups'), CHtml::normalizeUrl(array('settings/groups')),
         ($controllerId == 'settings' && $actionId == 'groups')? array('class'=>'active') : array()
    ) ?></li>
    <li><?php echo CHtml::link(Yii::t('main','Edit projects'), CHtml::normalizeUrl(array('settings/projects')),
                   ($controllerId == 'settings' && $actionId == 'projects')? array('class'=>'active') : array()
    ) ?></li>
<?php
	if ($isGlobalAdmin) {
?>
	<li><?php echo CHtml::link(Yii::t('main','Edit members'), CHtml::normalizeUrl(array('settings/members')),
         ($controllerId == 'settings' && $actionId == 'members')? array('class'=>'active') : array()
    ) ?></li>
    <li><?php echo CHtml::link(Yii::t('main','Company settings'), CHtml::normalizeUrl(array('settings/company')),
         ($controllerId == 'settings' && $actionId == 'company')? array('class'=>'active') : array()
    ) ?></li>
    <li><?php echo CHtml::link(Yii::t('main','Add ons'), CHtml::normalizeUrl(array('settings/addOns')),
         ($controllerId == 'settings' && $actionId == 'addOns')? array('class'=>'active') : array()
    ) ?></li>
<?php
    if(false && empty(User::current()->githubUser)) {
	    $company = Company::model()->findByPk(Company::current());
	    if(!empty($company) && $company->isGitHubIntegrationAvailable()) {
?>
    <li><?php echo CHtml::link(Yii::t('main','Connect to GitHub'),
            CHtml::normalizeUrl(array('github/auth'))
    ); ?></li>
<?php
			}
    }
	} // is global admin
	} // is admin
?>
</ul><!-- #right_menu -->
