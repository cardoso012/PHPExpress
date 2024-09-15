<?php

namespace PHPExpress\Exceptions;

use Exception;

class NotFoundException extends Exception
{

    public function __construct()
    {
        parent::__construct("NOT_FOUND", 404);
    }

}