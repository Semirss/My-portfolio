<?php
session_start();

// Check if the form is submitted
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Load the admin credentials from the JSON file
    $data = file_get_contents('admin_credentials.json');
    $credentials = json_decode($data, true);

    // Check if the JSON data contains the "admins" key
    if (isset($credentials['admins'])) {
        $adminFound = false;

        // Loop through the admins array to find a matching username and password
        foreach ($credentials['admins'] as $admin) {
            if ($admin['username'] === $username) {
                $adminFound = true;

                // Check if the password matches
                if ($admin['password'] === $password) {
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_name'] = $username;
                    header("Location: adminpage.php"); // Redirect to admin dashboard
                    exit;
                } else {
                    $error = "Invalid password.";
                }
            }
        }

        if (!$adminFound) {
            $error = "Invalid username.";
        }
    } else {
        $error = "No admin data found in JSON file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #000;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
}

.sign-in-box {
    background: rgba(0, 0, 0, 0.8);
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 0 20px #6244C5;
    text-align: center;
    color: #6244C5;
    width: 300px;
}

.sign-in-box h1 {
    margin-bottom: 30px;
    font-size: 32px;
    color: #fff;
    text-shadow: 0 0 10px #6244C5, 0 0 20px #6244C5, 0 0 30px #6244C5;
}

.sign-in-box label {
    display: block;
    margin: 10px 0 5px;
    color: #fff;
    font-size: 16px;
    text-align: left;
}

.sign-in-box input {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: none;
    border-radius: 5px;
    background: #333;
    color: #fff;
    font-size: 16px;
}

.sign-in-box button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background:#6244C5;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
    text-shadow: 0 0 10px #6244C5, 0 0 20px #fff, 0 0 30px #fff;
}

.sign-in-box button:hover {
    background: #ff4a4a;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="sign-in-box">
            <h1>Admin Login</h1>
            <?php
                if (isset($error)) {
                    echo "<p style='color: red;'>$error</p>";
                }
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
