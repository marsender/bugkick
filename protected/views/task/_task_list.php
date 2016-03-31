<div class="task-box">
    <!-- <div class="task-icon"></div>
    <div class="clear"></div> -->
    <ul class="task-list">
        <h3><?php echo Yii::t('main', 'Tasks');?></h3>
        <?php $this->widget('zii.widgets.CListView', array(
            'id'=>'task-list',
            'summaryText'=>'',
            'emptyText'=>'', //Yii::t('main', 'No tasks'),
        	'dataProvider'=>$tasks,
        	'itemView'=>'application.views.task._task_item',
        )); ?>
    </ul>
    <a href="<?php echo $this->createUrl('task/create', array('ticketID'=>$ticket->id));?>" class="add-task">&nbsp; &nbsp; &nbsp; <?php echo Yii::t('main', 'Add task'); ?></a>
</div>
<!-- Create Task-->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'createTaskDialog',
        'options'=>array(
            'title'=>'Add task',
            'autoOpen'=>false,
            'modal'=>true,
            'hide'=>'drop',
            'show'=>'drop',
            'buttons'=>array(
                'Cancel'=>'js:function(){ $(this).dialog("close");}',
                'Save'=>'js:createTask',
            ),
        ),
    ));
?>
    <div id="createTaskForm"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<!--End Create Task-->