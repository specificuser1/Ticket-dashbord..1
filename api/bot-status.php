<?php
$ping = @file_get_contents("sftp://nc1.lemonhost.me:2022/ping");

echo json_encode([
    "online" => $ping === "pong"
]);
