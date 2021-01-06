<div class="panel panel-default">
    <div class="panel-heading"><strong>Проверка важных файлов системы</strong></div>
    <div class="panel-body">
        % if !isset($data['data']) %
        <div class="alert alert-warning">Если любой из этих пунктов выделен красным, то пожалуйста выполните действия для исправления положения.</div>

        <table class="table table-responsive">
            <tr>
                <th>Файл</th>
                <th>Запись</th>
                <th>CHMOD</th>
            </tr>

            % loop $data['files'] as $t %
                <tr class="%% !$t['error'] ? 'success' : 'danger' %%">
                    <td>%% $t['file'] %%</td>
                    <td>%% $t['text'] %%</td>
                    <td>%% $t['chmod'] %%</td>
                </tr>
            % endloop %
        </table>

        % if !$data['not-found-error'] && !$data['chmod-error'] %
            <div class="alert alert-success">Проверка успешно завершена! Можете продолжить установку!</div>
            <div class="input-group-btn">
                <input type="button" value="Продолжить" class="btn btn-success files-btn-next pull-right">
            </div>
        % else %
            % if $data['chmod-error'] %
            <div class="alert alert-danger">
                <strong>Внимание!!!</strong> Во время проверки обнаружены ошибки! Запрещена запись в файл.<br />Вы должны выставить для папок CHMOD 777, для файлов CHMOD 666, используя ФТП-клиент.<br />Установка будет недоступна, пока не будут произведены изменения.
            </div>
            % endif %
            % if $data['not-found-error'] %
            <div class="alert alert-danger">
                <strong>Внимание!!!</strong> Во время проверки обнаружены ошибки! Файлы не найдены!.<br />Загрузить недостающие файлы, используя ФТП-клиент.<br />Установка будет недоступна, пока не будут произведены изменения.
            </div>
            % endif %
        % endif %
        % else %
            <div class="alert alert-danger">Ошибка при получении данных!</div>
        % endif %
        </div>
</div>
