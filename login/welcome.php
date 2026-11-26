<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome Page</title>

    <style>
        body {
            font-family: Arial;
            background: #eeeeee;
            text-align: center;
        }

        .container {
            width: 350px;
            margin: 100px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        .success {
            color: green;
        }

        button {
            padding: 10px 25px;
            background: red;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>WELCOME PAGE</h2>

    <h3>
        Welcome
        <?php echo htmlspecialchars($_SESSION['name']); ?>!
    </h3>

    <p>
        Username:
        <?php echo htmlspecialchars($_SESSION['username']); ?>
    </p>

    <h3 class="success">Login Successful!</h3>

    <a href="logout.php">
        <button>Logout</button>
    </a>

</div>

</body>
</html>
