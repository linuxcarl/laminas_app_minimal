<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Application\Model\User; 
use Application\Model\UsersTable; 
use Laminas\Db\ResultSet\ResultSet; 
use Laminas\Db\TableGateway\TableGateway;


class Module
{
    public function getConfig() : array
    {
        //$config = new \Laminas\Config\Config(include __DIR__ . '/../config/debug_config.php'); //line below will return: true echo $config->display_errors;
        //we can also get to the same value by using a get() method like so:
        // echo $config->get('display_errors');

        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig() {
        return array('factories' => array(
            'UsersTableGateway' => function ($sm) {
                $dbAdapter = $sm->get('Laminas\Db\Adapter\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new User());
                return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
            ​​},
            'Application\Model\UsersTable' => function($sm) {
                $tableGateway = $sm->get('UsersTableGateway');​​​
                $table = new UsersTable($tableGateway);
                return $table;​​
            } 
           ) 
       );
    }
}
