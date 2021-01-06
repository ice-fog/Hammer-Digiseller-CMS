<div class="panel panel-default">
    <div class="panel-heading"><strong>Обратная связь</strong></div>
    <div class="panel-body">
        % if isset($data['data']) && $data['count'] > 0 %
        <form id="list-feedback-form" method="post">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="">
                        <i class="glyphicon glyphicon-check"></i>
                    </th>
                    <th class="">#</th>
                    <th class="col-md-8">Сообщение</th>
                    <th class="">Автор</th>
                    <th class="col-md-2">E-Mail</th>
                    <th class="">IP-адрес</th>
                    <th class="">Дата</th>
                    <th class="">Действия</th>
                </tr>
                </thead>
                % loop $data['data'] as $t %
                    <tr id="feedback-%% $t['id'] %%" class="feedback-list %% $t['archive'] == 1 ? 'warning' : 'success' %%">
                        <td><input type="checkbox" name="id[]" value="%% $t['id'] %%"/></td>
                        <td>%% $t['id'] %%</td>
                        <td>%% nl2br($t['message']) %%</td>
                        <td>%% $t['name'] %%</td>
                        <td>%% $t['email'] %%</td>
                        <td>%% $t['ip'] %%</td>
                        <td>%% $t['time'] %%</td>
                        <td>
                            <div class="feedback-action action-btn pull-right">
                                % if $t['archive'] == 0 %
                                <div class="feedback-archive" data-toggle="tooltip" data-placement="top" title="Переместить в архив"><i class="fa fa-archive"></i></div>
                                % endif %
                                <div class="feedback-delete" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="fa fa-trash"></i></div>
                            </div>
                        </td>
                    </tr>
                % endloop %
            </table>
            <div class="input-group">
                <span class="input-group-addon">
                    <input type="checkbox" id="selectAll">
                    <input type="hidden" name="action" value="checkbox-handler"/>
                </span>
                <select name="select-action" class="form-control selectpicker show-tick">
                    % if !$data['archive'] %
                    <option value="archive" data-icon="glyphicon-compressed">Архивировать</option>
                    % endif %
                    <option value="delete" data-icon="glyphicon-trash">Удалить</option>
                </select>
                <span class="input-group-btn">
                    <button class="btn btn-default btn-feedback-checkbox" type="button">Применить</button>
                </span>
            </div>
        </form>
        % elseif isset($data['data']) && $data['count'] == 0 %
        <div class="alert alert-warning">Сообщения отсутствуют</div>
        % else %
        <div class="alert alert-danger">Ошибка при получении данных</div>
        % endif %
    </div>
</div>