<div class="row">
    <div class="simple-comments">
        {* Only Show the review if enabled. *}
        {if $enable_grades == 1 OR $enable_comments == 1}
        <section>
            {foreach from=$comments item=comment}
            <br>
            <div class="row">
                <div class="col-xs-1"><img
                        src="http://www.gravatar.com/avatar/{$comment.email|trim|strtolower|md5}?s=45"
                        class="mx-auto d-block img-thumbnail" />
                </div>
                <div class="col-xs-11">
                    <p>{$comment.firstname} {$comment.lastname|substr:0:1}.</p>
                    {* Only show grades if enabled *}
                    {if $enable_grades==1}
                    <strong>Grade:</strong>
                    {for $foo=1 to $comment.grade}
                    <span class="simple-star">★ </span>
                    {/for}
                    {for $foo=1 to (5-$comment.grade)}
                    <span class="simple-uncheck-star">★ </span>
                    {/for}
                    {/if}
                    <strong>Date:</strong>
                    {$comment.date_add|substr:0:11}
                    <br>
                    {* Only show comments if enabled and comment is not empty *}
                    {if $enable_comments==1 AND $comment.comment !=""}
                    <strong>Comment:</strong>
                    {$comment.comment}
                    <br>
                    {/if}
                </div>
            </div>
            </p>
            <br>
            {/foreach}
            <section>
                {/if}
                {* Showing Review form. *}
                {if $enable_grades == 1 OR $enable_comments == 1}
                <form action="" method="POST" id="comment-form">
                    <div class="form-group">
                        <label for="firstname">
                            {l s='Firstname:' mod='simplecomments'}
                        </label>
                        <div class="row">
                            <div class="col-xs-4">
                                <input type="text" name="firstname" id="firstname" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastname">
                            {l s='Lastname:' mod='simplecomments'}
                        </label>
                        <div class="row">
                            <div class="col-xs-4">
                                <input type="text" name="lastname" id="lastname" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">
                            {l s='Email:' mod='simplecomments'}
                        </label>
                        <div class="row">
                            <div class="col-xs-4">
                                <input type="email" name="email" id="email" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    {* Only show grade input if enabled *}

                    <div class="form-group">
                        {if $enable_grades == 1}
                        <label for="grade">Grade:</label>
                        <div class="row simple-row">
                            <div class="simple-rate">
                                <input type="radio" id="star5" name="grade" value="5" />
                                <label for="star5" title="5 stars" class="simple-star">5 stars</label>
                                <input type="radio" id="star4" name="grade" value="4" />
                                <label for="star4" title="4 stars" class="simple-star">4 stars</label>
                                <input type="radio" id="star3" name="grade" value="3" />
                                <label for="star3" title="3 stars" class="simple-star">3 stars</label>
                                <input type="radio" id="star2" name="grade" value="2" />
                                <label for="star2" title="2 stars" class="simple-star">2 stars</label>
                                <input type="radio" id="star1" name="grade" value="1" />
                                <label for="star1" title="1 star" class="simple-star">1 star</label>
                            </div>
                        </div>
                        {/if}
                        {* Only show comment input if enabled *}
                        {if $enable_comments == 1}
                        <div class="form-group">
                            <label for="comment">Comment:</label>
                            <textarea name="comment" id="comment" class="form-control"></textarea>
                        </div>
                        {/if}
                    </div>
                    <div class="submit">
                        <button type="submit" name="simplecomments_submit_comment"
                            class="btn btn-primary float-xs-right hidden-xs-down">
                            <span>Send<i class="icon-chevron-right right">
                                </i></span></button>
                    </div>

                </form>
                {/if}
                <br>


    </div>
</div>