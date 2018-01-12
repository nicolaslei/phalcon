<?php

namespace Lianni\Controller;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

class ErrorController extends Controller
{
    public function route404Action()
    {
        // 只渲染action视图
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function route500Action()
    {
        // 只渲染action视图
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }
}