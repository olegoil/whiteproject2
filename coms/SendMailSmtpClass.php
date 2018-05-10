<?php

/**
* SendMailSmtpClass
*
*
* @version 1.0
*/
class SendMailSmtpClass {
/**
*
* @var string $smtp_username - login
* @var string $smtp_password - pwd
* @var string $smtp_host - host
* @var string $smtp_from - from
* @var integer $smtp_port - port
* @var string $smtp_charset - coding
*
*/
public $smtp_username;
public $smtp_password;
public $smtp_host;
public $smtp_from;
public $smtp_port;
public $smtp_charset;
public function __construct($smtp_username, $smtp_password, $smtp_host, $smtp_from, $smtp_port = 25, $smtp_charset = "utf-8") {
$this->smtp_username = $smtp_username;
$this->smtp_password = $smtp_password;
$this->smtp_host = $smtp_host;
$this->smtp_from = $smtp_from;
$this->smtp_port = $smtp_port;
$this->smtp_charset = $smtp_charset;
}
/**
* Sending
*
* @param string $mailTo - receiver
* @param string $subject - theme
* @param string $message - body
* @param string $headers - header
*
* @return bool|string on success - true, else error text *
*/
    function send($mailTo, $subject, $message, $headers) {
        $contentMail = "Date: " . date("D, d M Y H:i:s") . " UT\r\n";
        $contentMail .= 'Subject: =?' . $this->smtp_charset . '?B?' . base64_encode($subject) . "=?=\r\n";
        $contentMail .= $headers . "\r\n";
        $contentMail .= $message . "\r\n";

        $socket = @fsockopen($this->smtp_host, $this->smtp_port, $errorNumber, $errorDescription, 30);

        $this->_parseServer($socket, "220");
        fputs($socket, "HELO " . $this->smtp_host . "\r\n");
        $this->_parseServer($socket, "250");
        fputs($socket, "AUTH LOGIN\r\n");
        $this->_parseServer($socket, "334");
        fputs($socket, base64_encode($this->smtp_username) . "\r\n");
        $this->_parseServer($socket, "334");
        fputs($socket, base64_encode($this->smtp_password) . "\r\n");
        $this->_parseServer($socket, "235");
        fputs($socket, "MAIL FROM: ".$this->smtp_username."\r\n");
        $this->_parseServer($socket, "250");
        fputs($socket, "RCPT TO: " . $mailTo . "\r\n");
        $this->_parseServer($socket, "250");
        fputs($socket, "DATA\r\n");
        $this->_parseServer($socket, "354");
        fputs($socket, $contentMail."\r\n.\r\n");
        $this->_parseServer($socket, "250");
        fputs($socket, "QUIT\r\n");
        fclose($socket);

    }
    private function _parseServer($socket, $response) {
        while (@substr($responseServer, 3, 1) != ' ') {
            if (!($responseServer = fgets($socket, 256))) {
                return false;
            }
        }
        if (!(substr($responseServer, 0, 3) == $response)) {
            return false;
        }
        return true;
    }
}

?>