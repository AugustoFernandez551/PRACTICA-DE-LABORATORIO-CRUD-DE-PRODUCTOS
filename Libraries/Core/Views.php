<?php

class Views
{
    public function render(object $controller, string $view, array $data = []): void
    {
        $folder = str_replace("Controller", "", get_class($controller));
        $path = "Views/{$folder}/{$view}.php";

        if (!file_exists($path)) {
            throw new RuntimeException("Vista no encontrada: {$path}");
        }

        require $path;
    }
}
