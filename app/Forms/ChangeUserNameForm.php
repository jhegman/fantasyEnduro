<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ChangeUserNameForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text',[
                'label' => 'Edit your Username:',
            ])
        ->add('submit', 'submit');
    }
}