<?php
require "../config.php";

if (!isset($_SERVER["HTTP_API_KEY"]) || $_SERVER["HTTP_API_KEY"] !== $secret_key) {
    http_response_code(403);
    die("FORBIDDEN");
}

$data = json_decode(file_get_contents("php://input"), true);

file_put_contents("../settings.json", json_encode($data, JSON_PRETTY_PRINT));

echo json_encode(["status" => "UPDATED"]);
