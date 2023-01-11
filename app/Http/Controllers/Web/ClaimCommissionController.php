<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\WakalahApplication;
use App\ClaimCommissionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimCommissionController extends Controller
{
    
    public function claim_commission()
    {
        return view('layouts.claim_commission', ['user'=> Auth::user()]);
    }

    
}
