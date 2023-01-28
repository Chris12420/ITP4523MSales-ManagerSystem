<!DOCTYPE html>
<html lang="en">
<head>
  <title>Order Placement</title>
  <meta charset="UTF-8">
<!--  <meta name="viewport" content="width=device-width, initial-scale=1.0">-->
  <!-- Boostrap5.0  -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <!-- CSS -->
  <link rel="stylesheet" href="css/salesPlaceOrders2.css">
    <!--    //successful checkout alert message-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <meta name="viewport" content="width=device-width">
    <style type="text/css">
        input[type=checkbox]
        {
            -ms-transform: scale(2); /* IE */
            -moz-transform: scale(2); /* FF */
            -webkit-transform: scale(2); /* Safari and Chrome */
            -o-transform: scale(2); /* Opera */
            transform: scale(2);
            padding: 10px;
        }
    </style>
  <script type="text/javascript">



    //    Disable the total price field
    function begin() {
        document.getElementById("deliveryAddress").hidden = true;
        document.getElementById("date").hidden = true;
        document.getElementById("CustomerName").hidden = true;
        document.getElementById("CustomerPhone").hidden = true;

        document.getElementById("deliveryAddress").required = false;
        document.getElementById("date").required = false;
    }

    function showDeliveryInfo(){
        document.getElementById("deliveryAddress").hidden = false;
        document.getElementById("date").hidden = false;
        document.getElementById("deliveryAddress").required = true;
        document.getElementById("date").required = true;
    }

    function noShowDeliveryInfo(){
        document.getElementById("deliveryAddress").hidden = true;
        document.getElementById("date").hidden = true;
        document.getElementById("deliveryAddress").required = false;
        document.getElementById("date").required = false;
    }

    function showCustomerInfo(){
        document.getElementById("CustomerName").hidden = false;
        document.getElementById("CustomerPhone").hidden = false;
    }

    function noShowCustomerInfo(){
        document.getElementById("CustomerName").hidden = true;
        document.getElementById("CustomerPhone").hidden = true;
    }


    function validateMyForm(){
        if (valthisform()) {
            // alert("Please select a item");
            if (document.getElementById("EmailValidate").innerHTML === "Not Exist" && document.getElementById("EmailradioOne").checked === true) {
                alert("Please input an existing customer email!");
                // returnToPreviousPage();
                document.getElementById("Email").autofocus = true;
                return false;
            } else if (document.getElementById("EmailValidate").innerHTML === "Exist" && document.getElementById("EmailradioTwo").checked === true) {
                alert("You are a existing customer, please select 'Yes' before input your email");
                // returnToPreviousPage();
                return false;
            } else {
                //alert("validations passed");
                return true;
            }
        }else {
            alert("Please select an item");
            return false;
        }
    }



    function CheckExsitingCustomer(){
        var Emailvalue = document.getElementById("Email").value;
        document.cookie = "Emailvalue = " + Emailvalue;
        //sessionStorage.SessionName = "SessionData"
        sessionStorage.setItem("SessionEmail",Emailvalue);

        $.ajax({
            type: "POST",
            url: 'salesPlaceOrdersEmailAjax.php',
            // url: 'ajax.php',
            data:{action:'call_this'},
            success:function(data) {
                // alert(data);
                $('.result').html(data);
            }

        });

            key ="susscess";
        alert("Checking if the Customer already exist                                          ");
        // setTimeout(function() {alert("my message");}, 100);
            if(read_cookie(key) == 1) {
                // alert("Existing Customer");
                // setTimeout(function() {alert("my message");}, 0);
                document.getElementById("EmailValidate").innerHTML = "Exist";
                document.getElementById("ExistingCustomer").value = "Exist";

            }else {
                // alert("Not Exist Customer");
                // setTimeout(function() {alert("my message");}, 100);
                document.getElementById("EmailValidate").innerHTML = "Not Exist";
                document.getElementById("ExistingCustomer").value = "NotExist";
            }
    }

    function read_cookie(key)
    {
        var result;
        return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? (result[1]) : null;
    }


    function changeTotalPrice(){
        // pass the TotalAmount value
        //let TotalAmount = parseInt(document.getElementById("totalPrice").value);
        let TotalAmount = 0;
        for(var i = 0; i<=document.getElementsByClassName("TotalItemGetFromDB").length; i++) {
            if (!((document.getElementById('CheckboxID' + i) == null))) {

                if (document.getElementById('CheckboxID' + i).checked) {
                    if(document.getElementById("buyQuantityID" + i).value == 0 || document.getElementById("buyQuantityID" + i).value == ""){
                        document.getElementById("eachItemTotalPrice" + i).value = (1 * document.getElementById("PriceID" + i).value).toFixed(2);
                        document.getElementById("buyQuantityID" + i).value = 1;
                    }else {
                        document.getElementById("eachItemTotalPrice" + i).value = (document.getElementById("buyQuantityID" + i).value * document.getElementById("PriceID" + i).value).toFixed(2);
                    }
                } else if (!document.getElementById('CheckboxID' + i).checked) {
                    //TotalAmount -= parseInt(document.getElementById("eachItemTotalPrice" + i).value);
                    document.getElementById("buyQuantityID" + i).value = 0;
                    document.getElementById("eachItemTotalPrice" + i).value = 0;
                }
            }else {
            }
        }

        for(var i = 0; i<=document.getElementsByClassName("TotalItemGetFromDB").length; i++){
            if (!((document.getElementById('CheckboxID' + i) == null))) {
                TotalAmount += parseInt(document.getElementById("eachItemTotalPrice" + i).value);
            }
        }
        // Show Total Amount
        document.getElementById("totalPrice").value = TotalAmount;
    }



    function valthisform()
    {
        var checkboxs=document.getElementsByClassName("checkbox");
        var okay=false;
        for(var i=0,l=checkboxs.length;i<l;i++)
        {
            if(checkboxs[i].checked)
            {
                okay=true;
                break;
            }
        }
        // if(okay)alert("Thank you for checking a checkbox");
        if(okay === true){
            return true;
        } else{
            // alert("Please select an item");
            return false;
        }

    }


    function submitForm(){
        document.forms[0].submit();
    }
    function ClearAll(){
        // document.getElementById("Email").hidden = true;
        document.getElementById("CustomerName").hidden = true;
        document.getElementById("CustomerPhone").hidden = true;
        document.getElementById("deliveryAddress").hidden = true;
        document.getElementById("date").hidden = true;
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

<php
  <div id="flex-container">
    <div id="main">
        <?php

        extract($_GET);
//                var_dump($_GET);
        //        var_dump($_GET);
        if(isset($orderID)&&isset($Updated)){
//            var_dump($Updated);
            echo '<script type="text/javascript">',
            "JSalert('$Updated');",
            '</script>'
            ;
        }

require_once('Connection/conn.php');
$sql = "SELECT * FROM item";
$rs = mysqli_query($conn, $sql);
echo<<<EOD
      <form id="form1" action="salesReceipt.php" method="post" autocomplete="off" onsubmit="return validateMyForm(); ">
        <table id="flex-item3">
          <thead>
            <tr>
              <th class="tableBorder"></th>
              <th class="tableBorder" id="itemID">itemID</th>
              <th class="tableBorder">itemName</th>
              <th class="tableBorder">Price($)</th>
              <th class="tableBorder">Quantity</th>
              <th class="tableBorder">Total($)</th>

            </tr>
          </thead>
EOD;

$incrementalID = -1;
while ($rc = mysqli_fetch_assoc($rs)) {
    extract($rc);
    $incrementalID++;

    $SelectedItem = "SelectedItem".$incrementalID;
    $CheckboxID = "CheckboxID".$incrementalID;
    $ItemID = "itemID".$incrementalID;
    $PriceID = "PriceID".$incrementalID;
    $buyQuantityID = "buyQuantityID".$incrementalID;
    $eachItemTotalPrice = "eachItemTotalPrice".$incrementalID;
    $ReceiptItem = "ReceiptItem".$incrementalID;

    echo <<<EOD
<input type="hidden" class="TotalItemGetFromDB">
EOD;
    if($stockQuantity == "0"){
        continue;
    }
    echo <<<EOD
          <tbody>
            <tr>
              <!--           Membership unit price-->

              <td>
              <div class="custom-control custom-checkbox checkbox-lg">
              <input type="Checkbox" class="checkbox" id="$CheckboxID" name="$SelectedItem" value="" onclick="changeTotalPrice();">
        </div>
              </td>

              <td><input type="hidden" name="$ItemID" value="$itemID">$itemID<br></td>
              <td><input type="hidden" name="$ReceiptItem" value="$itemName">$itemName</td>
              <td><input type="hidden" id="$PriceID" name="$PriceID" value="$price"> $price</td>
              <td><input type="number" class="buyQuantity" id="$buyQuantityID" name="$buyQuantityID" min="0" max="99" onchange="changeTotalPrice()"></td>
              <td><input type="text" id="$eachItemTotalPrice" name="$eachItemTotalPrice" step=".01" readonly></td>
            </tr>
          </tbody>
EOD;
}
?>
          <tfoot>
            <tr>
            </tr>
          </tfoot>

        </table>

    </div>
    <div id="aside">
        <div>
            <h3>Old Customer</h3>
            <div>
                <input type="radio" value="none" id="EmailradioOne" name="Customer" checked onclick="noShowCustomerInfo()" />
                <label for="radioOne" class="radio">Yes </label>

                <input type="radio" value="none" id="EmailradioTwo" name="Customer" onclick="showCustomerInfo()" />
                <label for="radioTwo" class="radio">No </label>

                <div>
<!--                    placeholder="Email"-->
                    <input type="text" id="Email" name="Email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Invalid Email" onchange="CheckExsitingCustomer(this)" required>
                    <label for="Email" id="EmailValidate"></label>
                </div>
                <div>
                    <input type="text" id="CustomerName" name="CustomerName" placeholder="Name(Optional)" >
                </div>
                <div>
                    <input type="text" id="CustomerPhone" name="CustomerPhone" pattern="^[0-9]{8,8}$" title="8-digit number is required"  placeholder="Phone Number(Optional)" >
                </div>
            </div>

            <h3>Delivery Method</h3>
          <div>
            <input type="radio" value="none" id="radioOne" name="method" checked onclick="noShowDeliveryInfo()" />
            <label for="radioOne" class="radio">For pick up </label>

            <input type="radio" value="none" id="radioTwo" name="method" onclick="showDeliveryInfo()" />
            <label for="radioTwo" class="radio">For delivery </label>
          </div>

            <div>
                <input type="text" id="deliveryAddress" name="deliveryAddress" placeholder="deliveryAddress">
            </div>
            <div>
                <input id="date" type="date" name="deliveryDate" placeholder="deliveryDate">
            </div>
            <div>
                <input id="ExistingCustomer" type="hidden" name="ExistingCustomer">
            </div>
            <div>

                <?php
                echo <<<EOD
                <input type="hidden" name="TotalLoopItem" value="$incrementalID">
EOD;
                ?>
            </div>
            <div>
                <br>
                <input type="reset" onclick="ClearAll()" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="background-color: cornflowerblue">
                <input class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="background-color: cornflowerblue" type="submit">
            </div>
        </div>
    </div>
    <div id="footer">
      <th class="TotalAmount" id="txtTotalAmt">
        <h5>𝑻𝒐𝒕𝒂𝒍 𝑨𝒎𝒐𝒖𝒕($)</h5>
      </th>
      <td id="last-margin" class="TotalAmount"><input id="totalPrice"  type="text" name="total" readonly></td>
    </div>
    </div>
</body>
</html>
