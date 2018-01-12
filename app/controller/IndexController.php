<?php

namespace Lianni\Controller;

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $row = $this->db->fetchOne("SELECT * FROM lnsm_shop");
        var_dump($row);exit;
    }
}