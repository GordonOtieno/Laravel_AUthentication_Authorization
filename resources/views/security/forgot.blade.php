<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>
</head>
<body>
 <form action="{{ url('/forgot_password') }}" method="post">
 	{{csrf_field()}}

 	@if(session('error'))
 <div>{{ session('error') }}</div> 
 	@endif

 	@if(session('success'))
     <div> {{ session('success') }}</div>
 	@endif

 	<input type="email" name="email" id="email">
 	<button type="submit">Submit</button>
 </form>
</body>
</html>