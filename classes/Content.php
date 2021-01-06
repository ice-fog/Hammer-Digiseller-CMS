<?php

/**
 * Class Content
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();


class Content{

    private $cdir;
    private $ctime;
    private $agentID;
    private $XMLID;

    /**
     * @param string $cdir
     * @param int $ctime
     * @param int $agentID
     * @param string $XMLID
     */
    public function __construct($cdir, $ctime, $agentID, $XMLID){
        $this->cdir = $cdir;
        $this->ctime = $ctime;
        $this->agentID = $agentID;
        $this->XMLID = $XMLID;
    }

    /**
     * @param string $url
     * @param string $data
     * @return mixed
     */
    private function get($url, $data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: text/xml'));
        return curl_exec ($curl);
    }

    /**
     * @param string $filename
     * @param int $time
     * @return bool|string
     */
    public function readCache($filename, $time){
        if (file_exists($filename))
            return time() - $time < filemtime($filename) ? file_get_contents($filename) : FALSE;
        else
            return FALSE;
    }

    /**
     * @param string $filename
     * @param string $content
     * @return mixed
     */
    public function writeCache($filename, $content){
        $handle = fopen($filename, 'w');
        fwrite($handle, $content);
        fclose($handle);
        return $content;
    }


    /**
     * @param int $type - type code: 0 - section, 1 - goods, 2 - seller, 3 - all
     */
    public function clearCache($type){
        switch($type){
            case 0:
                deleteFilesInDir($this->cdir.'section/');
                break;
            case 1:
                deleteFilesInDir($this->cdir.'goods/');
                break;
            case 2:
                deleteFilesInDir($this->cdir.'seller/');
                break;
            case 3:
                deleteFilesInDir($this->cdir);
                break;
        }
    }

    /**
     * @param int $id
     * @return SimpleXMLElement
     */
    public function section($id){
        $name = md5('SECTION'.$id);
        $temp = $this->readCache($this->cdir.'section/'.$name, $this->ctime);
        $cache = $temp ? $temp : $this->writeCache($this->cdir.'section/'.$name, $this->get('http://www.plati.ru/xml/sections.asp', '<digiseller.request><guid_agent>'.$this->XMLID.'</guid_agent><id_catalog>'.$id.'</id_catalog></digiseller.request>'));
        return simplexml_load_string($cache);
    }

    /**
     * @param int $id
     * @param int $page
     * @param int $rows
     * @param string $currency
     * @param string $order
     * @return SimpleXMLElement
     */
    public function goods($id,$page,$rows,$currency,$order){
        $name = md5('GOODS'.Registry::get('currency').Registry::get('order').$id.$page.$rows);
        $temp = $this->readCache($this->cdir.'goods/'.$name, $this->ctime);
        $cache = $temp ? $temp : $this->writeCache($this->cdir.'goods/'.$name, str_replace('&', '&amp;', $this->get('http://www.plati.ru/xml/goods.asp', '<digiseller.request><guid_agent>'.$this->XMLID.'</guid_agent><id_section>'.$id.'</id_section><page>'.$page.'</page><rows>'.$rows.'</rows><currency>'.$currency.'</currency><order>'.$order.'</order></digiseller.request>')));
        return simplexml_load_string($cache);
    }

    /**
     * @param int $id
     * @param array $patterns
     * @param array $replace
     * @param array $strSearch
     * @param array $strReplace
     * @return SimpleXMLElement
     */
    public function goodsInfo($id, $patterns, $replace, $strSearch, $strReplace){
        $xml = $this->get('http://www.plati.ru/xml/goods_info.asp', '<digiseller.request><guid_agent>'.$this->XMLID.'</guid_agent><id_goods>'.$id.'</id_goods></digiseller.request>');
        $xml = preg_replace($patterns, $replace, $xml);
        $xml = str_replace($strSearch, $strReplace, $xml);
        return simplexml_load_string($xml);
    }

    /**
     * @param int $seller
     * @param int $goods
     * @param $type
     * @param int $page
     * @param int $rows
     * @return SimpleXMLElement
     */
    public function responses($seller,$goods,$type,$page,$rows){
        return simplexml_load_string($this->get('http://www.plati.ru/xml/responses.asp', '<digiseller.request><guid_agent>'.$this->XMLID.'</guid_agent><id_seller>'.$seller.'</id_seller><id_goods>'.$goods.'</id_goods><type_response>'.$type.'</type_response><page>'.$page.'</page><rows>'.$rows.'</rows></digiseller.request>'));
    }

    /**
     * @param int $id
     * @return SimpleXMLElement
     */
    public function sellerInfo($id){
        return simplexml_load_string($this->get('http://www.plati.ru/xml/seller_info.asp', '<digiseller.request><guid_agent>'.$this->XMLID.'</guid_agent><id_seller>'.$id.'</id_seller></digiseller.request>'));
    }

    /**
     * @param int $seller
     * @param int $page
     * @param int $rows
     * @param string $currency
     * @param string $order
     * @return SimpleXMLElement
     */
    public function sellerGoods($seller,$page,$rows,$currency,$order){
        $name = md5('SELLER'.Registry::get('currency').Registry::get('order').$seller.$page.$rows);
        $temp = $this->readCache($this->cdir.'seller/'.$name, $this->ctime);
        $cache = $temp ? $temp : $this->writeCache($this->cdir.'seller/'.$name, str_replace('&', '&amp;', $this->get('http://www.plati.ru/xml/seller_goods.asp', '<digiseller.request><guid_agent>'.$this->XMLID.'</guid_agent><id_seller>'.$seller.'</id_seller><page>'.$page.'</page><rows>'.$rows.'</rows><currency>'.$currency.'</currency><order>'.$order.'</order></digiseller.request>')));
        return simplexml_load_string($cache);
    }

    /**
     * @param string $search
     * @param string $check
     * @param int $count
     * @param int $page
     * @param int $rows
     * @param string $currency
     * @return SimpleXMLElement
     */
    public function searchGoods($search,$check,$count,$page,$rows,$currency){
        $name = md5('SEARCH'.Registry::get('currency').Registry::get('order').$search.$page.$rows);
        $temp = $this->readCache($this->cdir.'goods/'.$name, $this->ctime);
        $cache = $temp ? $temp : $this->writeCache($this->cdir.'goods/'.$name, str_replace('&', '&amp;', $this->get('http://www.plati.ru/xml/search_goods.asp', '<digiseller.request><guid_agent>'.$this->XMLID.'</guid_agent><search_str>'.$search.'</search_str><check_words>'.$check.'</check_words><cnt_goods>'.$count.'</cnt_goods><page>'.$page.'</page><rows>'.$rows.'</rows><currency>'.$currency.'</currency></digiseller.request>')));
        return simplexml_load_string($cache);
    }

    /**
     * @param int $id
     * @param string $email
     * @param string $currency
     * @return SimpleXMLElement
     */
    public function discount($id,$email,$currency){
        return simplexml_load_string($this->get('http://www.plati.ru/xml/discount.asp', '<digiseller.request><guid_agent>'.$this->XMLID.'</guid_agent><id_goods>'.$id.'</id_goods><email>'.$email.'</email><currency>'.$currency.'</currency></digiseller.request>'));
    }

    /**
     * @param int $id
     * @param int $page
     * @param int $rows
     * @param string $currency
     * @param string $order
     * @return SimpleXMLElement
     */
    public function agentGoods($id,$page,$rows,$currency,$order){
        return simplexml_load_string($this->get('http://shop.digiseller.ru/xml/agent_goods.asp', '<digiseller.request><id_group>'.$id.'</id_group><page>'.$page.'</page><rows>'.$rows.'</rows><currency>'.$currency.'</currency><order>'.$order.'</order></digiseller.request>'));
    }
}