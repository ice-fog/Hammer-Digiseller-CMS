<label>
    <select class="select select-order" data-toggle="tooltip" data-placement="left" title="Способ сортировки товаров">
        % loop $data['order'] as $t %
            <option value="%% $t['value']%%" %% $t['value'] == Registry::get('order') ? 'selected' : '' %%>%% $t['name'] %%</option>
        % endloop %
    </select>
</label>
<label>
    <select class="select select-currency" data-toggle="tooltip" data-placement="left" title="Валюта">
        % loop $data['currency'] as $t %
            <option value="%% $t['value']%%" %% $t['value'] == Registry::get('currency') ? 'selected' : '' %%>%% $t['name'] %%</option>
        % endloop %
    </select>
</label>