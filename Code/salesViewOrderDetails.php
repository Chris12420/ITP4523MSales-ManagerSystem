<!DOCTYPE html>
<html>

<head>
    <title>View Orders</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/salesViewOrderDetails.css">
    <script>
    </script>
    <style type="text/css"
           .smallTable{
    /*  border: 1px solid #327a81;*/
    /*	 border-radius: 10px;*/
    box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.1);
    margin: 1em auto;
    overflow: hidden;
    height: 10vh;
    border-right: 0px;
    }
    ></style>

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
<div id="container">

        <?php
        require_once('Connection/conn.php');

            //var_dump($_GET);
            extract($_GET);
            $sql = "SELECT * FROM itemorders WHERE orderID = '$orderID'";
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
EOD;
                echo $formCode;
        }
        ?>
    </div>

    <?php
    require_once('Connection/conn.php');
    if(isset($_GET['itemID']) && isset($_GET['orderID']))  {
        $sql = "SELECT * FROM itemorders WHERE orderID = '$orderID'";
        $rs = mysqli_query($conn, $sql);
        echo<<<EOD
<div class="table-users">

    <div class="header" > Ordering Item</div>

    <table cellspacing="0">
        <tbody>
        <thead>
        <tr>
            <th>orderID</th>
            <th>itemID</th>
            <th>orderQuantity</th>
            <th>soldPrice</th>
            <th>Action</th>
        </tr>
        </thead>
EOD;
        while ($rc = mysqli_fetch_assoc($rs)) {
            //var_dump($rc);
            extract($rc);
            //var_dump($rc);
            echo <<<EOD
        <tr>
         <td>$orderID</td>
         <td>$itemID</td>
         <td>$orderQuantity</td>
         <td>$soldPrice</td>
        </tr>
        </tbody>
</div>
EOD;
        }
    }
    else{

    $sql = "SELECT * FROM itemorders WHERE orderID = '$orderID'";
    $rs = mysqli_query($conn, $sql);
    echo<<<EOD
<div class="table-users">
    <div class="header" ><a href="salesViewOrders.php"><input type="image" style="float: left;" src="css/images/imgBackBtn.png" height="40px" width="40px"  /> </a>Ordering item</div>

    <table cellspacing="0">
        <tbody>
        <thead>
        <tr>
            <th>orderID</th>
            <th>itemID</th>
            <th>orderQuantity</th>
            <th>soldPrice</th>
        </tr>
        </thead>
EOD;
    while ($rc = mysqli_fetch_assoc($rs)) {
        //var_dump($rc);
        extract($rc);
        //var_dump($rc);
        echo <<<EOD
        <tr>
         <td>$orderID</td>
         <td>$itemID</td>
         <td>$orderQuantity</td>
         <td id="hi">$soldPrice</td>

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
