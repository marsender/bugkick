<?php
// Use sample: Helper::formatDateSlash($date);
// Yii::app()->params['date']['formatDateSlash']
return array(
	'formatDate12'=>'d/m/Y g:ia', // format date and time to 12h format
	'formatDateShort'=>'d M', // format date to format:  oct 12
	'formatDateLong'=>'dS F Y', // format date to format:  03th December 2011
	'formatDateSlash'=>'j/n/Y', // format date to format:  2/25/12 - mon/day/year
	'formatDateSlashFull'=>'j/n/Y \a\t g:ia', // format date to format:  2/25/12 at 10:38pm - mon/day/year at time
	'formatDateLongWithTime'=>'jS F Y - g:ia', // format date to format:  2nd April 2012 - 3:42pm
);
