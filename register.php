<?php
#session_start();
?>

<?php include 'header.php'; ?>

<div id="wrapper">
    <form action="process_post.php" method="post">
    <h2 class="sr-only">Register</h2>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Username">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Password">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
        </div>
        <button type="submit" class="btn btn-primary" name="command" Value="Register">Sign Up</button>
        <a href="login.php" class="forgot">Have an account already? Login here.</a>
</form>
</div>


<?php include 'footer.php'; ?>