<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Receipt</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

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
              <div class="card">
                  <div class="card-body p-0">
                      <div class="invoice-container">
                          <div class="invoice-header">

<?php
                              session_start();
                  ?>
                              <div class="row gutters">
                                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                      <a href="index.html" class="invoice-logo">
                                          Better Limited
                                      </a>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6">

                                      <?php
                                      extract($_POST);
                                      if (!$deliveryAddress == '' || !$deliveryDate == ''){
                                          echo <<<EOD
                                      <address class="text-right">
                                          Delivery Address : $deliveryAddress <br>
                                          Delivery Date : $deliveryDate

                                      </address>
EOD;
                                      }
                                      ?>
                                  </div>
                              </div>
                              <!-- Row end -->
                              <!-- Row start -->
                              <div class="row gutters">
                                  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                      <div class="invoice-details">
<?php
                              extract($_POST);



                              if(isset($Email) && isset($CustomerName) && isset($CustomerPhone)) {
                                  if($ExistingCustomer == "Exist"){
                                      require_once('Connection/conn.php');
                                      $sql = "SELECT * FROM `customer` WHERE customerEmail ='$Email';";
                                      $rs = mysqli_query($conn, $sql);
                                      $rcEmail = mysqli_fetch_assoc($rs);
                                      extract($rcEmail);

                                  echo <<<EOD
                                                   <address>
                                                Customer’s Email : $Email<br>
                                              Customer’s Name : $customerName<br>
                                              Phone Number : $phoneNumber <br>  <br>
                                                    </address>
EOD;
                                  }else if($ExistingCustomer == "NotExist"){
                                      echo <<<EOD
                                                   <address>
                                                Customer’s Email : $Email<br>
                                              Customer’s Name : $CustomerName<br>
                                              Phone Number : $CustomerPhone <br>  <br>
                                                    </address>
EOD;
                                  }
                              }else{
                                  echo <<<EOD
                                                   <address>
                                                Customer’s Email : $Email<br>
                                                    </address>
EOD;
                              }
                              ?>

                                          <?php
                              extract($_POST);
                                          date_default_timezone_set('HongKong');
                                          $date = date('Y/m/d h:i:s ', time());
                                          require_once('Connection/conn.php');
                                          $sql = "SELECT max(orderID)+1 as orderID From orders";
                                          $rs = mysqli_query($conn, $sql);
                                          $rc = mysqli_fetch_assoc($rs);
                                          extract($rc);
                                          //var_dump($rc);
                                          $staffID = $_SESSION['user'];
                                          // get staff name
                                          $sql = "SELECT staffName From staff WHERE staffID = '$staffID'";
                                          $rs = mysqli_query($conn, $sql);
                                          $rc = mysqli_fetch_assoc($rs);
                                          extract($rc);
                                          //var_dump($rc);

                                          echo <<<EOD
                                      </div>
                                  </div>
                                  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                      <div class="invoice-details">
                                          <div class="invoice-num">
                                              <div>OrderID - $orderID</div>
                                              <div>Staff ID : $staffID</div>
                                              <div>Staff Name : $staffName</div>
                                              <div>Order Date & Time : $date</div>
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
                                              $j = 0;
                                              extract($_POST);
                                              $incrementalID = 0;
                                              for ($i = 0; $i<=$TotalLoopItem;$i++){
                                                  $showItem = "SelectedItem".$incrementalID;


                                                    if(isset($_POST[$showItem])){
                                                        $Item = $_POST["ReceiptItem".$incrementalID];
                                                        $ItemID = $_POST["itemID".$incrementalID];
                                                        $Price = $_POST["PriceID".$incrementalID];
                                                        $Qty = $_POST["buyQuantityID".$incrementalID];
                                                        $totalPrice = $_POST["eachItemTotalPrice".$incrementalID];

                                                        echo <<<EOD
                                                    <tr>
                                                  <td>
                                                      $Item
                                                  </td>
                                                  <td>$ItemID</td>
                                                  <td>$Qty</td>
                                                  <td>$$totalPrice</td>
                                              </tr>
EOD;
                                                    }
                                                    $incrementalID++;
                                                }
                                              ?>
                                              <?php
                                              extract($_POST);
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
                                                      
                                                      <?php
EOD;
                                                      ?>

                                              <?php
                                              $para1 = $total;
                                              require_once('callPythonRESTful.php');
                                              $percentageDiscount = ($discount*100)."%";
                                              $grandTotal = (1-$discount)*$total;

                                                echo <<<EOD
                                                        <p>
                                                          $$total<br>
                                                          $percentageDiscount<br>
                                                             <br>
                                                      </p>
                                                      <h5 class="text-success"><strong>$$grandTotal</strong></h5>
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
                  <?php
//                  include "Connection/conn.php";
//                  if($deliveryAddress == "" && $deliveryDate == ""){
//                      $sql = "INSERT INTO orders(orderID, customerEmail, staffID, dateTime, orderAmount) VALUES ('$orderID', '$Email', '$staffID', '$date', $grandTotal)";
//                      mysqli_query($conn, $sql) or die(mysqli_error($conn));
//                  }else{
//                      $sql = "INSERT INTO orders(orderID, customerEmail, staffID, dateTime, deliveryAddress, deliveryDate, orderAmount) VALUES ('$orderID', '$Email', '$staffID', '$date', '$deliveryAddress', '$deliveryDate', $grandTotal)";
//                      mysqli_query($conn, $sql) or die(mysqli_error($conn));
//                  }
                        echo <<<EOD
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
EOD;

                  ?>
                  <?php
                  extract($_POST);
                  $incrementalID = 0;
                  for ($i = 0; $i<=$TotalLoopItem;$i++){
                      $showItem = "SelectedItem".$incrementalID;


                      if(isset($_POST[$showItem])){
                          $Item = $_POST["ReceiptItem".$incrementalID];
                          $ItemID = $_POST["itemID".$incrementalID];
                          $Price = $_POST["PriceID".$incrementalID];
                          $Qty = $_POST["buyQuantityID".$incrementalID];
                          $totalPrice = $_POST["eachItemTotalPrice".$incrementalID];


                          $ItemIDName = "ItemIDName".$incrementalID;
                          $buyQuantityID  = "buyQuantityID".$incrementalID;
                          $eachItemTotalPrice = "eachItemTotalPrice".$incrementalID;
                          echo <<<EOD
                                                    <tr>
<!--                                                  <td><input type="hidden" name="orderID" value="$Item"> </td>-->
                                                  <td><input type="hidden" name="$ItemIDName" value="$ItemID"></td>
                                                  <td><input type="hidden" name="$buyQuantityID" value="$Qty"></td>
                                                  <td><input type="hidden" name="$eachItemTotalPrice" value="$totalPrice"></td>
                                              </tr>
EOD;
                      }
                      $incrementalID++;
                  }
                                    echo <<<EOD
                                        <td><input type="hidden" name="totalBuyItemNum" value="$incrementalID"></td>
EOD;
                  ?>

                  <input type="hidden" name="test" value="test">
                  <br>
                  <input id="submitButton"  type="submit" value="Confirm Purchase" class="btn btn-info col-md-12 text-center"  >
                  <br><br>
                  <a href="salesPlaceOrders.php"><input type="button" value="Cancel Order" src="" class="btn btn-info col-md-12 text-center"  >
              </form>
          </div>

</body></html>