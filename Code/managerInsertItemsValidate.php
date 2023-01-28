<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lab 05 Task 1</title>
</head>
<body>
<?php
include "Connection/conn.php";

            $sql = "SELECT IFNULL(max(itemID), 0)+1 AS \"itemIDs\" FROM item;";
            $rs = mysqli_query($conn, $sql);
            $rc = mysqli_fetch_assoc($rs);
            var_dump($rc);

            extract($rc);
            //echo "Will run a SQL INSERT statement";
            extract($_POST);
            var_dump($_POST);
            $sql = "INSERT INTO item(itemID, itemName, itemDescription, stockQuantity, price) VALUES ('$itemIDs', '$itemName', '$itemDescription', '$stockQuantity', '$price')";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));

            $num = mysqli_affected_rows($conn);
            if ($num == 1)
                header("location:managerInsertItems.php?Updated=$itemIDs");
            else if ($num == -1)
                header("location:managerInsertItems.php?Updated=Yes");

?>
</body>
</html>