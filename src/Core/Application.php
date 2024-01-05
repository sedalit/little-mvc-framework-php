<?php

namespace Sedalit\LittleMvcFramework\Core;

class Application {
    public static string $ROOT_PATH;
    public static Application $instanse;
    public Router $router;
    public Request $request;
    public Response $response;
    public function __construct(string $rootPath){
        self::$ROOT_PATH = $rootPath;
        self::$instanse = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run(){
        echo $this->router->resolve();
    }
}