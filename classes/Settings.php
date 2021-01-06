<?php

/**
 * Класс Settings
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Settings{

    /**
     * @var array
     */
    public $settings;

    /**
     *
     */
    function __construct() {
        $this->settings = $this->getSettings();
    }

    /**
     * @return array
     */
    public function getSettings() {
        return include $_SERVER['DOCUMENT_ROOT'] . '/data/settings.php';
    }

    /**
     * @param array | string $key
     * @param mixed $value
     * @return array
     */
    public function updateSettings($key, $value = null) {
        $settings = $this->getSettings();
        if(is_array($key)) {
            foreach($key as $k => $v) {
                $settings[$k] = $v;
            }
        } else {
            if($settings[$key]) {
                $settings[$key] = $value;
            }
        }
        $handler = @fopen($_SERVER['DOCUMENT_ROOT'] . '/data/settings.php', 'w+');
        fwrite($handler, "<?php\n\nreturn array(\n");
        foreach($settings as $name => $value) {
            $value = htmlspecialchars($value);
            if($name !== "robots-content"){
                $value = str_replace(array("\n", "\r"), '', $value);
            }
            fwrite($handler, "    '$name' => \"{$value}\",\n");
        }
        fwrite($handler, ");");
        fclose($handler);
        return true;
    }
}