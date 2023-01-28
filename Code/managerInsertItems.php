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
  <link rel="stylesheet" href="css/managerInsertItems.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>


    <style type="text/css">
        #hi{
            text-align: center;
        }
    </style>

  <script>
      function JSalert(Updated){
          swal({   title: "The order ID \"" + Updated + "\" is inserted",
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
                      location.href = 'managerInsertItems.php';
                  }
                  else {
                  } });
      }

      function processAjaxData(response, urlPath){
          document.getElementById("content").innerHTML = response.html;
          document.title = response.pageTitle;
          window.history.pushState({"html":response.html,"pageTitle":response.pageTitle},"", urlPath);
      }

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

<div id="container">
    <div class="smallTable">
        <form action="managerInsertItemsValidate.php" method="post">

  <table cellspacing="0">
      <tr>
<!--         <th>Item ID</th>-->
         <th>Item Name</th>
         <th>Item Description</th>
         <th>Stock Quantity</th>
         <th>Price</th>
         <th><input type="submit" value="Insert Record" </th>
      </tr>

      <tr>
<!--         <th><input type="text" name="itemID" style="color: black" readonly></th>-->
         <th><input type="text" name="itemName" ></th>
         <th><input type="text" name="itemDescription" ></th>
         <th><input type="text" name="stockQuantity" ></th>
         <th><input type="text" name="price"></th>
         <th><input type="button" value="Cancel" onclick="window.location.href='managerInsertItems.php';"></th>
      </tr>

   </table>

</form>

        <?php
        extract($_GET);
//        var_dump($_GET);
        if(isset($Updated)){
            echo '<script type="text/javascript">',
            "JSalert($Updated);",
            '</script>'
            ;
        }
        ?>
    </div>
    <?php
    require_once('Connection/conn.php');
    $sql = "SELECT * FROM item 
            GROUP BY itemID
            ORDER BY itemID ASC;";

    if(!empty($_POST)){
        extract($_POST);
        $sql = "SELECT * FROM item
            GROUP BY itemID
            ORDER BY $OrderBy $SortBy;";
    }



    $rs = mysqli_query($conn, $sql);
    echo<<<EOD
<form action="managerInsertItems.php" method="post">
<div class="table-users">
    <div class="header">Insert item</div>
   <tr>

<div style="display: flex;
align-items: center;
justify-content: center;
"> 
   <th> Sort by : &nbsp </th>
         <select name="OrderBy" style=""></div>
  <option value="itemID">Item ID</option>
  <option value="itemName">Item Name</option>
  <option value="itemDescription">Item Description</option>
  <option value="stockQuantity">Stock Quantity</option>
  <option value="price">Price</option>
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
        <tbody>
        <thead>
        <tr>
         <th>Item ID</th>
         <th>Item Name</th>
         <th>Item Description</th>
         <th>Stock Quantity</th>
         <th>Price</th>
        </tr>
        </thead>
EOD;

    while ($rc = mysqli_fetch_assoc($rs)) {
        //var_dump($rc);
        extract($rc);
        //var_dump($rc);
        echo <<<EOD
        <tr>
         <td>$itemID</td>
         <td>$itemName</td>
         <td>$itemDescription</td>
         <td>$stockQuantity</td>
         <td id="hi">$price</td>
        </tr>
        </tbody>
</div>
EOD;
    }
    ?>
</div>
</body>
</html>
