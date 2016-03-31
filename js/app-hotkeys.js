$(document).bind('keydown', 'n', function(evt) {
	$('#bug-form').css('display', 'block');
	$('#createBugDialog').dialog('open');
	return false;
});
$(document).bind('keydown', 'b', function(evt) {
	window.location = '/bugkick/bug';
	return false;
});
$(document).bind('keydown', 't', function(evt) {
	window.location = '/bugkick/bug/summaryTickets';
	return false;
});
$(document).bind('keydown', 'p', function(evt) {
	window.location = '/bugkick/project/index';
	return false;
});
$(document).bind('keydown', 'd', function(evt) {
	window.location = '/bugkick/site/dashboard';
	return false;
});
$(document).bind('keydown', 'u', function(evt) {
	window.location = '/bugkick/updates';
	return false;
});
$(document).bind('keydown', 's', function(evt) {
	window.location = '/bugkick/settings';
	return false;
});
$(document).bind('keydown', 'h', function(evt) {
	$('#shortcuts').css('display', 'block');
	return false;
});