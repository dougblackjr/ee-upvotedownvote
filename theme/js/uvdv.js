function upvotedownvote(url, ud) {
	event.preventDefault();
	
	// Act on the event
	$.ajax({
		url:url,
		type:'POST',
		success: function(rdata){
			console.log(rdata);
			// Get count div
			// Get total div
			// Add one to each
			// Update the divs
			},
		error: function(xhr){
			console.log(xhr);
		}
	});
};