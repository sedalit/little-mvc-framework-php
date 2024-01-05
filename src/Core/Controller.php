<?php

namespace Sedalit\LittleMvcFramework\Core;

abstract class Controller {
    public function render($view, $params = []){
        return Application::$instanse->router->renderView($view, $params);
    }
}