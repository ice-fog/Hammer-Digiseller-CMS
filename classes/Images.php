<?php

/**
 * Класс Images
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Images extends Core {

    /**
     * @var resource
     */
    private $image;

    /**
     * @var string
     */
    private $type;

    /**
     * @param string $filename
     */
    private function load($filename) {
        $imageInfo = getimagesize($filename);
        $this->type = $imageInfo[2];
        if($this->type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif($this->type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif($this->type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }
    }

    /**
     * @param string $filename
     * @param int $type
     * @param int $compression
     * @param int $permissions
     */
    private function save($filename, $type = IMAGETYPE_JPEG, $compression = 75, $permissions = null) {
        if($type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif($type == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } elseif($type == IMAGETYPE_PNG) {
            imagepng($this->image, $filename);
        }
        if($permissions != null) {
            chmod($filename, $permissions);
        }
    }

    /**
     * @return int
     */
    private function getWidth() {
        return imagesx($this->image);
    }

    /**
     * @return int
     */
    private function getHeight() {
        return imagesy($this->image);
    }

    /**
     *
     */
    private function resize() {
        $width = 140;
        $height = 150;
        $newImage = imagecreatetruecolor($width, $height);
        imagecopyresampled($newImage, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $newImage;
    }

    /**
     * @param string $name
     */
    public function delete($name) {
        if(file_exists($this->getRootDir() . $this->getSettings()->settings['images-dir'] . '/' . $name)) {
            unlink($this->getRootDir() . $this->getSettings()->settings['images-dir'] . '/' . $name);
        }
        if(file_exists($this->getRootDir() . $this->getSettings()->settings['images-thumb-dir'] . '/' . $name)) {
            unlink($this->getRootDir() . $this->getSettings()->settings['images-thumb-dir'] . '/' . $name);
        }
    }

    /**
     * @param array $names
     */
    public function multipleDelete($names) {
        foreach($names as $name) {
            $this->delete($name);
        }
    }

    /**
     * @param $name
     * @return string
     */
    public function getFileExt($name) {
        $ext = explode('.', $name);
        $ext = end($ext);
        return strtolower($ext);
    }

    /**
     * @return array
     */
    public function multiUpload() {
        $error = '';
        $images = array();
        foreach($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $tmp = $_FILES['images']['tmp_name'][$key];
            $name = $_FILES['images']['name'][$key];
            $ext = $this->getFileExt($name);
            $new = $this->getStartTime() . '-' . md5($name) . '.' . $ext;
            if(in_array($ext, array('jpeg', 'jpg', 'png', 'gif')) === true) {
                if(move_uploaded_file($tmp, $this->getRootDir() . $this->getSettings()->settings['images-dir'] . '/' . $new)) {
                    $this->load($this->getRootDir() . $this->getSettings()->settings['images-dir'] . '/' . $new);
                    $this->resize();
                    $this->save($this->getRootDir() . $this->getSettings()->settings['images-thumb-dir'] . '/' . $new);
                    $images[] = $new;
                } else
                    $error = 'Ошибка загрузке. Некоторые файлы не могут быть загружены.';
            } else {
                $error = 'Ошибка загрузке. Тип файла не допускается.';
            }
        }
        return array(
            'message' => 'uploadSuccess',
            'error' => $error,
            'images' => $images
        );
    }

    /**
     * @return array
     */
    public function upload() {
        $tmp = $_FILES['file']['tmp_name'];
        $name = $_FILES['file']['name'];
        $ext = $this->getFileExt($name);
        $new = $this->getStartTime() . '-' . md5($tmp) . '.' . $ext;
        if(move_uploaded_file($tmp, $this->getRootDir() . $this->getSettings()->settings['images-dir'] . '/' . $new)) {
            return array(
                'message' => 'uploadSuccess',
                'file' => $this->getSettings()->settings['images-dir'] . '/' . $new,
            );
        } else {
            return false;
        }
    }
}