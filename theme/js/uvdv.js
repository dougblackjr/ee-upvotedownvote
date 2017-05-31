function uvdvup() {
	// Get upvote
	$.ajax({
		url:'?&id=',
		type:'POST',
		success: function(rdata){
			console.log(rdata);
			},
		error: function(xhr){
			console.log(xhr);
		}
	});
}

function uvdvdown() {
	// Get upvote
	$.ajax({
		url:'?&id=',
		type:'POST',
		success: function(rdata){
			console.log(rdata);
			},
		error: function(xhr){
			console.log(xhr);
		}
	});
}