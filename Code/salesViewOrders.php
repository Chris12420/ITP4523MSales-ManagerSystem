<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boostrap5.0 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="css/salesViewOrders.css">
    <script>
    </script>
</head>
<body>
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

<?php
session_start();
if (isset($_SESSION['user'])) {
    $userView = $_SESSION['user'];
    $userView = strval($userView);

    require_once('Connection/conn.php');

    $sql = "SELECT orderID , customerEmail, customerName, phoneNumber, staffID, staffName, dateTime, deliveryAddress, deliveryDate, SUM(orderQuantity) as orderQuantity, orders.orderAmount as orderAmount
            FROM customer NATURAL JOIN item NATURAL JOIN itemorders NATURAL JOIN orders NATURAL JOIN staff WHERE staffID = '$userView'
            GROUP BY orderID
            ORDER BY orderID ASC;";

    if(!empty($_POST)){
        extract($_POST);

        $sql = "SELECT orderID , customerEmail, customerName, phoneNumber, staffID, staffName, dateTime, deliveryAddress, deliveryDate, SUM(orderQuantity) as orderQuantity, orders.orderAmount as orderAmount
            FROM customer NATURAL JOIN item NATURAL JOIN itemorders NATURAL JOIN orders NATURAL JOIN staff WHERE staffID = '$userView'
            GROUP BY orderID
            ORDER BY $OrderBy $SortBy;";
    }

    $rs = mysqli_query($conn, $sql);
    echo <<<EOD
<form action="salesViewOrders.php" method="post">
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
         <th>Receipt</th>
         <th>Detail</th>
      </tr>
EOD;
    while ($rc = mysqli_fetch_assoc($rs)) {

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
         <td><a href="salesViewTableReceipt.php?orderID=$orderID">View Receipt</td>
         <td id="hi"><a href="salesViewOrderDetails.php?orderID=$orderID">Ordering Item</td>
      </tr>
      
</div>
EOD;
    }
}
?>
</body>
</html>
