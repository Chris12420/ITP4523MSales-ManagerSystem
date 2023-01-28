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

    <link rel="stylesheet" href="css/salesUpdateOrders.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script>
        //    Disable the total price field
        function begin() {
            //          document.getElementById("Qty").disabled = true;
            document.getElementById("totalPrice").disabled = true;

        }

        function JSalert(Updated){
            swal({   title: "The order of\n order ID \"" + Updated + "\" is Created",
                    // text: "Are you sure to proceed?",
                    type: "success",
                    // showCancelButton: true,
                    confirmButtonColor: "#0000FF",
                    confirmButtonText: "Continue",
                    cancelButtonText: "I am not sure!",
                    closeOnConfirm: false,
                    closeOnCancel: false },
                function(isConfirm){
                    if (isConfirm)
                    {
                        location.href = 'salesPlaceOrders.php';
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

<!--	      <th>orderID</th><th>customerEmail</th><th>staffID</th><th>dateTime</th><th>deliveryAddress</th><th>deliveryDate</th><th>orderAmount</th><th>Action</th>-->


<div id="container">
    <div class="smallTable">


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

        ?>
        </div>
</div>
</body>

</html>
