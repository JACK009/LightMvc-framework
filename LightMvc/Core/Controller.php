<?php

namespace LightMvc\Core;

class Controller
{
    public function view(string $view, ?array $data = []) {
        require_once '..' . DS . 'app' . DS . 'views' . DS . $view . '.php';
    }
}