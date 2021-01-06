<?php

error_reporting(0);

define('APP', TRUE);

$start = microtime(true);

include $_SERVER['DOCUMENT_ROOT'] . '/modules/Site.php';

function __autoload($class){
    require $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class . '.php';
}

Registry::set('db-config', '/config/db-config.php');
Registry::set('templates-dir', '/public/');
Registry::set('templates-ext', '.tpl');
Registry::set('cache-dir', '/cache/xml/');


$site = new Site();
$site->sessionStart();
$site->setCookie('visit', 'yes');
$site->registryUpdate();
$site->cookieUpdate();
$route = $site->getRoute();



switch ($route[1]) {
    case '':
        $out = $site->viewHome();
        break;
    case 'captcha':
        getCaptcha();
        break;
    case 'feedback':
        $out = $site->viewFeedback();
        break;
    case 'category':
        $page = is_numeric($route[3]) ? $route[3] : 1;
        $out = $site->viewContent($page, $route[2]);
        break;
    case 'goods':
        $out = $site->viewSingle($route[2], 1);
        break;
    case 'seller':
        $page = is_numeric($route[3]) ? $route[3] : 1;
        $out = $site->sellerInfo($route[2], $page);
        break;
    case 'search':
        $page = is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $out = $site->viewContent($page, null, $_GET['search']);
        break;
    case 'unsubscribe':
        header("refresh: 5; url=/");
        $site->unsubscribe($route[2]);
        break;
    case 'rss':
        if ($site->getSettings()->settings['rss-enable']) {
            header("Content-Type: text/xml; charset=utf-8", true);
            $content = $site->getContent()->sellerGoods(Registry::get('home-seller'), 1, 50, Registry::get('currency'), Registry::get('order'));
            $xml = new DomDocument('1.0', 'utf-8');
            $rss = $xml->appendChild($xml->createElement('rss'));
            $rss->setAttribute('version', '2.0');
            $channel = $rss->appendChild($xml->createElement('channel'));
            $channel->appendChild($xml->createElement("title", $site->getSettings()->settings['site-title']));
            $channel->appendChild($xml->createElement("link", 'http://' . $site->getHTTPHost()));
            $channel->appendChild($xml->createElement("description", $site->getSettings()->settings['site-description']));
            if ($content->retval == 0) {
                foreach ($content->rows->row as $t) {
                    $item = $channel->appendChild($xml->createElement('item'));
                    $item->appendChild($xml->createElement('title', $t->name_goods));
                    $item->appendChild($xml->createElement('link', 'http://' . $site->getHTTPHost() . '/goods/' . $t->id_goods));
                    $description = $item->appendChild($xml->createElement('description'));
                    $description->appendChild($xml->createCDATASection('<img src="http://graph.digiseller.ru/img.ashx?maxlength=98&id_d=' . $t->id_goods . '" alt="' . $t->name_goods . '" title="' . $t->name_goods . '"/>'));
                    $item->appendChild($xml->createElement('pubDate', $t['time']));
                }
            }
            $xml->formatOutput = true;
            echo $xml->saveXML();
        } else {
            $out = $site->viewNotFound();
        }
        break;
    case 'sitemap.xml':
        if ($site->getSettings()->settings['sitemap-enable']) {
            header("Content-Type: text/xml; charset=utf-8", true);;
            $content = $site->getContent()->sellerGoods(Registry::get('home-seller'), 1, 1000, Registry::get('currency'), Registry::get('order'));
            $xml = new DomDocument('1.0', 'utf-8');
            $urlset = $xml->appendChild($xml->createElement('urlset'));
            $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
            if ($content->retval == 00) {
                foreach ($content->rows->row as $t) {
                    $url = $urlset->appendChild($xml->createElement('url'));
                    $url->appendChild($xml->createElement('loc', 'http://' . $site->getHTTPHost() . '/goods/' . $t->id_goods));
                    $url->appendChild($xml->createElement('changefreq', 'daily'));
                    $url->appendChild($xml->createElement('priority', 0.5));
                }
            }
            $xml->formatOutput = true;
            echo $xml->saveXML();
        } else {
            $out = $site->viewNotFound();
        }
        break;
    case 'robots.txt':
        if ($site->getSettings()->settings['robots-enable']) {
            header("Content-Type:text/plain");
            echo $site->getSettings()->settings['robots-content'];
        } else {
            $out = $site->viewNotFound();
        }
        break;
    case 'ajax':
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch ($_POST['action']) {
                case 'add-delivery-email':
                    if (is_string($_POST['subscribe-email'])) {
                        if ($site->getEmailDelivery()->checkEmail($_POST['subscribe-email'])) {
                            echo 'already signed';
                        } else {
                            if ($site->getEmailDelivery()->add($_POST['subscribe-email'])) {
                                echo 'ok';
                            }
                        }
                    }
                    break;
                case 'send-feedback':
                    if (md5($_POST['captcha']) != $_SESSION['captcha']) {
                        echo 'wrong captcha';
                    } else {
                        if (isset($_POST['name'], $_POST['email'], $_POST['message'])) {
                            if ($site->addFeedback($_POST['name'], $_POST['email'], $_POST['message'])) {
                                echo 'ok';
                            }
                        }
                    }
                    break;
                case 'save-notepad':
                    if (isset($_POST['content'])) {
                        if ($site->setCookie('notepad', $_POST['content'], time() + 2592000)) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'get-site-description':
                    echo $site->getSettings()->settings['site-description'];
                    break;
                case 'get-discount-value':
                    if(is_numeric($_POST['discount-id']) && is_string($_POST['discount-email']) && is_string($_POST['discount-currency'])){
                        $temp =  $site->getContent()->discount($_POST['discount-id'], $_POST['discount-email'], $_POST['discount-currency']);

                        echo json_encode(array(
                            'retval' => (int) $temp->retval,
                            'id' => (int) $temp->id_goods,
                            'email' => (string) $temp->email,
                            'currency' => (string) $temp->currency,
                            'price' => (int) $temp->discount->price,
                            'percent' => (int) $temp->discount->percent,
                            'amount' => (int)$temp->discount->amount
                        ));
                    }
                    break;
                case 'get-notepad':
                    echo $site->getTemplate()->compileBloc('notepad', $site->getCookie('notepad'));
                    break;
                case 'get-reviews':
                    if (isset($_POST['seller'], $_POST['goods'], $_POST['type'], $_POST['page'])) {
                        $type = $_POST['type'];
                        switch($type){
                            case 'reviews-all':
                                $type = '';
                                break;
                            case 'reviews-good':
                                $type = 'good';
                                break;
                            case 'reviews-bag':
                                $type = 'bad';
                                break;
                            default:
                                $type = '';
                        }
                        $reviews = $site->getContent()->responses($_POST['seller'], $_POST['goods'], $type, $_POST['page'], 10);
                        if ($reviews->retval == 0) {
                            echo $site->getTemplate()->compileBloc('reviews', $reviews);
                        } else {
                            echo 'Ошибка получение отзывов!';
                        }
                    }
                    break;
                case 'add-cart':
                    if (isset($_POST['id'], $_POST['name'], $_POST['price'])) {
                        $inCart = in_array($_POST['id'], arrayColumn($site->parseCookieData(Registry::get('cart')), 'id'), false);
                        if ($inCart) {
                            echo 'in-cart';
                        } else {
                            $site->cookieAddItem('cart', 0, $_POST['id'], $_POST['name'], $_POST['price']);
                            echo 'ok';
                        }
                    }
                    break;
                case 'delete-cart':
                    if (is_numeric($_POST['id'])) {
                        $site->cookieDeleteItem($_POST['id'], 'cart');
                        echo $site->getCart();
                    }
                    break;
                case 'delete-bookmark':
                    if (is_numeric($_POST['id'])) {
                        $site->cookieDeleteItem($_POST['id'], 'bookmark');
                        echo $site->getBookmark();
                    }
                    break;
                case 'add-bookmark':
                    if (isset($_POST['id'], $_POST['name'], $_POST['price'])) {
                        $inBookmarks = in_array($_POST['id'], arrayColumn($site->parseCookieData(Registry::get('bookmark')), 'id'));
                        if ($inBookmarks) {
                            echo 'in-bookmarks';
                        } else {
                            $site->cookieAddItem('bookmark', time() + 2592000, $_POST['id'], $_POST['name'], $_POST['price']);
                            echo 'ok';
                        }
                    }
                    break;
                case 'get-count':
                    echo json_encode(array(
                        'cart' => $site->getCookieCount($site->getCookie('cart')),
                        'bookmark' => $site->getCookieCount($site->getCookie('bookmark'))
                    ));
                    break;
                case 'get-cart':
                    echo $site->getCart();
                    break;
                case 'get-bookmark':
                    echo $site->getBookmark();
                    break;
                case 'set-currency':
                    if (in_array($_POST['currency'], array('USD', 'RUR', 'EUR', 'UAH'))) {
                        if ($site->setCookie('currency', $_POST['currency'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'set-order':
                    if (in_array($_POST['order'], array('price', 'priceDESC', 'ratingDESC', 'cntSellDESC', 'name', 'nameDESC'))) {
                        if ($site->setCookie('order', $_POST['order'])) {
                            echo 'ok';
                        }
                    }
                    break;
            }
        }
        break;
    default:
        $out = $site->viewPage($route[1]);
}

if (is_array($out)) {
    $site->getTemplate()->main('main');
    $site->getTemplate()->set('{title}', $out['title']);
    $site->getTemplate()->set('{runtime}', $time = microtime(true) - $start);
    $site->getTemplate()->set('{http-host}', $site->getHTTPHost());
    $site->getTemplate()->set('{description}', $out['description']);
    $site->getTemplate()->set('{site-title}', $site->getSettings()->settings['site-title']);
    $site->getTemplate()->set('{site-description}', $site->getSettings()->settings['site-description']);
    $site->getTemplate()->set('{ad-goods}', $site->getADGoodsHTML());
    $site->getTemplate()->bloc('{slider}', $out['slider'] ? 'slider' : '', $site->getSettings()->settings);
    $site->getTemplate()->bloc('{select}', 'select', $site->getSortArray());
    $site->getTemplate()->bloc('{sidebar}', 'sidebar', $out['side']);
    $site->getTemplate()->bloc('{content}', $out['template'], $out['data']);
    $site->getTemplate()->bloc('{links}', 'links', $site->getPagesLinks());
    $site->getTemplate()->out();
}

$site->updateStat();