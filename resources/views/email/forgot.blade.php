 <h1>Hello {{$user->name}}</h1>
 <p>
 	Please click the password reset button to reset your password.
 	<a href="{{ url('reset_password/'.$user->email.'/'.$code)}}">Reset Password </a>
 </p>