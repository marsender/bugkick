<?php
/* @var $this ForumController */
/* @var $model BKForum */
$this->breadcrumbs=array(
    Yii::app()->name=>array('/site'),
    'Forums'=>array('index'),
    CHtml::encode(Helper::truncateString($model->title))=>array('view','id'=>$model->id),
    'Update',
);
$this->menu=array(
    array('label'=>Yii::t('main', 'List forums'), 'url'=>array('index')),
   	array(
        'label'=>Yii::t('main', 'Create forum'),
        'url'=>array('create'),
   	    'visible'=>Yii::app()->user->checkAccess('moderator')
    ),
   	array(
        'label'=>Yii::t('main', 'View forum'),
        'url'=>array('view', 'id'=>$model->id)
    ),
   	array(
        'label'=>Yii::t('main', 'Manage forums'),
        'url'=>array('admin'),
   	    'visible'=>Yii::app()->user->checkAccess('moderator')
    ),
);
$this->pageTitle = Yii::t('main','Update forum');
?>
<header><h3><?php echo $this->pageTitle; ?></h3></header>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>