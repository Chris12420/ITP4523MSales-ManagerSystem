<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lab 05 Task 1</title>
</head>
<body>
<?php
require_once('Connection/conn.php');   # or use : include 'conn.php'
// Do you need to check the record exists before delete this record?
extract($_POST);
var_dump($_POST);

// take orderID from order
$sql = "SELECT orderID FROM orders WHERE customerEmail= '$customerEmail'";
$rs = mysqli_query($conn, $sql);

var_dump($rs);

$test = mysqli_num_rows($rs)== 1;
var_dump($test);

if(mysqli_num_rows($rs)== true){
while ($rc = mysqli_fetch_assoc($rs)) {
    extract($rc);
    var_dump($rc);
    $sql = "SELECT orderID FROM orders WHERE customerEmail= '$customerEmail'";
    $rs2 = mysqli_query($conn, $sql);
    var_dump($rs2);
    while ($rc3 = mysqli_fetch_assoc($rs2)) {
        extract($rc3);
        var_dump($rc3);
        $sql = "DELETE FROM itemorders WHERE orderID = '$orderID'";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }
    $sql = "DELETE FROM orders WHERE customerEmail = '$customerEmail'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $sql = "DELETE FROM customer WHERE customerEmail = '$customerEmail'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));

    header("location:managerCustomerRecord.php?Updated=$customerEmail");
}}else{
//        $sql = "DELETE FROM orders WHERE customerEmail = '$customerEmail'";
//        mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $sql = "DELETE FROM customer WHERE customerEmail = '$customerEmail'";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    header("location:managerCustomerRecord.php?Updated=$customerEmail");
}
?>
</body>
</html>