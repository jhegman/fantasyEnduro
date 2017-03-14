<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactForm;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Render Contact Form
     * @return Contact Form view
     */
    public function contactForm()
    {
        return view('misc.contact');
    }

    public function contactFormSubmitted(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        Mail::to('phegman@icloud.com, jack.hegman@gmail.com')->send(new ContactForm($request));

        return view('misc.contact-submitted');
    }
}