<?php
include "db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $dob = $_POST['dob'];
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check empty fields
    if (
        empty($name) || empty($dob) ||
        empty($username) || empty($password) ||
        empty($confirm_password)
    ) {
        $error = "Please fill all fields.";
    }

    // Check whether passwords match
    elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    }

    // Check date of birth
    else {
        $birthDate = DateTime::createFromFormat('!Y-m-d', $dob);
        $today = new DateTime('today');

        if (
            !$birthDate ||
            $birthDate->format('Y-m-d') !== $dob ||
            $birthDate > $today
        ) {
            $error = "Please enter a valid date of birth.";
        }
        else {
            $age = $birthDate->diff($today)->y;

            // Age must be greater than 18
            if ($age <= 18) {
                $error = "Registration allowed only above 18 years.";
            }

            // Check password strength
            elseif (!preg_match(
                '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9]).{8,}$/',
                $password
            )) {
                $error = "Password must contain uppercase, lowercase, number, special character and at least 8 characters.";
            }

            else {
                // Hash password
                $hashed_password = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                // Insert user details
                $sql = "INSERT INTO users
                        (name, dob, username, password)
                        VALUES (?, ?, ?, ?)";

                $stmt = mysqli_prepare($conn, $sql);

                mysqli_stmt_bind_param(
                    $stmt,
                    "ssss",
                    $name,
                    $dob,
                    $username,
                    $hashed_password
                );

                if (mysqli_stmt_execute($stmt)) {
                    header("Location: login.php?registered=1");
                    exit();
                }
                else {
                    if (mysqli_stmt_errno($stmt) == 1062) {
                        $error = "Username already exists!";
                    }
                    else {
                        $error = "Registration failed. Please try again.";
                    }
                }

                mysqli_stmt_close($stmt);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>

    <style>
        body {
            font-family: Arial;
            background: #eeeeee;
        }

        .container {
            width: 350px;
            margin: 40px auto;
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

        .password-box {
            display: flex;
            gap: 5px;
        }

        .password-box input {
            flex: 1;
            min-width: 0;
        }

        .error {
            color: red;
            text-align: center;
        }

        .link {
            text-align: center;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>CREATE ACCOUNT</h2>

    <?php if ($error != "") { ?>
        <p class="error">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php } ?>

    <form method="POST">

        <label>Name</label>
        <input type="text" name="name"
               value="<?php echo htmlspecialchars($name ?? ''); ?>"
               required>

        <label>Date of Birth</label>
        <input type="date" name="dob"
               value="<?php echo htmlspecialchars($dob ?? ''); ?>"
               required>

        <label>Username</label>
        <input type="text" name="username"
               value="<?php echo htmlspecialchars($username ?? ''); ?>"
               required>

        <label>Password</label>

        <div class="password-box">
            <input type="password" name="password"
                   id="password" required>

            <button type="button"
                    onclick="togglePassword('password', this)">
                Show
            </button>
        </div>

        <label>Confirm Password</label>

        <div class="password-box">
            <input type="password" name="confirm_password"
                   id="confirm_password" required>

            <button type="button"
                    onclick="togglePassword('confirm_password', this)">
                Show
            </button>
        </div>

        <p>
            <small>
                Password must contain uppercase, lowercase,
                number, special character and minimum 8 characters.
            </small>
        </p>

        <button type="submit" class="submit">
            Register
        </button>

    </form>

    <p class="link">
        Already have an account?
        <a href="login.php">Login</a>
    </p>

</div>

<script>
function togglePassword(id, button) {
    var input = document.getElementById(id);

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
