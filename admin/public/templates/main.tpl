<!DOCTYPE html>
<html lang="ru">
<head>
    <title>{title}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/admin/public/styles/style.min.css"/>
    <link rel="icon" type="image/x-icon" href="/admin/public/images/favicon.ico" >
    <script type="text/javascript" src="/admin/public/scripts/library.min.js"></script>
    <script type="text/javascript" src="/admin/public/scripts/trumbowyg.min.js"></script>
    <script type="text/javascript" src="/admin/public/scripts/codemirror.min.js"></script>
    <script type="text/javascript" src="/admin/public/scripts/application.min.js"></script>
</head>
<body>
<nav class="navbar navbar-fixed-top navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">HAMMER DIGISELLER</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="/admin/statistics"><span class="fa fa-bar-chart-o"></span>Статистика</a></li>
                <li><a href="/admin/pages"><span class="fa fa-newspaper-o"></span>Страницы</a></li>
                <li><a href="/admin/feedback"><span class="fa fa-envelope-o"></span>Обратная связь</a></li>
                <li><a href="/admin/delivery"><span class="fa fa-send-o"></span>Рассылка</a></li>
                <li><a href="/admin/service"><span class="fa fa-flash"></span>Обслуживание</a></li>
                <li><a href="/admin/editor"><span class="fa fa-paint-brush"></span>Редактор</a></li>
                <li><a href="/admin/settings"><span class="fa fa-sliders"></span>Настройки</a></li>
                <li><a href="/admin/logout"><span class="fa fa-sign-out"></span></a></li>
            </ul>
        </div>
    </div>
</nav>
<div id="content-outer" class="container-fluid">
    <div id="content-row" class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 main">
            {content}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 sidebar">
            {sidebar}
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        init();
    });
</script>
</body>
</html>
