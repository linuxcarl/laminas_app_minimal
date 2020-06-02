<?php

namespace Application\Model;

use Laminas\Db\TableGateway\TableGateway;
use Application\Model\User;
use RuntimeException;

class UsersTable{

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    public function getAll()
    {
        $result = $this->tableGateway->select();

        return $result;
    }
    public function getById($id = 0)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(['id'=>$id]);
        $row = $rowset->current();
        if(!$row){
            throw new \Exception("User no found with id:$id");
        }
        return $row;
    }

    public function save(User $userModel, $extraData = null)
    {
        //prepare model's data
        $data = $userModel->getArrayCopy();

        if (!empty($extraData)) {
            $data = array_merge($data, $extraData);
        }
        //determines if we are dealing with existing or new model
        $id = $userModel->getId();
        
        //if parameter $data is not passed in, then we will update all properties
        if (empty($data)) {
            $data = $userModel->getArrayCopy();
        }
        
        if (empty($id)) {
            //insert new data
            $this->tableGateway->insert($data);
            
            return $this->tableGateway->getLastInsertValue();
        }
        
        if (!$this->getById($id)) {
            throw new RuntimeException(get_class($userModel) .' with id: '.$id.' not found');
        }

        //edit existing data
        $this->tableGateway->update($data, ['id' => $id]);
        return $id;
    }
    public function delete($id)
    {
        $this->tableGateway->delete(['id'=> (int) $id ]);
    }

}