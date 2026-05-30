<?php include 'header.html'; ?>

    <h1>On this page u should login with superuser account to view the admin panel</h1>
    <form action="../Controllers/authorization.php" method="post">
        <input type="text" name="login" placeholder="Login" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>

<?php include 'footer.html'; ?>