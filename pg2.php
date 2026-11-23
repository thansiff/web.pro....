<html>
<head>
<title>factorial</title>
</head>
<body>
<h2>factorial of a number</h2>
<form method="post" action="">
Enter a number:
<input type="number"name="num"required>
<input type="submit" name="submit" value="find">
</form>
<?php
if(isset($_POST['submit']))
{
  $n=$_POST['num'];
  $fact=1;
 for($i=1;$i<=$n;$i++)
{
 $fact=$fact*$i;
}
 echo"Factroial of $n is $fact";
}
?>
</body>
</html>
