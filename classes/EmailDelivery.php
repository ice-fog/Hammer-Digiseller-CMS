<?php

/**
 * Класс EmailDelivery
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class EmailDelivery extends Core{

    /**
     * @return int
     */
    public function getCount() {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM delivery");
    }

    /**
     * @return int
     */
    public function getActiveCount() {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM delivery WHERE status = 1");
    }

    /**
     * @return int
     */
    public function getInactiveCount() {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM delivery WHERE status = 0");
    }

    /**
     * @param int $limit
     * @param int $page
     * @return array
     */
    public function get($limit, $page) {
        return $this->getDb()->getAll("SELECT * FROM delivery ORDER BY id DESC LIMIT ?i, ?i", $page * $limit - $limit, $limit);
    }

    /**
     * @return array
     */
    public function getActiveList() {
        return $this->getDb()->getAll("SELECT email FROM delivery WHERE status = 1 ORDER BY id");
    }

    /**
     * @param int $limit
     * @param int $page
     * @return array
     */
    public function getPublic($limit, $page) {
        return $this->getDb()->getAll("SELECT * FROM delivery WHERE status = 1 ORDER BY id DESC LIMIT ?i, ?i", $page * $limit - $limit, $limit);
    }

    /**
     * @param int $limit
     * @param int $page
     * @return array
     */
    public function getInactive($limit, $page) {
        return $this->getDb()->getAll("SELECT * FROM delivery WHERE status = 0 ORDER BY id DESC LIMIT ?i, ?i", $page * $limit - $limit, $limit);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function add($email) {
        return $this->getDb()->query("INSERT INTO delivery (email, status) VALUES (?s, 1)", $email);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getOne($id) {
        return $this->getDb()->getRow("SELECT * FROM delivery WHERE id = ?i", $id);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function checkEmail($email){
        if($this->getDb()->getRow("SELECT id FROM delivery WHERE email = ?s", $email)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        return $this->getDb()->query("DELETE  FROM delivery WHERE id = ?i", $id);
    }

    /**
     * @param int $email
     * @return bool
     */
    public function deleteByEmail($email) {
        return $this->getDb()->query("DELETE  FROM delivery WHERE email = ?s", $email);
    }

    /**
     * @param int $id - id email
     * @param int $status
     * @return bool
     */
    public function updateStatus($id, $status) {
        return $this->getDb()->query("UPDATE delivery SET status = ?s WHERE id = ?i", $status, $id);
    }

    /**
     * @param array $id
     * @param int $status
     * @return bool
     */
    public function multipleUpdateStatus($id, $status) {
        return $this->getDb()->query("UPDATE delivery SET status = ?s WHERE id IN (?a)", $status, $id);
    }

    /**
     * @param array $id
     * @return bool
     */
    public function multipleDelete($id) {
        return $this->getDb()->query("DELETE  FROM delivery WHERE id IN (?a)", $id);
    }

    /**
     * @param string $to
     * @param string $subject
     * @param string $message
     */
    public function sendEmail($to, $subject, $message) {
        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=utf-8; \r\n";
        mail($to, $subject, $message, $headers);
    }

    /**
     * @param string $name
     * @param string $content
     * @return bool
     */
    public function newDelivery($name, $content) {
        $tmp = file_get_contents($this->getRootDir(). '/public/email.tpl');
        foreach($this->getActiveList() as $t){
            $data = array(
                'header' => $name,
                'user-info' => false,
                'message' => $content,
                'link' => array(
                    'url' => $this->getHTTPHost().'/unsubscribe/'.base64_encode($t['email']),
                    'name' => 'Отписатся от рассылки'
                )
            );

            $this->sendEmail($t['email'], $name,  $this->getTemplate()->compileStr($tmp, $data));
        }
        return true;
    }
}