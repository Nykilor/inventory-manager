<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InertiaTestController extends Controller
{
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function __invoke()
    {
        return true;
    }
}
