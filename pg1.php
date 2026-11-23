<html>
<body>
<form method="GET">
Enter a number :
<input type="number" name="num">
<input type="submit" value="check">
</form>
<?php
if(isset($_GET['num']))
{
 $n=$_GET['num'];
if($n % 2==0)
{
   echo"The number is even";
}
else
{
   echo"The number is odd";
}
}
?>
</body>
</html>

