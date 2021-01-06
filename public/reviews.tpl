% function showReviews($data) %
    % loop $data as $t %
        % php $attributes = $t->attributes() %
        <li id="review-%% $attributes['id'] %%" class="review-item %% $t->type_response == 'good' ? 'review-good' : 'review-bad' %%">
            <div class="review-body">
                <p class="meta"><i class="fa fa-calendar-o"<i> %% $t->date_response %%</i></p>
                <p class="message">%% $t->text_response %%</p>
            </div>
        </li>
    % endloop %
% endfunction %

<div id="reviews-list" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    % if $data->cnt_responses > 0 %
        <ul class="reviews">
            % php showReviews($data->rows->row) %
        </ul>
        <ul id="reviews-pagination" class="pagination">
            % if $data->page > 1 %
            <li><a id="go-1">&larr;</a></li>
            % endif %
            % if $data->page > 1 %
            <li><a id="go-%% $data->page -1  %%">‹</a></li>
            % endif %
            % if $data->page - 2 > 1 %
            <li><a id="go-%% $data->page - 2 %%">%% $data->page - 2 %%</a></li>
            % endif %
            % if $data->page - 1 > 1 %
            <li><a id="go-%% $data->page -1 %%">%% $data->page - 1 %%</a></li>
            % endif %
            <li class="active"><a>%% $data->page  %%</a></li>
            % if $data->page + 1 < $data->pages  %
            <li><a id="go-%% $data->page + 1 %%">%% $data->page + 1 %%</a></li>
            % endif %
            % if $data->page + 2 < $data->pages  %
            <li><a id="go-%% $data->page + 2 %%">%% $data->page + 2 %%</a></li>
            % endif %
            % if intval($data->page) < $data->pages  %
            <li><a id="go-%% $data->page + 1 %%">›</a></li>
            % endif %
            % if intval($data->page) < $data->pages %
            <li><a id="go-%% $data->pages %%">&rarr;</a></li>
            % endif %
        </ul>
    % else %
    <div class="alert alert-warning">Отзывы отсутствуют!</div>
    % endif%
    <div class="alert alert-info">Вы можете оставить свой отзыв после покупки!</div>
</div>