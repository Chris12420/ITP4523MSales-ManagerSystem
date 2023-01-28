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
$sql = "SELECT * FROM item WHERE itemID= '$itemID'";
$rs = mysqli_query($conn, $sql);
var_dump($rs);

//check 下 result set 入面有冇個data
if(mysqli_num_rows($rs)== 1) { //if exist, delete the record
    $sql = "UPDATE item SET itemID='$itemID' WHERE itemID = '$itemID'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if (mysqli_affected_rows($conn) == 1) {
        $isSuccessUpdate = true;
    } else if (mysqli_affected_rows($conn) == 0) {
        $Location = "location:managerEditItems.php?msg=Fail+to+update+record";
    }

    $sql = "UPDATE item SET itemName='$itemName' WHERE itemID='$itemID'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if (mysqli_affected_rows($conn) == 1) {
        $isSuccessUpdate = true;
    } else if (mysqli_affected_rows($conn) == 0) {
        $Location = "location:managerEditItems.php?msg=Fail+to+update+record";
    }

    $sql = "UPDATE item SET itemDescription='$itemDescription' WHERE itemID='$itemID'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if (mysqli_affected_rows($conn) == 1) {
        $isSuccessUpdate = true;
    } else if (mysqli_affected_rows($conn) == 0) {
        $Location = "location:managerEditItems.php?msg=Fail+to+update+record";
    }

    $sql = "UPDATE item SET stockQuantity='$stockQuantity' WHERE itemID='$itemID'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if (mysqli_affected_rows($conn) == 1) {
        $isSuccessUpdate = true;
    } else if (mysqli_affected_rows($conn) == 0) {
        $Location = "location:managerEditItems.php?msg=Fail+to+update+record";
    }

    $sql = "UPDATE item SET price='$price' WHERE itemID='$itemID'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if (mysqli_affected_rows($conn) == 1) {
        $isSuccessUpdate = true;
    } else if (mysqli_affected_rows($conn) == 0) {
        $Location = "location:managerEditItems.php?msg=Fail+to+update+record";
    }

}
else{
    header("location:managerEditItems.php?msg=Fail+to+update+record");
}

if($isSuccessUpdate == true){
    header("location:managerEditItems.php?Updated=$itemID");
}else {
    header("location:managerEditItems.php?msg=Fail+to+update+record");
}
?>
</body>
</html>