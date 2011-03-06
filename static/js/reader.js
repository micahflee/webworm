$(function(){

	// load feeds
	$('#feeds').html('<img src="/static/images/ajax-loader.gif" />');
	$.ajax({
		url: '/index.php?c=reader&a=load_feeds',
		type: 'POST',
		success: function(data) {
			$('#feeds').html(data);
		}
	});
	
});
