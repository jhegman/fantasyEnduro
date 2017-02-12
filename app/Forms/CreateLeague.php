<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CreateLeague extends Form
{
    public function buildForm()
    {
        $this->add('new_league', 'text',[
                'label' => 'League name:',
            ])
            ->add('password', 'password',[
                'label' => 'Password (optional)'
            ])
            ->add('submit', 'submit');
    }
}