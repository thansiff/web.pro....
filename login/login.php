<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id, name, username, password
            FROM users WHERE username = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $username);

    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result(
        $stmt,
        $id,
        $name,
        $db_username,
        $db_password
    );

    if (mysqli_stmt_fetch($stmt)) {

        if (password_verify($password, $db_password)) {

            session_regenerate_id(true);

            $_SESSION['user_id'] = $id;
            $_SESSION['name'] = $name;
            $_SESSION['username'] = $db_username;

            mysqli_stmt_close($stmt);

            header("Location: welcome.php");
            exit();
        }
        else {
            $error = "Invalid username or password!";
        }
    }
    else {
        $error = "Invalid username or password!";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>

    <style>
        body {
            font-family: Arial;
            background: #eeeeee;
        }

        .container {
            width: 320px;
            margin: 100px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h2 {
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            box-sizing: border-box;
        }

        .password-box {
            display: flex;
            gap: 5px;
        }

        .password-box input {
            flex: 1;
            min-width: 0;
        }

        button {
            padding: 10px;
            cursor: pointer;
        }

        .submit {
            width: 100%;
            background: #2878d0;
            color: white;
            border: none;
        }

        .error {
            color: red;
            text-align: center;
        }

        .success {
            color: green;
            text-align: center;
        }

        .link {
            text-align: center;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>LOGIN</h2>

    <?php if (isset($_GET['registered'])) { ?>
        <p class="success">Registration successful! Please login.</p>
    <?php } ?>

    <?php if ($error != "") { ?>
        <p class="error">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php } ?>

    <form method="POST">

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>

        <div class="password-box">
            <input type="password" name="password"
                   id="login_password" required>

            <button type="button"
                    onclick="togglePassword()">
                Show
            </button>
        </div>

        <button type="submit" class="submit">
            Login
        </button>

    </form>

    <p class="link">
        Don't have an account?
        <a href="register.php">Create New Account</a>
    </p>

</div>

<script>
function togglePassword() {
    var input = document.getElementById("login_password");
    var button = input.nextElementSibling;

    if (input.type === "password") {
        input.type = "text";
        button.innerHTML = "Hide";
    } else {
        input.type = "password";
        button.innerHTML = "Show";
    }
}
</script>

</body>
</html>
