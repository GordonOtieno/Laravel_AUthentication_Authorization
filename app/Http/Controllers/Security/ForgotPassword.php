<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;
use Reminder;
use App\User;
use Mail;

class ForgotPassword extends Controller
{
    public function forgot(){
     return view('security.forgot');	
    }

public function password(Request $request){
	//dd($request->all()); 
	//get email from the request, then get user information from his email.
	$user=User::whereEmail($request->email)->first();

	if($user == null){
		return redirect()->back()->with(['error'=>'Email does not exist']);
	}
	//get complete information using sentinel

  $user=Sentinel::findById($user->id); 
  //$reminder=Reminder::exists($user) ? :Reminder::create($user);

 $reminder= Reminder::create($user);
  $this->sendEmail($user, $reminder->code);

  return redirect()->back()->with(['success'=>'Password Reset code has be successfully sent to your mail']);
}

public function sendEmail($user,$code){
	Mail::send(
	'email.forgot',
	['user'=>$user, 'code'=>$code],
	function($message) use ($user){
		$message->to($user->email);
		$message->subject('Hello '. $user->name.', Reset Your password.');
	}

);
}
 public function reset($email,$code){
 	$user=User::whereEmail($email)->first();

	if($user == null){
		echo 'Email does not exist';
	}
	//get complete information using sentinel

  $user=Sentinel::findById($user->id); 
  //$reminder=Reminder::exists($user) ? :Reminder::create($user);
 $reminder= Reminder::create($user);
    if($reminder){
    	if($code==$reminder->code){
    		//with function is used to send data to the view when loaded
    		//user information ame code.
    		return view('security.reset_password_form')->with(['user'=>$user, 'code'=>$code]); 
    	}else{
    		return redirect('/');
    	}
    }else{
    	echo "Time Expired";
    }
 }
}
