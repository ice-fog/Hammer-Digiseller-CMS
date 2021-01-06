<?php

/**
 * Класс Core
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

include $_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php';

class Core {

    /**
     * @var SysPages
     */
    private $sysPages;

    /**
     * @var Settings
     */
    private $settings;

    /**
     * @var Feedback
     */
    private $feedback;

    /**
     * @var Content
     */
    private $content;

    /**
     * @var Images
     */
    private $images;

    /**
     * @var Notify
     */
    private $notify;

    /**
     * @var FileEditor
     */
    private $fileEditor;

    /**
     * @var EmailDelivery
     */
    private $emailDelivery;

    /**
     * @var Pages
     */
    private $pages;

    /**
     * @var Template
     */
    private $template;

    /**
     * @var DataBase
     */
    private $db;

    /**
     * @var int
     */
    private $startTime;

    /**
     * @var Core
     */
    private static $instance;

    /**
     *
     */
    function __construct() {
        $this->setHeader();
        $this->setTime();

        if(self::$instance) {
            $this->db = &self::$instance->db;
            $this->template = &self::$instance->template;
            $this->settings = &self::$instance->settings;
            $this->feedback = &self::$instance->feedback;
            $this->pages = &self::$instance->pages;
            $this->content = &self::$instance->content;
            $this->sysPages = &self::$instance->sysPages;
            $this->images = &self::$instance->images;
            $this->notify = &self::$instance->notify;
            $this->fileEditor = &self::$instance->fileEditor;
            $this->emailDelivery = &self::$instance->emailDelivery;
        } else {
            self::$instance = $this;
            $this->settings = new Settings();
            $this->feedback = new Feedback();
            $this->pages = new Pages();
            $this->sysPages = new SysPages();
            $this->images = new Images();
            $this->notify = new Notify();
            $this->fileEditor = new FileEditor();
            $this->emailDelivery = new EmailDelivery();

            $this->content = new Content(
                $this->getRootDir().Registry::get('cache-dir'),
                $this->getSettings()->settings['cache-time'],
                $this->getSettings()->settings['agent-id'],
                $this->getSettings()->settings['xml-id']
            );

            $this->template = new Template(
                $this->getRootDir().Registry::get('templates-dir'),
                Registry::get('templates-ext')
            );

            $this->db = new DataBase(
                include $this->getRootDir().Registry::get('db-config')
            );
        }
    }


    /**
     *
     */
    private function setHeader(){
        header("X-PoweredBy: Hammer");
    }

    /**
     *
     */
    private function setTime(){
        $this->startTime = time();
    }

    /**
     * @return string
     */
    public function getRootDir() {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * @return string
     */
    public function getUserAgent() {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @return string
     */
    public function getHTTPHost() {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * @return mixed
     */
    public function getRequest(){
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @return int
     */
    public function getStartTime() {
        return $this->startTime;
    }

    /**
     * @param int $route - номер
     * @return int | array
     */
    public function getRoute($route = 0) {
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        if($route == 0) {
            return $routes;
        } else {
            return $routes[$route];
        }
    }

    /**
     * @return string
     */
    public function getURL() {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @return DataBase
     */
    public function getDb() {
        return $this->db;
    }

    /**
     * @return Template
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * @return SysPages
     */
    public function getSysPages() {
        return $this->sysPages;
    }

    /**
     * @return Images
     */
    public function getImages() {
        return $this->images;
    }

    /**
     * @return Notify
     */
    public function getNotify() {
        return $this->notify;
    }

    /**
     * @return Feedback
     */
    public function getFeedback() {
        return $this->feedback;
    }

    /**
     * @return Content
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @return FileEditor
     */
    public function getFileEditor() {
        return $this->fileEditor;
    }

    /**
     * @return EmailDelivery
     */
    public function getEmailDelivery() {
        return $this->emailDelivery;
    }

    /**
     * @return Pages
     */
    public function getPages() {
        return $this->pages;
    }

    /**
     * @return Settings
     */
    public function getSettings() {
        return $this->settings;
    }

    /**
     * @return bool
     */
    public function isSearchBot(){
        $bots = array(
            'Yandex',
            'Google',
            'Mail',
            'Rambler',
            'Yahoo',
            'msnbot',
            'bingbot',
            'AhrefsBot'
        );
        foreach($bots as $t){
            if(strstr($this->getUserAgent(), $t)){
                return true;
            }
        }
        return false;
    }

    /**
     * @return string
     */
    public function getUserIP() {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     *
     */
    public function updateRequestLog(){
        $file = $this->getRootDir() . '/data/log';
        $lines = file($file);
        while(count($lines) > 1000)
            array_shift($lines);
        $lines[] = date("H:i:s d.m.Y") . "|" . $this->getUserAgent() . "|" . $this->getUserIP() . "|" . $this->getURL() . "\r\n";
        file_put_contents($file, $lines);
    }

    /**
     *
     */
    public function updateStat() {
        if(!$this->isSearchBot()){
            $id = $this->db->getOne("SELECT id FROM statistics WHERE period = ?s", date("d.m.y"));
            if($id) {
                if($this->getCookie('visit') == 'yes') {
                    $this->db->query("UPDATE statistics SET total = total + 1 WHERE id = ?i", $id);
                } else {
                    $this->db->query("UPDATE statistics SET total = total + 1, uniques = uniques + 1 WHERE id = ?i", $id);
                }
            } else {
                $this->db->query("INSERT INTO statistics (period,  uniques, total) VALUES (?s, ?i, ?i)", date("d.m.y"), 1, 1);
            }
        }
        $this->updateRequestLog();
    }

    /**
     * @param $limit
     * @return array
     */
    public function getStat($limit) {
        return $this->db->getAll("SELECT * FROM statistics ORDER BY id DESC LIMIT ?i", $limit);
    }

    /**
     * @return array|bool
     */
    public function getUser() {
        $userId = $this->getCookie('user-id');
        $userHash = $this->getCookie('user-hash');

        if(is_numeric($userId) && strlen($userHash) > 0){
            $user = $this->getDb()->getRow("SELECT * FROM users WHERE id = ?i", $userId);
            if(($user['hash'] !== $userHash) || ($user['id'] !== $userId)) {
                $this->logout();
                return false;
            } else {
                return $user;
            }
        } else {
            return false;
        }
    }

    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function login($login, $password) {
        $user = $this->getDb()->getRow("SELECT * FROM users WHERE login = ?s", $login);
        if($user) {
            if($user['password'] === md5(md5($password))) {
                $hash = md5(rand(0, 9999));
                $this->getDb()->query("UPDATE users SET hash = ?s WHERE id = ?i", $hash, $user['id']);
                $this->setCookie('user-id', $user['id'], time() + 60 * 60 * 24 * 30);
                $this->setCookie('user-hash', $hash, time() + 60 * 60 * 24 * 30);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     *
     */
    public function logout() {
        $this->setCookie('user-id', "", time() - 3600 * 24 * 30 * 12);
        $this->setCookie('user-hash', "", time() - 3600 * 24 * 30 * 12);
    }

    /**
     *
     */
    public function sessionStart() {
        session_start();
    }

    /**
     *
     */
    public function sessionUnset() {
        session_unset();
    }

    /**
     *
     */
    public function sessionDestroy() {
        session_destroy();
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $time
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httpOnly
     * @return bool
     */
    public function setCookie($key, $value, $time = 0, $path = null, $domain = null, $secure = false, $httpOnly = false) {
        return setcookie(md5($key), base64_encode($value), $time, $path, $domain, $secure, $httpOnly);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getCookie($key) {
        if(isset($_COOKIE[md5($key)])){
            return base64_decode($_COOKIE[md5($key)]);
        }else{
            return false;
        }

    }
}