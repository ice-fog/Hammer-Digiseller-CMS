<h1 style="margin: 0 0 10px 0; font-size: 16px; padding: 0;">%% $data['header'] %%</h1>
% if $data['user-info'] %
<p style="padding: 0;margin: 10px 0;font-size: 12px;">
    Пользователь <strong>%% $data['name'] %%</strong> с почтовым ящиком <strong>%% $data['email'] %%</strong> %% $data['action'] %%
</p>
% endif %
<div style="margin: 0; padding: 10px;">%% $data['message'] %%</div>
<div style="padding: 0; margin: 10px 0; font-size: 12px;">
    <a href="http://%% $data['link']['url']%%">%%$data['link']['name'] %%</a>
</div>
