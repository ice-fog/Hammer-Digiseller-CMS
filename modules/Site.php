<?php

/**
 * Класс Site
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Site extends Core {

    /**
     * @return array
     */
    public function viewHome() {
        return array(
            'template' => 'content',
            'title' => $this->getSettings()->settings['site-title'],
            'description' => $this->getSettings()->settings['site-description'],
            'data' => array(
                'title' => 'Рекомендуемые товары',
                'content' => $this->getContent()->sellerGoods(Registry::get('home-seller'), 1, Registry::get('records-page'), Registry::get('currency'), Registry::get('order'))
            ),
            'side' => array(
                'category' => $this->getContent()->section(519),
                'active' => 0
            ),
            'slider' => 1
        );
    }

    /**
     * @param int $page
     * @param string $category
     * @param string $searchString
     * @return array
     */
    public function viewContent($page, $category = null, $searchString = null) {
        if(isset($searchString)) {
            $title = 'Результаты поиска';
            $description = 'Результаты поиска по запросу '.$searchString.'';
            $data = $this->getContent()->searchGoods($searchString, 'any', 1000, 1, 1000, Registry::get('currency'));
            $count = $data->cnt_goods;
            $start = $page * $this->getSettings()->settings['records-page'] - $this->getSettings()->settings['records-page'] + 1;
            $end = $start + $this->getSettings()->settings['records-page'] - 1;
            $dom = new DOMDocument();
            $temp = dom_import_simplexml($data);
            $temp = $dom->importNode($temp, true);
            $dom->appendChild($temp);
            $xpath = new DOMXpath($dom);
            $elements = $xpath->query('//row');

            foreach($elements as $t){
                $attr = $t->getAttribute('id');
                if(($attr < $start) || ($attr > $end)){
                    $t->parentNode->removeChild($t);
                }
            }

            $data = simplexml_import_dom($dom);

            if($count > 0) {
                $searchResult = TRUE;
                $url = '/search/?search=' . $searchString . '&page=';
            } else {
                $searchResult = FALSE;
            }

        } else {
            if(is_numeric($category)) {
                $data = $this->getContent()->goods($category, $page, Registry::get('records-page'), Registry::get('currency'), Registry::get('order'));
                $title = $data->name_section;
                $description = str_replace(array("\r", "\n"), '', $data->name_section);
                $count = $data->cnt_goods;
                $url = '/category/' . $category . '/';
            } else {
                return $this->viewNotFound();
            }
        }

        $pageCount = $count > 0 ? (intval(($count - 1) / $this->getSettings()->settings['records-page']) + 1) : 0;

        return array(
            'template' => 'content',
            'title' => $title,
            'description' => $description,
            'data' => array(
                'title' => $title,
                'content' => $data,
                'count' => $count,
                'limit' => $this->getSettings()->settings['records-page'],
                'search-string' => $searchString,
                'search-result' => $searchResult,
                'page-count' => $pageCount,
                'page' => $page,
                'url' => $url,
            ),
            'side' => array(
                'category' =>  $this->getContent()->section(519),
                'active' => $category,
            ),
            'slider' => 0
        );
    }

    /**
     * @param int $id - id
     * @param int $reviewPage - review page
     * @return array
     */
    public function viewSingle($id, $reviewPage) {

        $strSearch  = array(
            '&amp;lt;attention&amp;gt;',
            '&amp;lt;delivery&amp;gt;',
            '&amp;lt;/attention&amp;gt;',
            '&amp;lt;/delivery&amp;gt;'
        );

        $strReplace = array(
            '',
            '',
            '',
            ''
        );

        $pregPatterns = array(
            '!plati.ru/asp/seller.asp[?]id_s=(.*?)!',
            '!plati.ru/asp/pay.asp[?]id_d=(.*?)!',
            '!plati.ru/asp/pay.asp[?]idd=(.*?)!',
            '!plati.ru/asp/pay.asp[?]idd=(.*?)!',
            '!plati.com/itm/(.*?)!',
        );

        $pregReplace = array(
            $this->getHTTPHost().'/seller/\\1',
            $this->getHTTPHost().'/goods/\\1',
            $this->getHTTPHost().'/goods/\\1',
            $this->getHTTPHost().'/goods/\\1',
            $this->getHTTPHost().'/goods/\\1',
        );

        $data = $this->getContent()->goodsInfo($id, $pregPatterns, $pregReplace, $strSearch, $strReplace);

        if($data->retval != 0){
            return $this->viewNotFound();
        }

        $title = $data->name_goods;
        $reviewCount = $data->statistics->cnt_goodresponses + $data->statistics->cnt_badresponses;
        $reviewPageCount = $reviewCount > 0 ? (intval(($reviewCount - 1) / 10) + 1) : 0;

        $url = '/goods/' . $id. '/';

        $currencyList = array(
            0 => array(
                'id' => 'c-руб',
                'icon' => 'icon-wm',
                'value' => $data->price_goods->wmr,
                'name' => 'WMR'
            ),
            1 => array(
                'id' => 'c-$',
                'icon' => 'icon-wm',
                'value' => $data->price_goods->wmz,
                'name' => 'WMZ'
            ),
            2 => array(
                'id' => 'c-€',
                'icon' => 'icon-wm',
                'value' => $data->price_goods->wme,
                'name' => 'WME'
            ),
            3 => array(
                'id' => 'c-грн',
                'icon' => 'icon-wm',
                'value' => $data->price_goods->wmu,
                'name' => 'WMU'
            ),
            4 => array(
                'id' => 'c-руб',
                'icon' => 'icon-pyu',
                'value' => $data->price_goods->pyu,
                'name' => 'Банковской картой в руб'
            ),
            5 => array(
                'id' => 'c-$',
                'icon' => 'icon-pyu',
                'value' => $data->price_goods->py1,
                'name' => 'Банковской картой в $'
            ),
            6 => array(
                'id' => 'c-€',
                'icon' => 'icon-pyu',
                'value' => $data->price_goods->py2,
                'name' => 'Банковской картой в €'
            ),
            7 => array(
                'id' => 'c-руб',
                'icon' => 'icon-qsp',
                'value' => $data->price_goods->qsp,
                'name' => 'QIWI в руб'
            ),
            8 => array(
                'id' => 'c-руб',
                'icon' => 'icon-prc',
                'value' => $data->price_goods->pcr,
                'name' => 'Яндекс.Деньги руб'
            ),
            9 => array(
                'id' => 'c-руб',
                'icon' => 'icon-mts',
                'value' => $data->price_goods->mts,
                'name' => 'МТС руб'
            ),
            10 => array(
                'id' => 'c-руб',
                'icon' => 'icon-bln',
                'value' => $data->price_goods->bln,
                'name' => 'Билайн руб'
            ),
            11 => array(
                'id' => 'c-руб',
                'icon' => 'icon-mgf',
                'value' => $data->price_goods->mgf,
                'name' => 'Мегафон руб'
            ),
            12 => array(
                'id' => 'c-руб',
                'icon' => 'icon-tl2',
                'value' => $data->price_goods->tl2,
                'name' => 'TELE2 руб'
            ),
        );

        return array(
            'template' => 'single',
            'title' => $title,
            'description' => str_replace(array("\r", "\n"), '', mb_substr($data->info_goods, 0, 160, "UTF-8")),
            'data' => array(
                'agent-id' => $this->getSettings()->settings['agent-id'],
                'currency' => $this->getSettings()->settings['currency'],
                'title' => $title,
                'content' => $data,
                'seller' => $this->getContent()->sellerInfo($data->id_seller),
                'reviews-count' => $data->statistics->cnt_goodresponses + $data->statistics->cnt_badresponses,
                'currency-list' => $currencyList,
                'limit' => $this->getSettings()->settings['records-page'],
                'page-count' => $reviewPageCount,
                'page' => $reviewPage,
                'url' => $url,
            ),
            'side' => array(
                'category' =>  $this->getContent()->section(519),
                'active' => intval($data->id_section),
            ),
            'slider' => 0
        );
    }

    public function getADGoodsHTML(){
        if($this->getSettings()->settings['ad-block-enable'] && $this->getRoute(1) != null){
            $goods = $this->getContent()->sellerGoods($this->getSettings()->settings['ad-block-seller'], 1, 9, Registry::get('currency'), Registry::get('order'));
            $data = array();
            $iterator = 0;
            foreach($goods->rows->row as $t){
                switch($iterator){
                    case 0:
                        $data[0][] = $t;
                        break;
                    case 1:
                        $data[0][] = $t;
                        break;
                    case 2:
                        $data[0][] = $t;
                        break;
                    case 3:
                        $data[1][] = $t;
                        break;
                    case 4:
                        $data[1][] = $t;
                        break;
                    case 5:
                        $data[1][] = $t;
                        break;
                    case 6:
                        $data[2][] = $t;
                        break;
                    case 7:
                        $data[2][] = $t;
                        break;
                    case 8:
                        $data[2][] = $t;
                        break;
                }
                $iterator++;
            }

            return $this->getTemplate()->compileBloc('ad-goods', $data);
        }else{
            return '';
        }
    }

    public function sellerInfo($id, $page){

        $seller = $this->getContent()->sellerInfo($id);

        if($seller->responce != 0){
            return $this->viewNotFound();
        }

        $content = $this->getContent()->sellerGoods($seller->id_seller, $page, $this->getSettings()->settings['records-page'], Registry::get('currency'), 'price');

        $title = 'Информация о продавце '.$seller->name_seller;
        $pageCount = $seller->statistics->cnt_goods > 0 ? (intval(($seller->statistics->cnt_goods - 1) / $this->getSettings()->settings['records-page']) + 1) : 0;
        return array(
            'template' => 'seller',
            'title' => $title,
            'description' => mb_substr($seller->info_goods, 0, 160, "UTF-8"),
            'data' => array(
                'title' => $title,
                'count' => $seller->statistics->cnt_goods,
                'seller' => $seller,
                'content' => $content->rows->row,
                'content-title' => 'Все товары продавца '.$seller->name_seller,
                'limit' => $this->getSettings()->settings['records-page'],
                'page-count' => $pageCount,
                'page' => $page,
                'url' => '/seller/'.$seller->id_seller.'/',
            ),
            'side' => array(
                'category' =>  $this->getContent()->section(519),
            ),
            'slider' => 0
        );
    }

    /**
     * @return array
     */
    public function viewFeedback() {
        return array(
            'template' => 'feedback',
            'title' => 'Обратная связь',
            'description' => 'Страница обратной связи с администрацией',
            'data' => array(
                'header' => 'Обратная связь'
            ),
            'side' => array(
                'category' =>  $this->getContent()->section(519)
            ),
            'slider' => 0
        );
    }

    /**
     * @param $url
     * @return array
     */
    public function viewPage($url) {
        $page = $this->getPages()->getOnePageByUrl($url);
        if(is_array($page)) {
            return array(
                'template' => 'page',
                'title' => $page['title'],
                'description' => $page['description'],
                'data' => array(
                    'title' => $page['title'],
                    'content' => $page['content']
                ),
                'side' => array(
                    'category' =>  $this->getContent()->section(519)
                ),
                'slider' => 0
            );
        } else {
            return $this->viewNotFound();
        }
    }

    /**
     * @return array
     */
    public function viewNotFound() {
        header("HTTP/1.0 404 Not Found");
        return array(
            'template' => 'page',
            'title' => 'Страница не найдена',
            'data' => array(
                'content' => $this->getSysPages()->getNotFoundPage()
            ),
            'side' => array(
                'category' =>  $this->getContent()->section(519),
            ),
            'slider' => 0
        );
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $message
     * @return bool
     */
    public function addFeedback($name, $email, $message) {
        if($this->getFeedback()->add($name, $email, $message, $_SERVER['REMOTE_ADDR'])) {
            if($this->getSettings()->settings['notifications-enable']) {
                $this->getNotify()->newFeedback($name, $email, $message);
            }
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getPagesLinks() {
        return $this->getPages()->getPublicLinks();
    }

    /**
     * @param string $base64Email
     * @return array
     */
    public  function unsubscribe($base64Email){
        $email = base64_decode($base64Email);
        if($this->getEmailDelivery()->checkEmail($email)){
            $this->getEmailDelivery()->deleteByEmail($email);
            echo 'Вы отписались от рассылки!';
        } else {
            echo 'Произошла ошибка!';
        }
    }

    /**
     * @param string $data
     * @return array
     */
    public function parseCookieData($data){
        $result = array();
        $iterator = 0;
        $temp = explode('ￗ', $data);
        array_pop($temp);
        foreach($temp as $t){
            $item = explode('×', $t);
            $result[$iterator]['id'] = $item[0];
            $result[$iterator]['name'] = $item[1];
            $result[$iterator]['price'] = $item[2];
            $iterator++;
        }
        return $result;
    }

    /**
     * @param string $cookie
     * @param int $time
     * @param int $id
     * @param string
     * @param string
     * @return bool
     */
    public function cookieAddItem($cookie, $time, $id, $name, $price){
        if(strlen($this->getCookie($cookie)) < 1){
            $this->setCookie($cookie, $id.'×'.$name.'×'.$price.'ￗ', $time);
            Registry::set($cookie, $id.'×'.$name.'×'.$price.'ￗ', $time);
        }else{
            $data = $this->getCookie($cookie);
            $this->setCookie($cookie, $data.$id.'×'.$name.'×'.$price.'ￗ', $time);
            Registry::set($cookie, $data.$id.'×'.$name.'×'.$price.'ￗ', $time);
        }
    }

    /**
     * @param int $id
     * @param string $cookie
     * @return string
     */
    public function cookieDeleteItem($id, $cookie){
        $result = '';
        $data = $this->getCookie($cookie);
        $array = $this->parseCookieData($data);
        $iterator = 0;
        foreach($array as $t){
            if($t['id'] == $id){
                unset($array[$iterator]);
                break;
            }
            $iterator++;
        }
        foreach($array as $t){
            $result.=$t['id'].'×'.$t['name'].'×'.$t['price'].'ￗ';
        }
        $this->setCookie($cookie, $result);
        Registry::set($cookie, $result);
    }

    /**
     * @return string
     */
    public function getCart(){
        $cart = Registry::get('cart');
        if(strlen($cart) < 1){
            $data = null;
        }else{
            $data['count'] = $this->getCookieCount($cart);
            $data['goods'] = $this->parseCookieData($cart);
            $data['currency'] = Registry::get('currency');
            $data['cart-id'] = Registry::get('cart-id');
            $data['agent-id'] = Registry::get('agent-id');
            $data['fail-page'] = 'http://'.$this->getHTTPHost();
        }
        return $this->getTemplate()->compileBloc('cart', $data);
    }

    /**
     * @return string
     */
    public function getBookmark(){
        $bookmark = Registry::get('bookmark');
        if(strlen($bookmark) < 1){
            $data = null;
        }else{
            $data['count'] = $this->getCookieCount($bookmark);
            $data['goods'] = $this->parseCookieData($bookmark);
            $data['currency'] = Registry::get('currency');
        }
        return $this->getTemplate()->compileBloc('bookmark', $data);
    }

    /**
     *
     */
    public function registryUpdate(){
        $order = $this->getCookie('order');
        $currency = $this->getCookie('currency');
        if(in_array($order, array('price', 'priceDESC', 'ratingDESC', 'cntSellDESC', 'name', 'nameDESC'))){
            Registry::set('order', $order);
        }else{
            Registry::set('order', $this->getSettings()->settings['order']);
        }
        if(in_array($currency, array('USD', 'RUR', 'EUR', 'UAH'))){
            Registry::set('currency', $currency);
        }else{
            Registry::set('currency', $this->getSettings()->settings['currency']);
        }
        $currencySymbol = array(
            'USD' => '$',
            'RUR' => 'руб',
            'EUR' => '€',
            'UAH' => 'грн'
        );

        $currentCurrency = array(
            'USD' => 'WMZ',
            'RUR' => 'WMR',
            'EUR' => 'WME',
            'UAH' => 'WMU'
        );

        Registry::set('cart', $this->getCookie('cart'));
        Registry::set('bookmark', $this->getCookie('bookmark'));
        Registry::set('curr-symbol', $currencySymbol[Registry::get('currency')]);
        Registry::set('current-curr', $currentCurrency[Registry::get('currency')]);
        Registry::set('records-page', $this->getSettings()->settings['records-page']);
        Registry::set('ad-block-seller', $this->getSettings()->settings['ad-block-seller']);
        Registry::set('home-seller', $this->getSettings()->settings['home-seller']);
        Registry::set('agent-id', $this->getSettings()->settings['agent-id']);
        Registry::set('xml-id', $this->getSettings()->settings['xml-id']);
        Registry::set('cart-id', $this->getCookie('cart-id'));
    }

    public function cookieUpdate(){
        $this->setCookie('agent-id', $this->getSettings()->settings['agent-id']);
    }

    /**
     * @return array
     */
    public function getSortArray(){
        $data = array(
            'order' => array(
                0 => array(
                    'name' => '▲ цена',
                    'value' => 'price'
                ),
                1 => array(
                    'name' => '▼ цена',
                    'value' => 'priceDESC'
                ),
                2 => array(
                    'name' => '▲ название',
                    'value' => 'name'
                ),
                3 => array(
                    'name' => '▼ название',
                    'value' => 'nameDESC'
                ),
            ),
            'currency' => array(
                0 => array(
                    'name' => 'Доллары',
                    'value' => 'USD'
                ),
                1 => array(
                    'name' => 'Рубли',
                    'value' => 'RUR'
                ),
                2 => array(
                    'name' => 'Евро',
                    'value' => 'EUR'
                ),
                3 => array(
                    'name' => 'Гривны',
                    'value' => 'UAH'
                )
            )
        );
        return $data;
    }

    /**
     * @param string $data
     * @return int
     */
    public function getCookieCount($data){
        $data = explode('ￗ', $data);
        array_pop($data);
        return count($data);
    }
}