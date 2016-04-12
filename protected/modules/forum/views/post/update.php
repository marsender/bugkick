<?php
/* @var $this PostController */
/* @var $model BKPost */

$this->breadcrumbs=array(
    Yii::app()->name=>array('/site'),
    'Forums'=>array('/forum'),
    CHtml::encode(Helper::truncateString($model->topic->forum->title))=>
        array('forum/view/','id'=>$model->topic->forum->id),
    CHtml::encode(Helper::truncateString($model->topic->title))=>
            array('topic/view','id'=>$model->topic->id),
    CHtml::encode(Helper::truncateString($model->body)),
    Yii::t('main','Update')
);

$this->menu=array(
    array('label'=>Yii::t('main', 'Back to topic'), 'url'=>array('forum/topic/view', 'id'=>$model->topic->id)),
    array('label'=>Yii::t('main', 'Back to forum'), 'url'=>array('forum/view', 'id'=>$model->topic->forum->id)),
    array('label'=>Yii::t('main', 'Back to forums'), 'url'=>array('/forum')),
);
$this->pageTitle = Yii::t('main','Update post');
?>
<header><h3><?php echo $this->pageTitle; ?></h3></header>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'topic'=>$topic)); ?>