<h2>Password Resert </h2>
<h2>{{ $user->email }}</h2>
<form action="{{ url('/reset_password/'.$user->email.'/'.$code) }}" method="post">
	Password: 
	<input type="password" name="password" id="password">
	<br><br>
	Confirm Password:
	<input type="password" name="pasword_confirm" id="password_confirm">
	<br><br>
	<button type="submit">Reset Password</button>
</form>