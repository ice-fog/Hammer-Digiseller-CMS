<div class="panel panel-default">
    <div class="panel-heading"><strong>Управление страницами</strong></div>
    <div class="panel-body">
        <ul class="nav nav-tabs" style="margin-bottom: 10px;">
            <li class="active"><a href="/admin/pages">Страницы</a></li>
            <li><a href="/admin/pages/system">Системные страницы</a></li>
        </ul>
        % if isset($data['data']) && count($data['data']) > 0 %
        <form id="list-pages-form" method="post">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        <i class="glyphicon glyphicon-check"></i>
                    </th>
                    <th class="col-md-8">Заголовок</th>
                    <th class="col-md-4">URL</th>
                    <th class="">Действия</th>
                </tr>
                </thead>
                % loop $data['data'] as $t %
                <tr id="page-%% $t['id'] %%" class="pages-list %% ($t['status'] == 0) ? 'warning' : 'success' %%">
                    <td><input type="checkbox" name="id[]" value="%% $t['id'] %%"/></td>
                    <td>%% $t['title'] %%</td>
                    <td>%% $t['url'] %%</td>
                    <td>
                        <div class="pages-action action-btn pull-right">
                            <div class="page-edit" data-toggle="tooltip" data-placement="top" title="Редактировать"><span class="fa fa-edit"></span></div>
                            % if $t['status'] == 1 %
                            <div class="page-update-status-on" data-toggle="tooltip" data-placement="top" title="Сделать неактивной"><span class="fa fa-toggle-on"></span></div>
                            % else %
                            <div class="page-update-status-off" data-toggle="tooltip" data-placement="top" title="Сделать активной"><span class="fa fa-toggle-off"></span></div>
                            % endif %
                            <div class="page-delete" data-toggle="tooltip" data-placement="top" title="Удалить"><span class="fa fa-trash"></span></div>
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
                    <option value="enable" data-icon="glyphicon-eye-open">Сделать видимыми</option>
                    <option value="disable" data-icon="glyphicon-eye-close">Сделать невидимыми</option>
                    <option value="delete" data-icon="glyphicon-trash">Удалить</option>
                </select>
            <span class="input-group-btn">
                <button class="btn btn-default bnt-pages-checkbox" type="button">Применить</button>
            </span>
            </div>
        </form>
        % elseif isset($data['data']) && count($data['data']) == 0%
        <div class="alert alert-warning" role="alert">Страницы отсутствуют</div>
        % else %
        <div class="alert alert-danger" role="alert">Ошибка при получении данных</div>
        % endif %
    </div>
</div>