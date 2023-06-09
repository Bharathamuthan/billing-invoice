<?php
session_start();
include('header.php');
$loginError = '';
if (!empty($_POST['email']) && !empty($_POST['pwd'])) {
    include 'Invoice.php';
    $invoice = new Invoice();
    $user = $invoice->loginUsers($_POST['email'], $_POST['pwd']);
    if (!empty($user)) {
        $_SESSION['user'] = $user[0]['first_name'] . "" . $user[0]['last_name'];
        $_SESSION['userId'] = $user[0]['id'];
        $_SESSION['email'] = $user[0]['email'];
        $_SESSION['address'] = $user[0]['address'];
        $_SESSION['mobile'] = $user[0]['mobile'];
        header("Location:invoice_list.php");
    } else {
        $loginError = "Invalid email or password!";
    }
}
?>

<!-- Login-Page -->

<title>PCS Invoice</title>
<script src="js/invoice.js"></script>
<style type="text/css">
    .form-control {
        height: 46px;
        border-radius: 46px;
        border: none;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        margin-top: 1.5rem;
        background: white;
        opacity: 80%;
    }
    .demo-heading {
        margin-top: 20px;
        margin-left: 30px;
    }
    .login-form {
        margin-top: 200px;
        margin-left: 180px
    }
    .form-group {
        margin-left: 140px;
    }
</style>
<div class="row" style="background-image: url(img/bg-2.jpg); height: 657px; width: 1381px; background-size: cover;">
    <div class="demo-heading">
        <img src="img/PCS-Logo" height="70px">
    </div>
    <div class="login-form">
        <h4 style="color: black; font-size: 25px;"><b>Invoice User Login :</b></h4>
        <form method="post" action="">
            <div class="form-group">
                <?php if ($loginError) { ?>
                    <div class="alert alert-warning">
                        <?php echo $loginError; ?>
                    </div>
                <?php } ?>
            </div>
            <div class="form-group">
                <input name="email" id="email" type="email" class="form-control" placeholder="Email address" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="pwd" placeholder="Password" required>
            </div>
            <div class="form-group">
                <button type="submit" name="login" class="btn btn-info">Login</button><a href="/build-invoice-system/forget.php" style="margin-left:70px; color: red; font-weight: 700;">Forgotten Password?</a><br><br><br>
                <button class="btn btn-info" onclick="window.location.href='register.php'" style="margin-left: 83px; color: white; border: limegreen; background-color: limegreen; font-weight: 500;">Not a User?</button>
            </div>
            <br><br><br><br><br>
        </form>
        <!-- <br>
        <p style="color: black;"><b>Email : admin@pcs.com</b><br><b>Password : PCS</b></p> -->
    </div>
</div>
</div>
<?php include('footer.php'); ?>
