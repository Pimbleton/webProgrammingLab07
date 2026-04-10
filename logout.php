<!DOCTYPE html>
<html>
    <head>
        <title>Successful logout!</title>
    </head>

    <body>
        <p>You have successfully logged out.</p>
        <p>Sending you back to the home page...</p>
    </body>
</html>

<?php
    // Start session.
    session_start();

    // Unset all of the session variables.
    $_SESSION = array();

    // Destroy the session.
    session_destroy();

    // Redirect to home page.
    header("refresh: 3; url = index.php");
    exit();
?>