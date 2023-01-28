<?php session_start();?>
<!DOCTYPE html>
<html>

<head>
    <title>View Orders</title>
    <meta charset="UTF-8">
<!--<meta name="viewport" content="width=device-width, initial-scale=0.8" >-->
     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="lib/vanilla-toast.min.js"></script>

    <meta name="viewport" content="width=device-width">


    <link rel="stylesheet" href="css/salesUpdateOrders.css">

    <style type="text/css">
        #hi{
            text-align: center;
        }
        #snackbar {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
            font-size: 17px;
        }
        #snackbar.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }
        @-webkit-keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }
        @keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }
        @-webkit-keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }
        @keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }
    </style>
    <script>
        //    Disable the total price field
        function begin() {
            //          document.getElementById("Qty").disabled = true;
            document.getElementById("totalPrice").disabled = true;
        }

        function myFunction(Updated) {
            document.getElementById("snackbar").innerHTML = "The information orderID '"+ Updated + "' is Updated";
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
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
    <div id="snackbar">Some text some message..</div>
</nav>
<div id="container">
<div class="smallTable" >

    <?php
    extract($_GET);
    //        var_dump($_GET);
    if(isset($Updated)){
//        var_dump($Updated);
        echo '<script type="text/javascript">',
        "myFunction('$Updated');",
        '</script>'
        ;
    }
    if (isset($_SESSION['user'])) {
    $userView = $_SESSION['user'];
    $userView = strval($userView);
    require_once('Connection/conn.php');
    if(isset($_GET['orderID'])) {

        extract($_GET);

        $sql = "SELECT orderID , customerEmail, customerName, phoneNumber, staffID, staffName, dateTime, deliveryAddress, deliveryDate, SUM(orderQuantity) as orderQuantity, SUM(orders.orderAmount) as orderAmount
            FROM customer NATURAL JOIN item NATURAL JOIN itemorders NATURAL JOIN orders NATURAL JOIN staff WHERE staffID = '$userView' AND orderID = '$orderID'
            GROUP BY orderID
            ORDER BY orderID ASC;";

        if (!empty($_POST)) {
            extract($_POST);
            $sql = "SELECT orderID , customerEmail, customerName, phoneNumber, staffID, staffName, dateTime, deliveryAddress, deliveryDate, SUM(orderQuantity) as orderQuantity, SUM(orders.orderAmount) as orderAmount
            FROM customer NATURAL JOIN item NATURAL JOIN itemorders NATURAL JOIN orders NATURAL JOIN staff WHERE staffID = '$userView' AND orderID = '$orderID'
            GROUP BY orderID
            ORDER BY $OrderBy $SortBy;";
        }

        $rs = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($rs);
        if ($num == 0) {
            echo "Record not found<br>";
        } else {
            //get db record data
            $rec = mysqli_fetch_assoc($rs);
            //var_dump($rec);
            extract($rec);

            $formCode = <<<EOD
    <form action="salesUpdateOrdersValidate.php" method="post" name="custInfo">
  <table cellspacing="0">
      <tr>
         <th>orderID</th>
         <th>dateTime</th>
         <th>deliveryAddress</th>
         <th>deliveryDate</th>
         <th><input type="submit" value="Update Record" <a href="salesUpdateOrdersValidate.php?orderID=$orderID"></th>
      </tr>
      
      <tr>
         <th><input type="text" name="orderID" value="$orderID" readonly></th>
         <th><input type="text" name="dateTime" value="$dateTime" ></th>
         <th><input type="text" name="deliveryAddress" value="$deliveryAddress" ></th>
         <th><input type="date" name="deliveryDate" value="$deliveryDate" ></th>
         <th><input type="button" value="Cancel" onclick="window.location.href='salesUpdateOrders.php';"></th>
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

//var_dump($_SESSION['user']);
if (isset($_SESSION['user'])) {
    $userView = $_SESSION['user'];
    $userView = strval($userView);

    extract($_POST);
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
<form action="salesUpdateOrders.php" method="post">
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
         <td><a href="salesUpdateOrders.php?orderID=$orderID">Update Record</td>
         <td id="hi"><a href="salesUpdateOrderDetails.php?orderID=$orderID">Ordering Item</td>
      </tr>
        </tbody>
</div>
EOD;
    }
}}
?>
</div>
</body>

</html>
