<?php include 'header.html'; ?>

    <h1>On this page u can register a superuser to check how I did task</h1>
    <form action="../Controllers/create_superuser.php" method="post">
        <input type="text" name="login" placeholder="Login" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="confirm_password" placeholder="Confirm password" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <button type="submit">Register</button>
    </form>
    
<?php include 'footer.html'; ?>
    
