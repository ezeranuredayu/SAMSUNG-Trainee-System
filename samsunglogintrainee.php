<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SAMSUNG Trainee System</title>
	
<link rel="shortcut icon" href="images/logo.png" />
<style>

*,
*::before,
*::after {
	box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Roboto, -apple-system, 'Helvetica Neue', 'Segoe UI', Arial, sans-serif;
}

#background-image {
    position: fixed;
    top: 0;
    left: 0;
    min-width: 100%;
    min-height: 100%;
    width: auto;
    height: auto;
    z-index: -1;
    background-image: url('images/back.jpg'); 
    background-size: cover;
    background-position: center;
}

.content {
    position: relative;
    z-index: 1;
    color: white;
    text-align: center;
    padding-top: 200px;
}

.forms-section {
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
}

.section-title {
	font-size: 32px;
	letter-spacing: 1px;
	color: #fff;
	margin-bottom: 0px;
}

.forms {
	display: flex;
	align-items: flex-start;
	margin-top: 30px;
}

.form-wrapper {
	animation: hideLayer .3s ease-out forwards;
}

.form-wrapper.is-active {
	animation: showLayer .3s ease-in forwards;
}

@keyframes showLayer {
	50% {
		z-index: 1;
	}
	100% {
		z-index: 1;
	}
}

@keyframes hideLayer {
	0% {
		z-index: 1;
	}
	49.999% {
		z-index: 1;
	}
}

.switcher {
	position: relative;
	cursor: pointer;
	display: block;
	margin-right: auto;
	margin-left: auto;
	padding: 0;
	text-transform: uppercase;
	font-family: inherit;
	font-size: 16px;
	letter-spacing: .5px;
	color: #999;
	background-color: transparent;
	border: none;
	outline: none;
	transform: translateX(0);
	transition: all .3s ease-out;
	margin-bottom: 0px;
}

.form-wrapper.is-active .switcher-login {
	color: #000000;
	font-weight: bold;
	transform: translateX(90px);
}

.form-wrapper.is-active .switcher-signup {
	color: #000000;
	font-weight: bold;
	transform: translateX(-90px);
}

.underline {
	position: absolute;
	bottom: -5px;
	left: 0;
	overflow: hidden;
	pointer-events: none;
	width: 100%;
	height: 2px;
}

.underline::before {
	content: '';
	position: absolute;
	top: 0;
	left: inherit;
	display: block;
	width: inherit;
	height: inherit;
	background-color: currentColor;
	transition: transform .2s ease-out;
}

.switcher-login .underline::before {
	transform: translateX(101%);
}

.switcher-signup .underline::before {
	transform: translateX(-101%);
}

.form-wrapper.is-active .underline::before {
	transform: translateX(0);
}

.form {
	overflow: hidden;
	min-width: 260px;
	margin-top: 50px;
	padding: 30px 25px;
  border-radius: 5px;
	transform-origin: top;
}

.form-login {
	animation: hideLogin .3s ease-out forwards;
}

.form-wrapper.is-active .form-login {
	animation: showLogin .3s ease-in forwards;
}

@keyframes showLogin {
	0% {
		background: #FAEBD7;
		transform: translate(40%, 10px);
	}
	50% {
		transform: translate(0, 0);
	}
	100% {
		background-color: #fff;
		transform: translate(35%, -20px);
	}
}

@keyframes hideLogin {
	0% {
		background-color: #fff;
		transform: translate(35%, -20px);
	}
	50% {
		transform: translate(0, 0);
	}
	100% {
		background: #cfecf7;
		transform: translate(40%, 10px);
	}
}

.form-signup {
	animation: hideSignup .3s ease-out forwards;
}

.form-wrapper.is-active .form-signup {
	animation: showSignup .3s ease-in forwards;
}

@keyframes showSignup {
	0% {
		background: #FAEBD7;
		transform: translate(-40%, 10px) scaleY(.8);
	}
	50% {
		transform: translate(0, 0) scaleY(.8);
	}
	100% {
		background-color: #fff;
		transform: translate(-35%, -20px) scaleY(1);
	}
}

@keyframes hideSignup {
	0% {
		background-color: #fff;
		transform: translate(-35%, -20px) scaleY(1);
	}
	50% {
		transform: translate(0, 0) scaleY(.8);
	}
	100% {
		background: #cfecf7;
		transform: translate(-40%, 10px) scaleY(.8);
	}
}

.form fieldset {
	position: relative;
	opacity: 0;
	margin: 0;
	padding: 0;
	border: 0;
	transition: all .3s ease-out;
}

.form-login fieldset {
	transform: translateX(-50%);
}

.form-signup fieldset {
	transform: translateX(50%);
}

.form-wrapper.is-active fieldset {
	opacity: 1;
	transform: translateX(0);
	transition: opacity .4s ease-in, transform .35s ease-in;
}

.form legend {
	position: absolute;
	overflow: hidden;
	width: 1px;
	height: 1px;
	clip: rect(0 0 0 0);
}

.input-block {
	margin-bottom: 20px;
}

.input-block label {
	font-size: 14px;
	color: #000000;
}

.input-block input {
	display: block;
	width: 100%;
	margin-top: 8px;
	padding-right: 15px;
	padding-left: 15px;
	font-size: 16px;
	line-height: 40px;
	color: black;
	background: #336699;
	border: 1px solid #FFFFF0;
	border-radius: 2px;
}

.form [type='submit'] {
	opacity: 0;
	display: block;
	min-width: 120px;
	margin: 30px auto 10px;
	font-size: 18px;
	line-height: 40px;
	border-radius: 25px;
	border: none;
	transition: all .3s ease-out;
}

.form-wrapper.is-active .form [type='submit'] {
	opacity: 1;
	transform: translateX(0);
	transition: all .4s ease-in;
}

.btn-login {
	color: #fbfdff;
	background: #000000;
	transform: translateX(-30%);
}

.btn-signup {
	color: #fbfbff;
	background: #000000;
	transform: translateX(-30%);
}

a:link, a:visited {
	background-color: #336699;
	color: white;
	padding: 10px 30px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
}

a:hover, a:active {
	background-color: black;
}

</style>
</head>

<body>
	<div id="background-image"></div>

	<section class="forms-section"><br>
		<img class="jarallax-img" src="images/logo 1.png" alt="">

		<button type="button" class="switcher switcher-login">
			<p><a href="index.php" style="color: #ffffff">&nbsp;&nbsp;Staff&nbsp;&nbsp;</a> &emsp;
			<a href="samsunglogintrainee.php" style="color: #ffffff">Trainee</a></p>
		</button>

		<h1 id="form-title" class="section-title" style="color: #336699; margin: 0; padding: 0; line-height: 1;">
			Trainee Login
		</h1><br>

		<div class="forms" style="margin-top: 0;">
			<div class="form-wrapper is-active">
				<button type="button" class="switcher switcher-login">
					Login
					<span class="underline"></span>
				</button>
				<form class="form form-login" method="post" action="data1.php">
					<fieldset>
						<legend>Please, enter your email and password for login.</legend>

						<div class="input-block">
							<label for="login-email">Username</label>
							<input id="login-email" style="color: #ffffff" type="text" name="username" required>
						</div>

						<div class="input-block">
							<label for="login-password">Password</label>
							<input id="login-password" style="color: #ffffff" type="password" name="password" required>
						</div>
						
						<div style="text-align: right; margin-top: -10px; margin-bottom: 15px;">
  							<a href="forgotpasswordt.php" style="font-size: 14px; color: #336699; text-decoration: underline; background: none; border: none; padding: 0; display: inline;">Forgot Password?</a>
						</div>
						
					</fieldset>
					<button type="submit" name="submit" class="btn-login">Login</button>
				</form>
			</div>

			<div class="form-wrapper">
				<button type="button" class="switcher switcher-signup">
					Sign Up
					<span class="underline"></span>
				</button>
				<form class="form form-signup" method="post" action="newtrainee.php" onsubmit="return handleSubmit();">
					<fieldset>
						<legend>Please, enter your information to confirm your sign up.</legend>

						<div class="input-block">
							<label for="signup-fn">Full Name</label>
							<input id="signup-fn" style="color: #ffffff" type="text" name="trainee_name" required>
						</div>

						<div class="input-block">
							<label for="signup-ph">Phone Number</label>
							<input id="signup-ph" style="color: #ffffff" type="tel" name="trainee_phone" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
						</div>

						<div class="input-block">
							<label for="signup-email">Email</label>
							<input id="signup-email" style="color: #ffffff" type="email" name="trainee_email" required>
						</div>

						<div class="input-block">
							<label for="signup-username">Username</label>
							<input id="signup-username" style="color: #ffffff" type="text" name="trainee_username" required>
						</div>

						<div class="input-block">
							<label for="signup-password">Password</label>
							<input id="signup-password" style="color: #ffffff" type="password" name="trainee_password" required>
						</div>
					</fieldset>
					<button type="submit" name="signin" value="submit" class="btn-login">Sign Up</button>
				</form>
			</div>
		</div>
	</section>

	<script>
	const switchers = [...document.querySelectorAll('.switcher')];
	const formTitle = document.getElementById('form-title');

	switchers.forEach(item => {
		item.addEventListener('click', function() {
			switchers.forEach(item => item.parentElement.classList.remove('is-active'));
			this.parentElement.classList.add('is-active');

			if (this.classList.contains('switcher-login')) {
				formTitle.innerText = 'Trainee Login';
			} else if (this.classList.contains('switcher-signup')) {
				formTitle.innerText = 'Trainee Sign Up';
			}
		});
	});

	function handleSubmit() {
		alert('Trainee Successfully Signed Up! Please try to log in.');
		return true; 
	}
	</script>
</body>
</html>
