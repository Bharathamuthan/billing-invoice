<?php
$conn=mysqli_connect("localhost","root","","pcs_invoice");
?>
<!DOCTYPE html>
<html>
<head><title>Forget password ?</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Overpass&display=swap" rel="stylesheet">
</head>
<style type="text/css">
    body {
        margin-top: 160px;
        margin-left: 400px;
        background-image: url(img/bg-2.jpg);
        background-size: cover;
        background-repeat: no-repeat;
        height: 357px; 
        overflow: hidden;
    }
    h2 {
        font-family: 'Overpass',sans-serif;
        font-weight: bold;
        color: #000;
    }
    .form-control {
        height: 40px;
        border-radius: 0px;
        margin-top: 10px;
        font-family: 'Overpass',sans-serif;
        font-weight: bold;
        color: #000;
        opacity: 80%;
    }
    .btn {
        height: 40px;
        border-radius: 0px;
        margin-top: 10px;
        font-family: 'Overpass',sans-serif;
        font-weight: bold;
        color: #000;
    }
</style>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
            <form method="post">
            <h2 align="center">Forgotten Password</h2><br>
            <input type="email" name="email" class="form-control" placeholder="Email" required><br>
            <input type="password" name="password" class="form-control" placeholder="Password" required><br>
            <button type="submit" name="invoice_user" class="btn btn-info btn-block">Submit</button>
            </form>
            </div>
        </div>
    </div> 
</body>
</html>
<?php
if(isset($_POST['invoice_user']))
{
        $email=$_POST['email'];
        $pass=$_POST['password'];
        $password=md5($pass);
        $q=mysqli_query($conn, "UPDATE `invoice_user` SET `password` = '" . $password . "'
        WHERE email = '" . $email . "'");
    if($q)
    {
        echo"<script>alert('Password Successfully Changed !!')</script>";
        echo "<script>window.location= 'index.php'</script>";
    }
    else
    {
        echo"<script>alert('Unable to Change Password !')</script>";
        echo"<meta http-equiv='refresh' content='0'>";
    }
}
?>
