<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lab 05 Task 1</title>
</head>
<body>
<?php
require_once('Connection/conn.php');   # or use : include 'conn.php'
//    var_dump($_GET);
// Do you need to check the record exists before delete this record?
var_dump($_POST);
extract($_POST);
//var_dump($Gender);

//check if the record still exist
$sql = "SELECT * FROM orders WHERE orderID= '$orderID'";
$rs = mysqli_query($conn, $sql);
var_dump($rs);

//check 下 result set 入面有冇個data
if(mysqli_num_rows($rs)== 1) { //if exist, delete the record


//    var_dump(var_dump($orderAmount));
//    $sql = "UPDATE orders SET orderAmount='$orderAmount' WHERE orderID='$orderID'";
//    mysqli_query($conn, $sql) or die(mysqli_error($conn));
////        $delSuccess = (mysqli_affected_rows($conn) == 1);
//    if (mysqli_affected_rows($conn) == 1) {
//        //            $delSuccess = true;
//        // use urlencode() to encode the value embedded in the 'query string'
//        //query string 唔可以有空位, 有的話要用'+'表示
//        $isSuccessUpdate = true;
//    } else if (mysqli_affected_rows($conn) == 0) {
//        $Location = "location:salesUpdateOrders.php?msg=Fail+to+update+record";
//    }

    $sql = "UPDATE orders SET dateTime='$dateTime' WHERE orderID='$orderID'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
//        $delSuccess = (mysqli_affected_rows($conn) == 1);
    if (mysqli_affected_rows($conn) == 1) {
        //            $delSuccess = true;
        // use urlencode() to encode the value embedded in the 'query string'
        //query string 唔可以有空位, 有的話要用'+'表示
        $isSuccessUpdate = true;
    } else if (mysqli_affected_rows($conn) == 0) {
        $Location = "location:salesUpdateOrders.php?msg=Fail+to+update+record";
    }

    $sql = "UPDATE orders SET deliveryAddress='$deliveryAddress' WHERE orderID='$orderID'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
//        $delSuccess = (mysqli_affected_rows($conn) == 1);
    if (mysqli_affected_rows($conn) == 1) {
        //            $delSuccess = true;
        // use urlencode() to encode the value embedded in the 'query string'
        //query string 唔可以有空位, 有的話要用'+'表示
        $isSuccessUpdate = true;
    } else if (mysqli_affected_rows($conn) == 0) {
        $Location = "location:salesUpdateOrders.php?msg=Fail+to+update+record";
    }

    $sql = "UPDATE orders SET deliveryDate='$deliveryDate' WHERE orderID='$orderID'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
//        $delSuccess = (mysqli_affected_rows($conn) == 1);
    if (mysqli_affected_rows($conn) == 1) {
        //            $delSuccess = true;
        // use urlencode() to encode the value embedded in the 'query string'
        //query string 唔可以有空位, 有的話要用'+'表示
        $isSuccessUpdate = true;
    } else if (mysqli_affected_rows($conn) == 0) {
        $Location = "location:salesUpdateOrders.php?Updated=$orderID";
    }

}
else{
    header("location:salesUpdateOrders.php?Updated=$orderID");
}

if($isSuccessUpdate == true){
    header("location:salesUpdateOrders.php?Updated=$orderID");
}else {
    header("location:salesUpdateOrders.php?Updated=$orderID");
}

?>
</body>
</html>