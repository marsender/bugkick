<?php
/* @var $this PostController */
/* @var $model BKPost */
/* @var $topic BKTopic */

$this->breadcrumbs=array(
    Yii::app()->name=>array('/site'),
    'Forums'=>array('forum/index'),
    CHtml::encode(Helper::truncateString($topic->forum->title))=>array('forum/view','id'=>$topic->forum->id),
    CHtml::encode(Helper::truncateString($topic->title))=>array('topic/view','id'=>$topic->id),
	'Create',
);
$this->menu=array(
	array('label'=>'Back to Topic', 'url'=>array('topic/view','id'=>$topic->id)),
);
$this->pageTitle = Yii::t('main','Post comment');
?>

<header><h3><?php echo $this->pageTitle; ?></h3></header>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'topic'=>$topic)); ?>