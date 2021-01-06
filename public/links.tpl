% if count($data) > 0 %
    % loop $data as $t %
        <li><a href="/%% $t['url'] %%"><i class="fa fa-angle-right hidden-xs"></i> %% $t['title'] %%</a></li>
    % endloop %
% endif %