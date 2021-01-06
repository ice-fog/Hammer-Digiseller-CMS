<div class="features-items">
        <h2 class="title text-center">%% $data['title'] %%</h2>

        % if $data['search-result'] %
            <div class="alert alert-success">Найдено %% $data['count'] %% записей по запросу "%% $data['search-string'] %%"</div>
        % elseif $data['search-string'] != null %
            <div class="alert alert-warning">По вашему запросу "%% $data['search-string'] %%" ничего не найдено</div>
        % endif %

        % if $data['content']->retval == 0 %
            % loop $data['content']->rows->row as $t %
                <div id="item-%% $t['id'] %%-%% $t->id_goods %%" class="col-lg-4 col-sm-6 col-xs-12 col-md-6 content-item text-center">
                    % if $t->discount == 'yes' %
                    <div class="ribbon"><span>Скидка</span></div>
                    % endif %
                    <div class="thumbnail">
                        <img src="http://graph.digiseller.ru/img.ashx?maxlength=98&id_d=%% $t->id_goods%%" alt="%% $t->name_goods %%" class="img-preview">
                        <div class="caption">
                            <h3 class="goods-name">%% $t->name_goods %%</h3>
                            <aside>
                                <div class="price animated">
                                    <span class="current-price">%% $t->price %% %% Registry::get('curr-symbol') %%</span>
                                </div>
                                <div class="btn-group">
                                    <span class="btn btn-default bookmark-add"><i class="fa fa-bookmark-o"></i></span>
                                    <a href="/goods/%% $t->id_goods %%" class="btn btn-default">Подробнее</a>
                                    <span class="btn btn-default cart-add"><i class="fa fa-cart-plus"></i></span>
                                </div>
                                <span class="share">
                                    <span class="fa fa-facebook" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой на Фейсбуке"></span>
                                    <span class="fa fa-vk" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой во Вконтакте"></span>
                                    <span class="fa fa-odnoklassniki" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой в Одноклассниках"></span>
                                    <span class="fa fa-google-plus" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой в Гугл-плюсе"></span>
                                </span>
                            </aside>
                        </div>
                    </div>
                </div>
            % endloop %

            % if $data['count'] > $data['limit'] %
                <div class="text-center col-lg-12 col-sm-12 col-xs-12 col-md-12">
                    <ul class="pagination">
                        % if $data['page'] > 1 %
                            <li><a href="%% $data['url'] %%1">&larr;</a></li>
                        % endif %
                        % if $data['page'] > 1 %
                            <li><a href="%% $data['url'].($data['page'] - 1) %%">‹</a></li>
                        % endif %
                        % if $data['page'] - 2 > 1 %
                            <li><a href="%% $data['url'].($data['page'] - 2) %%">%% $data['page'] - 2 %%</a></li>
                        % endif %
                        % if $data['page'] - 1 > 1 %
                            <li><a href="%% $data['url'].($data['page'] - 1) %%">%% $data['page'] - 1 %%</a></li>
                        % endif %
                        <li class="active"><a href="#">%% $data['page'] %%</a></li>
                        % if $data['page'] + 1 < $data['page-count'] %
                            <li><a href="%% $data['url'].($data['page'] + 1) %%">%% $data['page'] + 1 %%</a></li>
                        % endif %
                        % if $data['page'] + 2 < $data['page-count'] %
                            <li><a href="%% $data['url'].($data['page'] + 2) %%">%% $data['page'] + 2 %%</a></li>
                        % endif %
                        % if $data['page'] < $data['page-count'] %
                            <li><a href="%% $data['url'].($data['page'] + 1) %%">›</a></li>
                        % endif %
                        % if $data['page'] < $data['page-count'] %
                            <li><a href="%% $data['url'].($data['page-count']) %%">&rarr;</a></li>
                        % endif %
                    </ul>
                </div>
        % endif %
        % else %
            <div class="alert alert-warning">%% $data['content']->retdesc %%</div>
        % endif %
</div>