<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function index()
    {
        return 'TEST';

        $userData = array(
            'email' => 'mhdmarwan1212@gmail.com',
            'password' => '56995699'
        );

        if(Auth::attempt($userData))
        {
            Auth::user();
        }else{
            // return back()->with('error', 'Wrong Login Details');
            return 'error';
        }
    }
}
