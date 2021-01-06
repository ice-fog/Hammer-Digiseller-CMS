<div class="panel panel-default">
    <div class="panel-heading"><strong>Лицензионное соглашение</strong></div>
    <div class="panel-body">
        % if !isset($data['data']) %
        <form id="license-form" action="" method="post">
            <div class="form-group">
                <textarea class="form-control" rows="40" style="font-size: 12px;">%% $data['license-text'] %%</textarea>
            </div>
            <div class="form-group">
                <label for="license">Я принимаю данное соглашение</label>
                <input id="license" type="checkbox" name="license" value="1">
                <input type="button" value="Продолжить" class="btn btn-success license-btn-next pull-right" disabled/>
            </div>
        </form>
        % else %
        <div class="alert alert-danger">Ошибка при получении данных!</div>
        % endif %
    </div>
</div>