<html>
<body>
	<div style='border: 1px solid silver; margin: 10px; padding: 10px;'>
		<p><?php echo Yii::t('main', 'Hi'); ?>,</p>
		<p>&nbsp;</p>
		<p>
			<?php echo sprintf(Yii::t('main', '%s has invited you to join a project on %s'), User::current()->getUserName(), Yii::app()->name); ?>.<br />
			<?php echo Yii::t('main', 'Please login to your account'); ?>.
		<p>&nbsp;</p>
		<p><?php echo Yii::t('main', 'Yours'); ?>,<br /><?php echo User::current()->getUserName(); ?></p>

		<p style='border-bottom: 1px solid silver;'>&nbsp;</p>
		<table>
			<tr>
				<td><a
					style="display: block; text-decoration: none; color: white; background-color: #1A74B0; margin: 10px; padding: 10px;"
					href="<?php echo $acceptUrl; ?>"><?php echo Yii::t('main', 'Login'); ?></a></td>
				<td style="margin: 10px; color: #666; font-size: 11px;">
<?php echo Yii::t('main', 'To login to your account, visit this link'); ?>:<br>
<?php echo CHtml::link($acceptUrl, $acceptUrl); ?>
</td>
			</tr>
		</table>
	</div>
</body>
</html>