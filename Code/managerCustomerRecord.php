<!DOCTYPE html>
<html>

<head>
  <title>Customer Record</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Boostrap5.0  -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <!-- CSS -->
  <link rel="stylesheet" href="css/managerCustomerRecord.css">
  <script>

      function JSalert(){
          swal({   title: "The Customer and its child record will be deleted permanently!",
                  text: "Are you sure to proceed?",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Remove My Customer Record!",
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

      function JSalertSusscessMessage(Updated){
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
                      location.href = 'managerCustomerRecord.php';
                  }
                  else {
                  } });
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

          <?php
          extract($_GET);
          //        var_dump($_GET);
          if(isset($Updated)){
              var_dump($Updated);
              echo '<script type="text/javascript">',
              "JSalertSusscessMessage('$Updated');",
              '</script>'
              ;
          }
          require_once('Connection/conn.php');
          if(isset($_GET['customerEmail'])){
//if(!empty($_GET)){
              //get a database record which match the custID
              //var_dump($_GET);
              extract($_GET);
              //var_dump($_GET);
//        var_dump($custID);
              $sql = "SELECT * FROM customer WHERE customerEmail = '$customerEmail'";
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
    <form action="managerCustomerRecordValidate.php" method="post" name="myform" id="myform">
    
  <table cellspacing="0">
      <tr>
         <th>customerEmail</th>
         <th>customerName</th>
         <th>phoneNumber</th>
         <th><input type="button" value="Delete Record" onclick="JSalert()"</th>
      </tr>
      
      <tr>
         <th><input type="text" name="customerEmail" value="$customerEmail" readonly></th>
         <th><input type="text" name="customerName" value="$customerName" readonly></th>
         <th><input type="text" name="phoneNumber" value="$phoneNumber" readonly></th>
         <th><input type="button" value="Cancel" onclick="window.location.href='managerCustomerRecord.php';"></th>
         
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
      require_once('Connection/conn.php');
      $sql = "SELECT * FROM customer
            GROUP BY customerEmail
            ORDER BY customerEmail ASC;";

      if(!empty($_POST)){
          extract($_POST);
//        var_dump($_POST);
          $sql = "SELECT * FROM customer
            GROUP BY customerEmail
            ORDER BY $OrderBy $SortBy;";
      }

      $rs = mysqli_query($conn, $sql);
      echo<<<EOD
<form action="managerCustomerRecord.php" method="post">
<div class="table-users">
    <div class="header">Customer Record</div>
   <tr>

<div style="display: flex;
align-items: center;
justify-content: center;
"> 
   <th> Sort by : &nbsp </th>
         <select name="OrderBy" style=""></div>
  <option value="customerEmail">customerEmail</option>
  <option value="customerName">customerName</option>
  <option value="phoneNumber">phoneNumber</option>
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
            <th>customerEmail</th>
            <th>customerName</th>
            <th>phoneNumber</th>
            <th>Action</th>
<!--            <th>Visit</th>-->
        </tr>
        </thead>
EOD;
      while ($rc = mysqli_fetch_assoc($rs)) {
          //var_dump($rc);
          extract($rc);
          //var_dump($rc);
          echo <<<EOD
        <tr>
         <td>$customerEmail</td>
         <td>$customerName</td>
         <td>$phoneNumber</td>
         <td id="hi"><a href="managerCustomerRecord.php?customerEmail=$customerEmail">Delete Record</td>
<!--         <td><a href="salesDeleteOrdersItem.php?customerEmail=$customerEmail">Customer order</td>-->
        </tr>
        </tbody>
</div>
EOD;
      }
      ?>
  </div>
</body>

</html>
