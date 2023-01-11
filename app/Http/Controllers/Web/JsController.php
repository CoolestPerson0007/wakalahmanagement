<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use Response;

class JsController extends Controller
{
    public function dynamic()
    {
        $contents = View::make('js.dynamic');
        $response = Response::make($contents, 200);
        $response->header('Content-Type', 'application/javascript');
        return $response;
    }
}
