<htmt>
<body>
<h2>STUDENT FORM</h2>
<form method="post">
<table border="1" cellpadding="8">
<tr>
<td>Name</td>
<td><input type="text" name="name"></td>
</tr>
<tr>
<td>Email Id</td>
<td><input type="email" name="email"></td>
</tr>
<tr>
<td>Address</td>
<td><input type="text" name="address"></td>
</tr>
<tr>
<td>Gender</td>
<td>
<input type="radio" name="gender" value="male">Male
<input type="radio" name="gender" value="female">female
</td>
</tr>
<tr>
<td>DATE OF BIRTH</td>
<td><input type="date" name="dob"></td>
</tr>
<tr>
<td colspan="2"align="center">
<input type="submit" name="submit" value="submit">
</td>
</tr>
</table>
</form>
<?php
if(isset($_REQUEST['submit']))
{
?>
<h2>Student Details</h2>
<table border="1" cellpadding="8">
<tr>
<td>Name</td>
<td><?php echo $_REQUEST['name'];?></td>
</tr>
<tr>
<td>Email Id</td>
<td><?php echo $_REQUEST['email'];?></td>
</tr>
<tr>
<td>Address</td>
<td><?php echo $_REQUEST['address'];?></td>
</tr>

<tr>
<td>Gender</td>
<td><?php echo $_REQUEST['gender'];?></td>
</tr>



<tr>
<td>Date Of Birth</td>
<td><?php echo $_REQUEST['dob'];?></td>
</tr>
</table>
<?php
}
?>
</body>
</html>



