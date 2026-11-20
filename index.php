<?php

require_once "Config/Config.php";
require_once "Libraries/Core/Autoload.php";

$url = $_GET["url"] ?? "productos";
$parts = array_values(array_filter(explode("/", trim($url, "/")), "strlen"));

$controller = ucfirst($parts[0] ?? "productos");
$method = $parts[1] ?? "index";
$param = $parts[2] ?? null;

require_once "Libraries/Core/Load.php";
