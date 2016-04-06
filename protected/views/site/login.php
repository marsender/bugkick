<?php
$this->pageTitle=Yii::app()->name . ' - Login';
/*
$this->breadcrumbs=array(
	'Login',
);
 */
?>

<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<?php if(Yii::app()->user->hasFlash('success'))
    echo Yii::app()->user->getFlash('success');
?>

	<p class="note"><?php echo Yii::t('main', 'Fields with <span class="required">*</span> are required'); ?>.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

<?php echo Yii::t('main', 'Not registered'); ?> ? <?php echo CHtml::link(Yii::t('main', 'Sign up'), Yii::app()->createUrl('registration')) ?>
