var Reader = function() {
	this.init();
};

Reader.prototype = {
	init: function() {
		// make add feed button work		
		$('#ww-add-feed').click(function() {
			var feed_url = prompt('What website would you like to add?', 'http://');
			if(!feed_url || feed_url == 'http://') {
				alert('Invalid website');
			} else {
				helpers.send('reader', 'add_feed', {url:feed_url}, function(data){
					if(data.error) {
						alert('Error adding website: '+data.error);
					} else {
						this.load_feeds();
					}
				}, function(){
					alert('Error adding website');
				});
			}
		});
	},

	load_feeds: function() {
		$('#ww-feeds').html('<img src="/static/images/ajax-loader.gif" />');
		helpers.send('reader', 'load_feeds', {}, function(feeds) {
			var $feeds = $('<ul></ul>');
			$.each(feeds, function(key, feed){
				$feeds.append('<li title="'+feed.url+'">'+feed.name+'</li>');
			});
			$('#ww-feeds').html($feeds);
		}, function(){
			$('$ww-feeds').html('Error loading feeds');
		});
	}
};

