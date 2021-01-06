<div class="panel panel-default">
    <div class="panel-heading"><strong>Настройки скрипта</strong></div>
    <div class="panel-body">
        % if isset($data['data']) %

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#main" aria-controls="main" role="tab" data-toggle="tab">Основные</a></li>
            <li role="presentation"><a href="#catalog" aria-controls="catalog" role="tab" data-toggle="tab">Каталог</a></li>
            <li role="presentation"><a href="#robots" aria-controls="robots" role="tab" data-toggle="tab">Файл robots.txt</a></li>
        </ul>

        <form id="settings-form">

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="main">
                <table class="table table-settings">
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="site-title" class="control-label">Название сайта:</label>
                            <p class="help-block">Например: "Мой Сайт"</p>
                        </td>
                        <td class="col-md-6">
                            <input id="site-title" name="site-title" value="%% $data['data']['site-title'] %%" type="text" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="site-description" class="control-label">Описание (Description) сайта:</label>
                            <p class="help-block">Краткое описание, не более 200 символов</p>
                        </td>
                        <td class="col-md-6">
                            <textarea id="site-description" name="site-description" rows="3" class="form-control form-control-settings">%% $data['data']['site-description'] %%</textarea>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="agent-id" class="control-label">ID агента:</label>
                            <p class="help-block">Ваш ID агента</p>
                        </td>
                        <td class="col-md-6">
                            <input id="agent-id" name="agent-id" value="%% $data['data']['agent-id'] %%" type="text" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="xml-id" class="control-label">XML ID агента:</label>
                            <p class="help-block">Ваш XML ID агента</p>
                        </td>
                        <td class="col-md-6">
                            <input id="xml-id" name="xml-id" value="%% $data['data']['xml-id'] %%" type="text" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="email" class="control-label">E-Mail адрес администратора:</label>
                            <p class="help-block">На этот адрес будут отправляться уведомления.</p>
                        </td>
                        <td class="col-md-6">
                            <input id="email" name="email" value="%% $data['data']['email'] %%" type="email" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="notifications-enable">Отсылать E-mail уведомление</label>
                            <p class="help-block">Разрешить или запретить E-mail уведомления.</p>
                        </td>
                        <td class="col-md-6">
                            <input id="notifications-enable" type="checkbox" name="notifications-enable" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" %% $data['data']['notifications-enable'] ? 'checked' : '' %%>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="rss-enable">Включить RSS экспорт записей</label>
                            <p class="help-block">Разрешить или запретить RSS экспорт.</p>
                        </td>
                        <td class="col-md-6">
                            <input id="rss-enable" type="checkbox" name="rss-enable" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" %% $data['data']['rss-enable'] ? 'checked' : '' %%>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="sitemap-enable">Включить sitemap.xml</label>
                            <p class="help-block">Включение или отключение xml карты сайта.</p>
                        </td>
                        <td class="col-md-6">
                            <input id="sitemap-enable" type="checkbox" name="sitemap-enable" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" %% $data['data']['sitemap-enable'] ? 'checked' : '' %%>
                        </td>
                    </tr>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="catalog">
                <table class="table table-settings">
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="order">Сортировка товаров:</label>
                            <p class="help-block">Варианты сортировки товаров</p>
                        </td>
                        <td class="col-md-6" style="overflow: visible;">
                            <select id="order" name="order" class="form-control selectpicker show-tick">
                                % loop $data['select-order'] as $t %
                                <option value="%% $t['value'] %%" data-icon="%% $t['icon'] %%" %% $data['data']['order'] == $t['value'] ? 'selected ' : '' %%>%% $t['name'] %%</option>
                                % endloop %
                            </select>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="currency">Используемая валюта:</label>
                            <p class="help-block">Валюта по умолчанию.</p>
                        </td>
                        <td class="col-md-6" style="overflow: visible;">
                            <select id="currency" name="currency" class="form-control selectpicker show-tick">
                                % loop $data['select-currency'] as $t %
                                <option value="%% $t['value'] %%" data-icon="%% $t['icon'] %%" %% $data['data']['currency'] == $t['value'] ? 'selected ' : '' %%>%% $t['name'] %%</option>
                                % endloop %
                            </select>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="records-page" class="control-label">Товаров на странице:</label>
                            <p class="help-block">Количество товаров на странице</p>
                        </td>
                        <td class="col-md-6">
                            <input id="records-page" name="records-page" value="%% $data['data']['records-page'] %%" type="number" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="home-seller" class="control-label">ID продавца для главной страницы:</label>
                            <p class="help-block">ID продавца товары которого отображать на главной страницы</p>
                        </td>
                        <td class="col-md-6">
                            <input id="home-seller" name="home-seller" value="%% $data['data']['home-seller'] %%" type="text" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="ad-block-seller" class="control-label">ID продавца для блока рекомендуемые товары:</label>
                            <p class="help-block">ID продавца товары которого отображать в блоке рекомендуемые</p>
                        </td>
                        <td class="col-md-6">
                            <input id="ad-block-seller" name="ad-block-seller" value="%% $data['data']['ad-block-seller'] %%" type="text" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-4">
                            <label for="ad-block-enable">Отображать блок рекомендуемые товары</label>
                            <p class="help-block">Если включено блок рекомендуемые товары отображаются в списках товаров и на страницы оплаты</p>
                        </td>
                        <td class="col-md-8">
                            <input id="ad-block-enable" type="checkbox" name="ad-block-enable" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" %% $data['data']['ad-block-enable'] ? 'checked' : '' %%>
                        </td>
                    </tr>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="robots">
                <table class="table table-settings">
                    <tr class="form-group">
                        <td class="col-md-4">
                            <label for="robots-content" class="robots-content">Файл robots.txt</label>
                            <p class="help-block">Содержимое файла robots.txt</p>
                        </td>
                        <td class="col-md-8">
                            <textarea id="robots-content" name="robots-content" rows="10" class="form-control form-control-settings">%% $data['data']['robots-content'] %%</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-4">
                            <label for="robots-enable">Включить robots.txt</label>
                            <p class="help-block">Включение или отключение robots.txt</p>
                        </td>
                        <td class="col-md-8">
                            <input id="robots-enable" type="checkbox" name="robots-enable" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" %% $data['data']['robots-enable'] ? 'checked' : '' %%>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
        % else %
        <div class="alert alert-danger">Ошибка при получении данных</div>
        % endif %
    </div>
</div>