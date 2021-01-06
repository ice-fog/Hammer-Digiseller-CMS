<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h2 class="title text-center">%% $data['title'] %%</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <td>
                        <table class="table table-striped">
                            <tr>
                                <td>Зарегистрирован:</td>
                                <td><small>%% $data['seller']->date_registration %%</small></td>
                            </tr>
                            <tr>
                                <td>ФИО:</td>
                                <td><small>%% (strlen($data['seller']->fio) > 0) ? $data['seller']->fio : 'Скрыто' %%</small></td>
                            </tr>
                            <tr>
                                <td>Страна проживания:</td>
                                <td><small>%% (strlen($data['seller']->address) > 0) ? $data['seller']->address : 'не указано' %%</small></td>
                            </tr>
                            <tr>
                                <td>Контактный телефон:</td>
                                <td><small>%% (strlen($data['seller']->phone) > 0) ? $data['seller']->phone : 'не указано' %%</small></td>
                            </tr>
                            <tr>
                                <td>Сайт:</td>
                                <td><small>%% (strlen($data['seller']->url) > 0) ? $data['seller']->url : 'не указано' %%</small></td>
                            </tr>
                            <tr>
                                <td>ICQ:</td>
                                <td><small>%% (strlen($data['seller']->icq) > 0) ? $data['seller']->icq : 'не указано' %%</small></td>
                            </tr>
                            <tr>
                                <td>WM-идентификатор:</td>
                                <td><small>%% (strlen($data['seller']->wmid) > 0) ? '<a rel="nofollow" href="https://passport.webmoney.ru/asp/certView.asp?wmid='.$data['seller']->wmid.'" target="_blank">'.$data['seller']->wmid.'</a>' : 'не указано' %%</small></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <div class="thumbnail">
                            <img src="/public/img/user.jpg" alt="" class="img-responsive">
                        </div>
                        <div class="cert-img pull-left">
                            % if strlen($data['seller']->dealer) > 0 %
                            <span class="dealer-icon" data-toggle="tooltip" data-placement="top" title="%% strip_tags($data['seller']->dealer) %%"></span>
                            % endif %
                            % if $data['seller']->attestat == 'yes'%
                            <span class="passport-icon" data-toggle="tooltip" data-placement="top" title="Продавец является аттестованным участником системы WebMoney Transfer"></span>
                            % endif %
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>Требования продавца к покупателям при оплате товара в кредит: </td>
                    <td>
                    % php $isCredit = false %
                    % if $data['seller']->client_credit->id_attestat == 120 %
                        % php $isCredit = true %
                        <small>обязательно наличие начального аттестата</small><br>
                    % elseif $data['seller']->client_credit->id_attestat == 130 %
                        % php $isCredit = true %
                        <small>обязательно наличие персонального аттестата</small><br>
                    % elseif $data['seller']->client_credit->id_attestat == 170 %
                        % php $isCredit = true %
                        <small>обязательно наличие аттестата статуса гарант</small><br>
                    % endif %
                    % if $data['seller']->client_credit->not_credit == 'yes' %
                        % php $isCredit = true %
                        <small>отсутствие непогашенных кредитов</small><br>
                    % endif %
                        % if isCredit %
                        <small>Кредит не предоставляется</small>
                        % endif%
                    </td>
                </tr>

                <tr>
                    <td>Статистика продавца:</td>
                    <td>
                        <small>Рейтинг продавца: <b>%% $data['seller']->statistics->rating %%</b></small><br>
                        <small>Количество товаров: <b>%% $data['seller']->statistics->cnt_goods %%</b></small><br>
                        <small>Количество продаж: <b>%% $data['seller']->statistics->cnt_sell %%</b></small><br>
                        <small>Количество возвратов: <b>%% $data['seller']->statistics->cnt_return %%</b></small><br>
                        <small>Количество положительных отзывов: <b>%% $data['seller']->statistics->cnt_good_responses %%</b></small><br>
                        <small>Количество отрицательных отзывов: <b>%% $data['seller']->statistics->cnt_bad_responses %%</b></small><br>
                    </td>
                </tr>
            </table>
        </div>
</div>

<div class="features-items col-lg-12 col-sm-12 col-xs-12 col-md-12">
    <h2 class="title text-center">%% $data['content-title'] %%</h2>
    <div class="row">
        % if $data['content']->retval == 0 %

        % loop $data['content'] as $t %
        <div id="item-%% $t['id'] %%-%% $t->id_goods %%" class="col-lg-4 col-sm-6 col-xs-12 col-md-6 content-item text-center">
            % if $t->discount == 'yes' %
            <div class="ribbon"><span>Скидка</span></div>
            % endif %
            <div class="thumbnail">
                <img src="http://graph.digiseller.ru/img.ashx?maxlength=98&id_d=%% $t->id_goods%%" alt="%% $t->name_goods %%" class="img-preview">
                <div class="caption">
                    <h3>%% $t->name_goods %%</h3>
                    <aside>
                        <div class="price animated">
                            <span class="current-price">%% $t->price %% %% Registry::get('curr-symbol') %%</span>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-default bookmark-add"><i class="fa fa-bookmark-o"></i></div>
                            <a href="/goods/%% $t->id_goods %%" class="btn btn-default">Подробнее</a>
                            <div class="btn btn-default cart-add"><i class="fa fa-cart-plus"></i></div>
                        </div>
                        <span class="share" style="padding-top: 15px;">
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
</div>