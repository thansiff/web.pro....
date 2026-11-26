<!DOCTYPE html>
<html>
<head>
    <title>Employee Details</title>
</head>
<body>

<h2>EMPLOYEE DETAILS</h2>

<form method="POST">

    Employee ID:
    <input type="number" name="emp_id" required>
    <br><br>

    Employee Name:
    <input type="text" name="emp_name" required>
    <br><br>

    Designation:
    <input type="text" name="designation" required>
    <br><br>

    Salary:
    <input type="number" name="salary" required>
    <br><br>

    Email:
    <input type="email" name="email" required>
    <br><br>

    <input type="submit" name="submit"
           value="Save Employee">

</form>

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "employee_db"
);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

echo "<p>Database Connected Successfully!</p>";

if (isset($_POST['submit'])) {

    $emp_id = $_POST['emp_id'];
    $emp_name = $_POST['emp_name'];
    $designation = $_POST['designation'];
    $salary = $_POST['salary'];
    $email = $_POST['email'];

    $sql = "INSERT INTO employees
    (emp_id, emp_name, designation, salary, email)
    VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Prepare Error: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "issis",
        $emp_id,
        $emp_name,
        $designation,
        $salary,
        $email
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "<p>Employee Details Inserted Successfully!</p>";
    } else {
        echo "<p>Error: " .
        htmlspecialchars(mysqli_stmt_error($stmt)) . "</p>";
    }

    mysqli_stmt_close($stmt);
}

echo "<h2>ALL EMPLOYEE DETAILS</h2>";

$result = mysqli_query(
    $conn,
    "SELECT * FROM employees"
);

if (!$result) {
    die("Select Error: " . mysqli_error($conn));
}

echo "<table border='1' cellpadding='10'>";

echo "<tr>
<th>Employee ID</th>
<th>Name</th>
<th>Designation</th>
<th>Salary</th>
<th>Email</th>
</tr>";

while ($row = mysqli_fetch_assoc($result)) {

    echo "<tr>";

    echo "<td>" . htmlspecialchars($row['emp_id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['emp_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['designation']) . "</td>";
    echo "<td>" . htmlspecialchars($row['salary']) . "</td>";
    echo "<td>" . htmlspecialchars($row['email']) . "</td>";

    echo "</tr>";
}

echo "</table>";

mysqli_close($conn);

?>

</body>
</html>
