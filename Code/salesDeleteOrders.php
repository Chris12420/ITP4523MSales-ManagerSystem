<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>View Orders</title>
    <meta charset="UTF-8">
    <!--<meta name="viewport" content="width=device-width, initial-scale=0.8" >-->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/salesDeleteOrders.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script>
        //    Disable the total price field
        function begin() {
            //          document.getElementById("Qty").disabled = true;
            document.getElementById("totalPrice").disabled = true;
        }

        function JSalert(){
            swal({   title: "The order will be deleted permanently!",
                    text: "Are you sure to proceed?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Remove My Account!",
                    cancelButtonText: "I am not sure!",
                    closeOnConfirm: false,
                    closeOnCancel: false },
                function(isConfirm){
                    if (isConfirm)
                    {
                        document.getElementById('myform').submit();
                        // swal("Account Removed!", "Your account is removed permanently!", "success");
                    }
                    else {
                        swal.close();
                    } });
        }

        function JSalertSuccessfulMessage(Updated){
            swal({   title: "The item ID \"" + Updated + "\" is Deleted",
                    // text: "Are you sure to proceed?",
                    type: "success",
                    // showCancelButton: true,
                    confirmButtonColor: "#0000FF",
                    confirmButtonText: "OK",
                    cancelButtonText: "I am not sure!",
                    closeOnConfirm: false,
                    closeOnCancel: false },
                function(isConfirm){
                    if (isConfirm)
                    {
                        location.href = 'salesDeleteOrders.php';
                    }
                    else {
                    } });
        }

    </script>
</head>
<body onload="begin()">
<nav class="navbar navbar-expand-lg navbar-light bg-info">

    <div class="container-fluid">
        <!-- logo -->
        <h1>Better Limited</h1>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#linkbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse " id="linkbar">
            <ul class="navbar-nav ms-auto">

                <ul class="nav navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Order</a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="salesViewOrders.php" class="dropdown-item">View order</a>
                            <div class="dropdown-divider"></div>
                            <a href="salesUpdateOrders.php" class="dropdown-item">Update order</a>
                            <a href="salesDeleteOrders.php" class="dropdown-item">Delete order</a>
                        </div>
                    </li>
                </ul>
                <li class="nav-item">
                    <a class="nav-link" href="salesPlaceOrders.php">Checkout</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Logout.php">Login Out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="container">
    <div class="smallTable">

        <?php
        extract($_GET);
        if(isset($Updated)){
            echo '<script type="text/javascript">',
            "JSalertSuccessfulMessage($Updated);",
            '</script>'
            ;
        }

        require_once('Connection/conn.php');
        if(isset($_GET['orderID'])){
            extract($_GET);
            $sql = "SELECT * FROM orders WHERE orderID = '$orderID'";
            $rs = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($rs);
            if($num == 0){
                echo "Record not found<br>";
            }else
            {
                //get db record data
                $rec = mysqli_fetch_assoc($rs);
                //var_dump($rec);
                extract($rec);

                $formCode = <<<EOD
    <form action="salesDeleteOrdersValidate.php" method="post" name="myform" id="myform">

  <table cellspacing="0">
      <tr>
         <th>orderID</th>
         <th>customerEmail</th>
         <th>staffID</th>
         <th>dateTime</th>
         <th>deliveryAddress</th>
         <th>deliveryDate</th>
         <th>orderAmount</th>
         <th><input type="button" value="Delete Record" onclick="JSalert()" ></th>
<!--         <th><input type="submit" value="Delete Record" onclick="JSalert()" </th>-->
      </tr>
      
      <tr>
         <th><input type="text" name="orderID" value="$orderID" readonly></th>
         <th><input type="text" name="customerEmail" value="$customerEmail" readonly></th>
         <th><input type="text" name="staffID" value="$staffID" readonly></th>
         <th><input type="text" name="dateTime" value="$dateTime" readonly></th>
         <th><input type="text" name="deliveryAddress" value="$deliveryAddress" readonly></th>
         <th><input type="text" name="deliveryDate" value="$deliveryDate" readonly></th>
         <th><input type="text" name="orderAmount" value="$orderAmount" readonly></th>
         <th><input type="button" value="Cancel" onclick="window.location.href='salesDeleteOrders.php';"></th>

      </tr>
   </table>
</form>
EOD;
                echo $formCode;
            }
        }
        ?>
    </div>
    <?php

    if (isset($_SESSION['user'])) {
        $userView = $_SESSION['user'];
        $userView = strval($userView);
        extract($_POST);
//    var_dump($_POST);
        require_once('Connection/conn.php');

        $sql = "SELECT orderID , customerEmail, customerName, phoneNumber, staffID, staffName, dateTime, deliveryAddress, deliveryDate, SUM(orderQuantity) as orderQuantity, orders.orderAmount as orderAmount
            FROM customer NATURAL JOIN item NATURAL JOIN itemorders NATURAL JOIN orders NATURAL JOIN staff WHERE staffID = '$userView'
            GROUP BY orderID
            ORDER BY orderID ASC;";

        if(!empty($_POST)){
            extract($_POST);
//        var_dump($_POST);
            $sql = "SELECT orderID , customerEmail, customerName, phoneNumber, staffID, staffName, dateTime, deliveryAddress, deliveryDate, SUM(orderQuantity) as orderQuantity, orders.orderAmount as orderAmount
            FROM customer NATURAL JOIN item NATURAL JOIN itemorders NATURAL JOIN orders NATURAL JOIN staff WHERE staffID = '$userView'
            GROUP BY orderID
            ORDER BY $OrderBy $SortBy;";
        }
        $rs = mysqli_query($conn, $sql);
        echo <<<EOD
<form action="salesDeleteOrders.php" method="post">
<div class="table-users">
   <div class="header">Order Table</div>
   <tr>

<div style="display: flex;
align-items: center;
justify-content: center;
"> 
   <th> Sort by : &nbsp </th>
         <select name="OrderBy" style=""></div>
  <option value="orderID">orderID</option>
  <option value="customerEmail">customerEmail</option>
  <option value="customerName">customerName</option>
  <option value="phoneNumber">phoneNumber</option>
  <option value="staffID">staffID</option>
  <option value="staffName">staffName</option>
  <option value="dateTime">dateTime</option>
  <option value="deliveryAddress">deliveryAddress</option>
  <option value="deliveryDate">deliveryDate</option>
  <option value="orderAmount">orderAmount</option>
</select>

         <th>Order by : &nbsp <select name="SortBy" >
  <option id="SortByAsc" value="asc">Ascending Order</option>
  <option id="SortByDes" value="desc">Descending Order</option>
</select></th>
<input type="submit" value="Search">
      </tr>
         </div>
    </form>
    
   <table cellspacing="0">
      <tr>
         <th>orderID</th>
         <th>customerEmail</th>
         <th>customerName</th>
         <th>phoneNumber</th>
         <th>staffID</th>
         <th>staffName</th>
         <th>dateTime</th>
         <th>deliveryAddress</th>
         <th>deliveryDate</th>
         <th>orderAmount</th>
         <th>Action</th>
         <th>Detail</th>
      </tr>
EOD;
        while ($rc = mysqli_fetch_assoc($rs)) {
            //var_dump($rc);
            extract($rc);
            //var_dump($rc);
            echo <<<EOD
        <tr>
         <td>$orderID</td>
         <td>$customerEmail</td>
         <td>$customerName</td>
         <td>$phoneNumber</td>
         <td>$staffID</td>
         <td>$staffName</td>
         <td>$dateTime</td>
         <td>$deliveryAddress</td>
         <td>$deliveryDate </td>
         <td>$orderAmount </td>
         <td><a href="salesDeleteOrders.php?orderID=$orderID">Delete Record</td>
         <td id="hi"><a href="salesDeleteOrdersItem.php?orderID=$orderID">Delete Ordering Item</td>
       </tr>
        </tbody>
</div>
EOD;
        }
    }
    ?>
</div>
</body>

</html>
