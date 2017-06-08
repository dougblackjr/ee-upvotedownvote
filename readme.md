# UpvoteDownvote

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


### Widget Code

Some widget code with JS and CSS is included in the theme. Feel free to make your own:

        <style>$css</style>
        <div class="upvotedownvote-block">
            <div class="count">$count</div>
            <div class="mini">($total votes)</div>
            <div class="thumbs">
                <div><a id="thumb-up" onclick="upvotedownvote('?ACT=$up&id=$id','up');"><img src="$tu" id="uvdv-tu-img" class="thumb thumbs-up" /></a></div>
                <div><a id="thumb-down" onclick="upvotedownvote('?ACT=$down&id=$id','down');"><img src="$td" id="uvdv-td-img" class="thumb thumbs-down" /></a></div>
            </div>
        </div>
        <script src="$js" type="text/javascript" charset="utf-8"></script>