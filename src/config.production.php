<?php

/**
 * PHPMaker 2021 configuration file (Production)
 */

return [
    "Databases" => [
        "DB" => ["id" => "DB", "type" => "MYSQL", "qs" => "`", "qe" => "`", "host" => "localhost", "port" => "3306", "user" => "root", "password" => "", "dbname" => "simexamerica"]
    ],
    "SMTP" => [
        "PHPMAILER_MAILER" => "smtp", // PHPMailer mailer
        "SERVER" => "mail.simexamericas.org", // SMTP server
        "SERVER_PORT" => 465, // SMTP server port
        "SECURE_OPTION" => "ssl",
        "SERVER_USERNAME" => "noreply@simexamericas.org", // SMTP server user name
        "SERVER_PASSWORD" => "{=#tZo8ro8c0", // SMTP server password
    ],
    "JWT" => [
        "SECRET_KEY" => "H4C2Zjpgg6XLU2XI", // API Secret Key
        "ALGORITHM" => "HS512", // API Algorithm
        "AUTH_HEADER" => "X-Authorization", // API Auth Header (Note: The "Authorization" header is removed by IIS, use "X-Authorization" instead.)
        "NOT_BEFORE_TIME" => 0, // API access time before login
        "EXPIRE_TIME" => 600 // API expire time
    ]
];
