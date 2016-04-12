<?php
/* @var $this TopicController */
/* @var $model BKTopic */

$this->breadcrumbs=array(
    Yii::app()->name=>array('/site'),
    'Forums'=>array('index'),
    CHtml::encode(Helper::truncateString($model->forum->title))=>array('view','id'=>$model->forum->id),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('main', 'Back to forum'), 'url'=>array('forum/view', 'id'=>$model->forum->id)),
	array('label'=>Yii::t('main', 'Create topic'),
        'url'=>array('create', 'forumID'=>$model->forum->id),
	    'visible'=>Yii::app()->user->checkAccess('user')
    ),
	array('label'=>Yii::t('main', 'View topic'), 'url'=>array('view', 'id'=>$model->id)),
/*	array('label'=>'Manage Topics', 'url'=>array('admin'),
	    'visible'=>Yii::app()->user->checkAccess('moderator')),*/
);
$this->pageTitle = Yii::t('main','Update topic');
?>
<header><h3><?php echo $this->pageTitle; ?></h3></header>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>