<div class="panel panel-default">
    <div class="panel-heading"><strong>Управление страницами</strong></div>
    <div class="panel-body">
        <ul class="nav nav-tabs" style="margin-bottom: 10px;">
            <li><a href="/admin/pages" aria-controls="home">Страницы</a></li>
            <li class="active"><a href="/admin/pages/system">Системные страницы</a></li>
        </ul>
        % if isset($data['data'])%
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="col-md-12">Страница</th>
                <th>Действия</th>
            </tr>
            </thead>
            % loop $data['data'] as $t %
            <tr id="sys-page-%% $t['page'] %%" class="sys-pages-list success">
                <td>%% $t['title'] %%</td>
                <td>
                    <div class="sys-pages-action action-btn pull-right">
                        <div class="sys-page-edit" data-toggle="tooltip" data-placement="top" title="Редактировать"><span class="fa fa-edit"></span></div>
                    </div>
                </td>
            </tr>
            % endloop %
        </table>
        % else %
        <div class="alert alert-danger" role="alert">Ошибка при получении данных</div>
        % endif %
    </div>
</div>