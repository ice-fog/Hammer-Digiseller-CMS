<?php

/**
 * Класс Notify
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Notify extends Core {

    /**
     * @param string $to
     * @param string $subject
     * @param string $message
     */
    public function email($to, $subject, $message) {
        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=utf-8; \r\n";
        mail($to, $subject, $message, $headers);
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $message
     */
    public function newFeedback($name, $email, $message) {
        $data = array(
            'header' => 'Новое сообщение от пользователя сайта ' . $this->getHTTPHost(),
            'user-info' => true,
            'name' => $name,
            'email' => $email,
            'action' => 'оставил сообщения',
            'message' => $message,
            'link' => array(
                'url' => $this->getHTTPHost() . '/admin/feedback',
                'name' => 'Просмотреть сообщения в админ панели'
            )
        );
        $message = $this->getTemplate()->compileBloc('email', $data);
        $this->email($this->getSettings()->settings['email'], 'Новое сообщение от пользователя сайта ' . $this->getHTTPHost(), $message);
    }
} 