<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuPrincipalController extends Controller
{
    public function index(){

        if(!Auth::check()){
            return redirect()->route('sistema.login');
        }

        return view('sistema.menuPrincipal');
    }
}
