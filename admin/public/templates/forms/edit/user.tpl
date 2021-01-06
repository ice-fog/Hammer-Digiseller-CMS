<div class="row">
    <div class="col-md-12">
        % if $data['data'] %
        <form id="user-form-edit" action="" method="post">
            <table class="table table-settings">
                <tr class="form-group">
                    <td class="col-md-6">
                        <label for="login" class="control-label">Логин</label>
                        <p class="help-block"></p>
                    </td>
                    <td class="col-md-6">
                        <input id="login" name="login" value="%% $data['data']['login'] %%" type="text" class="form-control form-control-settings"/>
                    </td>
                </tr>
                <tr class="form-group">
                    <td class="col-md-6">
                        <label for="old-password" class="control-label">Текущий пароль</label>
                        <p class="help-block"></p>
                    </td>
                    <td class="col-md-6">
                        <input id="old-password" name="old-password" value="" type="password" class="form-control form-control-settings"/>
                    </td>
                </tr>
                <tr class="form-group">
                    <td class="col-md-6">
                        <label for="new-password" class="control-label">Новый пароль</label>
                        <p class="help-block">Заполнение данного поля необходимо только в случае если вы хотите сменить свой текущий пароль.</p>
                    </td>
                    <td class="col-md-6">
                        <input id="new-password" name="new-password" value="" type="password" class="form-control form-control-settings"/>
                    </td>
                </tr>
            </table>
        </form>
        % else %
        <div class="alert alert-danger" role="alert">Ошибка при получении данных</div>
        % endif %
    </div>
</div>