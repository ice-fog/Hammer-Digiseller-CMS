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
            <tr id="cart-item-%% $t['id'] %%" class="cart-item">
                <td><a href="/goods/%% $t['id'] %%"><img src="http://graph.digiseller.ru/img.ashx?maxlength=32&id_d=%% $t['id'] %%"> %% $t['name'] %%</a></td>
                <td>%% $t['price'] %%</td>
                <td><span class="fa fa-trash cursor-pointer cart-item-delete"></span></td>
            </tr>
            % endloop %
        </table>
        <form id="cart-form" action="https://www.oplata.info/asp2/pay.asp" method="post">
            <div class="form-group">
                <input name="TypeCurr" value="%% $data['currency'] %%" type="hidden">
                <input name="Cart_UID" value="%% $data['cart-id'] %%" type="hidden">
                <input name="Agent" value="%% $data['agent-id'] %%" type="hidden">
                <input name="Lang" value="ru-RU" type="hidden">
                <input name="FailPage" value="%% $data['fail-page'] %%" type="hidden">
            </div>
        </form>
        % else %
        <div class="alert alert-warning">Ваша корзина пуста.</div>
        % endif %
    </div>
</div>
