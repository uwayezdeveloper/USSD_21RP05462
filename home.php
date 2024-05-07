<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="fontawesome-free-6.4.0-web (1)\fontawesome-free-6.4.0-web/css/all.css">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
    <title>Hostel  Reservation System</title>
</head>
<body>
<center> <h1>Hostel Reservation System</h1></center>
<center>login to HRS
    <fieldset style="border: double; width: 400px; height: 200px;">
<br>
<form class="form-group" method="POST" action="process2.php">
<strong class="form_control ">user email</strong>
<input type="email" name="email" ><br><br>
<strong><i class="fa fa-key" style="color: green;">&nbsp</i>user password</strong>
<input type="password" name="password">
<br><br>
<input type="submit" name="login" value="Unlock" class="btn btn-primary">
<input type="submit" name="login" value="Unlock As Admin" class="btn btn-primary">
<input type="reset" name="back" value="cancel" class="btn btn-danger">
<br>
<p><span>Or Create <a href="create.php">account</a><span> </p>
</fieldset>
</center> 
</form>   
</body>
</html>




