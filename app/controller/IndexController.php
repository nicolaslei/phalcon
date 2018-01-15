<?php

namespace Lianni\Controller;

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    /**
     * @Get('/')
     */
    public function indexAction()
    {
        /** @var \Phalcon\Acl\AdapterInterface $acl */
        $acl = $this->acl;
        // By default the action is deny access
        $acl->setDefaultAction(\Phalcon\Acl::DENY);

// You can add roles/resources/accesses to list or insert them directly in the tables

// Add roles
        //$acl->addRole(new \Phalcon\Acl\Role('Kefu'), 'Admins');

// Create the resource with its accesses
        //$acl->addResource('Products', ['insert', 'update', 'delete']);

// Allow Admins to insert products
        //$acl->allow('Kefu', 'Products', 'update');

// Do Admins are allowed to insert Products?
        var_dump($acl->isAllowed('Kefu', 'Products', 'delete'));exit;

    }
}