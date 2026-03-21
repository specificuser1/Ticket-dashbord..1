<?php
require "../config.php";

if ($_SERVER["HTTP_API_KEY"] !== $secret_key) {
    http_response_code(403);
    die("FORBIDDEN");
}

file_get_contents("sftp://nc1.lemonhost.me:2022/create-panel");

echo json_encode(["status" => "SENT"]);
