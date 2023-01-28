<?php
if($_POST['action'] == 'call_this') {
    $CheckEmail = $_COOKIE['Emailvalue'];
    var_dump($CheckEmail);

    require_once('Connection/conn.php');
    $sql = "SELECT customerEmail FROM customer WHERE customerEmail = '$CheckEmail'";
    $rs2 = mysqli_query($conn, $sql);

    var_dump($rs2);
//var_dump($rs);
    setcookie("susscess", "", time() - 3600);
    $_SESSION['SessionEmail'] = 0;
    while ($rc2 = mysqli_fetch_assoc($rs2)) {
        extract($rc2);
        var_dump($rc2);
        if ($CheckEmail === $customerEmail) {
            setcookie("susscess", 1);
            $_SESSION['SessionEmail'] = 1;
            var_dump($CheckEmail);
        }
    }
}
?>