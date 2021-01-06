<div class="row">
    <div class="col-md-12">
        % if isset($data['data'])%

        <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px;">
            <li role="presentation" class="active"><a href="#tab-options" id="nav-options" aria-controls="options" role="tab" data-toggle="tab">Параметры и seo</a></li>
            <li role="presentation" class=""><a href="#tab-content" id="nav-content" aria-controls="content" role="tab" data-toggle="tab">Содержание</a></li>
        </ul>

        <form id="page-form-edit" action="" method="post">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab-options">
                    <div class="form-group">
                        <label for="status">Активная</label>
                        <select id="status" name="status" class="form-control selectpicker show-tick">
                            % if $data['data']['status'] == 1%
                            <option selected value="1" data-icon="glyphicon-eye-open">Активная</option>
                            <option value="0" data-icon="glyphicon-eye-close">Неактивная</option>
                            % else %
                            <option selected value="0" data-icon="glyphicon-eye-close">Неактивная</option>
                            <option value="1" data-icon="glyphicon-eye-open">Активная</option>
                            % endif %
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title" class="control-label">Заголовок</label>
                        <input id="title" name="title" value="%% $data['data']['title'] %%" type="text" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="url" class="control-label">Адрес</label>
                        <input id="url" name="url" value="%% $data['data']['url'] %%" type="text" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Описание</label>
                        <textarea id="description" name="description" rows="2" class="form-control">%% $data['data']['description'] %%</textarea>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="tab-content">
                    <div class="form-group">
                        <label for="content" class="control-label">Содержание</label>
                        <textarea id="content" name="content" rows="10" class="form-control">%% $data['data']['content'] %%</textarea>
                        <input id="id" type="hidden" name="id" value="%% $data['data']['id'] %%"/>
                        <input id="action" type="hidden" name="action" value="edit"/>
                    </div>
                </div>
            </div>
        </form>
        % else %
        <div class="alert alert-danger">Ошибка при получении данных</div>
        % endif %
    </div>
</div>