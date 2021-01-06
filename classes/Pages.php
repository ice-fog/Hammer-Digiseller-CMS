<?php

/**
 * Класс Pages
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Pages extends Core{

    /**
     * @return array
     */
    public function getAllPage() {
        return $this->getDb()->getAll("SELECT * FROM pages ORDER BY title");
    }

    /**
     * @return array
     */
    public function getPublicLinks() {
        return $this->getDb()->getAll("SELECT title, url FROM pages WHERE status = 1 ORDER BY title");
    }

    /**
     * @param int $id
     * @return array
     */
    public function getOnePageById($id) {
        return $this->getDb()->getRow("SELECT * FROM pages WHERE id = ?i", $id);
    }

    /**
     * @param string $url
     * @return array
     */
    public function getOnePageByUrl($url) {
        return $this->getDb()->getRow("SELECT * FROM pages WHERE url = ?s", $url);
    }

    /**
     * @param $url
     * @return bool|int
     */
    public function checkFreeURL($url){
        return $this->getDb()->getOne("SELECT id FROM pages WHERE url = ?s", $url);
    }

    /**
     * @param string $url
     * @param int $status
     * @param string $title
     * @param string $description
     * @param string $content
     * @return boolean
     */
    public function addPage($url, $status, $title, $description, $content) {
        return $this->getDb()->query("INSERT INTO pages (url, status, title, description, content) VALUES (?s, ?s, ?s, ?s, ?s)", $url, $status, $title, $description, htmlspecialchars($content));
    }

    /**
     * @param int $id
     * @param string $url
     * @param int $status
     * @param string $title
     * @param string $description
     * @param string $content
     * @return boolean
     */
    public function editPage($id, $url, $status, $title, $description, $content) {
        return $this->getDb()->query("UPDATE pages SET url = ?s, status = ?s, title = ?s, description = ?s, content = ?s WHERE id = ?i", $url, $status, $title, $description, htmlspecialchars($content), $id);
    }

    /**
     * @param array $id
     * @param int $status
     * @return boolean
     */
    public function multipleUpdateStatus($id, $status) {
        return $this->getDb()->query("UPDATE pages SET status = ?i WHERE id IN (?a)", $status, $id);
    }

    /**
     * @param int $id
     * @param int $status
     * @return boolean
     */
    public function updateStatus($id, $status) {
        return $this->getDb()->query("UPDATE pages SET status = ?i WHERE id = ?i", $status, $id);

    }

    /**
     * @param array $id
     * @return boolean
     */
    public function multipleDeletePage($id) {
        return $this->getDb()->query("DELETE  FROM pages WHERE id IN (?a)", $id);
    }

    /**
     * @param int $id
     * @return boolean
     */
    public function deletePage($id) {
        return $this->getDb()->query("DELETE  FROM pages WHERE id = ?i", $id);
    }
} 