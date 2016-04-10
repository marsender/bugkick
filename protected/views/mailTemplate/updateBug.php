<html>
<body>
	<div style='border: 1px solid silver; margin: 10px; padding: 10px;'>
		<h3><?php echo Yii::app()->user->name . ' ' . Yii::app()->user->lname . ' ' . Yii::t('main', 'updated the ticket') . ' ' . $model->number . ' "' . $model->title . '"'; ?></h3>
<?php
foreach ($changes as $change) {
	$value = $change['value'];
	if ($change['field'] == 'duplicate_number') {
		if ($value == 0) {
			echo '<p><b style="color:#666;">' . Yii::t('main', 'Duplicate status') . ':</b> ' . Yii::t('main', 'Duplicate status was removed') . '</p>';
		}
		elseif ($value > 0) {
			echo '<p><b style="color:#666;">' . Yii::t('main', 'Duplicate status') . ':</b> ' . Yii::t('main', 'Ticket was set as duplicate of the ticket') . ' #' . $value . '</p>';
		}
	}
	elseif ($change['field'] == 'archived') {
		if ($value == 0) {
			echo '<p><b style="color:#666;">' . Yii::t('main', 'Ticket is opened') . '</b></p>';
		}
		else {
			echo '<p><b style="color:#666;">' . Yii::t('main', 'Ticket is closed') . '</b></p>';
		}
	}
	elseif ($change['field'] == 'label_id' || $change['field'] == 'user_id') {
		$paramChange = '';
		$name = $change['name'];
		$paramChange = '<p><b style="color:#666;">' . $name . ':</b> ';
		foreach ($value as $val) {
			$paramChange .= $val . ', ';
		}
		echo substr($paramChange, 0, -2) . '</p>';
	}
	else {
		$name = $change['name'];
		echo '<p><b style="color:#666;">' . $name . ':</b> ' . $value . '</p>';
	}
}
?>
       <br>
		<p style='border-bottom: 1px solid silver;'>&nbsp;</p>
		<table>
			<tr>
				<td><a
					style="display: block; text-decoration: none; color: white; background-color: #1A74B0; margin: 10px; padding: 10px;"
					href='<?php echo Yii::app()->createAbsoluteUrl('bug/view', array('id'=>$model->number))?>'>
                        <?php echo Yii::t('main', 'View ticket'); ?>
                    </a></td>
				<td style="margin: 10px; color: #666; font-size: 11px;">
                    <?php echo Yii::t('main', 'To view this ticket, visit this link'); ?>:<br>
                    <?php

echo CHtml::link(Yii::app()->createAbsoluteUrl('bug/view', array(
																					'id' => $model->number
																				)), Yii::app()->createAbsoluteUrl('bug/view', array(
																					'id' => $model->number
																				)));
																				?>
                </td>
			</tr>
		</table>
	</div>
</body>
</html>