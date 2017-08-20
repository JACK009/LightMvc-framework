<?php
namespace App\LightMvc\Core;
use App\Config\Config;

include_once 'ClassLoader.php';

class App {
    protected $controller = 'App\Controllers\HomeController';
    protected $method = 'indexAction';
    protected $params = [];

    private static $_instance = null;

    public function __construct()
    {
        ClassLoader::registerAutoLoad();
        $config = new Config();

        if(!empty($config->indexPage)) {
            $this->controller = 'App\Controllers\\' . ucfirst($config->indexPage['controller']) . 'Controller';
            $this->method = $config->indexPage['action'] . 'Action';
        }
    }

    private function parseUrl() {
        if(isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }

    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    public function run() {
        $url = $this->parseUrl();

        if(file_exists(ROOTDIRECTORY .'\Controllers\\' . ucfirst($url[0]) . 'Controller.php')){
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