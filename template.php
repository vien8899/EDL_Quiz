<?php
require_once "controller/main_controller.php";
date_default_timezone_set("Asia/Vientiane");
// $user_key = getMachineID();
// $token = json_decode(file_get_contents('assets/json/app.json'), true);
// limit of table row number
$limit_row = 10;
// check user logged in
// if (isset($token["$user_key"])) {
  // echo "<script>console.log('test0');</script>";
  if (empty($_SESSION["user_admin_login"])) {
    header("location:login");
  } else {
    $user_data = $_SESSION["user_admin_login"];
    $permission = $user_data["permission"];
    ?>
    <script>
      // console.log(<?=json_encode($user_data)?>); 
    </script>
    <?php
  }
// }else{
//   header("location:login");
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EDL Quiz System</title>
  <link rel="icon" type="image/png" href="assets/favicon.png">
  <link href="module/fontawesome-5.15.4/css/all.css" rel="stylesheet">
  <script src="module/fontawesome-5.15.4/js/all.js"></script>
  <!-- bootstrap -->
  <link rel="stylesheet" href="module/bootstrap-5.1.3/css/bootstrap.min.css">
  <script src="module/bootstrap-5.1.3/js/bootstrap.bundle.min.js"></script>

  <script src="assets/js/main.js"></script>

  <link rel="stylesheet" href="assets/css/style.css">

  <link rel="stylesheet" href="assets/css/temp-style.css">
  <!-- plugins:css -->
  <link rel="stylesheet" href="assets/vendors/feather/feather.css">
  <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="assets/css/vertical-layout-light/style.css">

  <link rel="stylesheet" href="assets/css/loader_style.css">

  <!-- sweetalert -->
  <link rel="stylesheet" href="module/sweetalert2/dist/sweetalert2.min.css">
  <script src="module/sweetalert2/dist/sweetalert2.all.min.js"></script>

</head>

<body>
  <div class="container-scroller">
    <div class="preloader">
      <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Loading...</p>
      </div>
    </div>
    <?php
    include 'temp/navbar.php';
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper main-container">
      <?php
      include 'temp/left-sidebar.php';
      ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <!-- @include($page,['page_num'=>$page_num]) -->
          <?php
          $content_page = $_GET['page'];
          if(isset($_GET['sub_page'])){
            $sub_page = $_GET['sub_page'];
            include_once "pages/$sub_page.php";
          }else{
            include_once "pages/$content_page.php";
          }
          // if($content_page!="new_user"){
          //     echo "<script>sessionStorage.setItem('new_user_class', 'hidden');</script>";
          // }
          // if($content_page!="report"){
          //     echo "<script>sessionStorage.removeItem('tab');</script>";
          // }
          ?>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-center text-sm-left d-block d-sm-inline-block">Copyright © 2022. Quiz System V 1.0</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <?php include 'modals/logout_confirm.php' ?>



  <!-- plugins:js -->
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="assets/vendors/chart.js/Chart.min.js"></script>
  <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="assets/js/dataTables.select.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/template.js"></script>
  <script src="assets/js/settings.js"></script>
  <script src="assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->


</body>
<script>
  if(window.history.replaceState){
    window.history.replaceState(null,null,window.location.href);
  }
</script>

</html>