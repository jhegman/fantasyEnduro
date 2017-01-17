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
        ->add('languages', 'select', [
    'choices' => ['male' => 'Male', 'female' => 'Female'],
    'selected' => 'male',
    'empty_value' => '=== Select Gender ==='
	])
        ->add('submit', 'submit');
    }
}
