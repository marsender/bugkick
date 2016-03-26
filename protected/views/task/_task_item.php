<li class="task-item access_del" taskID="<?php echo $data->id; ?>">
    <input type="checkbox" class="check-task"
        <?php if($data->status==Task::STATUS_COMPLETED) echo 'checked="checked"' ?>/>
    <span class="task-description <?php if($data->status==Task::STATUS_COMPLETED) echo 'crossed' ?>">
        <?php echo CHtml::encode($data->description); ?>
    </span>
    <div class="task_actions">
        <a class="edit_task_button">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/edit-icon.png" title="Edit micro task">
        </a>
        <a onclick="return confirm('Are you sure you want to delete this micro task?')" href="<?php echo Yii::app()->baseUrl; ?>/task/delete/<?php echo $data->id; ?>">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/i_delete.png" title="Delete micro task">
        </a>
    </div>
</li>