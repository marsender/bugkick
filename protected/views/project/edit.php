<div class="form">
<?php
/*<div class="project-pic" style="float: right; width: 20%;">
 <div>
 <img id="projectLogo" alt="Project logo" src="<?php echo $project->getLogoSrc(true); ?>" />
 </div>
 <?php
 $this->widget(
 'AjaxUpload',
 array(
 'id'=>'uploadProjectLogo',
 'buttonText'=>'Choose a logo',
 'posInitUploader'=>AjaxUpload::INIT_POS_DIRECTLY,
 'config'=>array(
 'action'=>$this->createUrl('project/uploadLogo'),
 'allowedExtensions'=>array('jpg', 'jpeg', 'gif', 'png'),
 'sizeLimit'=>2097152, // 2 MB - the maximum file size
 //'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
 'onComplete'=>"js:function(id, fileName, responseJSON) {
 if(responseJSON.filename != 'undefined'
 && responseJSON.tmpFileID != '0') {
 var projectLogo = $('#projectLogo')
 projectLogo.attr(
 'src',
 '/temp/project_logo/' + responseJSON.filename
 );
 $('#ProjectForm_tmpFileID').val(responseJSON.tmpFileID);
 var prop = projectLogo.width() > projectLogo.height()
 ? 'width'
 : 'height';
 projectLogo.css(prop, '50px');
 }
 }"
 )
 )
 );
 ?>
 </div>
 */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
	'id' => 'project-form',
	'action' => $formAction,
	'method' => 'POST',
	'enableAjaxValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => false
	),
	'htmlOptions' => array(
		//'enctype'=>'multipart/form-data',
		'name' => 'projectForm',
		'style' => 'float:left; display:none;'
	)
));
?>
    <ul class="nav nav-tabs">
		<li class="active"><a href="#project-common-info" data-toggle="tab"><?php echo Yii::t('main', 'Common info'); ?></a></li>
		<li><a href="#project-users" data-toggle="tab"><?php echo Yii::t('main', 'People'); ?></a></li>
		<li><a href="#project-labels" data-toggle="tab"><?php echo Yii::t('main', 'Labels'); ?></a></li>
		<li><a href="#project-defaults" data-toggle="tab"><?php echo Yii::t('main', 'Default actions'); ?></a></li>
<?php if($projectForm->connectToGitHub) { ?>
    <li><a href="#extra-features" data-toggle="tab"><?php echo Yii::t('main', 'Extra Features'); ?></a></li>
<?php } ?>
    </ul>

	<div class="tab-content">
		<div class="tab-pane active" id="project-common-info">
			<div class="main-info">
				<div class="project-pic">
					<div>
						<img id="projectLogo" alt="Project logo"
							src="<?php echo $project->getLogoSrc(70,70); ?>" />
					</div>
                    <?php
																				$this->widget('AjaxUpload', array(
																					'id' => 'uploadProjectLogo',
																					'buttonText' => 'Choose a logo',
																					'posInitUploader' => AjaxUpload::INIT_POS_DIRECTLY,
																					'config' => array(
																						'action' => $this->createUrl('project/uploadLogo'),
																						'allowedExtensions' => array(
																							'jpg',
																							'jpeg',
																							'gif',
																							'png'
																						),
																						'sizeLimit' => 2097152, // 2 MB - the maximum file size
																						//'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
																						'onComplete' => "js:function(id, fileName, responseJSON) {
                                    if(responseJSON.filename != 'undefined'
                                        && responseJSON.tmpFileID != '0') {
                                        var projectLogo = $('#projectLogo')
                                        projectLogo.attr(
                                            'src',
                                            '/temp/project_logo/' + responseJSON.filename
                                        );
                                        $('#ProjectForm_tmpFileID').val(responseJSON.tmpFileID);
                                        var prop = projectLogo.width() > projectLogo.height()
                                            ? 'width'
                                            : 'height';
                                        projectLogo.css(prop, '70px');
                                    }
                                }"
																					)
																				));
																				?>
                </div>

				<div class="row">
					<div class="basic-project-text">
						<div>
							<?php
							echo $form->labelEx($projectForm, 'Name'), $form->textField($projectForm, 'name'), $form->error($projectForm, 'name');
							?>
						</div>
						<div>
							<?php
							echo $form->labelEx($projectForm, 'Description'), $form->textArea($projectForm, 'description'), $form->error($projectForm, 'description');
							?>
						</div>
						<div style="margin-top:10px;">
							<?php
						if (!$project->isNewRecord && User::isCompanyAdmin($project->company->company_id) || User::isProjectAdmin($project->project_id)) {
							echo CHtml::link(Yii::t('main', 'Delete project'), array(
								'project/deleteProject',
								'id' => $project->project_id
							), array(
								'style' => 'color:#06C; margin-right:15px;',
								'onclick' => 'return confirm("After confirming of this action this project will be deleted.\n\nContinue?");'
							));

							echo CHtml::link(Yii::t('main', $project->archived == 1 ? 'Restore project' : 'Archive project'), array(
								'project/setArchived',
								'id' => $project->project_id
							), array(
								'style' => 'color:#06C; margin-right:20px;',
								'onclick' => $project->archived == 1 ? '' : 'return confirm("After confirming of this action you will lose the access to this project.\n\nContinue?");'
							));
						}
						?>
						</div>
					</div>
				</div>
			</div>

			<div class="clear"></div>
		</div>
		<!-- #project-coomon-info -->

		<div class="tab-pane" id="project-users">
			<div class="row">
                <?php echo $form->labelEx($projectForm, 'Project users'); ?>
                <?php
																echo CHtml::activeDropDownList($projectForm, 'users', CHtml::listData(Company::getUsers(), 'user_id', 'name'), array(
																	'multiple' => 'multiple',
																	'key' => 'label_id',
																	'prompt' => '&nbsp;',
																	'class' => 'chzn-select'
																));
																?>
                <?php echo $form->error($projectForm, 'users'); ?>
            </div>
		</div>
		<div class="tab-pane" id="project-labels">
			<div class="row">
                <?php echo $form->labelEx($projectForm, 'Project labels'); ?>
                <?php
																$labels = ($project->isNewRecord) ? Company::getPreCreatedLabels() : Company::getLabels();
																echo CHtml::activeDropDownList($projectForm, 'labels', CHtml::listData($labels, 'label_id', 'name'), array(
																	'multiple' => 'multiple',
																	'key' => 'label_id',
																	'prompt' => '&nbsp;',
																	'class' => 'chzn-select'
																));
																?>
                <?php echo $form->error($projectForm, 'labels'); ?>
            </div>
		</div>
		<!-- #project-users-and-labels -->

		<div class="tab-pane" id="project-defaults">
            <?php echo  $form->hiddenField($projectForm, 'tmpFileID');	//	temporary logo file ?>
            <div class="row">
                <?php echo $form->labelEx($projectSettings, 'defaultAssignee'); ?>
                <?php

																if ($project->isNewRecord)
																	$projectSettings->defaultAssignee = Yii::app()->user->id;
																echo CHtml::activeDropDownList($projectSettings, 'defaultAssignee', CHtml::listData(empty($project_id) ? array(
																	User::current()
																) : Project::getUsers($project_id), 'user_id', 'name'), array(
																	'prompt' => '&nbsp;',
																	'class' => 'chzn-select selectbox'
																))?>
            </div>
			<div class="row">
                <?php echo $form->error($projectSettings, 'defaultAssignee'); ?>
                <?php echo $form->labelEx($projectSettings, 'defaultStatus'); ?>
                <?php
																if ($project->isNewRecord) {
																	$newStatus = Company::getNewStatus();
																	if (!empty($newStatus))
																		$projectSettings->defaultStatus = $newStatus->status_id;
																}
																echo CHtml::activeDropDownList($projectSettings, 'defaultStatus', CHtml::listData(Company::getStatuses(), 'status_id', 'label'), array(
																	'prompt' => '&nbsp;',
																	'class' => 'chzn-select selectbox'
																))?>
            </div>
			<div class="row">
                <?php echo $form->error($projectSettings, 'defaultStatus'); ?>
                <?php echo $form->labelEx($projectSettings, 'defaultLabel'); ?>
                <?php
																if ($project->isNewRecord) {
																	$bugLabel = Project::getBugLabel();
																	if (!empty($bugLabel))
																		$projectSettings->defaultLabel = $bugLabel->label_id;
																}
																$labels = ($project->isNewRecord) ? Company::getPreCreatedLabels() : Project::getLabels($project->project_id);
																echo CHtml::activeDropDownList($projectSettings, 'defaultLabel', CHtml::listData($labels, 'label_id', 'name'), array(
																	'prompt' => '&nbsp;',
																	'class' => 'chzn-select selectbox'
																))?>
                <?php echo $form->error($projectSettings, 'defaultLabel'); ?>
            </div>

		</div>
		<!-- #project-defaults -->

        <?php if($projectForm->connectToGitHub) { ?>
        <div class="tab-pane" id="extra-features">
			<div class="row">
				<label>Integration with GitHub:</label>
                <?php
									echo CHtml::link('Connect to GitHub', array(
										'/github/repo/connect',
										'project_id' => $project->project_id
									), array(
										'class' => 'bkButtonBlueSmall medium'
									));
									?>
            </div>
		</div>
        <?php } ?>
    </div>
	<!-- .tab-content -->
<?php $this->endWidget();?>
    <div class="clear"></div>
</div>