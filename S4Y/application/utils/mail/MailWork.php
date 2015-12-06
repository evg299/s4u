<?php

class MailWork {

    public static function sendMail($email, $title, $content) {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: " . $_SERVER["HTTP_HOST"] . " <" . MAIL_EMAIL . ">\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        mail($email, $title, $content, $headers);
    }

    public static function sendMailByTemplate($email, $title, $template, $replace_vars) {
        $tpath = dirname(__FILE__) . "/../../../application_data/mail_templates/$template";
        $headers = "Content-type: text/html; charset=utf8";

        $tplLines = file($tpath);
        $tplStr = implode("\n", $tplLines);
        foreach ($replace_vars as $key => $value) {
            $tplStr = str_replace($key, $value, $tplStr);
        }

        // echo $tplStr;
        $html = "<html><body>$tplStr</body></html>";
        
        mail($email, trim($title), $html, $headers);
    }

}
