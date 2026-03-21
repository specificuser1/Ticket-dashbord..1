<?php
$ping = @file_get_contents("http://BOT-IP-OR-DOMAIN:5000/ping");

echo json_encode([
    "online" => $ping === "pong"
]);
