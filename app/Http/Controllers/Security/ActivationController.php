<?php

namespace App\Http\Controllers\security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User; 
use Sentinel;
use Activation;
class ActivationController extends Controller
{
   public function activate($email,$code)
   {

   	$user=User::whereEmail($email)->first();
   	$user=Sentinel::findById($user->id);
    
    if(Activation::complete($user,$code)){
    	return redirect(url('/login'));
    }

   }
}
