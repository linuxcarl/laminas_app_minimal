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
        $data = $UserModel->getArrayCopy();

        if (!empty($extraData)) {
            $data = array_merge($data, $extraData);
        }

        $id = $userModel->getId();

        if (!empty($data)) {
            $data = $userModel->getArrayCopy();
        }

        if (empty($id)) {
            $this->tableGateway->insert($data);

            return $this->tableGateway->getLastInsertValue();
        }

        if (!$this->getById($id)) {
            throw new RuntimeException(get_class($userModel). "with id: $id not found");
        }

        $this->tableGatway->update($data,['id'=>$id]);
        return $id;
    }

    public function delete($id)
    {
        $this->tableGateway->delete(['id'=> (int) $id ]);
    }

}