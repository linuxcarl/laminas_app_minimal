<?php 

namespace Application\Controller;

class UserForm extends \Laminas\Form\Form
{
    public function __contruct($name = 'user')
    {
        parent::__contruct($name);
        
        $this->add([
            'name' => 'id',
            'type'=>'hidden'
        ]);
        
        $this->add([
            'name' => 'username',
            'type'=>'text',
            'options' => [
                'label' => 'Username'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type'=>'submit',
            'atributes' => [
                'value'=>'Save',
                'id'=> 'saveUserForm'
            ]
        ]);
        //by default its also POST
        $this->setAttribute('method','POST');
    }
}
private function createForm($ArrayForm=[])
{
    # code...
}