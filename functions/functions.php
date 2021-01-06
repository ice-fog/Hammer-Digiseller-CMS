<?php

function getAllSubId($array, $id) {
    if(!isset($id))
        return null;
    $result = '';
    foreach($array as $t) {
        if($t['parent'] == $id) {
            $result .= $t['id'] . '|';
            $result .= getAllSubId($array, $t['id']);
        }
    }
    $result .= $id . '|';
    return $result;
}

function getRecordsCount($array, $id, $count) {
    if(!$id)
        return null;
    $result = $count;
    foreach($array as $t) {
        if($t['parent'] == $id) {
            $result += $t['count'];
            $result += getRecordsCount($array, $t['id'], 0);
        }
    }
    return $result;
}

function createTreeArray(&$list, $parent) {
    $tree = array();
    foreach($parent as $k => $l) {
        if(isset($list[$l['id']])) {
            $l['children'] = createTreeArray($list, $list[$l['id']]);
        }
        $tree[] = $l;
    }
    return $tree;
}

function arrayRenameKey(&$array, $old, $new) {
    if(!is_array($array)) {
        ($array == "") ? $array = array() : false;
        return $array;
    }
    foreach($array as &$arr) {
        if(is_array($old)) {
            foreach($new as $k => $new) {
                (isset($old[$k])) ? true : $old[$k] = NULL;
                $arr[$new] = (isset($arr[$old[$k]]) ? $arr[$old[$k]] : null);
                unset($arr[$old[$k]]);
            }
        } else {
            $arr[$new] = (isset($arr[$old]) ? $arr[$old] : null);
            unset($arr[$old]);
        }
    }
    return $array;
}

function getCaptcha() {
    $rand = rand(10000, 99999);
    $_SESSION['captcha'] = md5($rand);
    $picture = imagecreatetruecolor(60, 30);

    imagecolortransparent($picture, 000);
    imagefilledrectangle($picture, 4, 4, 50, 25, 000);
    imagestring($picture, 5, 5, 7, substr($rand, 0, 1), imagecolorallocate($picture, rand(100, 200), rand(100, 200), rand(100, 200)));
    imagestring($picture, 5, 15, 7, substr($rand, 1, 1), imagecolorallocate($picture, rand(100, 200), rand(100, 200), rand(100, 200)));
    imagestring($picture, 5, 25, 7, substr($rand, 2, 1), imagecolorallocate($picture, rand(100, 200), rand(100, 200), rand(100, 200)));
    imagestring($picture, 5, 35, 7, substr($rand, 3, 1), imagecolorallocate($picture, rand(100, 200), rand(100, 200), rand(100, 200)));
    imagestring($picture, 5, 45, 7, substr($rand, 4, 1), imagecolorallocate($picture, rand(100, 200), rand(100, 200), rand(100, 200)));

    header("Content-type: image/png");
    imagepng($picture);
    imagedestroy($picture);
}

function getDirSize($dir){
    $total = 0;
    $dirs = scandir($dir);
    foreach($dirs as $t){
        if($t != ".." && $t != "."){
            if(is_dir($dir.'/'.$t)){
                $parent = getDirSize($dir.'/'.$t);
                $total = $total + $parent;
            }else if(is_file($dir.'/'.$t)){
                $total = $total + filesize($dir.'/'.$t);
            }
        }
    }
    return $total;
}

function deleteFilesInDir($dir){
    $dirs = scandir($dir);
    foreach($dirs as $t){
        if($t != ".." && $t != "."){
            if(is_dir($dir.'/'.$t)){
                deleteFilesInDir($dir.'/'.$t);
            }else if(is_file($dir.'/'.$t)){
                unlink($dir.'/'.$t);
            }
        }
    }
}

function fileSizeConvert($bytes){
    $bytes = floatval($bytes);
    $arBytes = array(
        0 => array(
            "UNIT" => "TB",
            "VALUE" => pow(1024, 4)
        ),
        1 => array(
            "UNIT" => "GB",
            "VALUE" => pow(1024, 3)
        ),
        2 => array(
            "UNIT" => "MB",
            "VALUE" => pow(1024, 2)
        ),
        3 => array(
            "UNIT" => "KB",
            "VALUE" => 1024
        ),
        4 => array(
            "UNIT" => "B",
            "VALUE" => 1
        ),
    );

    foreach($arBytes as $arItem) {
        if($bytes >= $arItem["VALUE"]) {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        } else {
            $result = "0 ".$arItem["UNIT"];
        }
    }
    return $result;
}

function arrayColumn($array, $key){
    $result = array();
    foreach($array as $t){
        if(isset($t[$key])){
            $result[] = $t[$key];
        }
    }
    return $result;
}

function simpleXMLToArray($object, $out = array () ){
    foreach ((array) $object as $index => $node )
        $out[$index] = (is_object($node)) ? simpleXMLToArray($node) : $node;
    return $out;
}