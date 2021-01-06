<div class="row">
    <div class="col-md-12">

        <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px;">
            <li role="presentation" class="active"><a href="#tab-options" id="nav-options" aria-controls="options" role="tab" data-toggle="tab">Параметры и seo</a></li>
            <li role="presentation" class=""><a href="#tab-content" id="nav-content" aria-controls="content" role="tab" data-toggle="tab">Содержание</a></li>
        </ul>

        <form id="page-form-add" action="" method="post">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab-options">
                    <div class="form-group">
                        <label for="status">Статус</label>
                        <select id="status" name="status" class="form-control selectpicker show-tick">
                            <option value="1" data-icon="glyphicon-eye-open">Активная</option>
                            <option value="0" data-icon="glyphicon-eye-close">Неактивная</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title" class="control-label">Заголовок (Title)</label>
                        <input id="title" name="title" value="" type="text" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="url" class="control-label">Адрес (URL)</label>
                        <input id="url" name="url" value="" type="text" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Описание (Description)</label>
                        <textarea id="description" name="description" rows="2"  class="form-control"></textarea>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="tab-content">
                    <div class="form-group">
                        <label for="content" class="control-label">Содержание</label>
                        <textarea id="content" name="content" rows="10" class="form-control"></textarea>
                        <input type="hidden" name="action" value="add"/>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
