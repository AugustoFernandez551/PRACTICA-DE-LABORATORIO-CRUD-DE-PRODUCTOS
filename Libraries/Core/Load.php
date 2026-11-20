<?php

$controllerFile = "Controllers/{$controller}Controller.php";
$acciones = ["index"=>"GET", "crear"=>"GET", "guardar"=>"POST", "editar"=>"GET", "actualizar"=>"POST", "eliminar"=>"POST"];
$requiereId = in_array($method, ["editar", "actualizar", "eliminar"], true);
if ($controller !== "Productos" || !isset($acciones[$method]) || count($parts) > 3
    || ($requiereId ? !ctype_digit($param ?? "") : $param !== null)) {
    require "Controllers/ErrorController.php";
    exit;
}
if ($_SERVER["REQUEST_METHOD"] !== $acciones[$method]) {
    http_response_code(405);
    header("Allow: " . $acciones[$method]);
    exit;
}

if (!file_exists($controllerFile)) {
    require_once "Controllers/ErrorController.php";
    exit;
}

require_once $controllerFile;
$className = "{$controller}Controller";
$object = new $className();

if (!method_exists($object, $method)) {
    require_once "Controllers/ErrorController.php";
    exit;
}

$param === null ? $object->$method() : $object->$method($param);
