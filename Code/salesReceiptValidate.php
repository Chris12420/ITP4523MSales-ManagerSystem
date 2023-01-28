<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script type="javascript">
        // function jsFunction(){
        //     alert("hi");
        // }

    </script>

</head>
<body>

<?php
include "Connection/conn.php";
extract($_POST);
var_dump($_POST);
if($CustomerName == "" && $CustomerPhone == ""){
    try {
        $sql = "INSERT INTO customer(customerEmail) VALUES ('$Email')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }catch (Exception $e){

    }
//
//    echo '<script type="text/javascript">',
//    'jsfunction();',
//    '</script>'
//    ;
}else if($CustomerName == "" && !($CustomerPhone == "")){
    $sql = "INSERT INTO customer(customerEmail,phoneNumber) VALUES ('$Email','$CustomerPhone')";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
}else if(!($CustomerName == "") && $CustomerPhone == ""){
    $sql = "INSERT INTO customer(customerEmail, customerName) VALUES ('$Email', '$CustomerName')";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
}else{
    $sql = "INSERT INTO customer(customerEmail, customerName, phoneNumber) VALUES ('$Email', '$CustomerName', '$CustomerPhone')";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
}


if($deliveryAddress == "" && $deliveryDate == ""){
    $sql = "INSERT INTO orders(orderID, customerEmail, staffID, dateTime, orderAmount) VALUES ('$orderID', '$Email', '$staffID', '$date', '$grandTotal')";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
//    echo '<script type="text/javascript">',
//    'jsfunction();',
//    '</script>'
//    ;
}
else{
    $sql = "INSERT INTO orders(orderID, customerEmail, staffID, dateTime, deliveryAddress, deliveryDate, orderAmount) VALUES ('$orderID', '$Email', '$staffID', '$date', '$deliveryAddress', '$deliveryDate', '$grandTotal')";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
}


//$sql = "INSERT INTO orders(orderID, customerEmail, staffID, dateTime, deliveryAddress, deliveryDate, orderAmount) VALUES ('$orderID', '$Email', '$staffID', '$date', '$deliveryAddress', '$deliveryDate', $grandTotal)";
//mysqli_query($conn, $sql) or die(mysqli_error($conn));


$incrementalID = 0;
for ($i = 0; $i<=$totalBuyItemNum;$i++){
$ItemIDName = "ItemIDName".$incrementalID;
$buyQuantityID  = "buyQuantityID".$incrementalID;
$eachItemTotalPrice = "eachItemTotalPrice".$incrementalID;


    if(isset($_POST[$ItemIDName])){
        $ItemIDName =  $_POST[$ItemIDName];
        $buyQuantityID =  $_POST[$buyQuantityID];
        $eachItemTotalPrice =  $_POST[$eachItemTotalPrice];

        $sql = "INSERT INTO itemorders(orderID, itemID, orderQuantity, soldPrice) VALUES ('$orderID', '$ItemIDName', '$buyQuantityID', '$eachItemTotalPrice')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }
    $incrementalID++;
}


header("location:salesReceiptValidateSucessfulMessage.php?orderID=$orderID&Updated=$orderID");

?>



</body>
</html>

