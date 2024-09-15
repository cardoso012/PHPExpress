<?php

namespace PHPExpress\Exceptions;

use Exception;

class MethodNotAllowedException extends Exception
{

    public function __construct()
    {
        parent::__construct("METHOD_NOT_ALLOWED", 405);
    }

}