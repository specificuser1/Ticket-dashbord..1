<?php
$ping = @file_get_contents("http://sftp://nc1.lemonhost.me:5000/ping");

echo json_encode([
    "online" => $ping === "pong"
]);
