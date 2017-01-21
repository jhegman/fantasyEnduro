<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ChangeUserNameForm extends Form
{
    public function buildForm()
    {
        $this->add('edit_your_username', 'text',[
                'label' => 'Edit your Username:',
                'rules' => 'required|min:3',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])
        ->add('submit', 'submit');
    }
}