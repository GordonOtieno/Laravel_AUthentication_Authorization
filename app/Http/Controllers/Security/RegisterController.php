<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;
use Activation;
use App\User;
use App\Models\Roles\RoleModel;
use Mail;
 
class RegisterController extends Controller
{
   public function register(){
   	$data['roles']=RoleModel::get();
   	return view('security.register')->with('data',$data);	
   	// open the register file and damn the data.
   }

public function registerUser(Request $request){
	//this display every data yet to be submitted
	//dd($request->all());
	$data=$request->all();
	$roleID=$data['role'];
	//echo $roleID;
//exit();
	$user=Sentinel::register($request->all());
	//code to activate the user. it will generate activation code for the user
	//adding multiple roles loop between these code
	$role=Sentinel::findRoleByID($roleID);
	$role->users()->attach($user);

    $activate=Activation::create($user);
	//send email to user for activation
	$this->sendActivationEmail($user,$activate->code);
	return redirect('/');  
 
}

public function sendActivationEmail($user,$code){
	//email syntax
Mail::send(
	'email.activation',
	['user'=>$user, 'code'=>$code],
	function($message) use ($user){
		$message->to($user->email);
		$message->subject('Hello '. $user->name.', Activate your acount.');
	}

);
}

}
