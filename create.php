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
<center>create account to HRS
    <fieldset style="border: double; width: 400px; height: 420px;">
<br>
<form class="form-group" method="POST" action="crea.php">
<strong class="form_control ">your name </strong>
<input type="name" name="name" ><br><br>


<strong class="form_control ">user email</strong>
<input type="email" name="email" ><br><br>

<strong class="form_control ">telephone</strong>
<input type="number" name="tel" ><br><br>

<strong class="form_control ">user sex:
<input type="radio" name="sex" value="female">female
<input type="radio" name="sex" value="male">male<br><br></strong>

<strong class="form_control "> location</strong>
<input type="text" name="loc" ><br><br>

<strong><i >&nbsp</i> password</strong>
<input type="password" name="password">
<br><br>
<input type="submit" name="login" value="create" class="btn btn-primary">
<input type="reset" name="back" value="cancel" class="btn btn-danger">
<br>
<p><span>Have an account?? <a href="home.php">login</a><span> </p>
</fieldset>
</center> 
</form>   
</body>
</html>




