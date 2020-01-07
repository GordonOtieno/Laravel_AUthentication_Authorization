<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;
use Validator;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

class LoginController extends Controller
{
   public function login(){
   	//if already logged in then return to home url. Should redirect to dashboard.
   	if(Sentinel::check()){
   		return redirect(url('/'));  
   	}
   	return view('security.login');
   } //

   public function postLogin(Request $request){
   	//Sentinel::disableCheckpoints();
   	 $errorMsgs=[
    'email.required'=>'please provide email address',
    'email.email'=>'The email must be a valid Email',
    'password.required'=>'Password field is required'
   	 ];

$validator=Validator::make($request->all(),[
 'email'=>'required|email',
 'password'=>'required'

], $errorMsgs);

if($validator->fails()){
	$returnData=array(
  'status'=>'error',
  'message'=>'Please review fields',
  'errors'=>$validator->errors()->all()
	);
	//return response()->json($returnData,500);
  return redirect()->back()->with(['errors'=>$validator->errors()->all()]);
}
 if($request->remember=='on'){
 	try{
 		$user=Sentinel::authenticate($request->all());
 	}catch(ThrottlingException $e){
 		$delay=$e->getDelay();
 		$returnData=array(
         'status'=>'error',
		  'message'=>'Please review',
		  'errors'=>["You are bunned for $delay Seconds"]
 		);
 		//return response()->json($returnData,500);
    return redirect()->back()->with(['errors'=>"You are bunned for $delay Seconds"]);

 	}catch(NotActivatedException $e){
     $returnData=array(
         'status'=>'error',
		  'message'=>'Please review',
		  'errors'=>["Your Account Is Not Ativated. Please Activate your account"]
 		);
     //return response()->json($returnData,500);
     return redirect()->back()->with(['errors'=>"Your Account Is Not Ativated. Please Activate your account"]);
 	}
 }

 else{

 	try{
 		$user=Sentinel::authenticate($request->all());
 	}catch(ThrottlingException $e){
 		$delay=$e->getDelay();
 		$returnData=array(
         'status'=>'error',
		  'message'=>'Please review',
		  'errors'=>["You are bunned for $delay Seconds"]
 		);
 		//return response()->json($returnData,500);
     return redirect()->back()->with([ 'errors'=>"You are bunned for $delay Seconds"]);
  }

 	catch(NotActivatedException $e){
     $returnData=array(
         'status'=>'error',
		  'message'=>'Please review',
		  'errors'=>["Please Activate your account"]
 		);
     //return response()->json($returnData,500);

     return redirect()->back()->with(['errors'=>"Your Account Is Not activated. Please Activate your account"]);
 	}
 }
 if (Sentinel::check()){
 	return redirect(url('/'));
 }else{
 
 $returnData=array(
         'status'=>'error',
		  'message'=>'Please review',
		  'errors'=>["Email or Password is incorrect"]
 		);
    // return response()->json($returnData,500);
 return redirect()->back()->with(['errors'=>"Email or Password is incorrect"]);
 }
   }
   public function logout(){
   	Sentinel::logout();
   	return redirect(url('/login'));
   }
}
