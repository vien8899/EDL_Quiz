<?php
    session_start();
    date_default_timezone_set("Asia/Vientiane");
    if (empty($_SESSION["user_login"])) {
        header("location:login");
    } else {
        $user_data = $_SESSION["user_login"];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EDL Quiz System</title>
    <link rel="icon" type="image/png" href="assets/favicon.png">

    <link rel="stylesheet" href="assets/css/main-style.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <link href="module/fontawesome-5.15.4/css/all.css" rel="stylesheet">
    <script src="module/fontawesome-5.15.4/js/all.js"></script>
    <!-- bootstrap -->
    <link rel="stylesheet" href="module/bootstrap-5.1.3/css/bootstrap.min.css">
    <script src="module/bootstrap-5.1.3/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/loader_style.css">
    <!-- sweetalert -->
    <link rel="stylesheet" href="module/sweetalert2/dist/sweetalert2.min.css">
    <script src="module/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <script src="assets/js/jquery-1.9.1.min.js"></script>

    <link rel="stylesheet" href="assets/css/vertical-layout-light/style.css">
</head>

<body>
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Loading...</p>
        </div>
    </div>
    <div class="nav">
        <?php include_once "student/student_nav.php"; ?>
    </div>
    <div class="_container">
        <?php 
            if(isset($_GET['page'])){
                $content_page = $_GET['page'];
                include_once "student/$content_page.php";
            }else{
        ?>
        <header class="header">
            <div id="material-tabs">
                <a id="tab1-tab" href="#tab1">
                    <div class="phetsarath">ໜ້າຫຼັກ</div>
                </a>
                <a id="tab2-tab" href="#tab2">
                    <div class="phetsarath">ທົດລອງເສັງ</div>
                </a>
                <span class="yellow-bar"></span>
            </div>
        </header>
        <div class="tab-content">
            <div id="tab1">
                <?php include_once "student/home.php"; ?>
            </div>
            <div id="tab2">
                <?php include_once "student/demo.php"; ?>
            </div>
        </div>
        <?php } ?>
    </div>
</body>

<script src="assets/js/custom_js/main-page.js"></script>
<?php include 'modals/logout_confirm.php' ?>

<!-- plugins:js -->
<script src="assets/vendors/js/vendor.bundle.base.js"></script>

</html>