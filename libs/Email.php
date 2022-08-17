<?php

namespace libs;

class Email {

    static function certificationCodeSend($email) {
        $num = sprintf('%06d', rand(000000, 999999));
        $content = " 인증번호 : ". $num;
        $subject = "인증번호 : $num";
        $headers = "From: yueonsu@gmail.com";

        session_start();
        $_SESSION['num'] = $num;

        return mail($email, $subject, $content, $headers);
    }

    static function defaultSend($sub, $ctnt, $email) {
        $headers = "From: yueonsu@gmail.com";
        return mail($email, $sub, $ctnt, $headers);
    }

    static function codeCheck($num) {
        session_start();
        $result = $num == $_SESSION['num'] ? true : false;
        return $result;
    }
}