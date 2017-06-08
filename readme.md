# UpvoteDownvote

## Instructions
Add

        {exp:upvotedownvote:output entry="{entry_id}"}
            {score}
            {count}
            {upvotes}
            {downvotes}
            {up_action}
            {down_action}
        {/exp:upvotedownvote:output}

SCORE: Get cumulative score (upvotes - downvotes)
COUNT: Get total votes (# of upvotes + # of downvotes)
UPVOTES: Total # of upvotes
DOWNVOTES: Total # of downvotes
UP_ACTION: Number of action to call to log an upvote
DOWN_ACTION: Number of action to call to log an downvote

## Widget Code

Some widget code with JS and CSS is included in the theme. Feel free to make your own:

#### HTML with EE tags
        {exp:upvotedownvote:output entry="{entry_id}"}
            <div class="upvotedownvote-block">
                <div class="count">{score}</div>
            <div class="mini">({count} votes)</div>
            <div class="thumbs">
                <div><a id="thumb-up" onclick="upvotedownvote('?ACT={up_action}&id={entry_id}','up');"><img src="thumbs-up.png" id="uvdv-tu-img" class="thumb thumbs-up" /></a></div>
                <div><a id="thumb-down" onclick="upvotedownvote('?ACT={down_action}&id={entry_id}','down');"><img src="$td" id="uvdv-td-img" class="thumb thumbs-down" /></a></div>
            </div>
        </div>

#### CSS
        .upvotedownvote-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 60px;
            /*background: #4ab3e4;*/
            background: #7E7E7E;
            border-radius: 2px;
            padding: 0.2rem;
        }
        
        .upvotedownvote-block .count {
            color: white;
            font-size: 2rem;
        }
        
        .upvotedownvote-block .mini {
            color: white;
            font-size: 0.5rem;
            line-height: 0.7rem;
        }
        
        .upvotedownvote-block .thumbs {
            display: flex;
            justify-content: space-around;
        }
        
        .upvotedownvote-block .thumb {
            font-size: 1.3rem;
            cursor: pointer;
        }
        
        .upvotedownvote-block .thumbs-up {
            height: 20px;
            width: 20px;
        }
        
        .upvotedownvote-block .thumbs-down {
            height: 20px;
            width: 20px;
        }
        
        .upvotedownvote-block .success {
            color: #BB0000;
        }

#### JS
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
                    
                    if (ud == 'up') {
                        var thumb = $('#uvdv-tu-img').attr('src');
                        thumb = thumb.replace('thumbsup.png', 'thumbsup-success.png');
                        $('#uvdv-tu-img').attr('src', thumb);
                    } else {
                        var thumb = $('#uvdv-td-img').attr('src');
                        thumb = thumb.replace('thumbsdown.png', 'thumbsdown-success.png');
                        $('#uvdv-td-img').attr('src', thumb);
                    }
                    
                    $('#thumb-down').prop('onclick', null);
                    $('#thumb-up').prop('onclick', null);
                    
                },
                error: function(xhr){
                    console.log(xhr);
                }
            });
        };