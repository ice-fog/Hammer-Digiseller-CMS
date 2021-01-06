<?php

/**
 * Класс Feedback
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Feedback extends Core{

    /**
     * @param string $name
     * @param string $email
     * @param string $message
     * @param string $ip
     * @return boolean
     */
    public function add($name, $email, $message, $ip) {
        return $this->getDb()->query("INSERT INTO feedback (name, email, message, ip, archive) VALUES (?s, ?s, ?s, ?s, ?i)", $name, $email, $message, $ip, 0);
    }

    /**
     * @return array
     */
    public function getAllNotArchive() {
        return $this->getDb()->getAll("SELECT * FROM feedback WHERE archive = 0 ORDER BY id");
    }

    /**
     * @return array
     */
    public function getAllArchive() {
        return $this->getDb()->getAll("SELECT * FROM feedback WHERE archive = 1 ORDER BY id");
    }

    /**
     * @return int
     */
    public function getAllCount() {
        return $this->getDb()->getOne("SELECT COUNT(*) FROM feedback");
    }

    /**
     * @return int
     */
    public function getAllNotArchiveCount() {
        return $this->getDb()->getOne("SELECT COUNT(*) FROM feedback WHERE archive = 0");
    }

    /**
     * @return int
     */
    public function getAllArchiveCount() {
        return $this->getDb()->getOne("SELECT COUNT(*) FROM feedback WHERE archive = 1");
    }

    /**
     * @param array $id
     * @return boolean
     */
    public function multipleArchive($id) {
        return $this->getDb()->query("UPDATE feedback SET archive = 1 WHERE id IN (?a)", $id);
    }

    /**
     * @param array $id
     * @return boolean
     */
    public function multipleDelete($id) {
        return $this->getDb()->query("DELETE  FROM feedback WHERE id IN (?a)", $id);
    }

    /**
     * @param int $id
     * @return array
     */
    public function archive($id) {
        return $this->getDb()->query("UPDATE feedback SET archive = 1 WHERE id = ?i", $id);
    }

    /**
     * @param array $id
     * @return boolean
     */
    public function delete($id) {
        return $this->getDb()->query("DELETE  FROM feedback WHERE id = ?i", $id);
    }
} 