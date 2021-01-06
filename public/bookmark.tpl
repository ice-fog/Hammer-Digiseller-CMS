<div class="row">
    <div class="col-md-12">
        % if $data['count'] > 0 %
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Название товара </th>
                <th>Цена</th>
                <th><span class="fa fa-trash"></span></th>
            </tr>
            </thead>
            % loop $data['goods'] as $t %
            <tr id="bookmark-item-%% $t['id'] %%" class="bookmark-item">
                <td><a href="/goods/%% $t['id'] %%"><img src="http://graph.digiseller.ru/img.ashx?maxlength=32&id_d=%% $t['id'] %%"> %% $t['name'] %%</a></td>
                <td>%% $t['price'] %%</td>
                <td><span class="fa fa-trash cursor-pointer bookmark-item-delete"></span></td>
            </tr>
            % endloop %
        </table>
        % else %
        <div class="alert alert-warning">У вас нет закладок.</div>
        % endif %
    </div>
</div>
