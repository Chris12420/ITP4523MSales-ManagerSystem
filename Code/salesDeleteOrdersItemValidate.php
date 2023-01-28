<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<?php
require_once('Connection/conn.php');   # or use : include 'conn.php'
// Do you need to check the record exists before delete this record?
extract($_POST);
var_dump($_POST);
//check if the record still exist
$sql = "SELECT * FROM itemorders WHERE orderID= '$orderID' AND itemID= '$itemID'";
$rs = mysqli_query($conn, $sql);

//check 下 result set 入面有冇個data
if(mysqli_num_rows($rs)== 1){ //if exist, delete the record
    $sql = "DELETE FROM itemorders WHERE orderID = '$orderID'AND itemID= '$itemID'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
//        $delSuccess = (mysqli_affected_rows($conn) == 1);

    // use mysqli_affected_rows($conn) to check how many records are deleted
    if(mysqli_affected_rows($conn) == 1){
        $delSuccess = true;
        // use urlencode() to encode the value embedded in the 'query string'
        //query string 唔可以有空位, 有的話要用'+'表示
        header("location:salesDeleteOrdersItem.php?orderID=$orderID&Updated=$itemID");
    }else
        $delSuccess = false;
}else
    header("location:salesDeleteOrdersItem.php?orderID=$orderID&Updated=$itemID");   # redirect browser to this page

//  $custID = $_GET['custID'];
//  $sql = "DELETE FROM Customers WHERE custID = '$custID'";
//  mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>
</body>
</html>