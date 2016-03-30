<div id="signup">
	<div class="head">
		<h2>Sign up</h2>
	</div>
	<div class="form">
		<form action="#" method="post">
			<div class="row">
				<div class="profile-pic">
					<img src="http://lorempixel.com/50/50/people" alt="Profile Logo">
				</div>
				<div class="description">
					<label for="profile-pic-upload">Profile logo</label>
					<span>(Optional)</span>
				</div>
				<input type="file" id="profile-pic-upload" />
			</div>
			<div class="row">
				<div class="row.left">
					<label for="first-name">First name</label>
					<input type="text" id="first-name" />
				</div>
				<div class="row.right">
					<label for="last-name">Last name</label>
					<input type="text" id="last-name" />
				</div>
			</div>
			<div class="row">
				<label for="email">Email address</label>
				<input type="text" id="email" />
			</div>
			<div class="row">
				<label for="password">Password</label>
				<input type="password" id="password" />
			</div>
<?php
/*
			<div class="row">
				<div class="description">
					<label for="plan">Choose a plan:</label>
					<span id="view-plans-link">View Plans</span>
				</div>
				<select id="plan">
					<option>Free</option>
					<option>Premium</option>
					<option>Ultimate</option>
				</select>
			</div>
*/
?>
			<div class="row register">
				<input type="submit" value="Register" />
			</div>
		</form>
	</div>
</div>
