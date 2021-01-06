<?php

/**
 * Класс SysPages
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class SysPages extends Core{

    /**
     * @return array
     */
    public function getAllPages() {
        $array = include $this->getRootDir() . '/data/system-pages.php';
        return array(
            0 => array(
                'page' => 'not-found',
                'title' => 'Страница не найдена',
                'content' => $array['not-found']
            )
        );
    }

    /**
     * @return array
     */
    public function getPagesArray() {
        return include $this->getRootDir() . '/data/system-pages.php';
    }

    /**
     * @return array
     */
    public function getNotFoundPage() {
        $array = include $this->getRootDir() . '/data/system-pages.php';
        return htmlspecialchars_decode($array['not-found']);
    }

    /**
     * @param array | string $key
     * @param mixed $value
     * @return array
     */
    public function updatePage($key, $value = null) {
        $pages = $this->getPagesArray();
        if(is_array($key)) {
            foreach($key as $k => $v) {
                $pages[$k] = $v;
            }
        } else {
            if($pages[$key]) {
                $pages[$key] = $value;
            }
        }
        $handler = @fopen($this->getRootDir() . '/data/system-pages.php', 'w');
        fwrite($handler, "<?php\n\nreturn array(\n");
        foreach($pages as $name => $value) {
            fwrite($handler, "    '$name' => \"{$value}\",\n");
        }
        fwrite($handler, ");");
        fclose($handler);
        return true;
    }
} 