<div id="tabed-nav">
    <ul>
<?php
				$isGlobalAdmin = User::current()->isGlobalAdmin();
				$url = Yii::app()->getRequest()->getUrl();
        foreach($this->tabs as $tab) {
	        $classAdd = array();
	        $tabId = $tab['id'];
	        if (!$isGlobalAdmin) {
	        	if ($tabId == 'people-tab' || $tabId == 'settings-tab') {
		        	continue;
		        }
	        }
	        if ($tabId == 'calendar-tab' || $tabId == 'settings-tab') {
	        	$classAdd[] = 'iconsright';
	        }
	        if($url == $tab['url']) {
	        	$classAdd[] = 'current';
	        }
?>
        <li<?php
        if(count($classAdd)) {
        	echo ' class="' . implode (' ', $classAdd) . '"';
        }
        ?>>
        <?php
        echo CHtml::link(Yii::t('main', $tab['text']), $tab['url'], array(
            'title'=>Yii::t('main', $tab['title']),
            'id'=>$tabId,
            'class'=>isset($tab['class'])?$tab['class']:'',
        ));
        ?>
        </li>
        <?php } ?>
    </ul>
</div>
<?php
if(Yii::app()->controller->id=='bug' && Yii::app()->request->getParam('show')!='calendar'){
    Yii::app()->clientScript->registerCss(
        'tab-margin', '#content #tabed-nav{margin-right: 282px;}'
    );
}
?>