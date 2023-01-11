<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
 

use Illuminate\Http\Request;

class CheckApplicationController extends Controller
{
    public function show()
    {
        return view('layouts.check_application');
    }//

    public function check_application()
    {
        return view('layouts.check_application');
    }//
}
