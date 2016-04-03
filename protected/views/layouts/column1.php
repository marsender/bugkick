<?php
	$this->beginContent('//layouts/main');
	$controller = $this->getId();
	$action = $this->getAction()->getId();
	$divId = 'main_wide';
	switch ($controller) {
	case 'site':
		switch ($action) {
		case 'login';
			$divId = '';
			break;
		case 'dashboard';
			$divId = 'main';
			break;
		}
		break;
	case 'notification':
		switch ($action) {
		case 'index';
			$divId = 'main';
			break;
		}
		break;
	case 'project':
		switch ($action) {
		case 'people';
			$divId = 'main';
			break;
		}
		break;
	}
?>
    <div<?php if(!empty($divId)) echo ' id="' . $divId . '"'?>>
         <?php $this->renderPartial('application.views.site._menu'); ?>
        <div class="wide_content_wraper">
         <?php echo $content; ?>
        </div>
    </div>
<?php $this->endContent(); ?>