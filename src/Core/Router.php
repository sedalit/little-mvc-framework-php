<?php

namespace Sedalit\LittleMvcFramework\Core;

class Router {
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response){
        $this->request = $request;
        $this->response = $response;
    }
    public function get(string $path, object|string|array $callback){
        $this->addRoute("get", $path, $callback);
    }

    public function post(string $path, object|string|array $callback){
        $this->addRoute("post", $path, $callback);
    }

    protected function addRoute(string $method, string $path, object|string|array $callback){
        $this->routes[$method][$path] = $callback;
    }

    public function resolve(){
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if (!$callback){
            $this->response->setResponseStatus(404);
            return $this->renderContent("Not found!");
            //TODO: Add view for 404
        }

        if (is_string($callback)){
            return $this->renderView($callback);
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0];
        }
        return call_user_func($callback);
    }

    public function renderView(string $view, $params = []){
        $layoutContent = $this->layoutContent();
        $viewContent = $this->view($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderContent(string $content){
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $content, $layoutContent);
    }

    protected function layoutContent(){
        ob_start();
        include_once Application::$ROOT_PATH."/app/views/layouts/main.php";
        return ob_get_clean();
    }

    protected function view(string $view, $params = []){
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_PATH."/app/views/{$view}.php";
        return ob_get_clean();
    }
}