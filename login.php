<?php
#session_start();
?>

<?php include 'header.php'; ?>

<div id="wrapper">
    <form action="process_post.php" method="post">
        <h2 class="sr-only">Login</h2>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Username">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary" name="command" Value="Login">Log In</button>
        <a href="register.php" class="forgot">No login information? Create an account.</a>
    </form>
</div>

<?php include 'footer.php'; ?>