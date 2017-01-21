<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ChangeUserNameForm extends Form
{
    public function buildForm()
    {
        $this->add('edit_your_username', 'text')
        ->add('submit', 'submit');
    }
}