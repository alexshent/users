<?php

namespace alexshent\webapp\core;

class View {
    
    private $viewsDirectory = __DIR__ . "/../application/views/";
    private $path;
    
    public function __construct($path) {
        $this->path = rtrim($path, "/") . '/';
    }
    
    public function render(string $view, array $args = [], bool $donotflush = false): ?string {
        $content = null;
        extract($args, EXTR_SKIP);
        $viewFile = "{$this->viewsDirectory}{$this->path}{$view}.php";
        if ($donotflush) {
            ob_start();
        }
        if (!is_readable($viewFile)) {
            throw new \InvalidArgumentException("$viewFile not found");
        }
        require $viewFile;
        if ($donotflush) {
            $content = ob_get_contents();
            ob_end_clean();
        }
        return $content;
    }
}
