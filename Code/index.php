<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/index.css">
  
<!--  #Boostrap5.0-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <script type="text/javascript">
        function validateMsgId() {
            document.getElementById("inputWrongMessage").innerHTML = "Incorrect user ID or password"
        }
        function validateMsgPassword() {
            document.getElementById("inputWrongMessage").innerHTML = "Incorrect Password"
        }
    </script>


</head>

<body>

<!-- check if session isset-->
<?php
session_start();
//var_dump($_SESSION['user']);
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    if ($username == "Staff") {
        header("location:salesPlaceOrders.php");
    } else if ($username == "Manager") {
        header("location:managerCustomerRecord.php");
    }
//                var_dump($rs);
//                header("location:salesPlaceOrders.html?showMessage=Incorrect+user+ID+or+password");
}
?>





 <h1 id="TopText">𝓑𝓮𝓽𝓽𝓮𝓻 𝓛𝓲𝓶𝓲𝓽𝓮𝓭</h1>
 
  <div class="center">
    <h1>Login</h1>

<div class="inputWrongMessage" id="inputWrongMessage" style="text-align: center; color: red" ></div>
    <form method="post" action="index.php" autocomplete="off">
<div class="txt_field">
    <input type="hidden" name="submit" value="true">
        <input type="text" name="username" required>
        <span></span>
        <label>Username</label>
      </div>
      <div class="txt_field">
        <input type="password" name="password" required>
        <span></span>
        <label>Password</label>
      </div>
<!--      <div class="pass">Forgot Password?</div>-->
      <input type="submit" value="Login" onclick="showMsg()">
<!--      <div class="signup_link">-->
      
<!--      SignUp link-->
<!--       <a href="#">Signup</a>-->
      </div>

        <?php
//        if (isset($_SESSION['user'])) {
//<!--            logged in HTML and code here-->
        require_once('Connection/conn.php');   # or use : include 'conn.php'
        //check if the record still exist
//        var_dump($_POST);
        extract($_POST);
        $sql = "SELECT * FROM staff WHERE staffID= '$username'";
        $rs = mysqli_query($conn, $sql);
        if(mysqli_num_rows($rs)== 1){
//            $staffIDValue = (mysqli_fetch_assoc($rs));


        //check if there is the matched id value in the database
        if(mysqli_num_rows($rs)== 1) { //if id exist, then check the password exist or not
            $sql = "SELECT * FROM staff WHERE staffID='$username' AND password= '$password'";
            $rs = mysqli_query($conn, $sql);

            if(mysqli_num_rows($rs)== 1) {
            $staffInfo = (mysqli_fetch_assoc($rs));
//            var_dump($staffInfo);
            extract($staffInfo);

            if ($position == "Staff"){
                $_SESSION['user'] = $staffID;
                header("location:salesPlaceOrders.php");

            }else if($position == "Manager") {
                $_SESSION['user'] = $staffID;
                header("location:managerCustomerRecord.php");
            }
//                var_dump($rs);
//                header("location:salesPlaceOrders.html?showMessage=Incorrect+user+ID+or+password");
            }else{
                ?>
                <script type="text/javascript">
                    validateMsgPassword();
                </script>
                <?php
            }
        }else{
        if(isset($_POST['submit'])){
                ?>
            <script type="text/javascript">
                    validateMsgId();
            </script>
            <?php
        }
        }
        }else{
        if(isset($_POST['submit'])){
            ?>
            <script type="text/javascript">
                validateMsgId();
            </script>
            <?php
        }
        }
        ?>
    </form>
  </div>
</body>
</html>
