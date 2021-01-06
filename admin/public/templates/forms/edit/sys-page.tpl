<div class="row">
    <div class="col-md-12">
        % if isset($data) %
        <form id="sys-page-form-edit" action="" method="post">
            <div class="form-group">
                <textarea id="content" name="content" rows="20" class="form-control">%% $data['content'] %%</textarea>
                <input type="hidden" name="page" value="%% $data['page'] %%"/>
                <input type="hidden" name="action" value="sys-edit"/>
            </div>
        </form>
        % else %
        <div class="alert alert-danger">Ошибка при получении данных</div>
        % endif %
    </div>
</div>