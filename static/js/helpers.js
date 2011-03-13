helpers = {
	send: function(controller, action, data, success, error) {
		$.ajax({
			url: '/index.php?c='+controller+'&a='+action,
			type: 'POST',
			dataType: 'json',
			success: success,
			error: error 
		});

	}
};
