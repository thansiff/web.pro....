<!DOCTYPE html>
<html>
<head>
    <title>Book Information</title>
</head>
<body>

<h2>BOOK INFORMATION</h2>

<form method="POST">
    Book Number:
    <input type="number" name="book_no" required><br><br>

    Title:
    <input type="text" name="title" required><br><br>

    Edition:
    <input type="text" name="edition" required><br><br>

    Publisher:
    <input type="text" name="publisher" required><br><br>

    <input type="submit" name="submit" value="Save Book">
</form>

<?php

$conn = mysqli_connect("localhost", "root", "", "library");

if (!$conn) {
    die("Connection failed");
}

if (isset($_POST['submit'])) {

    $book_no = $_POST['book_no'];
    $title = $_POST['title'];
    $edition = $_POST['edition'];
    $publisher = $_POST['publisher'];

    $sql = "INSERT INTO book_details
    VALUES ('$book_no', '$title', '$edition', '$publisher')";

    $check = mysqli_query(
        $conn,
        "SELECT * FROM book_details WHERE book_no='$book_no'"
    );

    if (mysqli_num_rows($check) > 0) {

        echo "Error: Book Number already exists!";

    } elseif (mysqli_query($conn, $sql)) {

        echo "Book inserted successfully!";

    } else {

        echo "Error: " . mysqli_error($conn);
    }
}

echo "<h2>ALL BOOK DETAILS</h2>";

$result = mysqli_query(
    $conn,
    "SELECT * FROM book_details"
);

echo "<table border='1' cellpadding='10'>";
echo "<tr>
        <th>Book No</th>
        <th>Title</th>
        <th>Edition</th>
        <th>Publisher</th>
      </tr>";

while ($row = mysqli_fetch_assoc($result)) {

    echo "<tr>";
    echo "<td>" . $row['book_no'] . "</td>";
    echo "<td>" . $row['title'] . "</td>";
    echo "<td>" . $row['edition'] . "</td>";
    echo "<td>" . $row['publisher'] . "</td>";
    echo "</tr>";
}

echo "</table>";

mysqli_close($conn);

?>

</body>
</html>

