<div class="panel panel-default">
    <div class="panel-heading"><strong>Настройки конфигурации системы</strong></div>
    <div class="panel-body">
        <form id="config-form" action="" method="post">
            <div class="well well-lg">
                <h5>Данные для доступа к MySQL серверу</h5>
                <table class="table table-settings">
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="db-host" class="control-label">Сервер MySQL:</label>
                            <p class="help-block"></p>
                        </td>
                        <td class="col-md-6">
                            <input id="db-host" name="db-host" value="" type="text" placeholder="Пример: localhost" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="db-name" class="control-label">Имя базы данных:</label>
                            <p class="help-block"></p>
                        </td>
                        <td class="col-md-6">
                            <input id="db-name" name="db-name" value="" type="text" placeholder="Пример: db" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="db-user" class="control-label">Имя пользователя:</label>
                            <p class="help-block"></p>
                        </td>
                        <td class="col-md-6">
                            <input id="db-user" name="db-user" value="" type="text" placeholder="Пример: root" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="db-pass" class="control-label">Пароль:</label>
                            <p class="help-block"></p>
                        </td>
                        <td class="col-md-6">
                            <input id="db-pass" name="db-pass" value="" type="password" placeholder="Пример: password" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                        </td>
                        <td class="col-md-6">
                            <input type="button" value="Проверка подключения к mysql" class="btn btn-primary btn-test-connect pull-right"/>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="well well-lg">
                <h5>Основные настройки</h5>
                <table class="table table-settings">
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="site-title" class="control-label">Название сайта:</label>
                            <p class="help-block"></p>
                        </td>
                        <td class="col-md-6">
                            <input id="site-title" name="site-title" value="" type="text" placeholder="Пример: Моментальные покупки" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="site-description" class="control-label">Описание (Description)сайта:</label>
                            <p class="help-block"></p>
                        </td>
                        <td class="col-md-6">
                            <textarea id="site-description" name="site-description" rows="3" placeholder="Пример: Цифровые товары с мгновенной доставкой" class="form-control form-control-settings"></textarea>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="site-login" class="control-label">Логин:</label>
                            <p class="help-block"></p>
                        </td>
                        <td class="col-md-6">
                            <input id="site-login" name="site-login" value="" type="text" placeholder="Пример: admin" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="site-pass" class="control-label">Пароль:</label>
                            <p class="help-block"></p>
                        </td>
                        <td class="col-md-6">
                            <input id="site-pass" name="site-pass" value="" type="password" placeholder="Пример: password" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="site-email" class="control-label">Ваш Email:</label>
                            <p class="help-block"></p>
                        </td>
                        <td class="col-md-6">
                            <input id="site-email" name="site-email" value="" type="text" placeholder="пример: mail@mail.com" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="site-agent-id" class="control-label">Ваш ID агента:</label>
                            <p class="help-block"></p>
                        </td>
                        <td class="col-md-6">
                            <input id="site-agent-id" name="site-agent-id" value="" type="text" placeholder="Ваш ID агента" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="site-xml-id" class="control-label">Ваш XML ID агента:</label>
                            <p class="help-block"></p>
                        </td>
                        <td class="col-md-6">
                            <input id="site-xml-id" name="site-xml-id" value="" type="text" placeholder="Ваш уникальный идентификатор (32 символа)" class="form-control form-control-settings"/>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Продолжить</button>
            </div>
        </form>
    </div>
</div>
