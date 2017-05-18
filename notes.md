# My Notes

### What It Does
Upvote or downvote content
One click per page per user (use cookies)
Write to DB one table (entry_id, up_votes, down_votes)

### Process
Get entry_id, get cookie to see if person clicked, aggregate (up minus down), update ui

### Output
NUMBER - UP - DOWN

### Database
+ id: auto
+ entry_id: integer
+ upvotes: integer
+ downvotes: integer