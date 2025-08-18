<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    /**
     * Display the Terms of Service page.
     *
     * @return \Illuminate\View\View
     */
    public function terms()
    {
        return view('legal.terms');
    }

    /**
     * Display the Privacy Policy page.
     *
     * @return \Illuminate\View\View
     */
    public function privacy()
    {
        return view('legal.privacy');
    }

    /**
     * Display the Contact Us page.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('legal.contact');
    }
} 