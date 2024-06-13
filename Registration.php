<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>
<body>
    <h2>Registration Form</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ensure db_connection.php is included
        $db_connection_path = 'db_connection.php';
        if (file_exists($db_connection_path)) {
            include $db_connection_path;
        } else {
            die("Error: Database connection file not found.");
        }

        $firstname = $conn->real_escape_string($_POST['firstname']);
        $lastname = $conn->real_escape_string($_POST['lastname']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $confirm_password = $conn->real_escape_string($_POST['confirm_password']);
        $errors = [];

        if (empty($firstname)) {
            $errors[] = "First name is required.";
        }

        if (empty($lastname)) {
            $errors[] = "Last name is required.";
        }

        if (empty($email)) {
            $errors[] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if (empty($password)) {
            $errors[] = "Password is required.";
        }

        if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match.";
        }

        if (empty($errors)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO Success (firstname, lastname, email, password) VALUES ('$firstname', '$lastname', '$email', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
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
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required><br><br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
