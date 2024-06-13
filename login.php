<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>
<body>
    <h2>Login Form</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'db_connection.php';

        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $errors = [];

        if (empty($email)) {
            $errors[] = "Email is required.";
        }

        if (empty($password)) {
            $errors[] = "Password is required.";
        }

        if (empty($errors)) {
            $sql = "SELECT * FROM Success WHERE email = '$email'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    echo "Login successful!";
                    // Here you can start a session or redirect the user
                } else {
                    echo "Incorrect password.";
                }
            } else {
                echo "No account found with that email.";
            }
        } else {
            foreach ($errors as $error) {
                echo "<p style='color:red;'>$error</p>";
            }
        }

        $conn->close();
    }
    ?>
    <form action="" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
    <p><a href="registration.php">Create an account</a></p>
    <p><a href="forgot_password.php">Forgot your password?</a></p>
</body>
</html>
