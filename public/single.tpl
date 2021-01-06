<div class="features-items">
        <div id="item-0-%% $data['content']->id_goods %%" class="content-item">
            <h2 class="title text-center goods-name">%% $data['title'] %%</h2>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 alert images-box">
                % if $data['content']->previews_goods %
                % loop $data['content']->previews_goods->preview_goods as $t %
                    <div class="col-xs-3">
                        <div class="thumbnail">
                            <a href="%% $t->img_real %%" data-lightbox="roadtrip"><img src="%% $t->img_small %%" alt="" class="image-item"></a>
                        </div>
                    </div>
                % endloop %
                % else %
                <div style="position: relative; overflow: hidden;" class="thumbnail">
                    <img src="/public/img/noimage.jpg" alt="">
                </div>
                % endif %
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 content-block">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    % if $data['content']->discount == 'yes' %
                    <div class="alert discount-info">
                        <p>Скидка постоянным покупателям! Если общая сумма ваших покупок у продавца <b>%% $data['content']->name_seller %%</b> больше чем: %% $data['content']->discount_info->procent %% </p>
                        <b>Чтобы узнать размер скидки, укажите свой email:</b>
                        <form action="#" class="discount-form" id="discount-form">
                            <div class="form-group">
                                <div class="input-group ">
                                    <input type="text" name="discount-email" id="discount-email" placeholder="Введите ваш email" class="form-control"/>
                                    <input type="hidden" name="discount-id" value="%% $data['content']->id_goods %%">
                                    <input type="hidden" name="discount-currency" value="%% Registry::get('currency') %%">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                                    </span>
                                </div>
                            </div>
                        </form>
                        <div id="discount-load" class="progress hidden">
                            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>
                        <div class="discount-value"></div>
                    </div>
                    % endif %
                    % if !empty($data['content']->gift->wmr) %
                    <div class="alert gift-info">
                        <span class="gift-icon"></span> За положительный отзыв о купленном товаре продавец предоставит вам подарочную карту на сумму %% $data['content']->gift->wmr %% руб.
                    </div>
                    % endif %
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="well well-sm">
                        % if $data['content']->price_goods->wmz > 0 %
                        <div class="price text-center">
                            <span class="current-price">
                                %% Registry::get('current-curr') == 'WMR' ? $data['content']->price_goods->wmr .' '. Registry::get('curr-symbol'): '' %%
                                %% Registry::get('current-curr') == 'WMZ' ? $data['content']->price_goods->wmz .' '. Registry::get('curr-symbol'): '' %%
                                %% Registry::get('current-curr') == 'WME' ? $data['content']->price_goods->wme .' '. Registry::get('curr-symbol'): '' %%
                                %% Registry::get('current-curr') == 'WMU' ? $data['content']->price_goods->wmu .' '. Registry::get('curr-symbol'): '' %%
                            </span>
                        </div>

                        <form action="//www.oplata.info/asp2/pay.asp" method="POST">
                            <label for="type_curr">Оплатить с помощью:</label>
                            <div class="form-group">
                                <select id="type_curr" name="type_curr" class="form-control selectpicker show-tick" style="overflow: auto;">
                                    % loop $data['currency-list'] as $t %
                                    <option id="%% $t['id'] %%" data-icon="%% $t['icon'] %%" value="%% $t['value'] %%" %% empty($t['value']) ? 'disabled' : '' %% %% Registry::get('current-curr') ==  $t['name'] ? 'selected' : '' %%>%% $t['name'] %%</option>
                                    % endloop %
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-lg btn-success btn-block btn-order" value="Купить"/>
                                <!--<input type="button" class="btn btn-lg btn-primary btn-block cart-add" value="В корзину"/>-->
                                <input type="button" class="btn btn-lg btn-primary btn-block bookmark-add" value="В закладки"/>
                                <input type="hidden" name="id_d" value="%% $data['content']->id_goods %%">
                                <input type="hidden" name="agent" value="%% $data['agent-id'] %%">
                                <input type="hidden" name="fail_page" value="http://%% Registry::get('host') %%/goods/%% $data['content']->id_goods %%">
                            </div>
                        </form>
                        <div class="alert goods-info">
                            <table>
                                <tr>
                                    <td>Продаж:</td>
                                    <td>%% $data['content']->statistics->cnt_sell %%</td>
                                </tr>
                                <tr>
                                    <td>Возвратов:</td>
                                    <td>%% $data['content']->statistics->cnt_return %%</td>
                                </tr>
                                % if !strlen($data['content']->text_info->date_put) > 0 && !strlen($data['content']->file_info->date_put) > 0 %
                                    <tr>
                                        <td>Загружен:</td>
                                        <td>Товар является предзаказом</td>
                                    </tr>
                                % elseif $data['content']->type_goods == 'text' %
                                <tr>
                                    <td>Загружен:</td>
                                    <td>%% $data['content']->text_info->date_put %%</td>
                                </tr>
                                <tr>
                                    <td>Содержимое:</td>
                                    <td>текст (%% $data['content']->text_info->size %% символов)</td>
                                </tr>
                                % elseif $data['content']->type_goods == 'file'%
                                <tr>
                                    <td>Загружен:</td>
                                    <td>%% $data['content']->file_info->date_put %%</td>
                                </tr>
                                <tr>
                                    <td>Содержимое:</td>
                                    <td>%% $data['content']->file_info->name %% (%% fileSizeConvert($data['content']->file_info->size) %%)</td>
                                </tr>
                                % endif %
                                % if $data['content']->prop_goods == 'unique'%
                                <tr>
                                    <td>В наличии:</td>
                                    <td>%% $data['content']->available_goods %% шт.</td>
                                </tr>
                                % endif %
                            </table>
                        </div>
                        <aside class="item-action text-center" style="padding-top: 40px">
                            <span class="share">
                                <span class="fa fa-facebook" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой на Фейсбуке"></span>
                                <span class="fa fa-vk" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой во Вконтакте"></span>
                                <span class="fa fa-odnoklassniki" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой в Одноклассниках"></span>
                                <span class="fa fa-google-plus" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой в Гугл-плюсе"></span>
                            </span>
                        </aside>
                        % else %
                        <p class="alert alert-info">Извините, но этот товар временно закончился <br>Рекомендуем поискать похожий товар у других продавцов</p>
                        % endif %
                    </div>

                    <div class="alert seller-info">
                        <div class="cert-img pull-right">
                            % if strlen($data['seller']->dealer) > 0 %
                            <span class="dealer-icon" data-toggle="tooltip" data-placement="top" title="%% strip_tags($data['seller']->dealer) %%"></span>
                            % endif %
                            % if $data['seller']->attestat == 'yes'%
                            <span class="passport-icon" data-toggle="tooltip" data-placement="top" title="Продавец является аттестованным участником системы WebMoney Transfer"></span>
                            % endif %
                        </div>
                        <span class="seller-img"></span>
                        <div class="seller-info-block">
                            <a href="/seller/%% $data['content']->id_seller %%" class="seller-name">%% $data['content']->name_seller %%</a>
                            <a href="/seller/%% $data['content']->id_seller %%">информация о продавце и его товарах</a>
                        </div>
                        <div class="chat-block">
                            <div class="btn-group">
                                <span class="btn btn-chat %% $data['seller']->messenger %%"><span class="status-icon"></span>%% $data['seller']->messenger %%</span>
                                <span class="btn btn-success btn-chat" id="chat-%% $data['content']->id_seller %%-%% $data['content']->id_goods %%" data-toggle="tooltip" data-placement="top" title="Задать вопрос">Задать вопрос</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h3 class="title-small">Описание товара</h3>
                <article>
                    %% nl2br(strip_tags(html_entity_decode($data['content']->info_goods))) %%
                </article>
                % if !empty($data['content']->add_info_goods) %
                <h3 class="title-small">Дополнительная информация</h3>
                <article>
                    %% nl2br(strip_tags(html_entity_decode($data['content']->add_info_goods))) %%
                </article>
                % endif %
                <h3 class="title-small">Отзывы (%% $data['reviews-count'] %%)</h3>
                <form class="review-show-option" action="">
                    <select id="type-reviews" class="select-reviews-type form-control selectpicker show-tick">
                        <option value="reviews-all"  data-icon="icon-reviews-all">все отзывы (%% $data['reviews-count'] %%)</option>
                        <option value="reviews-good" data-icon="icon-reviews-good">положительные (%% $data['content']->statistics->cnt_goodresponses %%)</option>
                        <option value="reviews-bag" data-icon="icon-reviews-bad">отрицательные (%% $data['content']->statistics->cnt_badresponses %%)</option>
                    </select>
                </form>
                <aside>
                    <div id="reviews-%% $data['content']->id_seller %%-%% $data['content']->id_goods %%" class="reviews-container"></div>
                    <div id="reviews-load" class="progress hidden">
                        <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                    </div>
                </aside>
            </div>

        </div>
</div>
