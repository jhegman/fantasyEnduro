<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CreateLeague extends Form
{
    public function buildForm()
    {
        $this->add('new_league', 'text',[
                'label' => 'Create new league:',
                'rules' => 'required|min:3',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])
            ->add('password', 'password',[
                'label' => 'Password (optional)'
            ])
            ->add('submit', 'submit');
    }
}