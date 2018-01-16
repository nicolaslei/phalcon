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
        return $this->response
            ->setJsonContent(['ss']);
    }
}