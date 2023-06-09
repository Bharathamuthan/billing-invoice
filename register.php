<?php
$conn=mysqli_connect("localhost","root","","pcs_invoice");
?>
<!DOCTYPE html>
<html>
<head><title>Register Form</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Overpass&display=swap" rel="stylesheet">
</head>
<style type="text/css">
    body {
        margin-top: 40px;
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
            <h2 align="center">Registration Form</h2><br>
            <input type="text" name="first_name" class="form-control" placeholder="First Name"><br>
            <input type="text" name="last_name" class="form-control" placeholder="Last Name"><br>
            <input type="email" name="email" class="form-control" placeholder="Email" required><br>
            <input type="text" name="address" class="form-control" placeholder="Address"><br>
            <input type="text" name="mobile" class="form-control" placeholder="Mobile"><br>
            <input type="password" name="password" class="form-control" placeholder="Password" required><br>
            <button type="submit" name="invoice_user" class="btn btn-info btn-block">Register</button>
            </form>
            </div>
        </div>
    </div> 
</body>
</html>
<?php
if(isset($_POST['invoice_user']))
{
        $first_name=$_POST['first_name'];
        $last_name=$_POST['last_name'];
        $email=$_POST['email'];
        $address=$_POST['address'];
        $mobile=$_POST['mobile'];
        $pass=$_POST['password'];
        $password=md5($pass);
    $q=mysqli_query($conn,"INSERT INTO `invoice_user`(`first_name`,`last_name`,`email`,`address`,`mobile`,`password`)VALUES
    ('$first_name','$last_name','$email','$address','$mobile','$password')");
    if($q)
    {
        echo"<script>alert('Successfully Registered !!')</script>";
        echo "<script>window.location= 'index.php'</script>";
    }
    else
    {
        echo"<script>alert('Unable to Register !')</script>";
        echo"<meta http-equiv='refresh' content='0'>";
    }
}
?>

