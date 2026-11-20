<?php

class Controller
{
    protected Views $views;
    protected ?Model $model = null;

    public function __construct()
    {
        $this->views = new Views();
        $this->loadModel();
    }

    private function loadModel(): void
    {
        $modelName = str_replace("Controller", "Model", get_class($this));
        $modelPath = "Models/{$modelName}.php";

        if (file_exists($modelPath)) {
            require_once $modelPath;
            $this->model = new $modelName();
        }
    }
}
