<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class UploadForm extends Form
{
    public function buildForm()
    {
        $this->add('race_upload', 'file')
        ->add('submit', 'submit');
    }
}
