<?php

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Application\Model\UsersTable;
use Application\Model\User;
use Application\Form\UserForm;

class UsersController extends AbstractActionController
{
    private $usersTable = null;
    public function __construct(UsersTable $usersTable)
    {
        $this->usersTable = $usersTable;
    }
    public function indexAction()
    {
        $view = new ViewModel();
        $rows = $this->usersTable->getAll();
        //$view->serVariable('userRows' $row);
        $view->userRows = $rows;
        return $view;
    }
}