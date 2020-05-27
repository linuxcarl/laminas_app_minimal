<?php

namespace Application\Model;

use Laminas\Db\TableGateway\TableGateway;

class UsersTable{

    public function __contructor(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getById($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(['id'=>$id]);
        $row = $rowset->current();
        if(!$row){
            throw new \Exception("User no found with id:$id");
        }
        return $row;
    }

}