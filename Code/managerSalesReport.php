<!DOCTYPE html>
<html>

<head>
  <title>View Orders</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Boostrap5.0  -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  <!-- CSS -->
  <link rel="stylesheet" href="css/managerSalesReport.css">
    <style type="text/css">
        #hi{
            text-align: center;
        }
    </style>
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

                <li class="nav-item dropdown ms-auto">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Items</a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="managerInsertItems.php" class="dropdown-item">Insert Item</a>
                        <a href="managerEditItems.php" class="dropdown-item">Update order</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="managerSalesReport.php">Sales Report</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="managerCustomerRecord.php">Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Logout.php">Login Out</a>
                </li>

            </ul>
        </div>
    </div>
</nav>
<?php
require_once('Connection/conn.php');

extract($_POST);
//var_dump($_POST);
//
//$sql = "SELECT staffID, staffName, COUNT(staff.staffID) AS staffID, SUM(orders.orderAmount) as orderAmount
//  FROM itemorders NATURAL JOIN orders NATURAL JOIN staff
//  GROUP BY staff.staffID
//  ORDER BY staff.staffID DESC";
//
//
//if(!empty($_POST)){
//    $sql = "SELECT staffID, staffName, COUNT(staff.staffID) AS staffID, SUM(orders.orderAmount) as orderAmount
//  FROM itemorders NATURAL JOIN orders NATURAL JOIN staff
//  GROUP BY staff.staffID
//  ORDER BY $OrderBy $SortBy";
//}


$sql = "SELECT staff.staffID, staffName, COUNT(orders.staffID) AS numOfOrder, SUM(orders.orderAmount) as orderAmount
        FROM orders NATURAL JOIN staff
        GROUP BY staffID
        ORDER BY staff.staffID DESC;";

if(!empty($_POST)){
    $sql = "SELECT staff.staffID, staffName, COUNT(orders.staffID) AS numOfOrder, SUM(orders.orderAmount) as orderAmount
  FROM orders NATURAL JOIN staff WHERE dateTime LIKE '$start%'
  GROUP BY staffID
  ORDER BY $OrderBy $SortBy;";
}




//WHERE columnN LIKE pattern;

$rs = mysqli_query($conn, $sql);
echo<<<EOD
<form action="managerSalesReport.php" method="post">
<div class="table-users">
   <div class="header">Sales Report</div>
   
   <tr>

<div style="display: flex;
align-items: center;
justify-content: center;
"> 


   <th> Month </th>
<input type="month" id="start" name="start"
       min="2000-01" value="2022-01">


   <th> Sort by : &nbsp </th>
         <select name="OrderBy" style=""></div>
  <option value="staffID">Staff ID</option>
  <option value="staffName">Staff Name</option>
  <option value="staff.staffID">No.of order</option>
  <option value="orders.orderAmount">($)Total sales</option>
  
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
         <th>Staff ID</th>
         <th>Staff Name</th>
         <th>No.of order</th>
         <th>($)Total sales</th>

      </tr>
EOD;
while ($rc = mysqli_fetch_assoc($rs)) {
    extract($rc);
//    var_dump($rc);
    //var_dump($rc);
    echo <<<EOD
      <tr>
         <td>$staffID</td>
         <td>$staffName</td>
         <td>$numOfOrder</td>
         <td id="hi">$orderAmount</td>
      </tr>
      
</div>
EOD;
}

?>
</body>
