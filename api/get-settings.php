<?php
require "../config.php";

if ($_SERVER["HTTP_API_KEY"] !== $secret_key) {
    http_response_code(403);
    die("FORBIDDEN");
}

echo file_get_contents($settings_file);
