<?php

namespace Lianni\Controller;

use Phalcon\Mvc\Controller;

class TestController extends Controller
{
    /**
     * @Get('/test')
     */
    public function indexAction()
    {
        echo __FILE__;exit;
    }
}