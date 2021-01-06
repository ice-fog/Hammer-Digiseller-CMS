% function showOption($data) %
    % loop $data as $t %
        <a class="list-group-item %% $t['class'] %% %% $t['active'] ? 'active' : '' %%" href="%% $t['url'] %%">%% $t['name'] %% %% isset($t['badge']) ? '<span class="badge badge-small">'.$t['badge'].'</span>' : '' %%</a>
    % endloop %
% endfunction %

<div class="panel panel-primary">
    <div class="panel-heading">
        <strong>%% $data['title'] %%</strong>
    </div>
    <div class="panel-body">
        % if $data['data'] %
            % php showOption($data['data']) %
            <div class="clear"></div>
        % endif %
        % if $data['design-edit'] %
        <div id="editor-file-list"></div>
        % endif %
    </div>
</div>