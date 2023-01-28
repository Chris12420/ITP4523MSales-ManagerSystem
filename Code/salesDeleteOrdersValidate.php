<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lab 05 Task 1</title>
</head>
<body>
<?php
require_once('Connection/conn.php');   # or use : include 'conn.php'

//var_dump($_POST);
extract($_POST);

$sql = "SELECT * FROM orders WHERE orderID= '$orderID'";
$rs = mysqli_query($conn, $sql);

//check 下 result set 入面有冇個data
if(mysqli_num_rows($rs)== 1){ //if exist, delete the record
    $sql = "DELETE FROM itemorders WHERE orderID='$orderID'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
//        $delSuccess = (mysqli_affected_rows($conn) == 1);

    // use mysqli_affected_rows($conn) to check how many records are deleted
    if(mysqli_affected_rows($conn) == 1){
        //$delSuccess = true;
        $sql = "DELETE FROM orders WHERE orderID='$orderID'";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));

        // use urlencode() to encode the value embedded in the 'query string'
        //query string 唔可以有空位, 有的話要用'+'表示
    }    if(mysqli_affected_rows($conn) == 1){
        header("location:salesDeleteOrders.php?Updated=$orderID");
    }
    else {
        header("location:salesDeleteOrders.php?Updated=$orderID");
    }
        //$delSuccess = false;
}else
    header("location:salesDeleteOrders.php?Updated=$orderID");   # redirect browser to this page

//  $custID = $_GET['custID'];
//  $sql = "DELETE FROM Customers WHERE custID = '$custID'";
//  mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>
</body>
</html>