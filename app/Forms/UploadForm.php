<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class UploadForm extends Form
{
    public function buildForm()
    {
        $this->add('race_upload', 'file')
        ->add('race_name', 'text')
        ->add('race_location', 'text')
        ->add('week', 'text')
        ->add('gender', 'select', [
            'choices' => ['Men' => 'Male', 'Women' => 'Female'],
            'selected' => 'Men',
            'empty_value' => '=== Select Gender ==='
        ])
        ->add('submit', 'submit');
    }
}
