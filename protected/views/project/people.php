<?php
/**
 * Author: Alexey kavshirko@gmail.com
 * Date: 24.11.12
 * Time: 19:12
 */
$this->breadcrumbs = array(
	Yii::t('main', 'Project users'),
);
?>
<div class="settings">
    <div class="members-container">
            <!-- <h2 class="listing-title"><?php echo Yii::t('main', 'Project users'); ?></h2> -->
            <?php $this->renderFlash(); ?>
            <?php $this->renderPartial('_peopleGrid',array(
                'dataProvider' => $dataProvider,
            )); ?>
    </div>
    <a id="invitePeople" class="bkButtonBlueSmall normal"
       href="<?php echo $this->createUrl('project/managePeople'); ?>">
        <?php echo Yii::t('main', 'Invite user'); ?>
    </a>
</div>

<?php
    Yii::app()->clientScript->registerScript('invitePeople', '
    $("#invitePeople").live("click",function() {
        $.post(
            $(this).attr("href"),
            { YII_CSRF_TOKEN:YII_CSRF_TOKEN },
            function(data){
                $("#invitePeopleForm").html(data);
                $("#invitePeopleDialog").dialog("open");
                $(".chzn-select").chosen();
            },
            "html"
        );
        return false;
    });
    ', CClientScript::POS_END);
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'invitePeopleDialog',
	'options'=>array(
		'title'=>'Invite user',
		'autoOpen'=>false,
		'modal'=>true,
//      'hide'=>'drop',
//		'show'=>'drop',
        'width'=>500,
		'buttons'=>array(
            'Invite'=>'js:function(){
                $(\'#invite-form\').trigger(\'submit\');
            }'
        ),
	),
));
?>
<div id="invitePeopleForm"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>

<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'project-form-dialog',
        'options'=>array(
            'title'=>'Edit project',
            'autoOpen'=>false,
//    			'width'=>565,
            //'height'=>440,
            'modal'=>true,
            'hide'=>'drop',
            'show'=>'drop',
            'buttons'=>array(
                'Save'=>'js:submitProjectForm',
                //'Cancel'=>'js:closeDialog',
            ),
        )
    )
);
$this->endWidget();
?>