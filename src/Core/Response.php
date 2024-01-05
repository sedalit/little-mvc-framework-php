<?php

namespace Sedalit\LittleMvcFramework\Core;

class Response{
    public function setResponseStatus(int $statusCode){
        http_response_code($statusCode);
    }
}