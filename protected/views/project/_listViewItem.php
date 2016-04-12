<?php
/**
 * Author: Alexey kavshirko@gmail.com
 * Date: 16.01.12
 * Time: 23:41
 */
$isGlobalAdmin = User::isGlobalAdmin();
$isProjectAdmin = User::isProjectAdmin($data->project_id); // $isGlobalAdmin && ($userCurrent->isCompanyAdmin($data->company->company_id) || $isProjectAdmin);
?>
<div class="project-container">
	<!-- <div class="project-top"></div> -->
	<a
		href="<?php echo $this->createUrl('project/choose', array('menu_project_id'=>$data->project_id)); ?>">
		<div class="project-center">
			<img src="<?php echo $data->getLogoSrc(70,70) ?>" />
			<div class="project-description">
				<h3><?php echo Helper::truncateString($data->name, 25); ?></h3>
<?php
if (false) {
	echo CHtml::link(Yii::t('main', 'Manage'), array(
		'project/manage',
		'project_id' => $data->project_id
	), array('class' => 'update'))
	;
}
if ($isGlobalAdmin || $isProjectAdmin) {
	echo CHtml::link(Yii::t('main', 'Edit'), array(
		'project/edit',
		'id' => $data->project_id
	), array('class' => 'update'))
	;
}
if (false) { // !$isProjectAdmin) {
	echo CHtml::link(Yii::t('main', 'Unsuscribe'), array(
		'project/hide',
		'id' => $data->project_id
	), array(
		//'class' => 'hide',
		'onclick' => 'return confirm("After confirming of this action you will lose the access to this project.\n\nContinue?");'
	));
}

$tasks = $this->getTasksCounts($data->project_id);
$completed = ($tasks['total'] > 0 && $tasks['completed'] > 0) ? round($tasks['completed'] * 100 / $tasks['total'], 1) : 0;
?>
            <div class="progress-container">
					<div class="progress-completed" style="width:<?php echo 2 * $completed?>px"><?php echo $completed?>%</div>
				</div>
			</div>
		</div>
	</a>
	<!-- <div class="project-bottom"></div> -->
</div>