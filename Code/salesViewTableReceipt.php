<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Receipt</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <style type="text/css">
    </style>
<link rel="stylesheet" href="css/salesReceipt.css">
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

  <div class="container">
      <div class="row gutters">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="card" style="">
                  <div class="card-body p-0">
                      <div class="invoice-container">
                          <div class="invoice-header">

                              <div class="header" ><a href="salesViewOrders.php"><input type="image" style="float: left;" src="css/images/imgBackBtn.png" height="40px" width="40px"  /> </a></div>

<!--                              --><?php
                              session_start();
                              extract($_GET);

                              require_once('Connection/conn.php');

                              $sql = "SELECT orderID , customerEmail, customerName, phoneNumber, staffID, staffName, dateTime, deliveryAddress, deliveryDate, itemID, itemName, SUM(orderQuantity) as orderQuantity, SUM(orders.orderAmount) as orderAmount
                                        FROM customer NATURAL JOIN item NATURAL JOIN itemorders NATURAL JOIN orders NATURAL JOIN staff WHERE orderID = '$orderID'
                                        GROUP BY orderID,itemID,itemName
                                        ORDER BY orderID ASC;";

                              $rs = mysqli_query($conn, $sql);

                              $rc = mysqli_fetch_assoc($rs);
                                  extract($rc);

                                  echo <<<EOD
                              <div class="row gutters">
                                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                      <a href="index.html" class="invoice-logo">
                                          Better Limited
                                      </a>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6">

                                      <address class="text-right">
                                          Delivery Address : $deliveryAddress <br>
                                          Delivery Date : $deliveryDate
                                      </address>

                                  </div>
                              </div>
                              <!-- Row end -->
                              <!-- Row start -->

                              <div class="row gutters">
                                  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                      <div class="invoice-details">

                                                   <address>
                                                Customer’s Email : $customerEmail<br>
                                              Customer’s Name : $customerName<br>
                                              Phone Number : $phoneNumber <br>  <br>
                                                    </address>

                                      </div>
                                  </div>
                                  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                      <div class="invoice-details">
                                          <div class="invoice-num">
                                              <div>OrderID - $orderID</div>
                                              <div>Staff ID : $staffID</div>
                                              <div>Staff Name : $staffName</div>
                                              <div>Order Date & Time : $dateTime</div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <!-- Row end -->
                          </div>
EOD;
                          ?>

                          <div class="invoice-body">
                              <!-- Row start -->
                              <div class="row gutters">
                                  <div class="col-lg-12 col-md-12 col-sm-12">
                                      <div class="table-responsive">
                                          <table class="table custom-table m-0">
                                              <thead>
                                              <tr>
                                                  <th>Items</th>
                                                  <th>Item ID</th>
                                                  <th>Quantity</th>
                                                  <th>Sub Total</th>
                                              </tr>
                                              </thead>
                                              <tbody>

                                              <?php
                                              global $originalPrice;
                                              $sql = "SELECT orderID , customerEmail, customerName, phoneNumber, staffID, staffName, dateTime, deliveryAddress, deliveryDate, itemID, itemName, SUM(orderQuantity) as orderQuantity, soldPrice, orders.orderAmount as orderAmount
                                        FROM customer NATURAL JOIN item NATURAL JOIN itemorders NATURAL JOIN orders NATURAL JOIN staff WHERE orderID = '$orderID'
                                        GROUP BY orderID,itemID,itemName
                                        ORDER BY orderID ASC;";
                                              $rs = mysqli_query($conn, $sql);

                                              while ($rc = mysqli_fetch_assoc($rs)) {
                                                  extract($rc);
                                                  echo <<<EOD
                                                    <tr>
                                                  <td>
                                                        $itemName
                                                  </td>
                                                  <td>$itemID</td>
                                                  <td>$orderQuantity</td>
EOD;
                                                  ?>
                                              <?php
                                                  $SubTotal =  $soldPrice*$orderQuantity;
                                                  $originalPrice += $soldPrice;
                                                  echo <<<EOD
                                                  <td>$$soldPrice</td>
                                              </tr>
EOD;
                                              }
                                              ?>
<?php


$sql = "SELECT orderID , customerEmail, customerName, phoneNumber, staffID, staffName, dateTime, deliveryAddress, deliveryDate, itemID, itemName, SUM(orderQuantity) as orderQuantity, soldPrice, orders.orderAmount as orderAmount
                                        FROM customer NATURAL JOIN item NATURAL JOIN itemorders NATURAL JOIN orders NATURAL JOIN staff WHERE orderID = '$orderID'
                                        GROUP BY orderID,itemID,itemName
                                        ORDER BY orderID ASC;";
$rs = mysqli_query($conn, $sql);
$rc = mysqli_fetch_assoc($rs);
    extract($rc);
//    var_dump($rc);
    echo <<<EOD
                                              <tr>
                                                  <td>&nbsp;</td>
                                                  <td colspan="2">
                                                      <p>
                                                          Original Price<br>
                                                          Discount<br>
                                                              <br>
                                                      </p>
                                                      <h5 class="text-success"><strong>Grand Total</strong></h5>
                                                  </td>
                                                  <td>
                                                       
EOD;
?>
                                                        <?php
                                              $para1 = $originalPrice;
                                              require_once('callPythonRESTful.php');
                                              $percentageDiscount = ($discount*100)."%";
                                              $grandTotal = (1-$discount)*$orderAmount;
                                                echo <<<EOD
                                                        <p>
                                                          $$originalPrice<br>
                                                          $percentageDiscount<br>
                                                             <br>
                                                      </p>
                                                      <h5 class="text-success"><strong>$$orderAmount</strong></h5>
EOD;
?>
                                                  </td>
                                              </tr>
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                              </div>
                              <!-- Row end -->
                          </div>
                          <div class="invoice-footer">
                              @Better Limited.com
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="container">
      <div class="row gutters">

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <form action="salesReceiptValidate.php" method="post">

                    <td><input type="hidden" name="orderID" value="$orderID"></td>
                    <td><input type="hidden" name="Email" value="$Email"></td>
                    <td><input type="hidden" name="staffID" value="$staffID"></td>
                    <td><input type="hidden" name="date" value="$date"></td>
                    <td><input type="hidden" name="deliveryAddress" value="$deliveryAddress"></td>
                    <td><input type="hidden" name="deliveryDate" value="$deliveryDate"></td>
                    <td><input type="hidden" name="grandTotal" value="$grandTotal"></td>

                    <td><input type="hidden" name="Email" value="$Email"></td>
                    <td><input type="hidden" name="CustomerName" value="$CustomerName"></td>
                    <td><input type="hidden" name="CustomerPhone" value="$CustomerPhone"></td>

                                                    <tr>
                                                  <td><input type="hidden" name="$ItemIDName" value="$ItemID"></td>
                                                  <td><input type="hidden" name="$buyQuantityID" value="$Qty"></td>
                                                  <td><input type="hidden" name="$eachItemTotalPrice" value="$totalPrice"></td>
                                              </tr>
      <input type="hidden" name="test" value="test">
              </form>
          </div>
  <td>
  </td>
</body></html>