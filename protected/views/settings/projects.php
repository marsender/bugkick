<div class="settings">
<h2 class="listing-title"><?php echo ($projectView != 'archived')? Yii::t('main', 'Projects') : Yii::t('main', 'Archived projects'); ?></h2>
    <?php $this->renderFlash(); ?>
    <?php
    $this->renderPartial(
        '_projectsGrid',
        array(
            'model'=>$project,
            'dataProvider'=>$project->gridSearch(),
            'pager'=>$pager,
            'projectView'=>$projectView,
        )
    );
    if ($projectView != 'archived') { // && Company::model()->findByPk(Company::current())->archivedProjectCount>0){
        echo CHtml::link(Yii::t('main', 'View archived projects'), $this->createUrl('/settings/projects/archived'));
    }
    else {
        echo CHtml::link(Yii::t('main', 'Back to projects'), $this->createUrl('/settings/projects'));
    }
    echo CHtml::link(Yii::t('main', 'New project'), $this->createUrl('/project/edit'),
            array(
                'id'=>'createProjectBtn',
                'class'=>'bkButtonBlueSmall normal new-project',
            )
    );
?>
    <div class="clear"></div>
<?php
    $forceCreate=$this->request->getParam('forceCreate');
    $this->beginWidget(
        'zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'project-form-dialog',
            'options'=>array(
                'title'=>'New project',
                'autoOpen'=>!empty($forceCreate),
                //'width'=>350,
                //'height'=>440,
                'modal'=>true,
                'hide'=>'drop',
                'show'=>'drop',
                'buttons'=>array(
                    'Save'=>'js:submitProjectForm',
                    //'Cancel'=>'js:closeDialog',
                ),
                'open'=>'js: function(event, ui) {
                     $("#project-form").css("display", "block");
                }'
            ),
        )
    );
    $this->renderPartial(
        '/project/edit',
        array(
            'projectForm'=>$projectForm,
            'project'=>$project,
            'companies'=>$companies,
            'projectSettings'=>$projectSettings,
            'formAction'=>$formAction
        )
    );
    $this->endWidget();

    $this->beginWidget(
        'zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'update-dialog',
            'options'=>array(
                'title'=>'Please upgrade',
                'autoOpen'=>!empty($forceCreate),
                //'width'=>350,
                //'height'=>440,
                'modal'=>true,
                'hide'=>'drop',
                'show'=>'drop',
                'buttons'=>array(
                    'Upgrade'=>'js:function(){
                        document.location.href="'.$this->createUrl('payment/chooseSubscription').'"
                    }',
                ),
            )
        )
    );
    $this->endWidget();
?>
</div>