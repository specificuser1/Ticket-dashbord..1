<?php
require "../config.php";

if (!isset($_SERVER["HTTP_API_KEY"]) || $_SERVER["HTTP_API_KEY"] !== $secret_key) {
    http_response_code(403);
    die("FORBIDDEN");
}

header("Content-Type: application/json");
echo file_get_contents("../settings.json");
