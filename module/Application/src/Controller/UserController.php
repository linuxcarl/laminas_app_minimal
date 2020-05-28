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
    public function addAction()
    {
        $request = $this->getRequest();
        $userForm = new UserForm();
        $userForm->get('submit')->setValue('Add');
        if(!$request->isPost()){
            return ['userForm' => $userForm];
        }

        $userModel = new User();
        $userForm->setInputFilter($userModel->getInputFilter());
        $userForm->setData($request->getPost());
        if(!$userForm->isValid()){
            return ['userForm'=> $userModel];
        }

        $userModel->exchangeArray($userForm->getData());
        $this->usersTable->save($userModel);
        return $this->redirect()->toRoute('users');
    }

    public function editAction()
    {
        $view =  new ViewModel();
        //get the id from url
        $IdUser = (int)$this->params()->fromRoute('id');
        $view->setVariable('IdUser',$IdUser);
        //check if user id is not set and them move the user back to add action
        if ( 0 === $IdUser) {
            return $this->redirect()->toRoute('users',['action'=> 'add']);
        }
        //find user by id which might throw an Exception for not found user
        try {
            $userRow = $this->usersTable->getById($IdUser);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('users',['action'=> 'index']);
        }

        //create new form
        $userForm = new UserForm();
        //assign attributes to form from user object
        $userForm->bind($userRow);
        $userForm->get('submit')->setAttribute('value','save');
        $view->setVariable('userForm',$userForm);

        $request = $this->getRequest();

        if ( !$request->isPost()) {
            return $view;
        }
        //set form validations
        $userForm->setInputFilter($userRow->getInputFilter());
        //set new form data
        $userForm->setData($request->getPost());
        //make sure the data is correct
        if (!$userForm->isValid()) {
            return $view;
        }
        //save the new changes
        $this->usersTable->save($userRow);
        //redirect back to index action of users controller
        return $this->redirect()->toRoute('users',['action'=>'index']);
    }
}