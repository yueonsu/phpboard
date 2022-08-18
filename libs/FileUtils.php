<?php
namespace libs;

class FileUtils {

    function makeFolder($path) {
        if(!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    function getRandomFileName($fileName) {
        return $this->getUuid() . "." . $this->getExt($fileName);
    }

    function getUuid() {
        return sprintf('%08x-%04x-%04x-%04x-%04x%08x',
            mt_rand(0, 0xffffffff),
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff), mt_rand(0, 0xffffffff));
    }

    function getExt($fileName) {
        $file = $fileName;
        $file_arr = explode(".", $file);
        $ext = end($file_arr);
        return $ext;
    }

    function saveFile($path, $file) {
        $this->makeFolder($path);
        $tmpName = $file['tmp_name'];
        $fileName = $file['name'];
        $randNm = $this->getUuid() . "." . $this->getExt($fileName);
        $resultNm = $path . $randNm;
        move_uploaded_file($tmpName, $resultNm);
    }
}