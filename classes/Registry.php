<?php

/**
 * Class Registry
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

class Registry{
    private static $values = array();

    public static function set($key, $value = null) {
        self::$values[$key] = $value;
    }

    public static function get($key) {
        return isset(self::$values[$key]) ? self::$values [$key] : null;
    }

}