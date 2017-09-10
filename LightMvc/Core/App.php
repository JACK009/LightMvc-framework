<?php
namespace LightMvc\Core;

require_once 'ClassLoader.php';

use App\Config\Config;

class App {
    protected $controller;
    protected $method;
    protected $params = [];

    private static $_instance = null;

    private function parseUrl(): array {
        if(isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        } elseif(!empty($indexPage)) {
            return [
                $indexPage['controller'],
                $indexPage['action']
            ];
        }

        return [
            'Home',
            'index'
        ];
    }

    public static function getInstance(): self {
        if (self::$_instance == null) {
            self::$_instance = new App();
        }

        return self::$_instance;
    }

    public function run(): void {
        $this->init();
        $this->autoLoad();
        $this->config();
        $this->dispatch();
    }

    private function init(): void {
        define('DS', DIRECTORY_SEPARATOR);
        define('ROOTDIRECTORY', __DIR__ . DS . '..' . DS . '..' . DS);
    }

    private function autoLoad(): void {
        ClassLoader::registerAutoLoad();
    }

    private function config(): void {
        $GLOBALS['config'] = new Config();
    }

    private function dispatch(): void {
        $url = $this->parseUrl();

        if(file_exists(ROOTDIRECTORY . 'App' . DS .'Controllers' . DS . ucfirst($url[0]) . 'Controller.php')){
            $this->controller = 'App\Controllers\\' . ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        }

        $this->controller = new $this->controller();

        if(isset($url[1])){
            $action = $url[1] . 'Action';
            if(method_exists($this->controller, $action)){
                $this->method = $action;
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}