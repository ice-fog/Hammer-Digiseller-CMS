% function showCategory($data, $active) %
    % loop $data as $t %
        <li>
            <a data-toggle="tooltip" data-placement="top" title="%% $t->name_folder %%">
                %% $t->name_folder %% <span class="count">%% $t->cnt_goods%%</span>
            </a>
            % loop $t->section as $s %
            % php $attributes = $s->attributes() %
                <ul>
                    <li class="%% $attributes['id'] == $active ? 'selected' : '' %%">
                        <a href="/category/%% $attributes['id'] %%" data-toggle="tooltip" data-placement="top" title="%% $s->name_section %%">
                            %% $s->name_section %% <span class="count">%% $s->cnt_goods %%</span>
                        </a>
                    </li>
                </ul>
            % endloop %
            % if isset($t->folder) %
                <ul>
                    % php showCategory($t->folder, $active) %
                </ul>
            % endif %
        </li>
    % endloop %
% endfunction %

<div class="category-widget-sidebar">
    <h2 class="title text-center">Категории</h2>
    <div class="category-products">
        % if $data %
        <ul>
            % php showCategory($data['category'], $data['active'])%
        </ul>
        % else %
        <div class="alert alert-warning">Категории отсутствуют</div>
        % endif %
    </div>
</div>

<div class="category-widget-sidebar hidden-xs hidden-sm">
    <h2 class="title text-center">Популярное</h2>
    <div class="adds-goods">
        <a href="/category/21612"><img title="Skype" src="/public/img/skype.png" alt="Skype"></a>
        <a href="/category/21943"><img title="Dota 2" src="/public/img/dota.png" alt="Dota 2"></a>
        <a href="/category/20628"><img title="Playstation Network" src="/public/img/playstation.png" alt="Playstation Network"></a>
        <a href="/category/22599"><img title="Fallout" src="/public/img/fallout.png" alt="Fallout"></a>
        <a href="/category/22752"><img title="Just Cause 3" src="/public/img/justcause.png" alt="Just Cause 3"></a>
        <a href="/category/20322"><img title="Windows" src="/public/img/windows.png" alt="Windows"></a>
        <a href="/category/21709"><img title="Witcher 3" src="/public/img/wither.png" alt="Witcher 3"></a>
    </div>
</div>

<div class="category-widget-sidebar hidden-xs hidden-sm">
    <h2 class="title text-center">Способы оплаты</h2>
    <div class="payment-methods">
        <img src="/public/img/payments.jpg" alt="Способы оплаты" data-toggle="tooltip" data-placement="top" title="Способы оплаты">
    </div>
</div>