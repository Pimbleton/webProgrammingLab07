<!DOCTYPE html>
<html>
    <head>
        <title>Registration</title>
    </head>

    <body>
        <h2>Registration Page</h2>

        <form action="registration.php" method="post">
            <label for="uname">User Name:</label>
            <input type="text" id="uname" name="uname" value=""><br>

            <label for="psw">Password:</label>
            <input type="password" id="psw" name="psw" value=""><br>

            <label for="psw2">Reenter Password:</label>
            <input type="password" id="psw2" name="psw2" value=""><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value=""><br>

            <input type="submit" name="login" value="Submit">
        </form>
    </body>
</html>

<?php
    // Start session.
    session_start();

    // If the user is already logged in, redirect to home page.
    if (isset($_SESSION["username"])) {
        header("Location: home.php");
        exit();
    }

    // Link vars file and connect to DB.
    include('/home/hah1049/PHP-Includes/php-vars.inc');
    $conn = mysqli_connect($db_server, $user, $password, $db_names);

    // Check if login button is clicked.
    if (isset($_POST["login"])) {

        // Pull the data from the form and sanitize it.
        $username = trim(addslashes($_POST["uname"]));
        $passcode = trim(addslashes($_POST["psw"]));
        $passcode2 = trim(addslashes($_POST["psw2"]));
        $email = trim(addslashes($_POST["email"]));

        // Checks whether either of the three fields are empty.
        if (!empty($username) && !empty($passcode) && !empty($passcode2)) {
            
            // Checks that both password fields match.
            if ($passcode == $passcode2) {
                // Prepare the INSERT statement with placeholder ?s.
                $sql_string = "INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)";
                
                // Prepare the statement.
                $stmt = mysqli_prepare($conn, $sql_string);

                // Bind the variables to the placeholder ?s in the staement, then execute it.
                mysqli_stmt_bind_param($stmt, "sss", $username, $passcode, $email);
                mysqli_stmt_execute($stmt);

                echo "User data is registered! Go to the <a href='login.php'>login page</a> to log in.";

                // Close the statement.
                mysqli_stmt_close($stmt);
            } else {
                echo "Error: Passwords do not match. Please try again. <br>";
            }
        } else {
            echo "Missing username or password. Please fill in all fields.<br>";
        }
    } else {
        echo "Waiting for entry...";
    }

    // Close the connection.
    mysqli_close($conn);
?>