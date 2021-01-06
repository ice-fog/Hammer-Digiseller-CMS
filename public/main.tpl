<!DOCTYPE html>
<html lang="ru">
<head>
    <title>{title}</title>
    <meta charset="utf-8">
    <meta name="description" content="{description}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/public/css/style.min.css">
    <link rel="icon" type="image/x-icon" href="/public/img/favicon.ico">
    <link rel="alternate" type="application/rss xml" title="RSS" href="http://{http-host}/rss"/>

    <!--[if lt IE 9]>
    <script src="/public/js/html5shiv.min.js"></script>
    <script src="/public/js/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<div id="wrapper" class="container">
    <header id="header-area" class="home">
        <div class="header-top">
            <div class="row">
                <div class="col-sm-5 col-xs-12">
                    <div class="pull-left">
                        {select}
                    </div>
                </div>
                <div class="col-sm-7 col-xs-12">
                    <div class="social-icons text-center">
                        <ul class="share-site">
                            <li><a><i class="fa fa-facebook" data-toggle="tooltip" data-placement="bottom" title="Facebook"></i></a></li>
                            <li><a><i class="fa fa-odnoklassniki" data-toggle="tooltip" data-placement="bottom" title="Одноклассники"></i></a></li>
                            <li><a><i class="fa fa-vk" data-toggle="tooltip" data-placement="bottom" title="ВКонтакте"></i></a></li>
                            <li><a><i class="fa fa-google-plus" data-toggle="tooltip" data-placement="bottom" title="Google Plus"></i></a></li>
                            <li><a href="/rss"><i class="fa fa-rss"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-header">
            <div class="row">
                <div class="col-sm-4">
                    <div id="logo">
                        <a href="/"><img src="/public/img/logo.png" title="{http-host}" alt="{http-host}" class="img-responsive" /></a>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div id="bookmark" class="btn-group btn-block" data-toggle="tooltip" data-placement="bottom" title="Закладки">
                        <div type="button" data-toggle="dropdown" class="btn btn-block btn-lg bookmark-open">
                            <i class="fa fa-bookmark-o"></i>
                            <span id="bookmark-total" class="bookmark-count"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div id="cart" class="btn-group btn-block" data-toggle="tooltip" data-placement="bottom" title="Корзина">
                        <div type="button" data-toggle="dropdown" class="btn btn-block btn-lg cart-open">
                            <i class="fa fa-shopping-cart"></i>
                            <span id="cart-total" class="cart-count"></span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div id="search">
                        <form action="/search/">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control input-lg" placeholder="Поиск" required="required">
							    <span class="input-group-btn">
								<button class="btn btn-lg" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
							  </span>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <nav id="main-menu" class="navbar" role="navigation">

            <div class="navbar-header">
                <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-cat-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse navbar-cat-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/"><i class="fa fa-home"></i> Главная</a></li>
                    <li><a href="#" class="notepad-open" data-toggle="tooltip" data-placement="bottom" title="Блокнот"><i class="fa fa-sticky-note-o"></i> Блокнот</a></li>
                    <li><a href="http://www.oplata.info/delivery/delivery.asp" data-toggle="tooltip" data-placement="bottom" title="Мои покупки"><i class="fa fa-shopping-cart"></i> Мои покупки</a></li>
                    <li><a href="/feedback"><i class="fa fa-envelope-o" data-toggle="tooltip" data-placement="bottom" title="Связаться"></i> Связаться</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Информация <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            {links}
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    {slider}


    <div id="main-container" class="row" >
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
            {sidebar}
        </div>
        <div class="clearfix visible-sm"></div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
            {content}

            {ad-goods}
        </div>
        <div class="clearfix visible-sm"></div>
    </div>


    <footer id="footer-area">
        <div class="footer-links">
            <div class="row">
                <div class="col-md-2 col-sm-12">
                    <h5>Навигация</h5>
                    <ul>
                        <li><a href="/"><i class="fa fa-angle-right hidden-xs"></i> Главная</a></li>
                        {links}
                    </ul>
                </div>
                <div class="col-md-3 col-sm-12">
                    <h5>Покупателям</h5>
                    <ul>
                        <li><a href="#" class="notepad-open"><i class="fa fa-sticky-note-o hidden-xs"></i> Блокнот</a></li>
                        <li><a href="/http://www.oplata.info/delivery/delivery.asp"><i class="fa fa-shopping-cart hidden-xs"></i> Мои покупки</a></li>
                        <li><a href="/feedback"><i class="fa fa-envelope-o hidden-xs"></i> Связаться</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-12">
                    <h5>Наше преимущества</h5>
                    <ul>
                        <li><i class="fa fa-check hidden-xs"></i> Качественная поддержка</li>
                        <li><i class="fa fa-check hidden-xs"></i> Товар всегда в наличии</li>
                        <li><i class="fa fa-check hidden-xs"></i> Моментальная доставка</li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-12">
                    <h5>Подписаться на обновления</h5>
                    <form action="#" class="subscribe-form" id="subscribe-form" method="post">
                        <div class="form-group">
                            <div class="input-group ">
                                <input type="text" placeholder="Введите ваш email" name="subscribe-email" id="subscribe-email" class="form-control"/>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                                </span>
                            </div>
                        </div>
                        <p>Сообщения будут приходить не чаще одного-двух раз в месяц. В каждом из них будет ссылка на отключение рассылки.</p>
                    </form>
                </div>
            </div>
        </div>

        <div class="copyright clearfix">
            <p class="pull-left">
                Copyright © 2016 {http-host}. All rights reserved.
            </p>
            <ul class="pull-right list-inline"></ul>
        </div>
    </footer>
</div>
<script src="/public/js/library.min.js"></script>
<script src="/public/js/application.min.js"></script>
<script>
    $(document).ready(function () {
        init();
    });
</script>
</body>
</html>
<!-- RT: {runtime} -->