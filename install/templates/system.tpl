<div class="panel panel-default">
    <div class="panel-heading"><strong>Минимальные требования скрипта</strong></div>
    <div class="panel-body">
        % if !isset($data['data']) %
        <div class="alert alert-warning">Если любой из этих пунктов выделен красным, то пожалуйста выполните действия для исправления положения. В случае несоблюдения минимальных требований скрипта возможна его некорректная работа в системе.</div>
        <ul class="list-group">
            <li class="list-group-item list-group-item-%% $data['php-5-3'] ? 'success' : 'danger' %%">Версия PHP 5.3 и выше (%% $data['php-version'] %%)</li>
            <li class="list-group-item list-group-item-%% $data['is-mysql'] ? 'success' : 'danger' %%">Поддержка MySQL</li>
            <li class="list-group-item list-group-item-%% $data['is-xml'] ? 'success' : 'danger' %%">Поддержка XML</li>
            <li class="list-group-item list-group-item-%% $data['is-curl'] ? 'success' : 'danger' %%">Поддержка CURL</li>
        </ul>
        <table class="table table-responsive">
            <tr>
                <th>Рекомендуемые настройки</th>
                <th>Рекомендуемое значение</th>
                <th>Текущее значение</th>
            </tr>
            <tr class="%% !$data['output-buffering'] ? 'success' : 'danger' %%">
                <td>Буферизация вывода</td>
                <td>Выключено</td>
                <td>%% !$data['output-buffering'] ? 'Выключено' : 'Включено' %%</td>
            </tr>
            <tr class="%% !$data['magic-quotes-runtime'] ? 'success' : 'danger' %%">
                <td>Magic Quotes Runtime</td>
                <td>Выключено</td>
                <td>%% !$data['magic-quotes-runtime'] ? 'Выключено' : 'Включено' %%</td>
            </tr>
            <tr class="%% !$data['magic-quotes-gpc'] ? 'success' : 'danger' %%">
                <td>Magic Quotes GPC</td>
                <td>Выключено</td>
                <td>%% !$data['magic-quotes-gpc'] ? 'Выключено' : 'Включено' %%</td>
            </tr>
            <tr class="%% !$data['register-globals'] ? 'success' : 'danger' %%">
                <td>Register Globals</td>
                <td>Выключено</td>
                <td>%% !$data['register-globals'] ? 'Выключено' : 'Включено' %%</td>
            </tr>
            <tr class="%% !$data['session-auto-start'] ? 'success' : 'danger' %%">
                <td>Session auto start</td>
                <td>Выключено</td>
                <td>%% !$data['session-auto-start'] ? 'Выключено' : 'Включено' %%</td>
            </tr>
        </table>
        <div class="input-group-btn">
            <input type="button" value="Продолжить" class="btn btn-success system-btn-next pull-right">
        </div>
        % else %
        <div class="alert alert-danger">Ошибка при получении данных!</div>
        % endif %
    </div>
</div>
