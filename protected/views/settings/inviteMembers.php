<?php
$this->breadcrumbs = array(
    'Settings',
);
?>
<h1><?php echo Yii::t('main', 'Invite members'); ?></h1>

<?php $this->widget('InviteMember'); ?>

<?php $this->renderFlash(); ?>

<?php if (!empty($userProvider)): ?>
    <?php
    $this->renderPartial('_users', array(
        'model' => $userProvider,
    ));
    ?>
<?php else: ?>
<?php echo Yii::t('main', 'No users'); ?><br>
<?php endif ?>
