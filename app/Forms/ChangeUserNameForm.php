<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ChangeUserNameForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text',[
                'label' => 'Edit your Username:',
                'rules' => 'required|min:3',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])
        ->add('submit', 'submit');
    }
}