function upvotedownvote(url, ud) {
	event.preventDefault();
	
	// Act on the event
	$.ajax({
		url:url,
		type:'POST',
		success: function(rdata){
			console.log(rdata);
			// Get count div
			var count = $('.upvotedownvote-block .count').text();
			// Get total div
			var total = $('.upvotedownvote-block .mini').text();
			total = total.replace( /^\D+/g, '').split(' ');
			total = parseInt(total);
			// Add one to each
			total++;
			if (ud === 'up') {
				count++;
			} else {
				count--;
			}
			// Update the divs
			$('.upvotedownvote-block .count').text(count);
			$('.upvotedownvote-block .mini').text('('+total+' votes)');
		},
		error: function(xhr){
			console.log(xhr);
		}
	});
};