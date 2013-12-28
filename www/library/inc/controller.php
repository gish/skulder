<?php

abstract class Controller extends C
{
    public function __construct()
    {}
        
    public function render($viewPath = null)
    {
        if (!$viewPath)
        {
            $trace = debug_backtrace();
            $viewName = strtolower($trace[1]['function']);
            $className = strtolower(get_class($this));
            $viewPath = dirname(__FILE__) . "/../views/{$className}/{$viewName}.php";
        }

        return parent::render($viewPath);
    }
}